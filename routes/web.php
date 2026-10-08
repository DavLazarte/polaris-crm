<?php

use Illuminate\Support\Facades\Route;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;

// Cambio de idioma
Route::get('/lang/{locale}', function (Request $request, $locale) {
    if (in_array($locale, ['es', 'en', 'pt', 'fr'])) {
        session(['locale' => $locale]);
        cookie()->queue(cookie()->forever('locale', $locale));
    }
    return redirect()->back(fallback: route('home'));
})->name('lang.switch');

// Rutas principales del sitio (Blade)
Route::get('/', function () {
    $latestArticles = Article::where('is_published', true)
        ->orderBy('published_at', 'desc')
        ->take(3)
        ->get();
    return view('home', compact('latestArticles'));
})->name('home');

Route::get('/home', function () {
    return redirect()->route('home');
});

Route::get('/nosotros', function () {
    return view('nosotros');
})->name('nosotros');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

Route::get('/perspectivas', function () {
    $featured = Article::where('is_published', true)
        ->where('is_featured', true)
        ->orderBy('published_at', 'desc')
        ->first();

    $query = Article::where('is_published', true)->orderBy('published_at', 'desc');
    if ($featured) {
        $query->where('id', '!=', $featured->id);
    }
    $articles = $query->get();

    return view('news', compact('featured', 'articles'));
})->name('news');

Route::get('/radar', function () {
    return view('radar');
})->name('radar');

Route::redirect('/convocatorias', '/radar');
Route::redirect('/convocatorias.html', '/radar');
Route::redirect('/radar.html', '/radar');

// Redirecciones para evitar 404 si entran con .html o /news
Route::redirect('/index.html', '/');
Route::redirect('/nosotros.html', '/nosotros');
Route::redirect('/servicios.html', '/servicios');
Route::redirect('/contacto.html', '/contacto');
Route::redirect('/news.html', '/perspectivas');
Route::redirect('/news', '/perspectivas');

// Endpoint para recibir los mensajes de contacto
Route::post('/contacto/enviar', function (Request $request) {
    $data = $request->all();

    $message = ContactMessage::create([
        'name' => $data['nombre'] ?? 'Sin nombre',
        'organizacion' => $data['organizacion'] ?? null,
        'email' => $data['email'] ?? 'Sin email',
        'pais' => $data['pais'] ?? null,
        'intereses' => $data['intereses'] ?? null,
        'message' => $data['mensaje'] ?? null,
    ]);

    $subject = "Nueva consulta web: " . $message->name . ($message->organizacion ? " (" . $message->organizacion . ")" : "");
    $sent = false;

    // 1. Intento con Laravel Mailer (SMTP / Sendmail según .env)
    try {
        Mail::send('emails.contact', ['msg' => $message], function ($m) use ($message, $subject) {
            $m->to('info@polariscg.com.ar')
              ->cc(['carolina@polariscg.com.ar', 'andres@polariscg.com.ar']);

            if (!empty($message->email) && filter_var($message->email, FILTER_VALIDATE_EMAIL)) {
                $m->replyTo($message->email, $message->name);
            }

            $m->subject($subject);
        });
        $sent = true;
    } catch (\Throwable $e) {
        \Log::warning('Fallo envio con Laravel Mailer: ' . $e->getMessage() . '. Intentando fallback directo mail() de PHP...');
    }

    // 2. Fallback nativo mail() de PHP (método exacto de send_mail.php compatible 100% con Ferozo/DonWeb)
    if (!$sent) {
        try {
            $cuerpoHTML = view('emails.contact', ['msg' => $message])->render();
            $asunto_codificado = "=?UTF-8?B?" . base64_encode($subject) . "?=";
            
            $cabeceras = "MIME-Version: 1.0\r\n";
            $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
            $cabeceras .= "From: Polaris Web Form <no-reply@polariscg.com.ar>\r\n";
            if (!empty($message->email) && filter_var($message->email, FILTER_VALIDATE_EMAIL)) {
                $cabeceras .= "Reply-To: " . $message->name . " <" . $message->email . ">\r\n";
            }
            $cabeceras .= "Cc: carolina@polariscg.com.ar, andres@polariscg.com.ar\r\n";
            $cabeceras .= "X-Mailer: PHP/" . phpversion() . "\r\n";

            $nativeOk = @mail('info@polariscg.com.ar', $asunto_codificado, $cuerpoHTML, $cabeceras);
            if ($nativeOk) {
                \Log::info('Correo enviado exitosamente con mail() nativo (fallback Ferozo).');
            } else {
                \Log::error('Fallo el envio tambien con mail() nativo.');
            }
        } catch (\Throwable $fallbackEx) {
            \Log::error('Excepcion en fallback mail(): ' . $fallbackEx->getMessage());
        }
    }

    return response()->json(['success' => true]);
});

// Diagnostico de correo en produccion
Route::get('/polaris-test-mail/{token}', function ($token) {
    if ($token !== 'polaris2026') {
        abort(403, 'Acceso no autorizado.');
    }

    $dummy = (object) [
        'name' => 'Prueba de Sistema',
        'organizacion' => 'Polaris Verification',
        'email' => 'info@polariscg.com.ar',
        'pais' => 'Argentina',
        'intereses' => 'Prueba de envio de correos',
        'message' => 'Este es un correo de prueba enviado desde polaris-test-mail para verificar la recepcion en las 3 casillas.',
    ];

    $log = [];
    $subject = "Prueba de correo Polaris: " . date('Y-m-d H:i:s');

    // Test Laravel Mail
    try {
        Mail::send('emails.contact', ['msg' => $dummy], function ($m) use ($dummy, $subject) {
            $m->to('info@polariscg.com.ar')
              ->cc(['carolina@polariscg.com.ar', 'andres@polariscg.com.ar'])
              ->subject($subject);
        });
        $log[] = "✅ Laravel Mailer: Envío exitoso a info@, carolina@ y andres@";
    } catch (\Throwable $e) {
        $log[] = "⚠️ Laravel Mailer falló: " . $e->getMessage();
        
        // Test mail() nativo
        try {
            $cuerpoHTML = view('emails.contact', ['msg' => $dummy])->render();
            $asunto_codificado = "=?UTF-8?B?" . base64_encode($subject) . "?=";
            $cabeceras = "MIME-Version: 1.0\r\n";
            $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
            $cabeceras .= "From: Polaris Web Form <no-reply@polariscg.com.ar>\r\n";
            $cabeceras .= "Cc: carolina@polariscg.com.ar, andres@polariscg.com.ar\r\n";
            $cabeceras .= "X-Mailer: PHP/" . phpversion() . "\r\n";

            $res = @mail('info@polariscg.com.ar', $asunto_codificado, $cuerpoHTML, $cabeceras);
            if ($res) {
                $log[] = "✅ Fallback mail() nativo: Envío exitoso a info@, carolina@ y andres@";
            } else {
                $log[] = "❌ Fallback mail() nativo falló.";
            }
        } catch (\Throwable $ex) {
            $log[] = "❌ Excepción en mail() nativo: " . $ex->getMessage();
        }
    }

    return response('<pre style="background:#000412; color:#74acdf; padding:24px; font-family:monospace; font-size:14px; border-radius:10px;">' . implode("\n\n", $log) . '</pre>');
});

// Helper de deploy para Ferozo (ejecutar migraciones, storage:link y cache en hosting sin SSH)
Route::get('/polaris-setup/{token}', function ($token) {
    if ($token !== 'polaris2026') {
        abort(403, 'Acceso no autorizado.');
    }

    $log = [];
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $log[] = "1. Migraciones: \n" . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        $log[] = "1. Error en migraciones: " . $e->getMessage();
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        $log[] = "2. Datos iniciales (Seeders): \n" . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        $log[] = "2. Error en seeders: " . $e->getMessage();
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        $log[] = "3. Storage link: \n" . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        $log[] = "3. Error en storage:link: " . $e->getMessage();
    }

    try {
        \Illuminate\Support\Facades\Artisan::call('optimize:clear');
        $log[] = "4. Caché limpia: \n" . \Illuminate\Support\Facades\Artisan::output();
    } catch (\Exception $e) {
        $log[] = "4. Error en optimize:clear: " . $e->getMessage();
    }

    return response('<pre style="background:#000412; color:#74acdf; padding:24px; font-family:monospace; font-size:14px; border-radius:10px;">' . implode("\n\n", $log) . '</pre>');
});

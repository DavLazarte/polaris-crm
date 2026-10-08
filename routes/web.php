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

    try {
        Mail::send('emails.contact', ['msg' => $message], function ($m) use ($message) {
            $m->to('info@polariscg.com.ar')
              ->subject('Nuevo mensaje web: ' . $message->name);
        });
    } catch (\Exception $e) {
        \Log::error('Error enviando email: ' . $e->getMessage());
    }

    return response()->json(['success' => true]);
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

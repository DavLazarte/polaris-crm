<?php
/**
 * Polaris Cooperation Group
 * Formulario de contacto - Procesador de correo
 */

// Cabecera obligatoria para indicar que retornamos JSON
header('Content-Type: application/json; charset=utf-8');

// Validar que la petición sea de tipo POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Método de petición no permitido. Solo se admite POST.'
    ]);
    exit;
}

// Sanitizar y recibir los datos
$nombre = isset($_POST['nombre']) ? strip_tags(trim($_POST['nombre'])) : '';
$organizacion = isset($_POST['organizacion']) ? strip_tags(trim($_POST['organizacion'])) : '';
$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$pais = isset($_POST['pais']) ? strip_tags(trim($_POST['pais'])) : 'No especificado';
$intereses = isset($_POST['intereses']) ? strip_tags(trim($_POST['intereses'])) : 'Ninguno seleccionado';
$mensaje = isset($_POST['mensaje']) ? strip_tags(trim($_POST['mensaje'])) : '';

// Validar campos requeridos
if (empty($nombre) || empty($organizacion) || empty($email) || empty($mensaje)) {
    echo json_encode([
        'success' => false,
        'message' => 'Por favor complete todos los campos obligatorios (*).'
    ]);
    exit;
}

// Validar formato del correo
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'El formato del correo electrónico ingresado no es válido.'
    ]);
    exit;
}

// Destinatarios
$destinatario = 'info@polariscg.com.ar';
$copias = 'carolina@polariscg.com.ar, andres@polariscg.com.ar';

// Asunto del correo codificado en Base64 UTF-8 para evitar problemas de acentos en Outlook/Gmail
$asunto = "Nueva consulta web: " . $nombre . " (" . $organizacion . ")";
$asunto_codificado = "=?UTF-8?B?" . base64_encode($asunto) . "?=";

// Construir cuerpo del correo en HTML responsivo y con colores corporativos de Polaris
$cuerpoHTML = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva consulta web</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            color: #1c2340;
            margin: 0;
            padding: 40px 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 4, 18, 0.05);
            overflow: hidden;
            border: 1px solid #dde3ef;
        }
        .header {
            background-color: #000412;
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffffff;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .logo span {
            color: #74acdf;
        }
        .content {
            padding: 40px 30px;
        }
        h2 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #000412;
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: 2px solid #3057be;
            padding-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid #dde3ef;
            font-weight: 700;
            color: #5a6a8a;
            font-size: 0.85rem;
            text-transform: uppercase;
            width: 35%;
        }
        td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid #dde3ef;
            color: #1c2340;
            font-size: 0.95rem;
        }
        .interest-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .interest-tag {
            display: inline-block;
            background-color: rgba(48, 87, 190, 0.08);
            color: #3057be;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .message-box {
            background-color: #f7f9fc;
            border-left: 4px solid #3057be;
            padding: 20px;
            border-radius: 4px;
            font-style: italic;
            color: #1c2340;
            line-height: 1.6;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f7f9fc;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #dde3ef;
            font-size: 0.8rem;
            color: #5a6a8a;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Cabecera -->
        <div class="header">
            <img src="https://polariscg.com.ar/assets/vectorpolaris-blanco.png" alt="Polaris Cooperation Group" style="height: 48px; max-height: 48px; display: block; margin: 0 auto; border: 0;">
        </div>

        <!-- Contenido principal -->
        <div class="content">
            <h2>Nueva Consulta Recibida</h2>
            
            <table>
                <tr>
                    <th>Nombre</th>
                    <td>' . htmlspecialchars($nombre) . '</td>
                </tr>
                <tr>
                    <th>Organización</th>
                    <td>' . htmlspecialchars($organizacion) . '</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:' . htmlspecialchars($email) . '" style="color: #3057be; text-decoration: none;">' . htmlspecialchars($email) . '</a></td>
                </tr>
                <tr>
                    <th>País</th>
                    <td>' . htmlspecialchars($pais) . '</td>
                </tr>
                <tr>
                    <th>Áreas de interés</th>
                    <td>
                        <div class="interest-list">';
                            $tags = explode(', ', $intereses);
                            foreach ($tags as $tag) {
                                if (!empty(trim($tag))) {
                                    $cuerpoHTML .= '<span class="interest-tag">' . htmlspecialchars(trim($tag)) . '</span>';
                                }
                            }
$cuerpoHTML .= '
                        </div>
                    </td>
                </tr>
            </table>

            <h2>Mensaje</h2>
            <div class="message-box">' . htmlspecialchars($mensaje) . '</div>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            Este mensaje fue enviado automáticamente desde el formulario de contacto del sitio web.<br>
            Polaris Cooperation Group &copy; ' . date('Y') . '
        </div>
    </div>

</body>
</html>
';

// Cabeceras del correo para asegurar compatibilidad HTML y codificación UTF-8
// NOTA: Para evitar que el correo caiga en spam en servidores compartidos,
// el remitente (From) debe ser una cuenta del propio dominio (ej: no-reply@polariscg.com.ar).
// La dirección real del usuario se define en "Reply-To" para poder responder directamente.
$cabeceras = "MIME-Version: 1.0\r\n";
$cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
$cabeceras .= "From: Polaris Web Form <no-reply@polariscg.com.ar>\r\n";
$cabeceras .= "Reply-To: " . $nombre . " <" . $email . ">\r\n";
$cabeceras .= "Cc: " . $copias . "\r\n";
$cabeceras .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Enviar el correo electrónico
if (mail($destinatario, $asunto_codificado, $cuerpoHTML, $cabeceras)) {
    echo json_encode([
        'success' => true,
        'message' => 'El mensaje ha sido enviado correctamente.'
    ]);
} else {
    // Si falla el envío nativo, devolvemos el error correspondiente
    echo json_encode([
        'success' => false,
        'message' => 'Ocurrió un error al procesar el envío de correo. Por favor, consulte al administrador.'
    ]);
}
?>

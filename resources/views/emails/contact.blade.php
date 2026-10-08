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
        <!-- Cabecera con logo -->
        <div class="header">
            <img src="https://polariscg.com.ar/assets/vectorpolaris-blanco.png" alt="Polaris Cooperation Group" style="height: 48px; max-height: 48px; display: block; margin: 0 auto; border: 0;">
        </div>

        <!-- Contenido principal -->
        <div class="content">
            <h2>Nueva Consulta Recibida</h2>
            
            <table>
                <tr>
                    <th>Nombre</th>
                    <td>{{ $msg->name }}</td>
                </tr>
                <tr>
                    <th>Organización</th>
                    <td>{{ $msg->organizacion ?? 'No especificado' }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><a href="mailto:{{ $msg->email }}" style="color: #3057be; text-decoration: none;">{{ $msg->email }}</a></td>
                </tr>
                <tr>
                    <th>País</th>
                    <td>{{ $msg->pais ?? 'No especificado' }}</td>
                </tr>
                <tr>
                    <th>Áreas de interés</th>
                    <td>
                        <div class="interest-list">
                            @if(!empty($msg->intereses))
                                @foreach(explode(',', $msg->intereses) as $tag)
                                    @if(trim($tag) !== '')
                                        <span class="interest-tag">{{ trim($tag) }}</span>
                                    @endif
                                @endforeach
                            @else
                                <span>Ninguna seleccionada</span>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <h2>Mensaje</h2>
            <div class="message-box">{{ $msg->message }}</div>
        </div>

        <!-- Pie de página -->
        <div class="footer">
            Este mensaje fue enviado automáticamente desde el formulario de contacto del sitio web.<br>
            Polaris Cooperation Group &copy; {{ date('Y') }}
        </div>
    </div>

</body>
</html>

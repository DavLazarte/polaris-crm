<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #ddd; border-radius: 8px; max-width: 600px; }
        h2 { color: #3057be; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Nuevo mensaje desde la web (Polaris)</h2>
        <p><span class="label">Nombre:</span> {{ $msg->name }}</p>
        <p><span class="label">Email:</span> <a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></p>
        <p><span class="label">Intereses:</span> {{ $msg->intereses ?? 'No especificó' }}</p>
        <hr>
        <p><span class="label">Mensaje:</span></p>
        <p>{{ $msg->message }}</p>
        <hr>
        <p><em>Este mensaje fue guardado en el Panel de Administración de Polaris. Puedes verlo y gestionarlo desde allí.</em></p>
    </div>
</body>
</html>

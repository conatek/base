<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            margin: 0; padding: 0; background-color: #f4f7f9;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        .wrapper { width: 100%; table-layout: fixed; background-color: #f4f7f9; padding-bottom: 40px; }
        .main {
            background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px;
            border-spacing: 0; color: #4a4a4a; border-radius: 8px; overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header { background-color: #ffffff; padding: 30px; text-align: center; border-bottom: 1px solid #eeeeee; }
        .content { padding: 40px 30px; line-height: 1.6; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #94a3b8; }
        .logo { max-width: 250px; height: auto; }
        h1 { color: #1e293b; font-size: 24px; margin-bottom: 20px; }
        .accent-bar { height: 4px; background: linear-gradient(90deg, #127cb3, #00d4ff); }
        .collab-name { color: #127cb3; font-weight: bold; }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main">
            <tr><td><div class="accent-bar"></div></td></tr>
            <tr>
                <td class="header">
                    {{-- Asegúrate de que la ruta del logo sea correcta --}}
                    <img src="{{ $message->embed(public_path('images/logo-mh-lineal.png')) }}" alt="muyhumano" class="logo">
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h1>¡Hola, {{ $user->name }}! 👋</h1>
                    <p>Has solicitado el reporte detallado del colaborador: <br>
                       <span class="collab-name">{{ $collaborator->name }} {{ $collaborator->first_surname }}</span>.
                    </p>
                    <p>Adjunto a este correo encontrarás el expediente en formatos <strong>PDF</strong> (para impresión o lectura) y <strong>Excel</strong> (para gestión de datos).</p>
                    
                    <div style="text-align: center; margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                        <p style="font-size: 14px; color: #64748b;">Generado automáticamente por el módulo de gestión de talento de <strong>Muy Humano</strong>.</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    <p>&copy; {{ date('Y') }} Muy Humano. Todos los derechos reservados.</p>
                    <p>Este correo fue enviado a {{ $user->email }} tras tu solicitud en la plataforma.</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
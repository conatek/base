<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        /* Estilos base para compatibilidad */
        body {
            margin: 0;
            padding: 0;
            background-color: #f4f7f9;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f4f7f9;
            padding-bottom: 40px;
        }
        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #4a4a4a;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .header {
            background-color: #ffffff;
            padding: 30px;
            text-align: center;
            border-bottom: 1px solid #eeeeee;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0046ad; /* Azul corporativo ajustable */
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
        .logo {
            max-width: 250px;
            height: auto;
        }
        h1 {
            color: #1e293b;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .accent-bar {
            height: 4px;
            background: linear-gradient(90deg, #0046ad, #00d4ff);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main">
            <tr>
                <td><div class="accent-bar"></div></td>
            </tr>
            
            <tr>
                <td class="header">
                    <img src="{{ $message->embed(public_path('images/logo-mh-lineal.png')) }}" alt="muyhumano" class="logo">
                </td>
            </tr>

            <tr>
                <td class="content">
                    <h1>¡Hola, {{ $user->name }}! 👋</h1>
                    <p>Esperamos que estés teniendo un excelente día. Te informamos que el <strong>Reporte de General de Colaboradores</strong> que solicitaste ya ha sido generado con éxito.</p>
                    
                    <p>En el archivo adjunto encontrarás el detalle completo procesado por nuestro sistema, listo para tu revisión o impresión.</p>
                    
                    <div style="text-align: center; margin-top: 30px;">
                        <p style="font-size: 14px; color: #64748b;">Este es un proceso automático de <strong>Muy Humano</strong> para optimizar tu gestión de talento.</p>
                    </div>
                </td>
            </tr>

            <tr>
                <td class="footer">
                    <p>&copy; {{ date('Y') }} Muy Humano. Todos los derechos reservados.</p>
                    <p>Este correo fue enviado a {{ $user->email }} porque se solicitó un reporte desde la plataforma.</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
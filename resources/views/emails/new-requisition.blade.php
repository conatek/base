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
        .highlight { color: #127cb3; font-weight: bold; }

        .data-table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 14px; }
        .data-table th { text-align: left; color: #64748b; padding: 8px 0; width: 40%; vertical-align: top; }
        .data-table td { text-align: left; color: #334155; padding: 8px 0; font-weight: 500; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; background-color: #fef3c7; color: #92400e; }

        .table-elegant {
            width: 100%;
            border-collapse: collapse;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        .table-elegant tr {
            transition: background-color 0.2s ease;
            border-bottom: 1px solid #f0f2f5;
        }

        .table-elegant tr:last-child {
            border-bottom: none;
        }

        .table-elegant tr:hover {
            background-color: #f9fafc;
        }

        .table-elegant th {
            text-align: left;
            padding: 16px 20px;
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            width: 35%;
            border-right: 1px solid #e2e8f0;
        }

        .table-elegant td {
            padding: 16px 20px;
            color: #334155;
            font-size: 15px;
            font-weight: 500;
            background-color: white;
        }

        .table-elegant .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            background-color: #e2e8f0;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <table class="main">
            <tr><td><div class="accent-bar"></div></td></tr>
            <tr>
                <td class="header">
                    <img src="{{ $message->embed(public_path('images/logo-mh-lineal.png')) }}" alt="muyhumano" class="logo">
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h1>{{ $title }} 📋</h1>

                    <p>Hola,</p>

                    <p>
                        @if($action === 'create')
                            Se ha generado una nueva solicitud de personal.
                        @elseif($action === 'update')
                            Se ha actualizado una solicitud de personal existente.
                        @elseif($action === 'approve')
                            ¡Buenas noticias! Una requisición ha sido <strong>APROBADA</strong>.
                        @elseif($action === 'cancel')
                            Una requisición ha sido <strong>CANCELADA</strong>.
                        @endif
                    </p>
                    <p>Solicitado por: <span class="highlight">{{ $requisition->requested_by->name ?? 'Usuario' }}</span>.</p>

                    @if($status_comment)
                    <div style="background-color: {{ $action === 'cancel' ? '#fee2e2' : '#dcfce7' }}; padding: 15px; border-radius: 6px; border-left: 4px solid {{ $action === 'cancel' ? '#ef4444' : '#22c55e' }}; margin-bottom: 20px;">
                        <strong>{{ $action === 'cancel' ? 'Motivo de Cancelación' : 'Observación de Aprobación' }}:</strong><br>
                        <span style="color: #334155;">{{ $status_comment }}</span>
                    </div>
                    @endif

                    <table class="table-elegant">
                        <tr>
                            <th>Estado Actual:</th>
                            <td>
                                @php
                                    $badgeColor = '#fef3c7'; // amarillo (pendiente)
                                    $textColor = '#92400e';
                                    if($requisition->vacancy_status_id == 2) { $badgeColor = '#dcfce7'; $textColor = '#166534'; } // Aprobado
                                    if($requisition->vacancy_status_id == 5) { $badgeColor = '#fee2e2'; $textColor = '#991b1b'; } // Cancelado
                                @endphp
                                <span class="badge" style="background-color: {{ $badgeColor }}; color: {{ $textColor }};">
                                    {{ $requisition->vacancy_status->name ?? 'Pendiente' }}
                                </span>
                            </td>
                        </tr>
                    </table>

                    @if($requisition->observations)
                    <div style="margin-top: 20px; background-color: #f8fafc; padding: 15px; border-radius: 6px;">
                        <strong>Observaciones de la vacante:</strong><br>
                        <span style="font-size: 13px; font-style: italic;">{{ $requisition->observations }}</span>
                    </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Colaboradores</title>

    {{-- Bootstrap puede agregar márgenes no deseados, comentamos si es necesario --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Reset completo para eliminar espaciados innecesarios, excepto el body */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        h1, h2, h3, h4, h5, h6, p, table, thead, tbody, tr, td, th, div {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Estilos del body sin padding - los márgenes se controlan desde @page */
        body {
            font-size: 12px;
            font-family: Arial, sans-serif;
            line-height: 1.2;
        }

        html, body {
            width: 100%;
            height: 100%;
            margin: 0 !important;
        }

        h1 {
            font-size: 18px;
            text-align: center;
            margin-bottom: 10px !important; /* Solo este margen es necesario */
            margin-top: 5px !important; /* Margen mínimo superior */
        }

        .footer {
            margin-top: 15px !important; /* Solo este margen es necesario */
            text-align: center;
            font-size: 10px;
            color: #777;
        }

        /* Tabla sin espaciados externos */
        table {
            font-size: 11px;
            width: 100%;
            border-collapse: collapse;
            page-break-inside: avoid;
            margin: 0 !important;
        }

        /* Configuración crítica para evitar división de filas */
        tbody tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        thead {
            display: table-header-group;
        }

        tbody {
            display: table-row-group;
        }

        /* Celdas con padding mínimo pero funcional */
        td, th {
            vertical-align: top;
            padding: 4px 6px !important; /* Padding mínimo pero legible */
            line-height: 1.2;
            border: 1px solid #dee2e6; /* Borde manual ya que Bootstrap puede no aplicarse bien */
        }

        /* Espaciado interno de las celdas */
        td div {
            margin-bottom: 2px !important;
        }

        td div:last-child {
            margin-bottom: 0 !important;
        }

        /* Configuración específica de impresión */
        @media print {
            body {
                font-size: 11px;
            }

            @page {
                size: Letter;
                margin: 10mm; /* Asegurar márgenes en impresión */
            }

            .page-break {
                page-break-before: always;
            }

            h1 {
                page-break-after: avoid;
                margin-bottom: 8px !important;
                margin-top: 0 !important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }
        }

        /* Estilos para mejorar la legibilidad sin espaciado extra */
        .collaborator-name {
            font-weight: bold;
            color: #2c3e50;
        }

        .field-label {
            font-weight: bold;
            color: #34495e;
        }

        /* Configuración de página que aplica márgenes a TODAS las páginas */
        @page {
            size: Letter;
            margin: 10mm; /* Este margen se aplica a todas las páginas */
        }

        /* Sobrescribir estilos de Bootstrap que puedan añadir espaciado */
        .table {
            margin-bottom: 0 !important;
        }

        .table td, .table th {
            padding: 4px 6px !important;
            border-top: 1px solid #dee2e6 !important;
        }

        .table-bordered td, .table-bordered th {
            border: 1px solid #dee2e6 !important;
        }
    </style>
</head>

<body>
    <h1>Reporte General de Colaboradores</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th style="width: 30%;">Colaborador</th>
                <th style="width: 35%;">Información contractual</th>
                <th style="width: 35%;">Datos de contacto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($collaborators as $index => $collaborator)
            <tr>
                <td>
                    <div class="collaborator-name">{{ $collaborator->name }}</div>
                    <div>{{ $collaborator->first_surname }} {{ $collaborator->second_surname }}</div>
                    <div><span class="field-label">{{ $abbreviations[$collaborator->document_type->type] ?? $collaborator->document_type->type }}:</span> {{ $collaborator->document_number }}</div>
                    <div><span class="field-label">Fecha de nacimiento:</span> {{ $collaborator->birth_date }}</div>
                </td>
                <td>
                    <div><span class="field-label">Cargo:</span> {{ $collaborator->position }}</div>
                    <div><span class="field-label">Tipo de contrato:</span> {{ $collaborator->contract_type }}</div>
                    <div><span class="field-label">Salario:</span> {{ $collaborator->salary }}</div>
                    <div><span class="field-label">Área:</span> {{ $collaborator->area }}</div>
                </td>
                <td>
                    <div><span class="field-label">Email:</span> {{ $collaborator->email }}</div>
                    <div><span class="field-label">Celular:</span> {{ $collaborator->cellphone }}</div>
                    <div><span class="field-label">Teléfono:</span> {{ $collaborator->phone }}</div>
                    <div><span class="field-label">Dirección:</span> {{ $collaborator->address }} - {{ $collaborator->city }}</div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado automáticamente el {{ now()->format('d/m/Y') }} por {{ config('app.name') }}.
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reporte de Colaboradores</title>

    {{-- ✅ Incluir Bootstrap (usa solo el CSS, no JS) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Estilos adicionales personalizados (opcional) */
        body {
            font-size: 12px;
            margin: 0px;
        }

        h1 {
            font-size: 20px;
            text-align: center;
        }

        .footer {
            margin-top: 0px;
            text-align: center;
            font-size: 10px;
            color: #777;
        }

        table {
            font-size: 11px;
        }

        td, th {
            vertical-align: middle; /* centrado vertical */
        }
    </style>
</head>

<body>
    <h1>Reporte General de Colaboradores</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                {{-- <th>#</th> --}}
                <th>Colaborador</th>
                <th>Información contractual</th>
                <th>Datos de contacto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($collaborators as $index => $collaborator)
            <tr>
                {{-- <td>{{ $index + 1 }}</td> --}}
                <td>
                    <div><strong>{{ $collaborator->name }}</strong></div>
                    <div>{{ $collaborator->first_surname }} {{ $collaborator->second_surname }}</div>
                    <div><strong>{{ $abbreviations[$collaborator->document_type->type] ?? $collaborator->document_type->type }}:</strong> {{ $collaborator->document_number }}</div>
                    <div><strong>Fecha de nacimiento:</strong> {{ $collaborator->birth_date }}</div>
                </td>
                <td>
                    <div><strong>Cargo:</strong> {{ $collaborator->position }}</div>
                    <div><strong>Tipo de contrato:</strong> {{ $collaborator->contract_type }}</div>
                    <div><strong>Salario:</strong> {{ $collaborator->salary }}</div>
                    <div><strong>Área:</strong> {{ $collaborator->area }}</div>
                </td>
                <td>
                    <div><strong>Email:</strong> {{ $collaborator->email }}</div>
                    <div><strong>Celular:</strong> {{ $collaborator->cellphone }}</div>
                    <div><strong>Teléfono:</strong> {{ $collaborator->phone }}</div>
                    <div><strong>Dirección:</strong> {{ $collaborator->address }} - {{ $collaborator->city }}</div>
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

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #334155;
            margin: 0;
            padding: 30px;
            background-color: #fff;
        }

        /* --- NUEVA CABECERA DE 3 COLUMNAS --- */
        .header-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 10px 15px 10px 10px;
            margin-bottom: 20px;
            background-color: #fff;
        }

        .header-col { flex: 1; }

        /* Columna 1: Logo */
        .logo-box {
            width: 160px;
            height: 60px;
            /* border: 1px solid #f1f5f9; */
            /* border-radius: 10px; */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            background-color: #fff;
        }
        .logo-box img { max-width: 100%; max-height: 100%; object-fit: contain; }

        /* Columna 2: Títulos Centrales */
        .header-titles {
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .title-main { font-size: 13px; font-weight: 600; color: #0f172a; letter-spacing: 0.5px; }
        .title-sub { font-size: 11px; font-weight: 500; color: #323232; }

        /* Columna 3: Metadata */
        .header-meta {
            text-align: right;
            font-size: 10px;
            color: #64748b;
            line-height: 1.5;
        }

        /* --- ESTRUCTURA DE FILAS Y CARDS --- */
        .collab-row {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }

        .card {
            flex: 1;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            min-height: 200px;
            display: flex;
            flex-direction: column;
        }

        .card-identity {
            background-color: #f8fafc;
            border-left: 4px solid #323232;
        }

        .card-identity-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .photo-box { width: 80px; height: 80px; flex-shrink: 0; }
        .photo-box img, .photo-box svg {
            width: 80px; height: 80px; border-radius: 8px;
            border: 1px solid #cbd5e1; object-fit: cover; background: #fff;
        }

        .full-name { font-size: 13px; font-weight: 600; color: #323232; margin-bottom: 2px; }
        .dashed-divider { border-bottom: 1px dashed #cbd5e1; margin: 5px 0 10px 0; width: 100%; }

        /* --- ITEMS Y ALINEACIÓN --- */
        .item { font-size: 9px; margin-bottom: 3px; line-height: 1.3; }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4px; }
        .label { color: #64748b; font-weight: 400; }
        .value { color: #334155; font-weight: 500; }

        .item-horizontal {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 9px;
            margin-bottom: 2px;
        }
        .item-horizontal .label { flex: 0 0 35%; color: #64748b; }
        .item-horizontal .value-container {
            flex: 0 0 65%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #334155;
            font-weight: 500;
        }

        /* --- ESTILOS PROFESIONALES --- */
        .prof-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px; }
        .position-text { font-size: 11px; font-weight: 600; color: #0f172a; }
        .provider-text { font-size: 9px; color: #323232; font-weight: 500; }
        .section-tag {
            font-size: 9px; font-weight: 600; color: #323232;
            margin: 8px 0 5px 0; border-left: 3px solid #323232;
            padding: 2px 0 2px 6px; background-color: #f0f9ff;
        }

        /* --- EMPTY STATE --- */
        .empty-state-card {
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            padding: 60px 20px;
            text-align: center;
            margin-top: 20px;
        }
        .empty-icon { width: 60px; height: 60px; color: #94a3b8; margin-bottom: 15px; }

        .footer {
            position: fixed; bottom: 10px; width: 100%; text-align: center;
            font-size: 8px; color: #94a3b8;
        }
    </style>
</head>

<body>

    <div class="header-card">
        <div class="header-col">
            <div class="logo-box">
                @if (isset($company->logo_url) && $company->logo_url)
                    <img src="{{ $company->logo_url }}" alt="Logo">
                @else
                    <span style="font-weight: 600; font-size: 14px; color: #323232;">{{ $company->company_name ?? 'Muy Humano' }}</span>
                @endif
            </div>
        </div>

        <div class="header-col header-titles">
            <div class="title-main">REPORTE GENERAL</div>
            <div class="title-sub">Personal Activo y Vigente</div>
        </div>

        <div class="header-col header-meta">
            <div>Emitido: {{ now()->format('d/m/Y') }}</div>
            <div>Total colaboradores: <strong>{{ $collaborators->count() }}</strong></div>
        </div>
    </div>

    @if ($collaborators->count() > 0)
        @foreach ($collaborators as $collab)
            @php $contract = $collab->activeContract; @endphp
            <div class="collab-row">

                <div class="card card-identity">
                    <div class="card-identity-top">
                        <div class="photo-box">
                            @if ($collab->image_url)
                                <img src="{{ $collab->image_url }}" alt="Foto">
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5">
                                    <path d="M12 11a4 4 0 100-8 4 4 0 000 8zM17.5 21a5.5 5.5 0 00-11 0"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            @endif
                        </div>

                        @php
                            if ($collab->document_type->type === 'Cédula de ciudadanía') {
                                $docPrefix = 'CC';
                            } elseif ($collab->document_type->type === 'Cédula de extranjería') {
                                $docPrefix = 'CE';
                            } elseif ($collab->document_type->type === 'NIT') {
                                $docPrefix = 'NIT';
                            } elseif ($collab->document_type->type === 'NUIP') {
                                $docPrefix = 'NUIP';
                            } elseif ($collab->document_type->type === 'Pasaporte') {
                                $docPrefix = 'PP';
                            } elseif ($collab->document_type->type === 'Tarjeta de identidad') {
                                $docPrefix = 'TI';
                            } else {
                                $docPrefix = '';
                            }
                        @endphp

                        <div style="flex: 1;">
                            <div class="full-name">
                                {{ $collab->name }} {{ $collab->first_surname }} {{ $collab->second_surname ?? '' }}
                            </div>
                            <div class="item">
                                <span class="label">Documento:</span>
                                <span class="value">[{{ $docPrefix }}] {{ $collab->document_number }}</span>
                            </div>
                            <div class="item"><span class="label">Email:</span> <span
                                    class="value">{{ $collab->email }}</span></div>
                            <div class="item"><span class="label">Contacto:</span> <span
                                    class="value">{{ $collab->cellphone ?? 'No registrado' }}</span></div>
                        </div>
                    </div>

                    <div class="dashed-divider"></div>

                    {{-- <div class="section-tag">Perfil sociodemográfico</div> --}}

                    <div class="details-grid">
                        <div class="item">
                            <span class="label">Fecha de nacimiento:</span> <br>
                            <span
                                class="value">{{ \Carbon\Carbon::parse($collab->birth_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="item">
                            <span class="label">Lugar de nacimiento:</span> <br>
                            <span class="value">{{ $collab->birth_city->name ?? 'Sin definir' }}
                                ({{ $collab->birth_province->name ?? 'Sin definir' }})
                            </span>
                        </div>
                        <div class="item">
                            <span class="label">Estrato social:</span> <br>
                            <span class="value">[{{ $collab->stratum_type->id }}]
                                {{ $collab->stratum_type->name ?? 'Sin definir' }}</span>
                        </div>
                        <div class="item">
                            <span class="label">Lugar de residencia:</span> <br>
                            <span class="value">{{ $collab->residence_city->name ?? 'Sin definir' }}
                                ({{ $collab->residence_province->name ?? 'Sin definir' }})</span>
                        </div>
                        <div class="item">
                            <span class="label">Estado civil:</span> <br>
                            <span class="value">{{ $collab->civil_status_type->type ?? 'Sin definir' }}</span>
                        </div>
                        <div class="item">
                            <span class="label">Nivel académico:</span> <br>
                            <span
                                class="value">{{ $collab->highest_academic_achievement->achievement_type->type ?? 'Sin definir' }}</span>
                        </div>
                        <div class="item">
                            <span class="label">Sexo:</span> <br>
                            <span class="value">{{ $collab->sex_type->name ?? 'Sin definir' }}</span>
                        </div>
                        <div class="item">
                            <span class="label">Rh:</span> <br>
                            <span class="value">{{ $collab->rh_type->name ?? 'Sin definir' }}</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="prof-header">
                        <div class="position-text">{{ $contract->position->name ?? 'Cargo sin definir' }}</div>
                        <div class="provider-text">{{ $collab->staff_provider->name ?? 'Sin definir' }}</div>
                    </div>

                    <div class="dashed-divider"></div>

                    <div class="details-grid" style="grid-template-columns: 1fr 1fr 1fr;">
                        <div class="item"><span class="label">Inicio contrato:</span> <br><span
                                class="value">{{ \Carbon\Carbon::parse($contract->contract_start_date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="item"><span class="label">Finalización:</span> <br><span
                                class="value">{{ $contract->contract_end_date ? \Carbon\Carbon::parse($contract->contract_end_date)->format('d/m/Y') : 'Indefinido' }}</span>
                        </div>
                        <div class="item"><span class="label">Salario mensual:</span> <br><span class="value"
                                style="color: #323232; font-weight: 600;">${{ number_format($contract->salary, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="section-tag">Seguridad social</div>

                    @php $ss = $collab->social_security; @endphp

                    <div class="horizontal-list">
                        <div class="item-horizontal">
                            <span class="label">Eps:</span>
                            <div class="value-container"><span
                                    class="value-truncate">{{ $ss->eps->name ?? 'Sin definir' }}</span></div>
                        </div>
                        <div class="item-horizontal">
                            <span class="label">Arl:</span>
                            <div class="value-container"><span
                                    class="value-truncate">{{ $ss->arl->name ?? 'Sin definir' }}</span></div>
                        </div>
                        <div class="item-horizontal">
                            <span class="label">Pensiones:</span>
                            <div class="value-container"><span
                                    class="value-truncate">{{ $ss->afp_pension->name ?? 'Sin definir' }}</span>
                            </div>
                        </div>
                        <div class="item-horizontal">
                            <span class="label">Cesantías:</span>
                            <div class="value-container"><span
                                    class="value-truncate">{{ $ss->afp_saving->name ?? 'Sin definir' }}</span>
                            </div>
                        </div>
                        <div class="item-horizontal">
                            <span class="label">Caja compensación:</span>
                            <div class="value-container"><span
                                    class="value-truncate">{{ $ss->ccf->name ?? 'Sin definir' }}</span></div>
                        </div>
                    </div>

                    <div class="section-tag">Información bancaria</div>

                    <div class="horizontal-list">
                        <div class="item-horizontal">
                            <span class="label">Entidad:</span>
                            <div class="value-container"><span
                                    class="value-truncate">{{ $collab->bank_account->bank->name ?? 'Sin definir' }}</span>
                            </div>
                        </div>
                        <div class="item-horizontal">
                            <span class="label">Tipo de cuenta:</span>
                            <div class="value-container"><span
                                    class="value-truncate">{{ $collab->bank_account->accountType->name ?? 'Sin definir' }}</span>
                            </div>
                        </div>
                        <div class="item-horizontal">
                            <span class="label">Número de cuenta:</span>
                            <div class="value-container"><span
                                    class="value-truncate">{{ $collab->bank_account->bank_account ?? 'Sin definir' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-state-card">
            <svg class="empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                <path d="M12 11v4M10 13h4" stroke-linecap="round" />
            </svg>
            <h2 style="font-size: 16px; color: #475569; margin: 0 0 8px 0;">Búsqueda sin resultados</h2>
            <p style="font-size: 11px; color: #94a3b8; max-width: 320px; margin: 0 auto;">
                Actualmente no hay colaboradores que cumplan con los criterios de <span
                    style="color: #127cb3; font-weight: 500;">actividad y vigencia</span> en la base de datos de
                {{ $company->company_name ?? 'la empresa' }}.
            </p>
        </div>
    @endif

    <div class="footer">
        Confidencial | Generado por Muy Humano © {{ date('Y') }}
    </div>
</body>
</html>
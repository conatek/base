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
            padding: 20px;
            background-color: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 2px solid #127cb3;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #0f172a;
            font-weight: 600;
        }

        .header p {
            margin: 0;
            font-size: 11px;
            color: #64748b;
        }

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
            border-left: 4px solid #127cb3;
        }

        .card-identity-top {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .photo-box {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .photo-box img,
        .photo-box svg {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            object-fit: cover;
            background: #fff;
        }

        .full-name {
            font-size: 13px;
            font-weight: 600;
            color: #127cb3;
            margin-bottom: 2px;
        }

        .dashed-divider {
            border-bottom: 1px dashed #cbd5e1;
            margin: 5px 0 10px 0;
            width: 100%;
        }

        .item {
            font-size: 9px;
            margin-bottom: 3px;
            line-height: 1.3;
        }

        .label {
            color: #64748b;
            font-weight: 400;
        }

        .value {
            color: #334155;
            font-weight: 500;
        }

        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3px;
        }

        .prof-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }

        .position-text {
            font-size: 11px;
            font-weight: 600;
            color: #0f172a;
        }

        .provider-text {
            font-size: 9px;
            color: #127cb3;
            font-weight: 500;
        }

        .section-tag {
            font-size: 9px;
            font-weight: 600;
            color: #127cb3;
            margin: 5px 0 5px 0;
            border-left: 3px solid #127cb3;
            padding-left: 6px;
            background-color: #f0f9ff;
            padding-top: 2px;
            padding-bottom: 2px;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
        }

        /* Nueva estructura horizontal para ítems específicos */
        .item-horizontal {
            display: flex;
            align-items: center;
            gap: 3px;
            /* margin-bottom: 2px; */
            font-size: 9px;
        }

        .item-horizontal .label {
            flex: 0 0 33.33%;
            /* Exactamente 1/3 del ancho */
            color: #64748b;
            font-weight: 400;
            white-space: nowrap;
        }

        .item-horizontal .value-container {
            flex: 0 0 66.66%;
            /* Exactamente 2/3 del ancho */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            /* Trunca el texto si es muy largo */
            color: #334155;
            font-weight: 500;
        }

        /* Ajuste para que el texto truncado funcione correctamente */
        .value-truncate {
            display: block;
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="header">
        <div>
            <h1>Muy Humano</h1>
            <p>Reporte de personal activo y vigente</p>
        </div>
        <div style="text-align: right; font-size: 10px; color: #64748b;">
            Emitido el: {{ now()->format('d/m/Y') }} | Total: {{ $collaborators->count() }}
        </div>
    </div>

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

                <div class="details-grid">
                    <div class="item">
                        <span class="label">Fecha de nacimiento:</span> <br>
                        <span class="value">{{ \Carbon\Carbon::parse($collab->birth_date)->format('d/m/Y') }}</span>
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
                            style="color: #127cb3; font-weight: 600;">${{ number_format($contract->salary, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="section-tag">Seguridad social</div>

                @php $ss = $collab->social_security; @endphp

                <div class="horizontal-list">
                    <div class="item-horizontal">
                        <span class="label">Eps:</span>
                        <div class="value-container"><span
                                class="value-truncate">{{ $ss->eps->name ?? 'Sura EPS' }}</span></div>
                    </div>
                    <div class="item-horizontal">
                        <span class="label">Arl:</span>
                        <div class="value-container"><span
                                class="value-truncate">{{ $ss->arl->name ?? 'Sura ARL' }}</span></div>
                    </div>
                    <div class="item-horizontal">
                        <span class="label">Pensiones:</span>
                        <div class="value-container"><span
                                class="value-truncate">{{ $ss->afp_pension->name ?? 'Protección' }}</span>
                        </div>
                    </div>
                    <div class="item-horizontal">
                        <span class="label">Cesantías:</span>
                        <div class="value-container"><span
                                class="value-truncate">{{ $ss->afp_saving->name ?? 'Porvenir' }}</span>
                        </div>
                    </div>
                    <div class="item-horizontal">
                        <span class="label">Caja compensación:</span>
                        <div class="value-container"><span
                                class="value-truncate">{{ $ss->ccf->name ?? 'Comfama' }}</span></div>
                    </div>
                </div>

                <div class="section-tag">Información bancaria</div>

                @php $bankAccount = $collab->bank_accounts->first(); @endphp

                <div class="horizontal-list">
                    <div class="item-horizontal">
                        <span class="label">Entidad:</span>
                        <div class="value-container"><span
                                class="value-truncate">{{ $bankAccount->bank->name ?? 'Sin definir' }}</span></div>
                    </div>
                    <div class="item-horizontal">
                        <span class="label">Número de cuenta:</span>
                        <div class="value-container"><span
                                class="value-truncate">{{ $bankAccount->bank_account ?? 'Sin definir' }}</span>
                        </div>
                    </div>
                    <div class="item-horizontal">
                        <span class="label">Observaciones:</span>
                        <div class="value-container"><span
                                class="value-truncate">{{ $bankAccount->observations ?? 'Sin definir' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="footer">
        Confidencial | Generado por el sistema Muy Humano © {{ date('Y') }}
    </div>

</body>

</html>

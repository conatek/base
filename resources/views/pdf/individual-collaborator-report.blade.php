<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; color: #334155; margin: 0; padding: 25px; background-color: #fff; line-height: 1.4; }
        
        /* CABECERA */
        .header-card { display: flex; align-items: center; justify-content: space-between; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; margin-bottom: 20px; }
        .header-col { flex: 1; }
        .logo-box { width: 160px; display: flex; align-items: center; }
        .logo-box img { max-width: 100%; height: auto; }
        .header-titles { text-align: center; display: flex; flex-direction: column; }
        .title-main { font-size: 14px; font-weight: 600; color: #0f172a; letter-spacing: 1px; }
        .title-sub { font-size: 10px; color: #64748b; }
        .header-meta { text-align: right; font-size: 9px; color: #94a3b8; }

        /* PERFIL */
        .profile-section { display: flex; gap: 20px; margin-bottom: 20px; background-color: #f8fafc; padding: 20px; border-radius: 12px; border-left: 5px solid #323232; page-break-inside: avoid; }
        .profile-photo { width: 110px; height: 110px; flex-shrink: 0; }
        .profile-photo img, .profile-photo svg { width: 100%; height: 100%; border-radius: 8px; border: 2px solid #fff; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .profile-info { flex: 1; }
        .profile-name { font-size: 18px; font-weight: 600; color: #0f172a; margin-bottom: 2px; }
        .profile-position { font-size: 12px; color: #323232; font-weight: 500; margin-bottom: 12px; }

        /* GRILLAS DE INFORMACIÓN */
        .section-tag { font-size: 10px; font-weight: 600; color: #1e293b; text-transform: uppercase; letter-spacing: 1px; margin: 20px 0 10px 0; padding: 4px 10px; background-color: #f1f5f9; border-radius: 4px; border-left: 3px solid #323232; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px; margin-bottom: 5px; }
        .info-item { margin-bottom: 8px; }
        .label { font-size: 8px; color: #94a3b8; display: block; text-transform: uppercase; font-weight: 500; }
        .value { font-size: 10px; color: #334155; font-weight: 500; display: block; }

        /* TABLAS */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 5px; font-size: 9px; }
        .data-table th { text-align: left; background-color: #f8fafc; padding: 6px 8px; color: #64748b; font-weight: 600; border-bottom: 1px solid #e2e8f0; }
        .data-table td { padding: 6px 8px; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        
        .badge { padding: 2px 6px; border-radius: 4px; font-size: 8px; font-weight: 600; text-transform: uppercase; }
        .bg-blue { background-color: #e0f2fe; color: #0369a1; }
        
        .no-break { page-break-inside: avoid; }
        .footer { position: fixed; bottom: -10px; width: 100%; text-align: center; font-size: 8px; color: #cbd5e1; padding: 10px 0; border-top: 1px solid #f1f5f9; }
    </style>
</head>
<body>

    <div class="header-card">
        <div class="header-col">
            <div class="logo-box">
                @if ($company->logo_url) <img src="{{ $company->logo_url }}"> @else <span style="font-weight: 700; color: #323232;">{{ $company->company_name }}</span> @endif
            </div>
        </div>
        <div class="header-col header-titles">
            <span class="title-main">EXPEDIENTE DETALLADO DE COLABORADOR</span>
            <span class="title-sub">Gestión Integral de Talento Humano</span>
        </div>
        <div class="header-col header-meta">
            <div>Emisión: {{ now()->format('d/m/Y H:i') }}</div>
            <div>Estado: <strong>{{ $collab->is_active ? 'ACTIVO' : 'INACTIVO' }}</strong></div>
        </div>
    </div>

    <div class="profile-section">
        <div class="profile-photo">
            @if ($collab->image_url) <img src="{{ $collab->image_url }}"> @else <svg viewBox="0 0 24 24" fill="none" stroke="#cbd5e1"><path d="M12 11a4 4 0 100-8 4 4 0 000 8zM17.5 21a5.5 5.5 0 00-11 0" stroke-width="1.5" stroke-linecap="round"/></svg> @endif
        </div>
        <div class="profile-info">
            <div class="profile-name">{{ $collab->name }} {{ $collab->first_surname }} {{ $collab->second_surname }}</div>
            <div class="profile-position">{{ $collab->activeContract->position->name ?? 'Cargo No Definido' }}</div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="label">Documento</span>
                    <span class="value">{{ $collab->document_type->type }}</span>
                    <span class="value">{{ $collab->document_number }}</span>
                </div>
                <div class="info-item"><span class="label">Email Personal / Corp.</span><span class="value">{{ $collab->email }}</span></div>
                <div class="info-item"><span class="label">Celular</span><span class="value">{{ $collab->cellphone ?? 'N/A' }}</span></div>
            </div>
        </div>
    </div>

    <div class="no-break">
        <div class="section-tag">Información de Identificación y Origen</div>
        <div class="info-grid">
            <div class="info-item"><span class="label">Fecha de Expedición</span><span class="value">{{ $collab->expedition_date ? \Carbon\Carbon::parse($collab->expedition_date)->format('d/m/Y') : 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Lugar de Expedición</span><span class="value">{{ $collab->document_city->name ?? 'N/A' }} ({{ $collab->document_province->name ?? 'N/A' }})</span></div>
            <div class="info-item"><span class="label">Fecha de Nacimiento</span><span class="value">{{ \Carbon\Carbon::parse($collab->birth_date)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($collab->birth_date)->age }} años)</span></div>
            <div class="info-item"><span class="label">Lugar de Nacimiento</span><span class="value">{{ $collab->birth_city->name ?? 'N/A' }} ({{ $collab->birth_province->name ?? 'N/A' }})</span></div>
            <div class="info-item"><span class="label">Género / RH</span><span class="value">{{ $collab->sex_type->name ?? 'N/A' }} / {{ $collab->rh_type->name ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Estado Civil</span><span class="value">{{ $collab->civil_status_type->type ?? 'N/A' }}</span></div>
        </div>
    </div>

    <div class="no-break">
        <div class="section-tag">Residencia y Nivel Socioeconómico</div>
        <div class="info-grid">
            <div class="info-item"><span class="label">Dirección de Residencia</span><span class="value">{{ $collab->address ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Ciudad de Residencia</span><span class="value">{{ $collab->residence_city->name ?? 'N/A' }} ({{ $collab->residence_province->name ?? 'N/A' }})</span></div>
            <div class="info-item"><span class="label">Teléfono Fijo</span><span class="value">{{ $collab->phone ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Estrato Social</span>
                <span class="value">{{ $collab->stratum_type->id ? 'Estrato ' . $collab->stratum_type->id . ' (' . $collab->stratum_type->name . ')' : 'N/A' }}</span>
            </div>
            <div class="info-item"><span class="label">Tenencia de Vivienda</span><span class="value">{{ $collab->housing_tenure->type ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Máximo Nivel Académico</span><span class="value">{{ $collab->highest_academic_achievement->achievement_type->type ?? 'N/A' }}</span></div>
        </div>
    </div>

    <div class="no-break">
        <div class="section-tag">Vinculación Laboral y Cargo</div>
        @php $contract = $collab->activeContract; @endphp
        @if($contract)
            <div class="info-grid">
                <div class="info-item"><span class="label">Proveedor / Empleador</span><span class="value">{{ $collab->staff_provider->name ?? 'N/A' }}</span></div>
                <div class="info-item"><span class="label">Sede / Campus</span><span class="value">{{ $contract->position->area->campus->name ?? 'N/A' }}</span></div>
                <div class="info-item"><span class="label">Área / Proceso</span><span class="value">{{ $contract->position->area->name ?? 'N/A' }}</span></div>
                
                <div class="info-item"><span class="label">Tipo de Contrato</span><span class="value">{{ $contract->contractType->name ?? 'N/A' }}</span></div>
                <div class="info-item"><span class="label">Salario Mensual</span><span class="value">${{ number_format($contract->salary, 0, ',', '.') }}</span></div>
                <div class="info-item"><span class="label">Jefe / Líder Directo</span><span class="value">{{ $contract->position->area->leader ? $contract->position->area->leader->name . ' ' . $contract->position->area->leader->first_surname : 'No definido' }}</span></div>
                
                <div class="info-item"><span class="label">Fecha Inicio Contrato</span><span class="value">{{ \Carbon\Carbon::parse($contract->contract_start_date)->format('d/m/Y') }}</span></div>
                <div class="info-item"><span class="label">Fecha Fin Contrato</span><span class="value">{{ $contract->contract_end_date ? \Carbon\Carbon::parse($contract->contract_end_date)->format('d/m/Y') : 'Indefinido' }}</span></div>
                <div class="info-item"><span class="label">Fin Periodo de Prueba</span><span class="value">{{ $contract->test_period_end_date ? \Carbon\Carbon::parse($contract->test_period_end_date)->format('d/m/Y') : 'N/A' }}</span></div>
                
                <div class="info-item">
                    <span class="label">Nivel de Riesgo</span>
                    <span class="value">{{ $contract->position->position_risk_class->class ? $contract->position->position_risk_class->class . ' (' . $contract->position->position_risk_class->description . ')' : 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Criticidad del Cargo</span>
                    <span class="value">{{ $contract->position->position_criticality_level ? 'Nivel ' . $contract->position->position_criticality_level->id . ' (' . $contract->position->position_criticality_level->level . ')' : 'N/A' }}</span>
                </div>
            </div>
        @endif
    </div>

    <div class="no-break">
        <div class="section-tag">Seguridad Social y Datos Bancarios</div>
        <div class="info-grid">
            <div class="info-item"><span class="label">EPS</span><span class="value">{{ $collab->social_security->eps->name ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">ARL</span><span class="value">{{ $collab->social_security->arl->name ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Caja de Compensación</span><span class="value">{{ $collab->social_security->ccf->name ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Fondo de Pensiones</span><span class="value">{{ $collab->social_security->afp_pension->name ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Fondo de Cesantías</span><span class="value">{{ $collab->social_security->afp_saving->name ?? 'N/A' }}</span></div>
            <div class="info-item"></div>
            <div class="info-item"><span class="label">Entidad Bancaria</span><span class="value">{{ $collab->bank_account->bank->name ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Tipo de Cuenta</span><span class="value">{{ $collab->bank_account->accountType->name ?? 'N/A' }}</span></div>
            <div class="info-item"><span class="label">Número de Cuenta</span><span class="value">{{ $collab->bank_account->bank_account ?? 'N/A' }}</span></div>
        </div>
    </div>

    <div class="no-break">
        <div class="section-tag">Grupo Familiar Registrado</div>
        @if($collab->families->count() > 0)
            <table class="data-table">
                <thead><tr><th>Parentesco</th><th>Nombre Completo</th><th>Ocupación</th><th>Edad</th></tr></thead>
                <tbody>
                    @foreach($collab->families as $fam)
                    <tr>
                        <td>{{ $fam->relationship->name }}</td>
                        <td>{{ $fam->name }} {{ $fam->first_surname }} {{ $fam->second_surname }}</td>
                        <td>{{ $fam->occupation->name }}</td>
                        <td>{{ $fam->birth_date ? \Carbon\Carbon::parse($fam->birth_date)->age . ' años' : 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else <p class="value">Sin registros familiares.</p> @endif
    </div>

    <div class="no-break">
        <div class="section-tag">Historial de Formación</div>
        @if($collab->academic_achievements->count() > 0)
            <table class="data-table">
                <thead><tr><th>Nivel</th><th>Título / Programa</th><th>Institución</th><th>Estado / Año</th></tr></thead>
                <tbody>
                    @foreach($collab->academic_achievements as $ac)
                    <tr>
                        <td><strong>{{ $ac->achievement_type->type }}</strong></td>
                        <td>{{ $ac->degree }}</td>
                        <td>{{ $ac->institution }}</td>
                        <td>{{ $ac->end_date ? \Carbon\Carbon::parse($ac->end_date)->format('Y') : 'En curso' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else <p class="value">Sin registros académicos.</p> @endif
    </div>

    <div class="no-break">
        <div class="section-tag">Historial de Exámenes Médicos</div>
        @if($collab->medical_examinations->count() > 0)
            <table class="data-table">
                <thead><tr><th>Tipo de Examen</th><th>Fecha</th><th>Observaciones</th></tr></thead>
                <tbody>
                    @foreach($collab->medical_examinations as $med)
                    <tr>
                        <td>{{ $med->examination_type->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($med->examination_date)->format('d/m/Y') }}</td>
                        <td>{{ $med->observations ?? 'Sin observaciones' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else <p class="value">Sin exámenes registrados.</p> @endif
    </div>

    <div class="no-break">
        <div class="section-tag">Seguimiento de Visitas Domiciliarias</div>
        @if($collab->home_visits->count() > 0)
            <table class="data-table">
                <thead><tr><th>Tipo de Visita</th><th>Fecha</th><th>Observaciones</th></tr></thead>
                <tbody>
                    @foreach($collab->home_visits as $visit)
                    <tr>
                        <td>{{ $visit->home_visit_type->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($visit->visit_date)->format('d/m/Y') }}</td>
                        <td>{{ $visit->observations ?? 'Sin observaciones' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else <p class="value">Sin visitas registradas.</p> @endif
    </div>

    @if($collab->observations)
    <div class="no-break">
        <div class="section-tag">Observaciones Generales del Sistema</div>
        <div style="font-size: 10px; color: #475569; padding: 10px; border: 1px dashed #cbd5e1; border-radius: 8px;">{{ $collab->observations }}</div>
    </div>
    @endif

    <div class="footer">Confidencial | Generado por Muy Humano © {{ date('Y') }} - Documento de uso interno y privado.</div>
</body>
</html>
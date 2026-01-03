<template>
    <div class="empty-state text-center py-4">
        <div class="empty-state-icon mb-3">
            <svg v-if="icon === 'gender'" class="icon-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Icono de género: símbolos masculino/femenino estilizados -->
                <circle cx="35" cy="40" r="15" stroke="#F472B6" stroke-width="3" fill="none"/>
                <line x1="35" y1="55" x2="35" y2="80" stroke="#F472B6" stroke-width="3" stroke-linecap="round"/>
                <line x1="25" y1="65" x2="45" y2="65" stroke="#F472B6" stroke-width="3" stroke-linecap="round"/>
                <circle cx="65" cy="40" r="15" stroke="#38BDF8" stroke-width="3" fill="none"/>
                <line x1="76" y1="29" x2="88" y2="17" stroke="#38BDF8" stroke-width="3" stroke-linecap="round"/>
                <line x1="78" y1="17" x2="88" y2="17" stroke="#38BDF8" stroke-width="3" stroke-linecap="round"/>
                <line x1="88" y1="17" x2="88" y2="27" stroke="#38BDF8" stroke-width="3" stroke-linecap="round"/>
            </svg>

            <svg v-else-if="icon === 'academic'" class="icon-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Icono académico: birrete de graduación -->
                <polygon points="50,20 10,40 50,60 90,40" fill="none" stroke="#3B82F6" stroke-width="3" stroke-linejoin="round"/>
                <line x1="50" y1="60" x2="50" y2="85" stroke="#3B82F6" stroke-width="3" stroke-linecap="round"/>
                <path d="M25 48 L25 70 Q50 85 75 70 L75 48" fill="none" stroke="#10B981" stroke-width="3" stroke-linecap="round"/>
                <circle cx="50" cy="85" r="4" fill="#F59E0B"/>
            </svg>

            <svg v-else-if="icon === 'civil'" class="icon-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Icono estado civil: corazón con anillos -->
                <path d="M50 80 C20 55 15 35 30 25 C40 18 50 28 50 35 C50 28 60 18 70 25 C85 35 80 55 50 80Z" 
                      fill="none" stroke="#10B981" stroke-width="3"/>
                <circle cx="35" cy="60" r="8" stroke="#059669" stroke-width="2" fill="none"/>
                <circle cx="45" cy="60" r="8" stroke="#34D399" stroke-width="2" fill="none"/>
            </svg>

            <svg v-else-if="icon === 'age'" class="icon-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Icono edad: reloj de arena estilizado -->
                <path d="M25 15 L75 15 L75 25 L55 50 L75 75 L75 85 L25 85 L25 75 L45 50 L25 25 L25 15Z" 
                      fill="none" stroke="#8B5CF6" stroke-width="3" stroke-linejoin="round"/>
                <ellipse cx="50" cy="70" rx="12" ry="5" fill="#C4B5FD"/>
                <path d="M45 35 Q50 45 55 35" stroke="#A78BFA" stroke-width="2" fill="none"/>
            </svg>

            <svg v-else-if="icon === 'seniority'" class="icon-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Icono antigüedad: calendario con estrella -->
                <rect x="20" y="25" width="60" height="55" rx="5" fill="none" stroke="#ca8a04" stroke-width="3"/>
                <line x1="20" y1="40" x2="80" y2="40" stroke="#ca8a04" stroke-width="3"/>
                <line x1="35" y1="15" x2="35" y2="30" stroke="#eab308" stroke-width="3" stroke-linecap="round"/>
                <line x1="65" y1="15" x2="65" y2="30" stroke="#eab308" stroke-width="3" stroke-linecap="round"/>
                <polygon points="50,48 53,57 63,57 55,63 58,73 50,67 42,73 45,63 37,57 47,57" 
                         fill="#fcd34d" stroke="#d97706" stroke-width="1"/>
            </svg>

            <svg v-else-if="icon === 'strata'" class="icon-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Icono estrato: edificios/casas escalonadas -->
                <rect x="15" y="60" width="20" height="25" rx="2" fill="none" stroke="#9A3412" stroke-width="2.5"/>
                <rect x="40" y="45" width="20" height="40" rx="2" fill="none" stroke="#C2410C" stroke-width="2.5"/>
                <rect x="65" y="30" width="20" height="55" rx="2" fill="none" stroke="#F97316" stroke-width="2.5"/>
                <rect x="22" y="70" width="6" height="8" fill="#FDBA74"/>
                <rect x="47" y="55" width="6" height="8" fill="#FDBA74"/>
                <rect x="47" y="70" width="6" height="8" fill="#FDBA74"/>
                <rect x="72" y="40" width="6" height="8" fill="#FDBA74"/>
                <rect x="72" y="55" width="6" height="8" fill="#FDBA74"/>
                <rect x="72" y="70" width="6" height="8" fill="#FDBA74"/>
            </svg>

            <svg v-else-if="icon === 'collaborators'" class="icon-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="35" cy="45" r="10" stroke="#94A3B8" stroke-width="3"/>
                <path d="M15 80 C15 65 25 60 35 60 C40 60 45 62 48 65" stroke="#94A3B8" stroke-width="3" stroke-linecap="round"/>
                
                <circle cx="65" cy="45" r="10" stroke="#94A3B8" stroke-width="3"/>
                <path d="M85 80 C85 65 75 60 65 60 C60 60 55 62 52 65" stroke="#94A3B8" stroke-width="3" stroke-linecap="round"/>
                
                <circle cx="50" cy="35" r="12" stroke="#3B82F6" stroke-width="3" fill="white"/>
                <path d="M25 80 C25 60 35 55 50 55 C65 55 75 60 75 80" stroke="#3B82F6" stroke-width="3" stroke-linecap="round" fill="none"/>
                
                <circle cx="75" cy="30" r="8" fill="#10B981"/>
                <path d="M75 26 V34 M71 30 H79" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>

            <!-- Icono por defecto -->
            <svg v-else class="icon-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="50" cy="50" r="35" stroke="#CBD5E1" stroke-width="3" fill="none"/>
                <path d="M35 50 L45 60 L65 40" stroke="#94A3B8" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
        </div>

        <p class="empty-state-message text-muted mb-2">{{ message }}</p>
        <p class="empty-state-hint text-muted small">
            <span class="hint-icon">💡</span> Registra colaboradores para ver las estadísticas
        </p>
    </div>
</template>

<script>
export default {
    name: 'EmptyState',
    props: {
        icon: {
            type: String,
            default: 'default'
        },
        message: {
            type: String,
            default: 'No hay datos disponibles'
        }
    }
}
</script>

<style scoped>
.empty-state {
    min-height: 180px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 50%;
    padding: 15px;
    animation: pulse-soft 3s ease-in-out infinite;
}

.icon-svg {
    width: 100%;
    height: 100%;
}

.empty-state-message {
    font-size: 0.95rem;
    font-weight: 500;
    color: #64748b;
    margin: 0;
}

.empty-state-hint {
    font-size: 0.8rem;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.hint-icon {
    font-size: 0.9rem;
}

@keyframes pulse-soft {
    0%, 100% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.9;
    }
}

/* Responsive */
@media (max-width: 575.98px) {
    .empty-state {
        min-height: 150px;
        padding: 1rem;
    }
    
    .empty-state-icon {
        width: 60px;
        height: 60px;
        padding: 12px;
    }
    
    .empty-state-message {
        font-size: 0.85rem;
    }
    
    .empty-state-hint {
        font-size: 0.75rem;
    }
}
</style>
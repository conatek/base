{{-- @extends('auth.layouts.app')

@section('content')
<div class="app-container app-theme-white body-tabs-shadow bg-white">
    <div class="app-container">
        <div class="h-100">
            <div class="h-100 g-0 row">
                <div class="col-12 col-lg-4 bg-dark position-relative min-vh-50 min-lg-vh-100"
                    style="background-image: url('images/sidebar/mh-people-lineart.jpg');
                            background-size: cover;
                            background-position: center;
                            background-repeat: no-repeat;
                            background-attachment: local;">
                </div>
                @include('auth.partials.auth-form-login')
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('auth.layouts.app')

@section('content')

{{-- Fuente Outfit --}}
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
    /* DEFINICIÓN DE VARIABLES (Misma paleta del Home) */
    :root {
        --mh-green: #12b338;
        --mh-green-light: #E8F5E9;
        --mh-orange: #ff4600;
        --mh-text: #1F2937;
        --mh-bg: #FAFAF9;
    }

    body {
        font-family: 'Outfit', sans-serif !important;
        background-color: var(--mh-bg);
    }

    /* CONTENEDOR PRINCIPAL */
    .login-wrapper {
        min-height: 100vh;
        width: 100%;
        display: flex;
        overflow: hidden;
    }

    /* LADO IZQUIERDO: IMAGEN Y BRANDING */
    .login-brand-side {
        background-color: var(--mh-green);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 4rem;
        color: white;
        overflow: hidden;
    }

    /* Efecto de superposición para la imagen lineal */
    .brand-bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset("images/sidebar/mh-people-lineart.jpg") }}');
        background-size: cover;
        background-position: center;
        opacity: 0.15; /* Hacemos que el dibujo sea sutil sobre el verde */
        mix-blend-mode: multiply; /* Mezcla con el verde */
        z-index: 0;
    }

    /* Decoración orgánica (Blob) */
    .brand-blob {
        position: absolute;
        top: -10%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255,255,255,0.1);
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        z-index: 1;
    }

    .brand-content {
        position: relative;
        z-index: 2;
    }

    /* LADO DERECHO: FORMULARIO */
    .login-form-side {
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        position: relative;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        padding: 2rem;
    }

    /* ESTILOS DEL FORMULARIO */
    .mh-logo-img {
        max-width: 180px;
        margin-bottom: 2rem;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }

    .welcome-text {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--mh-green);
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .subtitle-text {
        color: #6B7280;
        text-align: center;
        margin-bottom: 2rem;
        font-weight: 300;
    }

    /* Inputs Modernos */
    .form-control {
        background-color: #F3F4F6;
        border: 2px solid transparent;
        border-radius: 12px; /* Bordes suaves */
        padding: 0.8rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background-color: white;
        border-color: var(--mh-green);
        box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
    }

    /* Botón Principal */
    .btn-primary {
        background-color: var(--mh-green);
        border: none;
        border-radius: 50px; /* Estilo píldora */
        padding: 0.8rem 2rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        width: 100%;
        margin-top: 1rem;
        transition: transform 0.2s;
    }

    .btn-primary:hover {
        background-color: #1B5E20; /* Verde más oscuro */
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: transparent;
        color: var(--mh-text);
        border: 1px solid #E5E7EB;
        border-radius: 50px;
        margin-top: 0.5rem;
    }

    /* Enlaces */
    .forgot-link {
        color: var(--mh-green);
        font-size: 0.9rem;
        text-decoration: none;
        font-weight: 500;
    }

    .forgot-link:hover {
        text-decoration: underline;
        color: var(--mh-orange);
    }

    .btn-link-custom {
        color: var(--mh-green);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: color 0.2s;
    }
    
    .btn-link-custom:hover { color: var(--mh-orange); }

    /* RESPONSIVE */
    @media (max-width: 991px) {
        .login-wrapper {
            flex-direction: column;
        }
        .login-brand-side {
            min-height: 200px;
            padding: 2rem;
            flex: 0 0 auto;
        }
        .brand-quote { display: none; } /* Ocultar cita en móviles */
    }
</style>

<div class="login-wrapper">
    
    <div class="col-lg-5 col-xl-4 login-brand-side">
        <div class="brand-bg-image"></div>
        <div class="brand-blob"></div>
        
        <div class="brand-content text-center text-lg-start">
            <h2 class="display-6 fw-bold mb-3">Bienvenido de nuevo</h2>
            <p class="lead fw-light mb-4 d-none d-lg-block">
                "El lugar donde los grandes equipos comienzan a construirse"
            </p>
            {{-- <div class="d-none d-lg-block mt-4">
                <small class="opacity-75">© 2025 Muy Humano</small>
            </div> --}}
        </div>
    </div>

    <div class="col-lg-7 col-xl-8 login-form-side">
        <div class="login-card">
            
            <div class="text-center">
                 {{-- Asegúrate que esta ruta sea correcta --}}
                <img src="{{ asset('images/logo-mh.svg') }}" alt="Muy Humano Logo" class="mh-logo-img">
            </div>

            <h1 class="welcome-text">¡Hola!</h1>
            <p class="subtitle-text">Ingresa tus credenciales para acceder al portal.</p>

            {{-- 
               OPCIÓN A: Si tu partial 'auth-form-login' tiene solo los inputs, 
               puedes descomentar la siguiente línea:
            --}}
            {{-- @include('auth.partials.auth-form-login') --}}

            {{-- 
               OPCIÓN B (Recomendada): Usar este formulario estandarizado 
               para asegurar que tome los nuevos estilos CSS definidos arriba.
               Ajusta los 'name' y 'route' según tu configuración actual.
            --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label visually-hidden">Correo electrónico</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                           placeholder="nombre@empresa.com">
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label visually-hidden">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password" 
                           placeholder="••••••••">
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label small text-muted" for="remember">
                            Recordarme
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        Ingresar
                    </button>
                </div>

                <div class="text-center d-flex flex-column gap-3">
                    <a href="{{ route('start') }}" class="btn-link-custom">
                        <i class="bi bi-arrow-left me-1"></i> Volver al inicio
                    </a>
                </div>
            </form>
            {{-- FIN DEL FORMULARIO --}}

        </div>
    </div>
</div>
@endsection

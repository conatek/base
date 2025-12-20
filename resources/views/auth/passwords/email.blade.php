{{-- @extends('auth.layouts.app')

@section('content')
<div class="app-container app-theme-white body-tabs-shadow bg-white">
    <div class="app-container">
        <div class="h-100">
            <div class="h-100 g-0 row">
                <div class="d-none d-lg-block col-lg-4 bg-dark"></div>
                @include('auth.partials.auth-form-password-email')
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
    /* --- SISTEMA DE DISEÑO MUY HUMANO (Mismos estilos del Login) --- */
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

    .login-wrapper {
        min-height: 100vh;
        width: 100%;
        display: flex;
        overflow: hidden;
    }

    /* Lado Izquierdo (Branding) */
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

    .brand-bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* Asegúrate que la ruta sea correcta */
        background-image: url('{{ asset("images/sidebar/mh-people-lineart.jpg") }}');
        background-size: cover;
        background-position: center;
        opacity: 0.15;
        mix-blend-mode: multiply;
        z-index: 0;
    }

    .brand-blob {
        position: absolute;
        bottom: -5%;
        left: -5%;
        width: 250px;
        height: 250px;
        background: rgba(255,255,255,0.1);
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        z-index: 1;
    }

    .brand-content { position: relative; z-index: 2; }

    /* Lado Derecho (Formulario) */
    .login-form-side {
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem;
    }

    .login-card {
        width: 100%;
        max-width: 450px;
        padding: 2rem;
    }

    .mh-logo-img {
        max-width: 160px;
        margin-bottom: 2rem;
        display: block;
        margin: 0 auto 2rem auto;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--mh-text);
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .page-subtitle {
        color: #6B7280;
        text-align: center;
        margin-bottom: 2rem;
        font-weight: 300;
        font-size: 0.95rem;
    }

    /* Inputs */
    .form-control {
        background-color: #F3F4F6;
        border: 2px solid transparent;
        border-radius: 12px;
        padding: 0.8rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        background-color: white;
        border-color: var(--mh-green);
        box-shadow: 0 0 0 4px rgba(46, 125, 50, 0.1);
    }

    /* Botones */
    .btn-primary {
        background-color: var(--mh-green);
        border: none;
        border-radius: 50px;
        padding: 0.8rem 2rem;
        font-weight: 600;
        width: 100%;
        transition: transform 0.2s;
    }

    .btn-primary:hover {
        background-color: #1B5E20;
        transform: translateY(-2px);
    }

    .btn-link-custom {
        color: var(--mh-green);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: color 0.2s;
    }
    
    .btn-link-custom:hover { color: var(--mh-orange); }

    /* Estilo para la alerta de éxito */
    .alert-custom-success {
        background-color: var(--mh-green-light);
        color: var(--mh-green);
        border: 1px solid rgba(46, 125, 50, 0.2);
        border-radius: 12px;
        font-size: 0.9rem;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    @media (max-width: 991px) {
        .login-wrapper { flex-direction: column; }
        .login-brand-side { min-height: 150px; padding: 2rem; flex: 0 0 auto; }
        .brand-desc { display: none; }
    }
</style>

<div class="login-wrapper">
    
    <div class="col-lg-5 col-xl-4 login-brand-side">
        <div class="brand-bg-image"></div>
        <div class="brand-blob"></div>
        
        <div class="brand-content text-center text-lg-start">
            <h2 class="display-6 fw-bold mb-3">Recupera tu acceso</h2>
            <p class="lead fw-light mb-0 brand-desc">
                "No te preocupes, nos pasa a todos. Sigue los pasos y vuelve a conectar con tu equipo en segundos."
            </p>
        </div>
    </div>

    <div class="col-lg-7 col-xl-8 login-form-side">
        <div class="login-card">
            
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo-mh.svg') }}" alt="Muy Humano" class="mh-logo-img">
            </a>

            <h1 class="page-title">¿Olvidaste tu contraseña?</h1>
            <p class="page-subtitle">Ingresa tu correo electrónico y te enviaremos un enlace para que puedas crear una nueva.</p>

            @if (session('status'))
                <div class="alert alert-custom-success" role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-4 position-relative"> <label for="email" class="form-label visually-hidden">Correo electrónico</label>
                    
                    <i class="bi bi-envelope position-absolute" 
                       style="top: 50%; left: 15px; transform: translateY(-50%); color: #9CA3AF; font-size: 1.1rem; z-index: 5;"></i>
                    
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                           placeholder="ejemplo@empresa.com"
                           style="padding-left: 3rem;"> @error('email')
                        <span class="invalid-feedback d-block mt-2" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid gap-2 mb-4">
                    <button type="submit" class="btn btn-primary">
                        Enviar enlace de recuperación
                    </button>
                </div>

                <div class="text-center d-flex flex-column gap-3">
                    <a href="{{ route('login') }}" class="btn-link-custom">
                        <i class="bi bi-arrow-left me-1"></i> Volver al inicio de sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

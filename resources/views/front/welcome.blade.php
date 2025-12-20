{{-- <!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Muy Humano</title>

        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="icon" type="image/x-icon" href="./images/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link rel="stylesheet" href="./css/styles.css">

        <style>
            @media (max-width: 600px) {
                .navbar-brand {
                    margin: 10px auto;
                    padding: 0
                }

                .logo {
                    width: 100%;
                }

                .container-action-button {
                    margin: 10px auto;
                }

            }
        </style>

    </head>

    <body class="d-flex flex-column h-100">
        <main class="flex-shrink-0">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container px-5">
                    <a class="navbar-brand" href="index.html"><img class="logo" src="{{ asset('images/logo-muyhumano-lineal-neutro-300.png') }}" alt="" style="max-width: 300px;"></a>
                    <div class="container-action-button">
                        @if (Route::has('login'))
                            <div class="hidden fixed top-0 right-0 sm:block">
                                @auth
                                    <a href="{{ url('/home') }}" class="btn btn-primary base-link">
                                        Administrador
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-light base-link">
                                        Ingresar
                                    </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </nav>
            <header class="bg-dark py-5">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center justify-content-center">
                        <div class="col-lg-8 col-xl-7 col-xxl-6">
                            <div class="my-5 text-center text-xl-start">
                                <h1 class="display-5 fw-bolder text-white mb-2">Simplifica la gestión, maximiza el potencial</h1>
                                <p class="lead fw-normal text-white-50 mb-4">Nuestra aplicación web revoluciona la gestión de recursos humanos al centralizar todas las funciones clave en una plataforma intuitiva!</p>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                    <a class="btn btn-outline-light btn-lg px-4 me-sm-3" href="#features">Empezar</a>
                                    <a class="btn btn-outline-light btn-lg px-4" href="#features">Aprende más...</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center"><img class="img-fluid rounded-3 my-5" src="{{ asset('images/trabajo-equipo.jpg') }}" alt="..." /></div>
                    </div>
                </div>
            </header>
            <section class="py-5" id="features">
                <div class="container px-5 my-5">
                    <div class="row gx-5">
                        <div class="col-lg-4 mb-5 mb-lg-0"><h2 class="fw-bolder mb-0">La mejor manera de empezar a construir el mejor equipo</h2></div>
                        <div class="col-lg-8">
                            <div class="row gx-5 row-cols-1 row-cols-md-2">
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-aspect-ratio"></i></div>
                                    <h2 class="h5">Centralización de Información</h2>
                                    <p class="mb-0">Almacena y accede fácilmente a todos los datos relevantes de tu equipo, desde su historial laboral hasta sus habilidades y desempeño.</p>
                                </div>
                                <div class="col mb-5 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-collection"></i></div>
                                    <h2 class="h5">Gestión Integral de Tareas y Proyectos</h2>
                                    <p class="mb-0">Utiliza nuestras herramientas para asignar, gestionar y supervisar tareas y proyectos, garantizando que nada se quede sin hacer.</p>
                                </div>
                                <div class="col mb-5 mb-md-0 h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-bar-chart"></i></div>
                                    <h2 class="h5">Monitoreo y Reducción del Ausentismo</h2>
                                    <p class="mb-0">Reduce el impacto del ausentismo en tu empresa con un seguimiento detallado y herramientas para gestionar permisos y ausencias de manera eficiente.</p>
                                </div>
                                <div class="col h-100">
                                    <div class="feature bg-primary bg-gradient text-white rounded-3 mb-3"><i class="bi bi-check-square"></i></div>
                                    <h2 class="h5">Desarrollo y Evaluación del Talento</h2>
                                    <p class="mb-0">Diseña y sigue planes de formación para tus colaboradores, y evalúa su desempeño para asegurarte de que siempre estén creciendo y mejorando.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="py-5 bg-light">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center">
                        <div class="col-lg-10 col-xl-7">
                            <div class="text-center">
                                <div class="fs-4 mb-4 fst-italic">"La inteligencia de una organización no se mide por la inteligencia de sus individuos, sino por la calidad de sus interacciones"</div>
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="fw-bold">
                                        Peter Senge
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer class="bg-dark py-4 mt-auto">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto"><div class="small m-0 text-white">Todos los derechos reservados &copy; MUYHUMANO 2025</div></div>
                </div>
            </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="./js/scripts.js"></script>
    </body>
</html> --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Muy Humano - Gestión de Talento</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet" />
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            /* Paleta de colores "Muy Humano" - Fresca y Natural */
            --primary-color: #12b338; /* Verde bosque */
            --primary-light: #E8F5E9; /* Verde muy suave */
            --accent-color: #ff4600;  /* Naranja cálido para llamadas a la acción */
            --text-dark: #1F2937;
            --text-muted: #6B7280;
            --bg-off-white: #FAFAF9;  /* No es blanco puro, es más natural */
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-dark);
            background-color: var(--bg-off-white);
            overflow-x: hidden;
        }

        /* Navbar Personalizado */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }

        .navbar-brand img {
            height: 45px; /* Ajuste para logo */
            width: auto;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
        }

        /* Botones personalizados */
        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
            border-radius: 50px; /* Bordes totalmente redondeados */
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #1B5E20;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
        }

        .btn-outline-custom {
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 50px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Hero Section */
        .hero-section {
            padding: 80px 0;
            position: relative;
            background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
            border-bottom-left-radius: 80px; /* Toque orgánico */
        }

        .hero-title {
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-muted);
            font-weight: 300;
        }

        .hero-img-container {
            position: relative;
            z-index: 1;
        }

        /* Efecto de mancha orgánica detrás de la imagen */
        .hero-blob {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 120%;
            height: 120%;
            background-color: var(--primary-light);
            border-radius: 48% 52% 68% 32% / 42% 28% 72% 58%;
            z-index: -1;
            animation: blob-bounce 10s infinite ease-in-out;
        }

        @keyframes blob-bounce {
            0%, 100% { border-radius: 48% 52% 68% 32% / 42% 28% 72% 58%; }
            50% { border-radius: 28% 72% 42% 58% / 68% 32% 48% 52%; }
        }

        .hero-img {
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            transform: rotate(-2deg);
            transition: transform 0.5s ease;
        }
        
        .hero-img:hover {
            transform: rotate(0deg);
        }

        /* Features Section */
        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 24px;
            border: 1px solid rgba(0,0,0,0.03);
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0,0,0,0.08);
            border-color: var(--primary-light);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: var(--primary-light);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }

        /* Testimonial */
        .testimonial-section {
            background-color: var(--primary-color);
            color: white;
            border-radius: 24px;
            margin: 3rem auto;
            position: relative;
            overflow: hidden;
        }

        .testimonial-quote {
            font-size: 1.5rem;
            font-style: italic;
            font-weight: 300;
        }

        /* Footer */
        footer {
            background-color: white;
            border-top: 1px solid #eee;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">

    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container px-5">
            <a class="navbar-brand" href="/">
                {{-- <img src="{{ asset('images/logo-muyhumano-lineal-neutro-300.png') }}" alt="Muy Humano" onerror="this.style.display='none'; document.getElementById('logo-txt').style.display='block';"> --}}
                <img src="{{ asset('images/logo-mh-lineal.svg') }}" alt="Muy Humano" onerror="this.style.display='none'; document.getElementById('logo-txt').style.display='block';">
                <span id="logo-txt" style="display:none; font-weight:700; color:var(--primary-color); font-size:1.5rem;">MuyHumano</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item"><a class="nav-link me-3" href="#features">Soluciones</a></li>
                    
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="btn btn-primary-custom">Ir al Panel</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="btn btn-outline-custom me-2">Ingresar</a>
                            </li>
                            {{-- @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="btn btn-primary-custom">Registrarse</a>
                            </li>
                            @endif --}}
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-shrink-0" style="margin-top: 70px;">
        
        <header class="hero-section">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="text-center text-lg-start">
                            <div class="badge bg-success bg-opacity-10 text-success mb-3 px-3 py-2 rounded-pill fw-bold">
                                🚀 Revolución en RRHH
                            </div>
                            <h1 class="display-4 hero-title mb-4">Simplifica la gestión,<br><span style="color: var(--primary-color);">maximiza el potencial</span></h1>
                            <p class="hero-subtitle mb-5">Centraliza, organiza y potencia tu equipo con una plataforma intuitiva diseñada para personas, no solo para recursos.</p>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-lg-start">
                                <a class="btn btn-primary-custom btn-lg px-4 me-sm-3" href="#features">Empezar ahora</a>
                                <a class="btn btn-outline-custom btn-lg px-4" href="#contact">Ver demo</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-block">
                        <div class="hero-img-container">
                            <div class="hero-blob"></div>
                            <img class="img-fluid hero-img" src="{{ asset('images/trabajo-equipo.jpg') }}" alt="Equipo trabajando feliz" style="width: 100%; object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="py-5" id="features">
            <div class="container px-5 my-5">
                <div class="row gx-5 justify-content-center mb-5">
                    <div class="col-lg-8 text-center">
                        <h2 class="fw-bold mb-3">Todo lo que necesitas para tu equipo</h2>
                        <p class="text-muted lead">Herramientas diseñadas para crear un ambiente laboral más productivo y feliz.</p>
                    </div>
                </div>
                
                <div class="row gx-4 gy-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-people"></i>
                            </div>
                            <h3 class="h5 fw-bold">Info Centralizada</h3>
                            <p class="text-muted small mb-0">Accede fácilmente al historial, habilidades y datos clave de cada colaborador en un solo lugar seguro.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-kanban"></i>
                            </div>
                            <h3 class="h5 fw-bold">Gestión de Tareas</h3>
                            <p class="text-muted small mb-0">Asigna y supervisa proyectos con herramientas visuales que garantizan el cumplimiento de objetivos.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-heart-pulse"></i>
                            </div>
                            <h3 class="h5 fw-bold">Bienestar y Asistencia</h3>
                            <p class="text-muted small mb-0">Monitorea el ausentismo y gestiona permisos eficientemente para cuidar la salud de tu organización.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <h3 class="h5 fw-bold">Desarrollo de Talento</h3>
                            <p class="text-muted small mb-0">Planes de formación y evaluación de desempeño para asegurar que tu equipo nunca deje de crecer.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="container px-5">
            <div class="testimonial-section p-5">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <i class="bi bi-quote display-3 opacity-50"></i>
                        <div class="testimonial-quote mb-4">
                            "La inteligencia de una organización no se mide por la inteligencia de sus individuos, sino por la calidad de sus interacciones."
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="fw-bold">
                                — Peter Senge
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer class="py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small text-muted">© 2025 <strong>Muy Humano</strong>. Hecho con <i class="bi bi-heart-fill text-danger"></i> en Medellín.</div>
                </div>
                <div class="col-auto">
                    <a class="link-dark small text-decoration-none me-3" href="#!">Privacidad</a>
                    <a class="link-dark small text-decoration-none" href="#!">Términos</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
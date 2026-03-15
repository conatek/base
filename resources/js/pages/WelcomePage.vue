<template>
    <div class="d-flex flex-column h-100" style="font-family: 'Outfit', sans-serif; background-color: #FAFAF9;">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg fixed-top welcome-navbar">
            <div class="container px-5">
                <router-link class="navbar-brand" to="/">
                    <img :src="'/images/logo-mh-lineal.svg'"
                         alt="Muy Humano"
                         style="height: 45px; width: auto;"
                         @error="showTextLogo = true"
                         v-show="!showTextLogo">
                    <span v-show="showTextLogo"
                          style="font-weight: 700; color: #12b338; font-size: 1.5rem;">MuyHumano</span>
                </router-link>

                <button class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarContent"
                        aria-controls="navbarContent"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link me-3" href="#features">Soluciones</a>
                        </li>
                        <li v-if="isAuthenticated" class="nav-item">
                            <router-link to="/home" class="btn btn-primary-custom">
                                Ir al Panel
                            </router-link>
                        </li>
                        <li v-else class="nav-item">
                            <router-link to="/login" class="btn btn-outline-custom me-2">
                                Ingresar
                            </router-link>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenido principal -->
        <main class="flex-shrink-0" style="margin-top: 70px;">

            <!-- Hero -->
            <header class="hero-section">
                <div class="container px-5">
                    <div class="row gx-5 align-items-center">
                        <div class="col-lg-6">
                            <div class="text-center text-lg-start">
                                <div class="badge bg-success bg-opacity-10 text-success mb-3 px-3 py-2 rounded-pill fw-bold">
                                    🚀 Revolución en RRHH
                                </div>
                                <h1 class="display-4 hero-title mb-4">
                                    Simplifica la gestión,<br>
                                    <span style="color: #12b338;">maximiza el potencial</span>
                                </h1>
                                <p class="hero-subtitle mb-5">
                                    Centraliza, organiza y potencia tu equipo con una plataforma intuitiva diseñada para personas, no solo para recursos.
                                </p>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-lg-start">
                                    <a class="btn btn-primary-custom btn-lg px-4 me-sm-3" href="#features">Empezar ahora</a>
                                    <a class="btn btn-outline-custom btn-lg px-4" href="#contact">Ver demo</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="hero-img-container">
                                <div class="hero-blob"></div>
                                <img class="img-fluid hero-img"
                                     :src="'/images/trabajo-equipo.jpg'"
                                     alt="Equipo trabajando feliz"
                                     style="width: 100%; object-fit: cover;">
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Features -->
            <section class="py-5" id="features">
                <div class="container px-5 my-5">
                    <div class="row gx-5 justify-content-center mb-5">
                        <div class="col-lg-8 text-center">
                            <h2 class="fw-bold mb-3">Todo lo que necesitas para tu equipo</h2>
                            <p class="text-muted lead">
                                Herramientas diseñadas para crear un ambiente laboral más productivo y feliz.
                            </p>
                        </div>
                    </div>

                    <div class="row gx-4 gy-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h3 class="h5 fw-bold">Info Centralizada</h3>
                                <p class="text-muted small mb-0">
                                    Accede fácilmente al historial, habilidades y datos clave de cada colaborador en un solo lugar seguro.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="bi bi-kanban"></i>
                                </div>
                                <h3 class="h5 fw-bold">Gestión de Tareas</h3>
                                <p class="text-muted small mb-0">
                                    Asigna y supervisa proyectos con herramientas visuales que garantizan el cumplimiento de objetivos.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="bi bi-heart-pulse"></i>
                                </div>
                                <h3 class="h5 fw-bold">Bienestar y Asistencia</h3>
                                <p class="text-muted small mb-0">
                                    Monitorea el ausentismo y gestiona permisos eficientemente para cuidar la salud de tu organización.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="bi bi-graph-up-arrow"></i>
                                </div>
                                <h3 class="h5 fw-bold">Desarrollo de Talento</h3>
                                <p class="text-muted small mb-0">
                                    Planes de formación y evaluación de desempeño para asegurar que tu equipo nunca deje de crecer.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Testimonial -->
            <div class="container px-5">
                <div class="testimonial-section p-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 text-center">
                            <i class="bi bi-quote display-3 opacity-50"></i>
                            <div class="testimonial-quote mb-4">
                                "La inteligencia de una organización no se mide por la inteligencia de sus individuos,
                                sino por la calidad de sus interacciones."
                            </div>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="fw-bold">— Peter Senge</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>

        <!-- Footer -->
        <footer class="py-4 mt-auto welcome-footer">
            <div class="container px-5">
                <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                    <div class="col-auto">
                        <div class="text-muted">Todos los derechos reservados &copy; Muy Humano {{ currentYear }}</div>
                    </div>
                    <div class="col-auto">
                        <a class="link-dark small text-decoration-none me-3" href="#">Privacidad</a>
                        <a class="link-dark small text-decoration-none" href="#">Términos</a>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</template>

<script>
import auth from '@/store/auth';

export default {
    name: 'WelcomePage',

    data() {
        return {
            showTextLogo: false,
        };
    },

    computed: {
        isAuthenticated() {
            return !!auth.user;
        },

        currentYear() {
            return new Date().getFullYear();
        },
    },
};
</script>

<style scoped>
:root {
    --primary-color: #12b338;
    --primary-light: #E8F5E9;
    --accent-color: #ff4600;
    --text-dark: #1F2937;
    --text-muted: #6B7280;
    --bg-off-white: #FAFAF9;
}

.welcome-navbar {
    background-color: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
    padding: 1rem 0;
}

.nav-link {
    font-weight: 500;
    color: #1F2937 !important;
}

.btn-primary-custom {
    background-color: #12b338;
    border-color: #12b338;
    color: white;
    border-radius: 50px;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-primary-custom:hover {
    background-color: #1B5E20;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(46, 125, 50, 0.3);
}

.btn-outline-custom {
    color: #12b338;
    border: 2px solid #12b338;
    border-radius: 50px;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-outline-custom:hover {
    background-color: #12b338;
    color: white;
}

.hero-section {
    padding: 80px 0;
    position: relative;
    background: linear-gradient(135deg, #ffffff 0%, #f0fdf4 100%);
    border-bottom-left-radius: 80px;
}

.hero-title {
    font-weight: 700;
    color: #1F2937;
    letter-spacing: -0.5px;
    line-height: 1.2;
}

.hero-subtitle {
    font-size: 1.2rem;
    color: #6B7280;
    font-weight: 300;
}

.hero-img-container {
    position: relative;
    z-index: 1;
}

.hero-blob {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 120%;
    height: 120%;
    background-color: #E8F5E9;
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
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    transform: rotate(-2deg);
    transition: transform 0.5s ease;
}

.hero-img:hover {
    transform: rotate(0deg);
}

.feature-card {
    background: white;
    padding: 2.5rem;
    border-radius: 24px;
    border: 1px solid rgba(0, 0, 0, 0.03);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
    transition: all 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 30px rgba(0, 0, 0, 0.08);
    border-color: #E8F5E9;
}

.feature-icon {
    width: 60px;
    height: 60px;
    background-color: #E8F5E9;
    color: #12b338;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
}

.testimonial-section {
    background-color: #12b338;
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

.welcome-footer {
    background-color: white;
    border-top: 1px solid #eee;
}
</style>

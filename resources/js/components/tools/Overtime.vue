<template>
  <div class="overtime-container">
    <div class="card">
      <div class="illustration">
        <!-- <img src="@/assets/under-construction.svg" alt="Módulo en desarrollo" /> -->
        <img src="../../assets/images/under-construction.svg" alt="Módulo en desarrollo" />
      </div>
      <h2>Control de Horas Extras</h2>
      <p class="message">Estamos construyendo esta sección para ti.</p>
      <p class="subtext">Muy pronto podrás gestionar todas las horas extras del personal desde aquí.</p>
      <!-- <button class="notify-button" @click="notifyMe">Notificarme cuando esté listo</button> -->
    </div>
  </div>
</template>

<script>
export default {
  name: 'Provision',
  methods: {
    notifyMe() {
      alert("Gracias. Te notificaremos cuando esté disponible."); // Puedes reemplazar esto con una lógica real
    }
  }
};
</script>

<style scoped>
.overtime-container {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 3rem;
  background: linear-gradient(135deg, #f0f4f8, #ffffff);
  min-height: 300px;
}

.card {
  background: white;
  padding: 2rem 2.5rem;
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
  text-align: center;
  max-width: 400px;
  width: 100%;
}

.illustration img {
  width: 100%;
  height: auto;
  margin-bottom: 1.5rem;
}

h2 {
  font-size: 1.75rem;
  margin-bottom: 0.5rem;
  color: #333;
}

.message {
  font-size: 1.1rem;
  font-weight: 500;
  color: #444;
  margin-bottom: 0.5rem;
}

.subtext {
  font-size: 0.9rem;
  color: #666;
  margin-bottom: 1.5rem;
}

.notify-button {
  background-color: #4f46e5;
  color: white;
  border: none;
  padding: 0.6rem 1.25rem;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.notify-button:hover {
  background-color: #4338ca;
}
</style>

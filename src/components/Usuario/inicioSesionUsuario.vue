<template>
    <div class="flex flex-col items-center">
        <h1 class="text-4xl font-bold text-center mt-6">Inicio de Sesión</h1>

        <form @submit.prevent="handleLogin" class="mt-6 w-96">
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                <input v-model="nombre" type="text" id="nombre" name="nombre" class="w-full p-2 border rounded-lg"
                    required />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                <input v-model="password" type="password" id="password" name="password"
                    class="w-full p-2 border rounded-lg" required />
            </div>
            <div class="flex justify-center">
                <button type="submit" class="fwb-button w-32 bg-blue-500 text-white rounded-lg p-2 hover:bg-blue-700">
                    Iniciar sesión
                </button>
            </div>
        </form>

        <div class="mt-4">
            <p>¿No tienes cuenta? <a @click="toggleRegister" class="text-blue-500 cursor-pointer">Regístrate</a></p>
        </div>

        <div v-if="isRegistering" class="mt-6">
            <RegistroUsuario @registered="handleRegistration" />
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import RegistroUsuario from './registroUsuario.vue';
const nombre = ref('');
const password = ref('');
const isRegistering = ref(false); 

const handleLogin = () => {
    alert('Usuario autenticado');
};

const toggleRegister = () => {
    isRegistering.value = !isRegistering.value;  
};

const handleRegistration = () => {
    alert('Usuario registrado');
    isRegistering.value = false;
};
</script>
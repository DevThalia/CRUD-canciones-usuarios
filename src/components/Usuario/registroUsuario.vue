<template>
    <div class="flex flex-col items-center">
        <h1 class="text-4xl font-bold text-center mt-6">Registro de Usuario</h1>
        <form @submit.prevent="registrarUsuario" class="mt-6 w-96">
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
                    Registrar
                </button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
const nombre = ref('');
const password = ref('');
const emit = defineEmits();
const registrarUsuario = async () => {
    try {
        const response = await fetch(
            `http://localhost/proyectoVue/proyecto-vue/api/Usuario/POST/registroUsuario.php`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    nombre: nombre.value,
                    password: password.value,
                }),
            }
        );
        const result = await response.json();
        if (result.success) {
            alert('Usuario registrado exitosamente');
            emit('registered');
        } else {
            alert('Error al registrar el usuario: ' + result.message);
        }
    } catch (error) {
        console.error('Error de red:', error);
        alert('Error de conexión al servidor');
    }
};
</script>

<style scoped></style>
<template>
    <div class="p-6 max-w-7xl mx-auto">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">Crear Usuario</h2>

        <!-- Formulario de creación de usuario -->
        <form @submit.prevent="crearUsuario" class="space-y-4">
            <div>
                <label for="name" class="block text-gray-700">Nombre:</label>
                <input v-model="newUser.name" type="text" id="name" required class="input input-bordered w-full" />
            </div>

            <div>
                <label for="username" class="block text-gray-700">Username:</label>
                <input v-model="newUser.username" type="text" id="username" required
                    class="input input-bordered w-full" />
            </div>

            <div>
                <label for="email" class="block text-gray-700">Correo:</label>
                <input v-model="newUser.email" type="email" id="email" required class="input input-bordered w-full" />
            </div>

            <div>
                <label for="phone" class="block text-gray-700">Teléfono:</label>
                <input v-model="newUser.phone" type="text" id="phone" required class="input input-bordered w-full" />
            </div>

            <button @click="cancelarCreacionUsuario" type="button"
                class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-200 transition">
                Cancelar
            </button>
            <fwb-button color="green" pill type="submit" class="btn btn-primary w-full">Crear Usuario</fwb-button>

        </form>

        <!-- Mensajes de éxito o error -->
        <div v-if="message" :class="messageClass" class="mt-4 p-4 rounded-lg">
            {{ message }}
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { FwbButton } from 'flowbite-vue';

const newUser = ref({
    name: '',
    username: '',
    email: '',
    phone: ''
});

const message = ref('');
const messageClass = ref('');
const router = useRouter();

const crearUsuario = async () => {
    try {
        const response = await fetch('http://localhost/proyectoVue/proyecto-vue/api/Usuario/PUT/crearUsuario.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: newUser.value.name,
                username: newUser.value.username,
                email: newUser.value.email,
                phone: newUser.value.phone
            })
        });

        const data = await response.json();

        if (data.success) {
            message.value = 'Usuario creado exitosamente';
            messageClass.value = 'success';
            router.push({ name: 'listarUsuarios' });
        } else {
            message.value = `Error: ${data.message}`;
            messageClass.value = 'error';
        }
    } catch (error) {
        message.value = 'Hubo un error al crear el usuario';
        messageClass.value = 'error';
    }
};

const cancelarCreacionUsuario = () => {
    router.push({ name: 'listarUsuarios' });
};
</script>

<style scoped>
.success {
    background-color: #d4edda;
    color: #155724;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
}
</style>

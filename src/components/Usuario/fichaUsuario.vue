<template>
    <div class="p-6 max-w-7xl mx-auto">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">Ficha de Usuario</h2>

        <!-- Mensaje de carga -->
        <div v-if="loading" class="flex justify-center items-center">
            <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="4" class="opacity-25" />
                <path fill="currentColor" d="M4 12a8 8 0 118 8 8 8 0 01-8-8z" />
            </svg>
            <span class="ml-3 text-lg text-gray-600">Cargando...</span>
        </div>

        <div v-else-if="usuario" class="bg-white shadow-xl rounded-xl p-8 space-y-6">
            <div class="flex justify-between items-center">
                <!-- Botón de volver a la lista -->
                <router-link to="/listar-usuarios"
                    class="bg-blue-500 text-white py-2 px-3 rounded-md text-base hover:bg-blue-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Volver a la lista
                </router-link>
                <div class="text-right">
                    <button @click="editarUsuario"
                        class="bg-yellow-500 text-white py-2 px-4 rounded-xl hover:bg-yellow-400 transition">
                        <i class="fas fa-edit mr-2"></i> Editar
                    </button>
                    <button @click="eliminarUsuario"
                        class="bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-red-400 transition ml-4">
                        <i class="fas fa-trash mr-2"></i> Eliminar
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-3xl font-bold text-gray-800">{{ usuario.name }}</h3>
                <p class="text-xl text-gray-600"><strong>Nombre usuario:</strong> {{ usuario.username }}</p>
                <p class="text-xl text-gray-600"><strong>Email:</strong> {{ usuario.email }}</p>
                <p class="text-xl text-gray-600"><strong>Telefono:</strong> {{ usuario.phone }}</p>
                <p class="text-xl text-gray-600"><strong>Nivel:</strong> {{ usuario.nivel }}</p>
            </div>
        </div>


        <!-- Formulario de edición (solo visible cuando isEditing es true) -->
        <div v-if="isEditing" class="mt-8">
            <div class="bg-white shadow-xl rounded-xl p-8 space-y-6">
                <h3 class="text-2xl font-bold text-gray-800">Editar Usuario</h3>
                <form @submit.prevent="guardarCambiosUsuario" class="space-y-4">
                    <div>
                        <label for="name" class="block text-lg text-gray-700">Nombre</label>
                        <input type="text" id="name" v-model="usuario.name" required
                            class="input input-bordered w-full py-3 px-4 rounded-lg" />
                    </div>
                    <div>
                        <label for="username" class="block text-lg text-gray-700">Nombre de usuario</label>
                        <input type="text" id="username" v-model="usuario.username" required
                            class="input input-bordered w-full py-3 px-4 rounded-lg" />
                    </div>
                    <div>
                        <label for="email" class="block text-lg text-gray-700">Email</label>
                        <input type="text" id="email" v-model="usuario.email" required
                            class="input input-bordered w-full py-3 px-4 rounded-lg" />
                    </div>
                    <div>
                        <label for="phone" class="block text-lg text-gray-700">Telefono</label>
                        <input type="number" id="phone" v-model="usuario.phone" required
                            class="input input-bordered w-full py-3 px-4 rounded-lg" />
                    </div>
                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-green-500 text-white py-2 px-6 rounded-lg hover:bg-green-400 transition">
                            Guardar Cambios
                        </button>
                        <button @click="cancelarEdicionUsuario" type="button"
                            class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-200 transition">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mensajes de éxito o error -->
        <div v-if="message" :class="messageClass" class="mt-6 p-4 rounded-lg">
            {{ message }}
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';


const route = useRoute();
const router = useRouter();
const userId = route.params.userId;

const usuario = ref({
    name: '',
    username: '',
    email: '',
    phone: '',
    nivel: ''
});

const loading = ref(true);
const isEditing = ref(false);
const message = ref('');
const messageClass = ref('');

const cargarUsuario = async () => {
    if (userId) {
        try {
            const response = await fetch(`http://localhost/proyectoVue/proyecto-vue/api/Usuario/GET/fichaUsuario.php?userId=${userId}`);
            const data = await response.json();

            if (data.success) {
                usuario.value = data.data;
                loading.value = false;
            } else {
                message.value = data.message;
                messageClass.value = 'error';
            }
        } catch (error) {
            message.value = 'Error al cargar el usuario';
            messageClass.value = 'error';
        }
    }
};

const eliminarUsuario = async () => {
    if (!userId) {
        message.value = 'No se ha especificado un usuario';
        messageClass.value = 'error';
        return;
    }

    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        try {
            const response = await fetch(`http://localhost/proyectoVue/proyecto-vue/api/Usuario/POST/eliminaUsuario.php?userId=${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ userId })
            });
            const data = await response.json();

            if (data.success) {
                message.value = 'Usuario eliminado exitosamente';
                messageClass.value = 'success';
                router.push({ name: 'listarUsuarios' });
            } else {
                message.value = data.message;
                messageClass.value = 'error';
            }
        } catch (error) {
            message.value = 'Error al eliminar el usuario';
            messageClass.value = 'error';
        }
    }
};

const editarUsuario = () => {
    isEditing.value = true;
};

const guardarCambiosUsuario = async () => {
    if (!usuario.value.name || !usuario.value.username || !usuario.value.email || !usuario.value.phone) {
        message.value = 'Por favor, completa todos los campos';
        messageClass.value = 'error';
        return;
    }

    const updatedUser = {
        userId: userId,
        name: usuario.value.name,
        username: usuario.value.username,
        email: usuario.value.email,
        phone: usuario.value.phone
    };

    try {
        const response = await fetch(`http://localhost/proyectoVue/proyecto-vue/api/Usuario/POST/actualizaUsuario.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(updatedUser)
        });
        const result = await response.json();
        if (result.success) {
            message.value = 'Usuario actualizado exitosamente';
            messageClass.value = 'success';
            router.push({ name: 'listarUsuarios' });
        } else {
            message.value = result.message;
            messageClass.value = 'error';
        }
    } catch (error) {
        message.value = 'Error al actualizar el usuario';
        messageClass.value = 'error';
    }
};

const cancelarEdicionUsuario = () => {
    isEditing.value = false;
    cargarUsuario();
};

onMounted(() => {
    cargarUsuario();
});
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

.input {
    border: 1px solid #ccc;
    padding: 0.75rem;
    border-radius: 0.375rem;
    width: 100%;
}

.input-bordered {
    border-color: #ddd;
}

.btn-success {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border-radius: 0.375rem;
    cursor: pointer;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
    padding: 10px 20px;
    border-radius: 0.375rem;
    cursor: pointer;
}

.btn:hover {
    opacity: 0.8;
}
</style>

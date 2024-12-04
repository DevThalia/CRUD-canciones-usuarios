<template>
    <div class="p-6 max-w-7xl mx-auto space-y-6">
        <h2 class="text-4xl font-bold text-gray-800 text-center mb-6">Ficha de Canción</h2>

        <!-- Mensaje de carga -->
        <div v-if="loading" class="flex justify-center items-center">
            <svg class="animate-spin h-12 w-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <circle cx="12" cy="12" r="10" stroke-width="4" class="opacity-25" />
                <path fill="currentColor" d="M4 12a8 8 0 118 8 8 8 0 01-8-8z" />
            </svg>
            <span class="ml-3 text-lg text-gray-600">Cargando...</span>
        </div>

        <!-- Información de la canción -->
        <div v-else-if="cancion" class="bg-white shadow-xl rounded-xl p-8 space-y-6">
            <div class="flex justify-between items-center">
                <!-- Botón de volver a la lista -->
                <router-link to="/listar-canciones"
                    class="bg-blue-500 text-white py-2 px-3 rounded-md text-base hover:bg-blue-400 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Volver a la lista
                </router-link>
                <div class="text-right">
                    <button @click="editarCancion"
                        class="bg-yellow-500 text-white py-2 px-4 rounded-xl hover:bg-yellow-400 transition">
                        <i class="fas fa-edit mr-2"></i> Editar
                    </button>
                    <button @click="eliminarCancion"
                        class="bg-red-500 text-white py-2 px-4 rounded-xl hover:bg-red-400 transition ml-4">
                        <i class="fas fa-trash mr-2"></i> Eliminar
                    </button>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-3xl font-bold text-gray-800">{{ cancion.title }}</h3>
                <p class="text-xl text-gray-600"><strong>Artista:</strong> {{ cancion.artist }}</p>
                <p class="text-xl text-gray-600"><strong>Álbum:</strong> {{ cancion.album }}</p>
                <p class="text-xl text-gray-600"><strong>Año:</strong> {{ cancion.year }}</p>
            </div>
        </div>

        <!-- Formulario de edición (solo visible cuando isEditing es true) -->
        <div v-if="isEditing" class="mt-8">
            <div class="bg-white shadow-xl rounded-xl p-8 space-y-6">
                <h3 class="text-2xl font-bold text-gray-800">Editar Canción</h3>
                <form @submit.prevent="guardarCambiosCancion" class="space-y-4">
                    <div>
                        <label for="title" class="block text-lg text-gray-700">Título</label>
                        <input type="text" id="title" v-model="cancion.title" required
                            class="input input-bordered w-full py-3 px-4 rounded-lg" />
                    </div>
                    <div>
                        <label for="artist" class="block text-lg text-gray-700">Artista</label>
                        <input type="text" id="artist" v-model="cancion.artist" required
                            class="input input-bordered w-full py-3 px-4 rounded-lg" />
                    </div>
                    <div>
                        <label for="album" class="block text-lg text-gray-700">Álbum</label>
                        <input type="text" id="album" v-model="cancion.album" required
                            class="input input-bordered w-full py-3 px-4 rounded-lg" />
                    </div>
                    <div>
                        <label for="year" class="block text-lg text-gray-700">Año</label>
                        <input type="number" id="year" v-model="cancion.year" required
                            class="input input-bordered w-full py-3 px-4 rounded-lg" />
                    </div>
                    <div class="flex gap-4">
                        <button type="submit"
                            class="bg-green-500 text-white py-2 px-6 rounded-lg hover:bg-green-400 transition">
                            Guardar Cambios
                        </button>
                        <button @click="cancelarEdicion" type="button"
                            class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-200 transition">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mensajes de éxito o error -->
        <div v-if="message" :class="messageClass" class="mt-6 p-6 rounded-xl">
            {{ message }}
        </div>
    </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const songId = route.params.songId;

const cancion = ref({
    title: '',
    artist: '',
    album: '',
    year: ''
});
const loading = ref(true);
const message = ref('');
const messageClass = ref('');
const isEditing = ref(false);

const cargarCancion = async () => {
    if (songId) {
        try {
            const response = await fetch(`http://localhost/proyectoVue/proyecto-vue/api/Cancion/GET/fichaCancion.php?songId=${songId}`);
            const result = await response.json();

            if (result.success) {
                cancion.value = result.data;
            } else {
                console.error(result.message);
                cancion.value = null;
            }
        } catch (error) {
            console.error('Error al cargar la canción:', error);
            cancion.value = null;
        } finally {
            loading.value = false;
        }
    } else {
        console.error('ID de canción no proporcionado.');
        loading.value = false;
    }
};

const eliminarCancion = async () => {
    if (!songId) {
        message.value = 'ID de canción no proporcionado.';
        messageClass.value = 'error';
        return;
    }
    if (confirm('¿Estás seguro de que deseas eliminar esta canción?')) {
        try {
            const response = await fetch('http://localhost/proyectoVue/proyecto-vue/api/Cancion/POST/eliminaCancion.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ songId })
            });

            const result = await response.json();

            if (result.success) {
                message.value = 'Canción eliminada exitosamente.';
                messageClass.value = 'success';
                router.push({ name: 'listarCanciones' });
            } else {
                message.value = `Error al eliminar la canción: ${result.message}`;
                messageClass.value = 'error';
            }
        } catch (error) {
            message.value = 'Hubo un error al intentar eliminar la canción.';
            messageClass.value = 'error';
            console.error(error);
        }
    }
};

const editarCancion = () => {
    isEditing.value = true;
};

const cancelarEdicion = () => {
    isEditing.value = false;
    cargarCancion();
};

const guardarCambiosCancion = async () => {
    if (!cancion.value.title || !cancion.value.artist || !cancion.value.album || !cancion.value.year) {
        message.value = 'Todos los campos son obligatorios.';
        messageClass.value = 'error';
        return;
    }

    const updatedCancion = {
        songId: songId,
        title: cancion.value.title,
        artist: cancion.value.artist,
        album: cancion.value.album,
        year: cancion.value.year
    };

    try {
        const response = await fetch('http://localhost/proyectoVue/proyecto-vue/api/Cancion/POST/actualizaCancion.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedCancion)
        });

        const result = await response.json();

        if (result.success) {
            message.value = 'Canción editada exitosamente.';
            messageClass.value = 'success';
            router.push({ name: 'listarCanciones' });
        } else {
            message.value = `Error al editar la canción: ${result.message}`;
            messageClass.value = 'error';
        }
    } catch (error) {
        message.value = 'Hubo un error al intentar editar la canción.';
        messageClass.value = 'error';
        console.error(error);
    }
};

onMounted(() => {
    cargarCancion();
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
</style>
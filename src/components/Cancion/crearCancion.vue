<template>
    <div class="p-6 max-w-7xl mx-auto">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">Crear Canción</h2>

        <!-- Formulario de creación de canción -->
        <form @submit.prevent="crearCancion" class="space-y-4">
            <div>
                <label for="title" class="block text-gray-700">Título:</label>
                <input v-model="newSong.title" type="text" id="title" required class="input input-bordered w-full" />
            </div>

            <div>
                <label for="artist" class="block text-gray-700">Artista:</label>
                <input v-model="newSong.artist" type="text" id="artist" required class="input input-bordered w-full" />
            </div>

            <div>
                <label for="album" class="block text-gray-700">Álbum:</label>
                <input v-model="newSong.album" type="text" id="album" required class="input input-bordered w-full" />
            </div>

            <div>
                <label for="year" class="block text-gray-700">Año:</label>
                <input v-model="newSong.year" type="number" id="year" required class="input input-bordered w-full" />
            </div>

            <button @click="cancelarCreacionCancion" type="button"
                class="bg-gray-300 text-gray-800 py-2 px-6 rounded-lg hover:bg-gray-200 transition">
                Cancelar
            </button>

            <fwb-button color="green" pill type="submit" class="btn btn-primary w-full">Crear Canción</fwb-button>

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
import { FwbButton } from 'flowbite-vue'

const newSong = ref({
    title: '',
    artist: '',
    album: '',
    year: ''
});

const message = ref('');
const messageClass = ref('');
const router = useRouter();

const crearCancion = async () => {
    try {
        const response = await fetch('http://localhost/proyectoVue/proyecto-vue/api/Cancion/PUT/crearCancion.php', {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                title: newSong.value.title,
                artist: newSong.value.artist,
                album: newSong.value.album,
                year: newSong.value.year
            })
        });

        const data = await response.json();

        if (data.success) {
            message.value = 'Canción creada exitosamente';
            messageClass.value = 'success';
            router.push({ name: 'listarCanciones' });
        } else {
            message.value = `Error: ${data.message}`;
            messageClass.value = 'error';
        }
    } catch (error) {
        message.value = 'Hubo un error al crear la canción';
        messageClass.value = 'error';
    }
};

const cancelarCreacionCancion = () => {
    router.push({ name: 'listarCanciones' });
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
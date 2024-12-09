<template>
  <div class="p-6 max-w-7xl mx-auto">
    <h2 class="text-3xl font-semibold text-gray-800 mb-4">Listado de Canciones</h2>

    <!-- Botón para crear una canción -->
    <router-link to="/crear-cancion">
      <fwb-button color="yellow" pill type="submit" class="btn btn-primary w-full">Crear canción</fwb-button>
    </router-link>

    <!-- Mensaje de carga -->
    <div v-if="loading" class="flex justify-center items-center">
      <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <circle cx="12" cy="12" r="10" stroke-width="4" class="opacity-25"/>
        <path fill="currentColor" d="M4 12a8 8 0 118 8 8 8 0 01-8-8z"/>
      </svg>
      <span class="ml-3 text-lg text-gray-600">Cargando canciones...</span>
    </div>

    <!-- Tabla de canciones -->
    <table v-else class="table-auto w-full text-left bg-white shadow-md rounded-lg">
      <thead class="bg-gray-100">
        <tr>
          <th class="px-6 py-4 text-lg font-semibold text-gray-700">
            ID
            <input
              type="text"
              v-model="filtros.id"
              placeholder="Filtrar por ID"
              class="w-full p-2 border rounded-lg mt-2"
            />
          </th>
          <th class="px-6 py-4 text-lg font-semibold text-gray-700">
            Título
            <input
              type="text"
              v-model="filtros.titulo"
              placeholder="Filtrar por Título"
              class="w-full p-2 border rounded-lg mt-2"
            />
          </th>
          <th class="px-6 py-4 text-lg font-semibold text-gray-700">
            Artista
            <input
              type="text"
              v-model="filtros.artista"
              placeholder="Filtrar por Artista"
              class="w-full p-2 border rounded-lg mt-2"
            />
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cancion in paginatedCanciones" :key="cancion.songId" class="border-b hover:bg-gray-50">
          <td class="px-6 py-4 text-lg text-gray-800">
            <router-link :to="'/cancion/' + cancion.songId" class="text-blue-500 hover:underline">
              {{ cancion.songId }}
            </router-link>
          </td>
          <td class="px-6 py-4 text-lg text-gray-800">{{ cancion.title }}</td>
          <td class="px-6 py-4 text-lg text-gray-800">{{ cancion.artist }}</td>
        </tr>
      </tbody>
    </table>

    <div class="mt-6 flex justify-center">
      <fwb-pagination 
        v-model="currentPage" 
        :total-pages="totalPages" 
        :layout="'pagination'"
        :show-dots="true"
      ></fwb-pagination>
    </div>
  </div>
</template>

<script setup>
import { ref, onBeforeMount, computed } from 'vue';
import { FwbButton, FwbPagination } from 'flowbite-vue';

const canciones = ref([]);
const loading = ref(true);
const currentPage = ref(1);
const itemsPerPage = 10;  

// Filtros por columna
const filtros = ref({
  id: '',
  titulo: '',
  artista: ''
});

const cargarCanciones = async () => {
  try {
    const response = await fetch(`http://localhost/proyectoVue/proyecto-vue/api/Cancion/GET/listaCanciones.php`);
    const result = await response.json();

    if (result.success) {
      canciones.value = result.data;
    } else {
      console.error('Error al obtener canciones:', result.message);
      canciones.value = [];
    }
  } catch (error) {
    console.error('Error de red:', error);
    canciones.value = [];
  } finally {
    loading.value = false;
  }
};

const cancionesFiltradas = computed(() => {
  return canciones.value.filter(cancion => {
    const matchId = filtros.value.id
      ? cancion.songId.toString().includes(filtros.value.id)
      : true;
    const matchTitulo = filtros.value.titulo
      ? cancion.title.toLowerCase().includes(filtros.value.titulo.toLowerCase())
      : true;
    const matchArtista = filtros.value.artista
      ? cancion.artist.toLowerCase().includes(filtros.value.artista.toLowerCase())
      : true;

    return matchId && matchTitulo && matchArtista;
  });
});

const paginatedCanciones = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage;
  return cancionesFiltradas.value.slice(startIndex, startIndex + itemsPerPage);
});

const totalPages = computed(() => {
  return Math.ceil(cancionesFiltradas.value.length / itemsPerPage);
});

onBeforeMount(cargarCanciones);
</script>

<style scoped>
table {
  font-size: 1.125rem;  
}

th, td {
  padding: 1rem;  
}

input {
  font-size: 1rem;
}
</style>

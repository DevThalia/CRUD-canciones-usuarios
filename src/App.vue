<template>
  <div class="min-h-screen flex">
    <div class="w-64 bg-green-500 text-white p-6 fixed top-0 left-0 bottom-0 flex flex-col justify-between">
      <div>
        <h1 class="text-3xl font-bold mb-8">Gestión de usuarios y canciones</h1>
        <div class="space-y-4">
          <router-link 
            class="block p-4 bg-green-700 rounded-lg hover:bg-green-600" 
            :to="{ path: '/listar-canciones' }" 
            @click="mostrarLista('canciones')">Lista de canciones</router-link>
          <router-link 
            class="block p-4 bg-green-700 rounded-lg hover:bg-green-600" 
            :to="{ path: '/listar-usuarios' }" 
            @click="mostrarLista('usuarios')">Lista de usuarios</router-link>
          <router-link
          class="block p-4 bg-green-700 rounded-lg hover:bg-green-600" 
          :to="{ path: '/lista-proveedores' }"
          @click="mostrarLista('proveedores')">Lista de proveedores</router-link>
        </div>
      </div>
    </div>
    <div class="flex-1 p-8 ml-64 bg-gray-100">
      <div v-if="showList">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
const showList = ref(false);
const currentList = ref(null);
const mostrarLista = (list) => {
  currentList.value = list;
  showList.value = true;
};
</script>

<style scoped>
.bg-green-500 {
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.fixed {
  position: fixed;
}

button:hover {
  transform: translateY(-2px);
  transition: transform 0.2s ease-in-out;
}

button:active {
  transform: translateY(0);
}

.flex-1 {
  flex: 1;
  background-color: #f0f9f4;
  padding: 2rem;
}

.ml-64 {
  margin-left: 16rem; 
}

.fwb-button {
  background-color: #4CAF50;
  color: white;
}

.fwb-button:hover {
  background-color: #45a049;
}
</style>

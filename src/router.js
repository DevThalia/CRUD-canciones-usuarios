import { createRouter, createWebHistory } from 'vue-router';
//CANCIONES
import listarCanciones from './components/Cancion/listarCanciones.vue';
import fichaCancion from './components/Cancion/fichaCancion.vue';
import crearCancion from './components/Cancion/crearCancion.vue';
//USUARIOS
import listarUsuarios from './components/Usuario/listarUsuarios.vue';
import fichaUsuario from './components/Usuario/fichaUsuario.vue';
import crearUsuario from './components/Usuario/crearUsuario.vue';
//HOME
import App from './App.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: App
  },

  {
    path: '/listar-canciones',
    name: 'listarCanciones',
    component: listarCanciones,
  },
  {
    path: '/cancion/:songId',
    name: 'fichaCancion',
    component: fichaCancion,
    props: true,
  },
  {
    path: '/crear-cancion',
    name: 'CrearCancion',
    component: crearCancion
  },
  {
    path: '/listar-usuarios',
    name: 'listarUsuarios',
    component: listarUsuarios,
  },
  {
    path: '/crear-usuario',
    name: 'crearUsuario',
    component: crearUsuario,
  },
  {
    path: '/usuario/:userId',
    name: 'fichaUsuario',
    component: fichaUsuario,
    props: true,
  },

  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
];


const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;


import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

//Importar Flowbite CSS
import 'flowbite/dist/flowbite.min.css';


createApp(App)
  .use(router)
  .mount('#app');

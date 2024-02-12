import {createApp} from 'vue'
import 'ant-design-vue/dist/reset.css';
import '../css/app.css';
import Antd from 'ant-design-vue';
import App from './App.vue'
import router from './routes';
import { createPinia } from 'pinia';

const pinia = createPinia();
createApp(App).use(pinia).use(router).use(Antd).mount("#app");
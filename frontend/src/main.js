import { createApp } from 'vue'
import { Toaster } from 'vue-sonner'
import App from './App.vue'
import './assets/main.css'

const app = createApp(App)
app.component('Toaster', Toaster)
app.mount('#app')
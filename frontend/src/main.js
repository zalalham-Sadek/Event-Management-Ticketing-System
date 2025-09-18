import { createApp } from 'vue'
import App from './App.vue'
import NavBar from './components/NavBar.vue'
import router from './router'
import { i18n } from './i18n'
import '@fortawesome/fontawesome-free/css/all.min.css'
import InputField from './components/InputField.vue'
import ToastMessage from './components/ToastMessage.vue'
import { createPinia } from 'pinia'

const app = createApp(App)
const pinia = createPinia()

app.component('app-header', NavBar)
app.component('InputFeld', InputField)
app.component('ToastMessage',ToastMessage)
app.use(router)
app.use(i18n)
app.use(pinia)
app.mount('#app')

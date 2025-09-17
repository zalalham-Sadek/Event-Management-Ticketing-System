import { createApp } from 'vue'
import App from './App.vue'
import NavBar from './components/NavBar.vue'
import router from './router'
import { i18n } from './i18n'
import '@fortawesome/fontawesome-free/css/all.min.css'
import InputField from './components/InputField.vue'

const app = createApp(App)
app.component('app-header', NavBar)
app.component('InputFeld', InputField)
app.use(router)
app.use(i18n)
app.mount('#app')

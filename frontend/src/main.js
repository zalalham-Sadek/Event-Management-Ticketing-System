import { createApp } from 'vue'
import App from './App.vue'
import NavBar from './components/NavBar.vue'
import router from './router'
import { i18n } from './i18n'

const app = createApp(App)
app.component('app-header', NavBar)
app.use(router)
app.use(i18n)
app.mount('#app')

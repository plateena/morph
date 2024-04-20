import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { store, key } from './store'
import axios from 'axios'
import axiosPlugin from './axios-plugin'

const app = createApp(App)

app.use(axiosPlugin, { axios })
app.use(router)
app.use(store, key)

app.mount('#app')

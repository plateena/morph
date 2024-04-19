import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'
import axiosPlugin from './axios-plugin'

const app = createApp(App)

// app.use(axiosPlugin, { axios, baseUrl: process.env.API_BASE_URL })
app.use(axiosPlugin, { axios })
app.use(router)

app.mount('#app')

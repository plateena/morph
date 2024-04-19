// axios-plugin.ts
import { AxiosInstance } from 'axios'
import { App } from 'vue'

interface AxiosPluginOptions {
    axios?: AxiosInstance
    baseUrl?: string
}

const axiosPlugin = {
    install(app: App, options: AxiosPluginOptions = {}) {
        const { axios, baseUrl } = options

        if (!axios) {
            throw new Error('Axios instance is required in plugin options.')
        }

        // Read base URL from options or use a default value
        const baseURL = baseUrl || import.meta.env.VITE_API_BASE_URL || 'http://localhost/api'

        axios.defaults.baseURL = baseURL

        app.config.globalProperties.$axios = axios
    }
}

export default axiosPlugin

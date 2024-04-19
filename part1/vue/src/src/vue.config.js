module.exports = {
    publicPath: process.env.NODE_ENV === '/vue',
    pluginOptions: {
        axios: {
            baseURL: import.meta.env.VITE_API_BASE_URL + '/v2' || 'http://localhost/api/v1/'
        }
    }
}

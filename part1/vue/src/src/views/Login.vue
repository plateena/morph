<!-- Login.vue -->
<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required />
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="password" required />
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
import { store } from './../store'

export default {
    data() {
        return {
            email: 'kafuvyqude@mailinator.com',
            password: 'Pa$$w0rd!'
        }
    },
    methods: {
        async login() {
            try {
                const response = await this.$axios.post('login', {
                    email: this.email,
                    password: this.password,
                    device_name: '*'
                })
                // Handle successful login response
                store.commit('saveToken', response.data.data.token)

                // Redirect to dashboard or perform other actions
                this.$router.push({ name: 'home' })
            } catch (error) {
                // Handle login error
                console.error('Login error:', error)
                // Display error message to the user
            }
        }
    }
}
</script>

<style scoped>
/* Add CSS styles for your login form */
</style>

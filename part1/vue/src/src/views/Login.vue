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
import axios from 'axios'
export default {
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        login() {
            axios
                .post('http://localhost/api/v1/login', {
                    email: this.email,
                    password: this.password
                }, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*',
                    }
                })
                .then((response) => {
                    // Handle successful login response
                    console.log('Login successful:', response.data)
                    // Redirect to dashboard or perform other actions
                })
                .catch((error) => {
                    // Handle login error
                    console.error('Login error:', error.response.data)
                    // Display error message to the user
                })
        }
    }
}
</script>

<style scoped>
/* Add CSS styles for your login form */
</style>

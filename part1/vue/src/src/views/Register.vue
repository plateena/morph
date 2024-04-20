<template>
    <div>
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="name" required />
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="email" required />
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" v-model="password" required />
            </div>
            <div>
                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" v-model="confirmPassword" required />
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: ''
        }
    },
    methods: {
        register() {
            // Check if passwords match
            if (this.password !== this.confirmPassword) {
                alert('Passwords do not match')
                return
            }

            this.$axios
                .post(
                    'register',
                    {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        password_confirmation: this.confirmPassword
                    }
                )
                .then((response) => {
                    // Handle successful login response
                    console.log('Register successful:', response.data)
                    // Redirect to dashboard or perform other actions
                })
                .catch((error) => {
                    // Handle Register error
                    console.error('Register error:', error.response.data)
                    // Display error message to the user
                })
        }
    }
}
</script>

<style scoped>
/* Add CSS styles for your registration form */
</style>

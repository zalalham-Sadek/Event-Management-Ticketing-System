<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
        <div class="bg-white dark:bg-gray-800 p-8 rounded shadow-md w-full max-w-md">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Initial Setup</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Create the first admin account for your application</p>
            </div>

            <form @submit.prevent="handleSetup">
                <div class="mb-4">
                    <InputField v-model="name" type="text" placeholder="Enter your full name" />
                </div>
                
                <div class="mb-4">
                    <InputField v-model="email" type="email" placeholder="Enter your email" />
                </div>
                
                <div class="mb-4">
                    <InputField v-model="password" type="password" placeholder="Enter your password" />
                </div>
                
                <div class="mb-6">
                    <InputField v-model="confirmPassword" type="password" placeholder="Confirm your password" />
                </div>

                <!-- Error Message -->
                <div v-if="error" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ error }}
                </div>

                <!-- Success Message -->
                <div v-if="successMessage" class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ successMessage }}
                </div>

                <button 
                    type="submit"
                    :disabled="loading"
                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    {{ loading ? 'Setting up admin account...' : 'Create Admin Account' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/store/user'
import services from '@/services'
import InputField from '@/components/dashboard/ui/InputField.vue'

const name = ref('')
const email = ref('')
const password = ref('')
const confirmPassword = ref('')
const successMessage = ref('')
const error = ref('')
const loading = ref(false)

const userStore = useUserStore()
const router = useRouter()

// Check if setup is needed on component mount
onMounted(async () => {
    try {
        const response = await services.AuthService.checkSetup()
        console.log('Setup page - check response:', response.data)
        if (response.data.admin_exists) {
            // If admin exists, redirect to login
            console.log('Admin exists, redirecting to login')
            router.push('/login')
        } else {
            console.log('No admin, staying on setup page')
        }
    } catch (err) {
        console.error('Setup check error:', err)
        // If it's a 409 conflict, it means admin exists
        if (err.response && err.response.status === 409) {
            console.log('409 conflict - admin exists, redirecting to login')
            router.push('/login')
        } else {
            console.log('Other error, staying on setup page')
        }
        // For other errors, assume setup is needed
    }
})

async function handleSetup() {
    loading.value = true
    error.value = ''
    successMessage.value = ''

    // Validation
    if (!name.value || !email.value || !password.value || !confirmPassword.value) {
        error.value = 'Please fill in all fields'
        loading.value = false
        return
    }

    if (password.value !== confirmPassword.value) {
        error.value = 'Passwords do not match'
        loading.value = false
        return
    }

    if (password.value.length < 6) {
        error.value = 'Password must be at least 6 characters long'
        loading.value = false
        return
    }

    try {
        console.log('Attempting admin setup with:', { 
            name: name.value, 
            email: email.value, 
            password: '***' 
        });
        
        const setupData = {
            name: name.value,
            email: email.value,
            password: password.value,
            confirm_password: confirmPassword.value,
            role: 'admin'
        };
        
        console.log('Sending setup data:', setupData);
        
        const response = await services.AuthService.setupAdmin(setupData);
        
        console.log('Setup response:', response);
        
        const data = response.data;
        
        if (response.status === 200 || response.status === 201 || response.success) {
            successMessage.value = 'Admin account created successfully! Logging you in...'
            
            // Auto-login the user
            try {
                const loginResponse = await services.AuthService.login({
                    email: email.value,
                    password: password.value
                });
                const user = loginResponse.data.user
                const token = loginResponse.data.token

                // Save user in Pinia store
                userStore.login(user)

                // Save token in localStorage for API requests
                localStorage.setItem('api_token', token)

                // Redirect
                setTimeout(() => {
                router.push('/dashboard')
                    }, 1500)
                // if (loginResponse.data.message === 'Login successful') {
                //     userStore.login({
                //         email: loginResponse.data.user.email,
                //         role: loginResponse.data.user.roles && loginResponse.data.user.roles.length > 0 ? loginResponse.data.user.roles[0] : 'admin',
                //         avatar: "images/person-1.png",
                //     })
                    
                //     // Redirect to dashboard
                //     setTimeout(() => {
                //         router.push('/')
                //     }, 1500)
                // }
            } catch (loginErr) {
                console.error('Auto-login error:', loginErr)
                // If auto-login fails, redirect to login page
                setTimeout(() => {
                    router.push('/login')
                }, 2000)
            }
        } else {
            error.value = data.error || 'Setup failed. Please try again.';
        }
    } catch (err) {
        console.error('Setup error:', err);
        error.value = err.response?.data?.error || 'An error occurred during setup. Please try again.';
    } finally {
        loading.value = false;
    }
}
</script>

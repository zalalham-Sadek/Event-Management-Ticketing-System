<template>
  <div class="min-h-screen flex">
    <!-- Left side - Background Image -->
    <ImgSign />

    <!-- Right side - Register Form -->
    <div class="w-full lg:w-1/3 flex items-center justify-center p-8 bg-[#f7f9fd] dark:bg-[#1f2937]">
      <div class="w-full max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
          <h2 class="text-3xl font-bold text-gradient mb-2">{{$t('Create Account')}}</h2>
          <p class="text-gray-600 dark:text-gray-300">{{$t('Sign up to get started with your account')}}</p>
        </div>

        <!-- Registration Form -->
        <form @submit.prevent="handleRegister" class="space-y-6">
          <!-- Full Name Field -->
          <InputField
            v-model="form.name"
            type="text"
            label="Full Name"
            placeholder="Enter your full name"
            required
            icon="fas fa-user"
            error-message="Please enter your name"
          />

          <!-- Email Field -->
          <InputField
            v-model="form.email"
            type="email"
            label="Email"
            placeholder="Enter your email"
            required
            icon="fas fa-envelope"
            error-message="Please enter a valid email"
          />

          <!-- Password Field -->
          <div class="relative">
            <InputField
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              label="Password"
              placeholder="Enter your password"
              required
              icon="fas fa-lock"
              error-message="Please enter your password"
            />
            <button
              type="button"
              @click="togglePasswordVisibility"
              class="absolute right-3 top-11 flex items-center z-10"
            >
              <svg v-if="!showPassword" class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
              <svg v-else class="h-5 w-5 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
              </svg>
            </button>
          </div>

          <!-- Confirm Password Field -->
          <InputField
            v-model="form.confirmPassword"
            :type="showPassword ? 'text' : 'password'"
            label="Confirm Password"
            placeholder="Confirm your password"
            required
            icon="fas fa-lock"
            error-message="Passwords must match"
          />

          <!-- Terms Checkbox -->
          <div class="flex items-center">
            <input
              id="terms"
              v-model="form.terms"
              type="checkbox"
              class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
            />
            <label for="terms" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
              {{$t('I agree to the')}}
              <a href="#" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 font-medium transition-colors duration-200">
                {{$t('Terms & Conditions')}}
              </a>
            </label>
          </div>

          <!-- Register Button -->
          <button
            type="submit"
            :disabled="isLoading"
            class="w-full bg-[var(--color-primary)] text-white dark:text-black py-3 px-4 rounded-md hover:bg-[var(--color-primary-hover)] focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed font-medium"
          >
            <span v-if="!isLoading">{{$t('Register')}}</span>
            <span v-else class="flex items-center justify-center">
              <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Registering...
            </span>
          </button>
        </form>

        <!-- Already have account -->
        <div class="mt-6 text-center">
          <p class="text-gray-600 dark:text-gray-300">
            {{$t('Already have an account?')}}
            <router-link to="/login" class="text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 font-medium transition-colors duration-200">
              {{$t('Sign in')}}
            </router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import ImgSign from '@/components/ImgSign.vue'
import InputField from '@/components/InputField.vue'

const router = useRouter()

const form = reactive({
  name: '',
  email: '',
  password: '',
  confirmPassword: '',
  terms: false
})

const showPassword = ref(false)
const isLoading = ref(false)

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}

const handleRegister = async () => {
  if (!form.terms) {
    alert('You must accept the terms and conditions.')
    return
  }
  if (form.password !== form.confirmPassword) {
    alert('Passwords do not match.')
    return
  }

  isLoading.value = true
  try {
    // Simulate API call
    await new Promise(resolve => setTimeout(resolve, 2000))
    console.log('Register data:', form)
    router.push('/login')
  } catch (err) {
    console.error('Registration error:', err)
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
.bg-gradient-to-br {
  background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}
button, input, a {
  transition: all 0.2s ease-in-out;
}
input:focus, button:focus {
  outline: none;
}
input[type="checkbox"] {
  accent-color: #3b82f6;
}
</style>

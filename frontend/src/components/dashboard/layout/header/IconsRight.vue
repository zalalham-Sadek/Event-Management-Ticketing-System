<template>
  <div class="flex items-center gap-4 shrink-0">
              <LanguageSwitcher @language-changed="handleLanguageChange" />

    <BtnMode />

    <!-- Notifications -->
    <span class="text-xl text-secondary-text">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path fill="currentColor"
          d="M21 19v1H3v-1l2-2v-6c0-3.1 2.03-5.83 5-6.71V4a2 2 0 0 1 2-2a2 2 0 0 1 2 2v.29c2.97.88 5 3.61 5 6.71v6zM14 21a2 2 0 0 1-4 0"/>
      </svg>
    </span>

    <!-- User Dropdown -->
   <!-- User Dropdown -->
<div v-if="isLoggedIn" class="relative">
  <router-link to="/profile" class="w-10 h-10 bg-gray-500 rounded-full overflow-hidden block">
    <img
      v-if="user?.avatar"
      :src="user.avatar"
      alt="Profile"
      class="w-full h-full object-cover"
    />
    <svg
      v-else
      xmlns="http://www.w3.org/2000/svg"
      class="w-full h-full text-primary-text object-cover"
      viewBox="0 0 24 24"
    >
      <path fill="currentColor"
        d="M12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M12 6a3.5 3.5 0 0 1 3.5 3.5A3.5 3.5 0 0 1 12 13a3.5 3.5 0 0 1-3.5-3.5A3.5 3.5 0 0 1 12 6m0 14c-1.86 0-3.57-.64-4.93-1.72c.43-.9 3.05-1.78 4.93-1.78s4.5.88 4.93 1.78A7.9 7.9 0 0 1 12 20z"
      />
    </svg>
  </router-link>
</div>


    

    <!-- If not logged in -->
    <div v-else>
      <router-link to="/login" class="text-sm text-blue-600 hover:underline">
        login
      </router-link>
    </div>

    
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useUserStore } from '@/store/user'
import BtnMode from './BtnMode.vue'
import { useRouter } from 'vue-router'
import LanguageSwitcher from '@/components/LanguageSwitcher.vue'

const userStore = useUserStore()
const router = useRouter()

const isLoggedIn = computed(() => userStore.isAuthenticated)
const user = computed(() => userStore.user)

function handleLogout() {
  userStore.logout()
  router.push('/login') // More graceful than reload
}

// Dropdown state
const isDropdownOpen = ref(false)
const dropdownRef = ref(null)

function toggleDropdown() {
  isDropdownOpen.value = !isDropdownOpen.value
}

function handleClickOutside(event) {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isDropdownOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

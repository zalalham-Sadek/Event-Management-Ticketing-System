<template>
  <div>

    <!-- Show Topbar and Sidebar only if user is logged in -->
    <Topbar
      v-if="isLoggedIn"
      :sidebarOpen="sidebarOpen"
      @update:sidebarOpen="sidebarOpen = $event"
      :sidebarCollapsed="sidebarCollapsed"
    />
    
    <Sidebar
      v-if="isLoggedIn"
      v-model:sidebarOpen="sidebarOpen"
      v-model:sidebarCollapsed="sidebarCollapsed"
    />

    <!-- Main Content -->
    <main
      class=" transition-all duration-300  "
      :class="isLoggedIn ? (sidebarCollapsed ? 'md:ps-20 pt-16' : 'md:ps-64 pt-16') : ''"
    >
      <router-view />
    </main>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useUserStore } from '@/store/user'
import Topbar from '@/components/dashboard/layout/Topbar.vue'
import Sidebar from '@/components/dashboard/layout/Sidebar.vue'

const sidebarOpen = ref(false)
const sidebarCollapsed = ref(false)

const userStore = useUserStore()
userStore.loadUserFromStorage()
// ✅ Computed to check login state
const isLoggedIn = computed(() => userStore.isAuthenticated)
</script>

<style scoped>
.size-10 {
  width: 40px;
  height: 40px;
}
</style>

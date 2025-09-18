<template>
  <!-- Sidebar -->
<aside
  class="fixed top-0 start-0 h-full bg-[var(--color-muted)] pt-5 z-40 transition-all duration-300 ease-in-out overflow-hidden flex flex-col justify-between"
  :class="[
    sidebarCollapsed ? 'w-20' : 'w-64',
    // On small screens: hidden by default; show when open.
    // LTR: move fully left off-canvas using -translate-x-full; RTL: move right using translate-x-full.
    sidebarOpen ? 'translate-x-0' : '-translate-x-full rtl:translate-x-full',
    // On md and up: sidebar is always visible (force override for both directions)
    'md:translate-x-0 md:ltr:translate-x-0 md:rtl:translate-x-0'
  ]"
>

    <div>
      <!-- Top Sidebar controls -->
      <div class="flex items-center text-primary-text px-4" :class="[sidebarCollapsed ? 'justify-center' : 'justify-between']">
        <TopSideBar :sidebarCollapsed="sidebarCollapsed" />
        <BtnToggle :toggleCollapse="toggleCollapse" :sidebarCollapsed="sidebarCollapsed" />
        <!-- Close button for mobile -->
        <button @click="closeSidebar" class="md:hidden text-accent text-2xl hover:cursor-pointer">
          &times;
        </button>
      </div>

      <!-- Sidebar list -->
      <ListSideBar :sidebarCollapsed="sidebarCollapsed" />
    </div>

    <!-- Logout Button -->
    <div class="p-4 flex items-center" :class="[sidebarCollapsed ? 'justify-center' : 'justify-between']">
      <button
        @click="handleLogout"
        class="flex items-center gap-2 text-primary-text px-4 hover:text-hover transition-colors duration-200"
        :class="[sidebarCollapsed ? 'justify-center' : 'justify-between']"
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="text-primary-text" viewBox="0 0 24 24">
          <path fill="currentColor" d="m17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5M4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4z"/>
        </svg>
        <span v-if="!sidebarCollapsed"> logout</span>
      </button>
    </div>
  </aside>

  <!-- Mobile Overlay -->
  <div
    v-if="sidebarOpen"
    class="fixed inset-0 bg-black/50 z-30 md:hidden"
    @click="closeSidebar"
  ></div>
</template>

<script setup>
import BtnToggle from './sidebar/BtnToggle.vue'
import ListSideBar from './sidebar/ListSideBar.vue'
import TopSideBar from './sidebar/TopSideBar.vue'
import { useUserStore } from '@/store/user'
import { useRouter } from 'vue-router'

const props = defineProps({
  sidebarOpen: Boolean,
  sidebarCollapsed: Boolean
})
const emit = defineEmits(['update:sidebarOpen', 'update:sidebarCollapsed'])

function closeSidebar() {
  emit('update:sidebarOpen', false)
}

function toggleCollapse() {
  emit('update:sidebarCollapsed', !props.sidebarCollapsed)
}

const userStore = useUserStore()
const router = useRouter()

function handleLogout() {
  userStore.logout()
  router.push('/login')
}
</script>

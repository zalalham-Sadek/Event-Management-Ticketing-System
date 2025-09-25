<template>
  <header class="fixed top-0 left-0 right-0 z-30 h-16 bg-[var(--color-bg)] shadow-md transition-all duration-300
         w-full  flex items-center" :class="sidebarCollapsed ? 'md:ps-20 ' : 'md:ps-64'">
    <div class="flex items-center justify-around w-full pr-4 gap-4 overflow-visible">
      <!-- Toggle -->
    <button @click="openSidebar" class="md:hidden text-2xl pl-2">&#9776;</button>
      <!-- Search -->
      <SearchInput/>
      <!-- Icons -->
      <IconsRight/>
    </div>
  </header>
</template>

<!-- <script setup>
import { ref } from 'vue'

const props = defineProps({
  sidebarOpen: Boolean
})
const emit = defineEmits(['update:sidebarOpen'])

const openSidebar = () => emit('update:sidebarOpen', true)

const sidebarCollapsed = ref(false)


</script> -->
<script setup>
import IconsRight from './header/IconsRight.vue'
import SearchInput from './header/SearchInput.vue'
const props = defineProps({
  sidebarOpen: Boolean,
  sidebarCollapsed: Boolean
})

const emit = defineEmits(['update:sidebarOpen'])

const openSidebar = () => emit('update:sidebarOpen', true)
</script>


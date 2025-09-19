<template>
  <div class="breadcrumb flex items-center justify-between border-b border-gray-300 dark:border-foreground pb-4 mb-6">
    <!-- المسار -->
    <ul class="flex items-center text-l">
      <li class="border-r border-primary-border pr-2 text-secondary-text dark:text-black">
        <a class="hover:text-gray-800" href="#">{{ part }}</a>
      </li>
      <li class="pl-2  text-secondary-text/80 dark:text-gray-700">{{ title }}</li>
    </ul>
    <div v-if="showButton">
      <Btn :btnTitle="btnTitle" :href="href" />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useUserStore } from '@/store/user'
import Btn from '@/components/dashboard/ui/Btn.vue'

const props = defineProps({
  part: String,
  title: String,
  enableBtn: {
    type: Boolean,
    default: false,
  },
  btnTitle: {
    type: String,
    default: 'Add',
  },
  href: {
    type: String,
    default: '#',
  },
})
const userStore = useUserStore()
console.log('Role from store:', userStore.userRole)

const showButton = computed(() => 
  props.enableBtn && userStore.isAuthenticated && userStore.userRole.toLowerCase() === 'admin'
)
</script>

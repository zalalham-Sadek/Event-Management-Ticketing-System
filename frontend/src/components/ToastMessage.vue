<!-- src/components/ToastMessage.vue -->
<template>
  <transition name="fade">
    <div
      v-if="visible"
      :class="[
        'fixed bottom-5 left-1/2 transform -translate-x-1/2 text-white px-6 py-3 rounded-lg shadow-lg transition-opacity duration-300 z-50',
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
      ]"
    >
      {{ message }}
    </div>
  </transition>
</template>

<script setup>
defineProps({
  message: String,
  visible: Boolean,
  type: {
    type: String,
    default: 'success',
  },
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
.fade-enter-to,
.fade-leave-from {
  opacity: 1;
}
</style>

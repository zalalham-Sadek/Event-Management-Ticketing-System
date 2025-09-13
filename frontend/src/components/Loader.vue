<template>
  <div
    v-if="show"
    class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-30 z-50 transition-opacity"
  >
    <div class="flex flex-col items-center">
      <!-- Spinner -->
      <div
        class="w-16 h-16 border-4 border-t-4 border-blue-600 border-t-transparent rounded-full animate-spin"
      ></div>

      <!-- Optional text -->
      <p v-if="message" class="mt-4 text-white text-lg">{{ message }}</p>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
  show: { type: Boolean, default: false },
  message: { type: String, default: "Loading..." },
});
</script>

<style scoped>
/* Tailwind animate-spin handles the spinning */
</style>

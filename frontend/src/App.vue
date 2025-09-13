<template>
  <app-header></app-header>

  <!-- Loader without overlay -->
  <Loader :show="isLoading" message="Loading..." />

  <div v-if="!isLoading" class="min-h-screen flex flex-col items-center justify-center bg-gray-100 p-4">
    <h1 class="text-4xl font-bold text-blue-600 mb-4">You did it!</h1>
    <p class="text-gray-700 text-lg">
      Visit 
      <a href="https://vuejs.org/" target="_blank" rel="noopener" class="text-blue-500 underline hover:text-blue-700">
        vuejs.org
      </a> 
      to read the documentation
    </p>
  </div>
</template>

<script setup>
import Loader from './components/Loader.vue'
import { ref } from "vue";

const isLoading = ref(true);

// Hide loader after 1 second
setTimeout(() => { isLoading.value = false }, 1000);
</script>

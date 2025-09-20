<template>
  <!-- Loader full screen -->
  <div
    v-if="isLoading"
    class="fixed inset-0 flex items-center justify-center bg-[var(--color-bg)]  z-50"
  >
    <Loader />
  </div>

  <!-- Main app content, only visible after loading -->
  <div v-else>
    <app-header />
    <router-view />
    <Footer />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Loader from '@/components/Loader.vue';
import Footer from "@/components/Footer.vue";

const isLoading = ref(true);

onMounted(() => {
  // Simulate a 1s loading
  setTimeout(() => {
    isLoading.value = false;
  }, 1000);
});
</script>

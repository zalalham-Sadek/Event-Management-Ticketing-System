<template>
  <nav class="dark:bg-[var(--color-bg)] bg-[#5d679b] shadow-md sticky top-0 z-50 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">

        <!-- Logo + Menu for desktop -->
        <div class="flex items-center space-x-8">
          <router-link to="/" class="text-2xl font-bold text-[var(--color-primary)]">🎟️ TicMate</router-link>

          <!-- Menu -->
          <div
            :class="[
              'flex flex-col md:flex-row md:space-x-6 font-medium items-center absolute md:static left-0 w-full md:w-auto dark:bg-[var(--color-bg)] bg-[#5d679b] md:bg-transparent shadow-md md:shadow-none transition-all duration-300 ease-in-out',
              isOpen ? 'top-16 opacity-100' : 'top-[-400px] opacity-0 md:opacity-100'
            ]"
          >
            <NavItem to="/" label="home" class="mt-2 md:mt-0 font-cairo" />
            <NavItem to="/" label="events" class="mt-2 md:mt-0 font-cairo" />
            <NavItem to="/" label="organizers" class="mt-2 md:mt-0 font-cairo" />
          </div>
        </div>

        <!-- Controls -->
        <div class="flex items-center space-x-4">
          <!-- Login Icon -->
          <router-link to="/login" class="text-[var(--color-accent)] hover:text-[var(--color-primary)]">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.5.88 4.93 1.78A7.9 7.9 0 0 1 12 20c-1.86 0-3.57-.64-4.93-1.72m11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33A7.93 7.93 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.5-1.64 4.83M12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6m0 5a1.5 1.5 0 0 1-1.5-1.5A1.5 1.5 0 0 1 12 8a1.5 1.5 0 0 1 1.5 1.5A1.5 1.5 0 0 1 12 11"/></svg>
          </router-link>

          <!-- Dark/Light Toggle -->
          <BtnMode />

          <!-- Language Switcher -->
          <LanguageSwitcher @language-changed="handleLanguageChange" />

          <!-- Mobile Menu Toggle -->
          <div class="md:hidden">
            <button @click="isOpen = !isOpen" class="text-[var(--color-primary)] hover:text-[var(--color-accent)] focus:outline-none">
              <svg v-if="!isOpen" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>

      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from "vue";
import BtnMode from "./BtnMode.vue";
import LanguageSwitcher from "./LanguageSwitcher.vue";
import NavItem from "./NavItem.vue";

const isOpen = ref(false);

const handleLanguageChange = (lang) => {
  console.log("Selected language:", lang);
};
</script>

<style scoped>
/* Add spacing for vertical mobile menu */
@media (max-width: 768px) {
  .flex-col > * {
    margin-top: 0.5rem; /* space between menu items */
  }
}
</style>

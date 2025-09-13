<template>
  <nav class="fixed w-full z-50 transition-all duration-300 py-6">
    <div class="container mx-auto px-4 flex justify-between items-center">
      <div class="flex items-center">
          <router-link to="/" class="text-2xl font-bold text-[var(--color-primary)]">🎟️ EventSys</router-link>
      </div>
      <ul class="hidden lg:flex items-center space-x-8">
        <li>
                    <NavItem to="/" :label="$t('home')" />
                    <NavItem to="/" :label="$t('home')" />
                    <NavItem to="/" :label="$t('home')" />
                    <NavItem to="/" :label="$t('home')" />
</li>
      </ul>
      <div class="hidden lg:flex items-center space-x-4">
        <BtnMode />
  <LanguageSwitcher @language-changed="handleLanguageChange" />

        <button
          class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent h-10 px-4 py-2 rounded-xl text-gray-300 hover:text-white">Login</button><a
          href="/cryptoflow/#!"><button
            class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 px-4 py-2 rounded-xl bg-crypto-purple hover:bg-crypto-dark-purple text-white w-full">Buy
            Now</button></a></div>
            <button class="lg:hidden text-white">
              <svg xmlns="http://www.w3.org/2000/svg"
          width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu">
          <line x1="4" x2="20" y1="12" y2="12"></line>
          <line x1="4" x2="20" y1="6" y2="6"></line>
          <line x1="4" x2="20" y1="18" y2="18"></line>
        </svg></button>
    </div>
  </nav>

</template>

<script setup>
import { ref } from "vue";
import BtnMode from "./BtnMode.vue";
import LanguageSwitcher from "./LanguageSwitcher.vue";
import NavItem from "./NavItem.vue";

const isOpen = ref(false);

// Handle language change
const handleLanguageChange = (lang) => {
  console.log("Selected language:", lang);
  // Example with vue-i18n:
  // i18n.global.locale = lang;
  // locale.value = lang;
};
</script>

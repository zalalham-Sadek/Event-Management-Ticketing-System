<template>
  <div
    v-show="show"
    role="status"
    aria-hidden="!show"
    class="relative w-[100px] h-[100px] rounded-full border-t-[5px] border-t-[#ff6700] animate-spin-slow
           before:content-[''] before:absolute before:inset-0 before:w-[100px] before:h-[100px] before:rounded-full before:border-t-[5px] before:border-t-[#004e98] before:rotate-[120deg]
           after:content-[''] after:absolute after:inset-0 after:w-[100px] after:h-[100px] after:rounded-full after:border-t-[5px] after:border-t-[#3a6ea5] after:rotate-[240deg]">
    <!-- Accessible text; screen-readers will get this -->
    <span class="sr-only text-black">Loading...</span>

    <!-- Visible text centered and spinning reverse -->
    <span class="absolute inset-0 flex items-center justify-center text-sm text-[#000000] animate-spin-reverse-slow pointer-events-none">
      Loading...
    </span>
  </div>
</template>

<script setup>
const props = defineProps({
  show: { type: Boolean, default: true },
});
</script>

<style scoped>
/* no extra CSS needed; animations come from Tailwind config */
</style>

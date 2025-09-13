<template>
  <router-link
    :to="to"
    class="text-gray-300 hover:text-white transition-colors"
    :class="[
      { 'text-blue-600 font-semibold': active },
      'block md:inline-block md:mr-6 mb-4 md:mb-0' // vertical spacing on mobile
    ]"
  >
    {{ $t(label) }}
  </router-link>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

// Props
const props = defineProps({
  to: { type: String, required: true },
  label: { type: String, required: true },
});

// Highlight active route
const route = useRoute();
const active = computed(() => route.path === props.to);
</script>

<template>
<div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-3 sm:p-4 md:p-6 shadow-sm hover:shadow-md transition-all duration-300 hover:border-blue-200 dark:hover:border-blue-600">
  <div class="flex items-center gap-2 sm:gap-3 md:gap-4">
    <img
      :src="avatarUrl"
      :alt="`${name} avatar`"
      class="h-10 w-10 sm:h-12 sm:w-12 md:h-16 md:w-16 rounded-full object-cover flex-shrink-0 border-2 border-gray-100 dark:border-gray-600"
    />

    <div class="min-w-0 flex-1">
      <p class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate leading-tight">{{ name }}</p>
      <a
        href="#"
        class="mt-1 inline-block text-xs sm:text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200"
      >
        {{ followers }} followers
      </a>
    </div>
  </div>
</div>
</template>

<script setup>
const props = defineProps({
  name: { type: String, default: 'Creative Events Agency' },
  avatarUrl: {
    type: String,
    default:
      'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=200&h=200&fit=crop',
  },
  followers: { type: [Number, String], default: 6 },
});
const { name, avatarUrl, followers } = props;
</script>

<style scoped>
</style>
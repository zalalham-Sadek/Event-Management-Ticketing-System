<template>
  <div class="flex items-center justify-between mb-6">
    <div class="space-y-3 my-3">
      <span
        class="text-sm px-5 py-1 text-[var(--color-primary)] font-semibold uppercase bg-[#e1e5ec] dark:bg-[#172231]"
      >
        {{ $t(subtitle) }}
      </span>
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-3">
        {{ $t(title) }}
      </h2>
    </div>

    <!-- Navigation buttons -->
    <div class="flex space-x-2">
      <button
        class="w-8 h-8 flex items-center justify-center rounded-full border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-[var(--color-bg)]"
        @click="$emit('prev')"
      >
        <span>&#10094;</span>
      </button>
      <button
        class="w-8 h-8 flex items-center justify-center rounded-full border border-[var(--color-primary)] text-[var(--color-primary)] hover:bg-[var(--color-primary)] hover:text-[var(--color-bg)]"
        @click="$emit('next')"
      >
        <span>&#10095;</span>
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    required: true
  },
  subtitle: {
    type: String,
    default: ""
  }
})
</script>

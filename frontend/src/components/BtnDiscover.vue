<template>
  <!-- Themed Gradient Button -->
  <button
    class="relative inline-flex items-center gap-2 px-6 py-3 font-cairo
     text-[var(--color-text)] dark:text-white
     bg-gradient-to-tr from-[var(--color-primary)] via-[var(--color-accent)] to-[var(--color-muted)]
     dark:from-[var(--color-primary)] dark:via-[var(--color-muted)] dark:to-[var(--color-bg)]
     ring-4 ring-[var(--color-border)] 
     rounded-full overflow-hidden hover:opacity-90 transition-opacity
     before:absolute before:top-4 before:left-1/2 before:-translate-x-1/2 before:w-[100px] before:h-[100px]
     before:rounded-full before:bg-gradient-to-b before:from-[var(--color-primary-hover)]/20 before:blur-xl"
  >
    {{ $t("Discover Events") }}
</button>
</template>

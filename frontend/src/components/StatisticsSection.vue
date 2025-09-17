<template>
  <section class="px-6 bg-[var(--color-bg)]">
    <div class="max-w-7xl mx-auto">
      <!-- Statistics Grid -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <div 
          v-for="(stat, index) in statistics" 
          :key="index"
          class="text-center stat-card"
        >
          <!-- Icon and Number Row -->
          <div class="mb-2 flex items-center justify-center gap-3 rtl:flex-row-reverse">
            <i :class="stat.icon" class="text-2xl sm:text-3xl md:text-4xl text-[var(--color-primary)]"></i>
            <div class="flex flex-col items-start rtl:items-end">
              <span class="text-xl sm:text-2xl md:text-3xl font-bold text-[var(--color-text)]">
                {{ stat.value }}
              </span>
              <p class="text-xs sm:text-sm md:text-base text-gray-600 dark:text-gray-300 font-medium">
                {{ $t(stat.label) }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
const statistics = [
  { icon: 'fas fa-calendar-plus', value: '120K', label: 'Events Added' },
  { icon: 'fas fa-users', value: '30K+', label: 'Event Organizers' },
  { icon: 'fas fa-microphone', value: '3K', label: 'Event Hosted' },
  { icon: 'fas fa-ticket-alt', value: '11M', label: 'Tickets Sold' }
];
</script>

<style scoped>
/* Custom animations */
@keyframes countUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

.stat-card {
  animation: countUp 0.6s ease-out;
}
</style>

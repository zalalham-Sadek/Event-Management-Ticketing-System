<template>
  <section class="py-16 px-6 bg-[var(--color-bg)]">
    <!-- Heading -->
    <div class="text-center space-y-3 mb-16">
      <span
        class="text-sm px-5 py-1 font-semibold uppercase text-[var(--color-primary)] bg-[#e1e5ec] dark:bg-[#172231] rounded-full">
        {{ $t('how it works') }}
      </span>
      <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mt-3">
        {{ $t('how it works') }}
      </h2>
      <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mt-2">
        Follow these simple steps to find and join your next amazing event.
      </p>
    </div>

    <!-- Steps Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 items-start justify-items-center">
      <!-- Step 1 -->
      <div class="flex flex-col items-center text-center relative">
        <div class="bg-white dark:bg-gray-800 rounded-full p-6 shadow-md hover:shadow-lg transition z-10">
          <span class="text-4xl text-[var(--color-primary)]">
            <i class="fas fa-map-marker-alt"></i>
          </span>
        </div>
        <h6 class="mt-4 font-semibold text-gray-900 dark:text-white">Pick a Location</h6>
        <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
          Choose from a variety of locations to attend your next event.
        </p>
      </div>

      <!-- Step 2 -->
      <div class="flex flex-col items-center text-center relative">
        <div class="bg-white dark:bg-gray-800 rounded-full p-6 shadow-md hover:shadow-lg transition z-10">
          <span class="text-4xl text-[var(--color-primary)]">
            <i class="fas fa-calendar-alt"></i>
          </span>
        </div>
        <h6 class="mt-4 font-semibold text-gray-900 dark:text-white">Choose a Date</h6>
        <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
          Select a date that works best for your schedule.
        </p>
      </div>

      <!-- Step 3 -->
      <div class="flex flex-col items-center text-center relative">
        <div class="bg-white dark:bg-gray-800 rounded-full p-6 shadow-md hover:shadow-lg transition z-10">
          <span class="text-4xl text-[var(--color-primary)]">
            <i class="fas fa-ticket-alt"></i>
          </span>
        </div>
        <h6 class="mt-4 font-semibold text-gray-900 dark:text-white">Get Your Tickets</h6>
        <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
          Secure your spot by booking tickets online easily.
        </p>
      </div>

      <!-- Step 4 -->
      <div class="flex flex-col items-center text-center relative">
        <div class="bg-white dark:bg-gray-800 rounded-full p-6 shadow-md hover:shadow-lg transition z-10">
          <span class="text-4xl text-[var(--color-primary)]">
            <i class="fas fa-smile-beam"></i>
          </span>
        </div>
        <h6 class="mt-4 font-semibold text-gray-900 dark:text-white">Enjoy the Event</h6>
        <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
          Attend and enjoy your selected event with ease and convenience.
        </p>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>

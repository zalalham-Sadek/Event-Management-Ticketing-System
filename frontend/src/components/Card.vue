<template>
  <div
    class="bg-[var(--color-bg)]  rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 
           transform transition duration-300 hover:shadow-lg hover:-translate-y-1"
  >
    <!-- Image with action button -->
    <div class="relative">
      <img
        :src="event.image"
        :alt="event.title"
        class="w-full h-40 object-cover transition duration-300 group-hover:scale-105"
      />
      <button
        class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full bg-white/50 shadow hover:bg-[var(--color-primary)] transition"
      >
<i class="fa-solid fa-share-nodes text-[var(--color-bg)] text-[13px]" ></i>      </button>
    </div>

    <!-- Card content -->
    <div class="p-4">
      <h3
        class="text-md font-semibold text-[var(--color-text)]  truncate"
      >
        <router-link :to="event.to">{{ event.title }}</router-link>
      </h3>

      <!-- Date & location -->
      <div class="mt-2 space-y-1 text-sm text-gray-600 dark:text-gray-300">
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-calendar-days"></i>
          <span>{{ event.date }}</span>
        </div>
        <div class="flex items-center gap-2">
<i class="fa-solid fa-location-dot"></i>
          <span>{{ event.location }}</span>
        </div>
      </div>

      <!-- Price -->
      <p class="mt-3 text-lg font-bold text-[var(--color-primary)]">
        {{ event.price }}
      </p>
    </div>

    <!-- Organizer -->
    <div
      class="border-t border-gray-200 dark:border-gray-700 px-4 py-3 flex items-center gap-3"
    >
      <img
        :src="event.organizerLogo"
        alt="Organizer"
        class="w-8 h-8 rounded-full object-cover"
      />
      <p class="text-sm text-gray-600 dark:text-gray-300">
        Organized By <br />
        <span class="text-[var(--color-primary)] font-medium">{{ event.organizer }}</span>
      </p>
    </div>
  </div>
</template>


<script setup>
defineProps({
  event: {
    type: Object,
    required: true,
    default: () => ({
      title: "Big Apple Sports Extravaganza: Where Athletes Shine",
      image: "https://picsum.photos/id/1011/400/250",
      date: "30 Sep, 2025 - 02 Oct, 2025",
      location: "New York",
      price: "$20.00",
      organizer: "Green and Gonzales Trading",
      organizerLogo: "https://picsum.photos/id/1005/100/100",
      to:"/",
    })
  }
})
</script>

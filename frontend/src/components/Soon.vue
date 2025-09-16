<template>
  <section class="py-12 my-5 px-6 bg-[#f7f9fd] dark:bg-[#1f2937]">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
        <div class="flex items-center justify-between mb-6">
    <div class="space-y-3 my-3">
      <span
        class="text-sm px-5 py-1 text-[var(--color-primary)] font-semibold uppercase bg-[#e1e5ec] dark:bg-[#172231]"
      >
        {{ $t("starting soon") }}
      </span>
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-3">
        {{ $t("Starting Soon Events" ) }}
      </h2>
    </div>

    <!-- Navigation buttons -->
    
  </div>



      <!-- Cards Grid -->
      <div class="flex flex-wrap justify-center gap-6">
        <Card
          v-for="(card, i) in filteredCards"
          :key="i"
          class="w-full sm:w-[calc(50%-1.5rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(25%-1.5rem)]"
          :event="card"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed } from "vue"
import { Swiper, SwiperSlide } from "swiper/vue"
import { Navigation } from "swiper/modules"
import "swiper/css"
import SectionHeader from "./SectionHeader.vue"
import Card from "./Card.vue"

const swiper = ref(null)
const onSwiper = (s) => {
  swiper.value = s
}

const filters = ["All", "Music", "Sports", "Art", "Tech", "Food", "Business"]
const activeFilter = ref("All")

// Example cards with categories
const cards = ref([
  {
    title: "Big Apple Sports Extravaganza",
    category: "Sports",
    image: "https://picsum.photos/id/1011/400/250",
    date: "30 Sep, 2025 - 02 Oct, 2025",
    location: "New York",
    price: "$20.00",
    organizer: "Green and Gonzales Trading",
    organizerLogo: "https://picsum.photos/id/1005/100/100"
  },
  {
    title: "Jazz Night in the City",
    category: "Music",
    image: "https://picsum.photos/id/1025/400/250",
    date: "15 Oct, 2025",
    location: "Los Angeles",
    price: "$35.00",
    organizer: "LA Music Events",
    organizerLogo: "https://picsum.photos/id/1016/100/100"
  },
  {
    title: "Tech Expo 2025",
    category: "Tech",
    image: "https://picsum.photos/id/1035/400/250",
    date: "05 Nov, 2025",
    location: "San Francisco",
    price: "$50.00",
    organizer: "Innovators Inc.",
    organizerLogo: "https://picsum.photos/id/1018/100/100"
  },
  {
    title: "Art Festival Downtown",
    category: "Art",
    image: "https://picsum.photos/id/1045/400/250",
    date: "20 Dec, 2025",
    location: "Chicago",
    price: "$15.00",
    organizer: "Creative Minds",
    organizerLogo: "https://picsum.photos/id/1020/100/100"
  },
])

// Computed property to filter cards
const filteredCards = computed(() => {
  if (activeFilter.value === "All") return cards.value
  return cards.value.filter((c) => c.category === activeFilter.value)
})

const setFilter = (filter) => {
  activeFilter.value = filter
  console.log("Filter changed to:", filter)
}
</script>

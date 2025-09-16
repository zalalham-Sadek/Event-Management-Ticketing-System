<template>
  <section class="py-12 my-5 px-6 bg-[#f7f9fd] dark:bg-[#1f2937]">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <SectionHeader
        title="Featured Events"
        subtitle="FEATURED"
        @prev="swiper.slidePrev()"
        @next="swiper.slideNext()"
      />

      <!-- Filters Swiper -->
      <Swiper
        :modules="[Navigation]"
        :slides-per-view="'auto'"
        :space-between="8"
        :loop="false"
        :free-mode="true"
        :navigation="false"
        @swiper="onSwiper"
        class="overflow-hidden mb-8"
      >
        <SwiperSlide
          v-for="(filter, index) in filters"
          :key="index"
          class="!w-auto"
        >
          <button
            type="button"
            class="w-auto inline-flex items-center px-4 py-2 text-sm font-medium border rounded-lg transition-colors duration-300"
            :class="[
              activeFilter === filter
                ? 'bg-[var(--color-primary)] text-white border-[var(--color-primary)]'
                : 'bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
            ]"
            @click="setFilter(filter)"
          >
            {{ filter }}
          </button>
        </SwiperSlide>
      </Swiper>

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

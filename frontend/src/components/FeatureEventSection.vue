<template>
  <section class="py-12 my-5 px-6 bg-[#f7f9fd] dark:bg-[#1f2937]">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <SectionHeader
        title="Tickets"
        subtitle="AVAILABLE TICKETS"
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
          v-for="(ticket, i) in paginatedTickets"
          :key="i"
          class="w-full sm:w-[calc(50%-1.5rem)] md:w-[calc(33.333%-1.5rem)] lg:w-[calc(25%-1.5rem)]"
          :event="{
            title: ticket.event.title,
            category: ticket.event.type,
            image: ticket.event.poster ? `http://127.0.0.1:8000/storage/${ticket.event.poster}` : 'https://picsum.photos/400/250',
            date: ticket.event.date,
            location: ticket.event.location,
            price: `$${ticket.price}`,
            organizer: ticket.event.user.name,
            organizerLogo: ticket.event.user.avatar || 'https://picsum.photos/id/1005/100/100',
            to: `/events/${ticket.event.id}/book`
          }"
        />
      </div>

      <!-- Pagination -->
      <div v-if="totalPages > 1" class="flex justify-center mt-6 space-x-2">
        <button
          @click="prevPage"
          :disabled="currentPage === 1"
          class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded disabled:opacity-50"
        >
          Prev
        </button>
        <span class="px-3 py-1">{{ currentPage }} / {{ totalPages }}</span>
        <button
          @click="nextPage"
          :disabled="currentPage === totalPages"
          class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded disabled:opacity-50"
        >
          Next
        </button>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue"
import { Swiper, SwiperSlide } from "swiper/vue"
import { Navigation } from "swiper/modules"
import "swiper/css"
import SectionHeader from "./SectionHeader.vue"
import Card from "./Card.vue"
import services from "@/services"

const swiper = ref(null)
const onSwiper = (s) => { swiper.value = s }

const filters = ["All", "VIP", "Regular", "Early Bird"]
const activeFilter = ref("All")

// Tickets state
const tickets = ref([])
const loading = ref(false)
const error = ref('')

// Pagination
const currentPage = ref(1)
const itemsPerPage = 8

// Fetch tickets from API
const loadTickets = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await services.TicketService.getAllTickets() // API should return ticket -> event -> user
    tickets.value = response.data.data
  } catch (err) {
    console.error('Error loading tickets:', err)
    error.value = 'Failed to load tickets.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadTickets()
})

// Filtered tickets
const filteredTickets = computed(() => {
  if (activeFilter.value === "All") return tickets.value
  return tickets.value.filter(ticket => ticket.type === activeFilter.value)
})

// Pagination logic
const totalPages = computed(() => Math.ceil(filteredTickets.value.length / itemsPerPage))

const paginatedTickets = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage
  return filteredTickets.value.slice(start, start + itemsPerPage)
})

const prevPage = () => {
  if (currentPage.value > 1) currentPage.value--
}

const nextPage = () => {
  if (currentPage.value < totalPages.value) currentPage.value++
}

watch([activeFilter, tickets], () => { currentPage.value = 1 })

const setFilter = (filter) => {
  activeFilter.value = filter
}
</script>

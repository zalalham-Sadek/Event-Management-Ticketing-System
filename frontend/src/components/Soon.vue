<template>
  <section class="py-12 my-5 px-6 bg-[#f7f9fd] dark:bg-[#1f2937]">
    <div class="max-w-6xl mx-auto">
      <!-- Header -->
      <div class="flex items-center justify-between mb-6">
        <div class="space-y-3 my-3">
          <span class="text-sm px-5 py-1 text-[var(--color-primary)] font-semibold uppercase bg-[#e1e5ec] dark:bg-[#172231]">
            {{ $t("upcoming") }}
          </span>
          <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-3">
            {{ $t("Events in the Next 2 Weeks") }}
          </h2>
        </div>
      </div>

      <!-- Cards Grid -->
      <div v-if="loading" class="flex justify-center items-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <span class="ml-2 text-gray-600">{{ $t('tickets.loading') }}</span>
      </div>
      <div v-else-if="error" class="p-4 bg-red-100 text-red-700 rounded mb-4">{{ error }}</div>
      <div v-else class="flex flex-wrap justify-center gap-6">
        <Card
          v-for="(ticket, i) in filteredTickets"
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
          }"
        />
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from "vue"
import Card from "@/components/Card.vue"
import services from "@/services"

const tickets = ref([])
const loading = ref(false)
const error = ref('')

// Fetch tickets from API
const loadTickets = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await services.TicketService.getAllTickets() // Make sure this returns ticket -> event -> user
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

// Computed: filter tickets for events in the next 2 weeks and one ticket per event
const filteredTickets = computed(() => {
  const now = new Date()
  const twoWeeksLater = new Date()
  twoWeeksLater.setDate(now.getDate() + 14) // 14 days ahead

  // Filter tickets in the next 2 weeks
  const upcomingTickets = tickets.value.filter(ticket => {
    const eventDate = new Date(ticket.event.date)
    return eventDate >= now && eventDate <= twoWeeksLater
  })

  // Pick only one ticket per event
  const oneTicketPerEvent = []
  const seenEventIds = new Set()
  for (const ticket of upcomingTickets) {
    if (!seenEventIds.has(ticket.event.id)) {
      oneTicketPerEvent.push(ticket)
      seenEventIds.add(ticket.event.id)
    }
  }

  // Sort by event date ascending
  return oneTicketPerEvent.sort((a, b) => new Date(a.event.date) - new Date(b.event.date))
})
</script>

<template>
  <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />

  <div class="p-6 max-w-7xl mx-auto ">
    <headPage 
      :part="$t('tickets.part')" 
      :title="$t('tickets.title')" 
      :enableBtn="false" 
    />

    <!-- Error Message -->
    <div v-if="error" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
      {{ error }}
    </div>

    <div class="col-span-12 md:col-span-6">
      <div
        class="bg-background-secondary space-y-3 dark:bg-box-dark m-0 p-0 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative">
        
        <div class="px-5 pt-2 ">
          <p class="text-xl inline dark:text-gray-400">{{ $t('common.filters') }}</p>
        </div>

        <SearchAndPerpage v-model:searchQuery="searchQuery" v-model:itemsPerPage="itemsPerPage" />

        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center py-8">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
          <span class="ml-2 text-gray-600">{{ $t('tickets.loading') }}</span>
        </div>

        <!-- Tickets Table -->
        <div v-else class="max-w-full overflow-x-auto shadow-md rounded-xl">
          <DynamicTable 
            :colTitle="['Type', 'Price', 'Quantity', 'Sold', 'Created At', 'Action']"
            :paginatedEvents="paginatedTickets" 
            @refreshData="refreshTickets"
            baseRoute="tickets"
            :title="$t('tickets.titleSingular')"
            :service="services.TicketService"
          />

          <!-- Pagination -->
          <Pagination 
            v-model:currentPage="currentPage" 
            :totalPages="totalPages" 
            :itemsPerPage="itemsPerPage"
            :totalItems="filteredTickets.length" 
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/store/user'
import services from '@/services'
import SearchAndPerpage from '@/components/dashboard/ui/SearchAndPerpage.vue'
import HeadPage from '@/components/dashboard/ui/HeadPage.vue'
import DynamicTable from '@/components/dashboard/ui/TableEvent.vue'
import Pagination from '@/components/dashboard/ui/Pagination.vue'
import ToastMessage from '@/components/ToastMessage.vue'

// Router and user store
const router = useRouter()
const userStore = useUserStore()

// Toast state
const toastMessage = ref("")
const toastVisible = ref(false)
const toastType = ref("success")
function showToast(message, duration = 3000, type = "success") {
  toastMessage.value = message
  toastVisible.value = true
  toastType.value = type
  setTimeout(() => (toastVisible.value = false), duration)
}

// Redirect non-admins
onMounted(() => {
  if (!userStore.isAdmin && !userStore.isOrganizer) {
    router.push('/')
  }
})

// Tickets state
const tickets = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(5)
const loading = ref(false)
const error = ref('')

// Load tickets from API
const loadTickets = async () => {
  loading.value = true
  error.value = ''
  
  try {
    const response = await services.TicketService.getAllTickets()
    console.log('Raw Tickets API Response:', response)
    
    // Handle different response structures
    let ticketsData = []
    if (response.data) {
      // If response.data is an array, use it directly
      if (Array.isArray(response.data)) {
        ticketsData = response.data
      } 
      // If response.data has a data property, use that
      else if (response.data.data && Array.isArray(response.data.data)) {
        ticketsData = response.data.data
      }
      // If response.data has items property, use that
      else if (response.data.items && Array.isArray(response.data.items)) {
        ticketsData = response.data.items
      }
    }
    
    tickets.value = ticketsData
    console.log('Processed Tickets:', tickets.value)
  } catch (err) {
    console.error('Error loading tickets:', err)
    error.value = 'Failed to load tickets. Please try again.'
    // Add some sample data for testing
    tickets.value = [
      {
        id: 1,
        type: 'General Admission',
        price: 50.00,
        quantity: 100,
        sold: 25,
        remaining: 75,
        created_at: '2024-01-15T10:30:00Z'
      },
      {
        id: 2,
        type: 'VIP',
        price: 100.00,
        quantity: 50,
        sold: 10,
        remaining: 40,
        created_at: '2024-01-15T10:30:00Z'
      }
    ]
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  refreshTickets()
})

// Computed
const filteredTickets = computed(() => {
  const q = searchQuery.value.toLowerCase()
  return (Array.isArray(tickets.value) ? tickets.value : []).filter(ticket =>
    ticket.type.toLowerCase().includes(q) ||
    String(ticket.price).includes(q) ||
    String(ticket.quantity).includes(q)
  )
})

const totalPages = computed(() =>
  Math.ceil(filteredTickets.value.length / itemsPerPage.value)
)

const paginatedTickets = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  return filteredTickets.value.slice(start, start + itemsPerPage.value)
})

// Watchers
watch(searchQuery, () => { currentPage.value = 1 })
watch(itemsPerPage, () => { currentPage.value = 1 })

// Methods
const refreshTickets = async () => {
  await loadTickets()
}

const editTicket = (ticket) => {
  router.push(`/tickets/edit/${ticket.id}`)
}

const viewTicket = (ticket) => {
  router.push(`/tickets/${ticket.id}`)
}

const deleteTicket = async (ticket) => {
  try {
    await services.TicketService.delete('eventId', ticket.id)
    tickets.value = tickets.value.filter(t => t.id !== ticket.id)
    showToast(`✅ Ticket "${ticket.type}" deleted successfully`, 3000, "success")
  } catch (err) {
    console.error('Error deleting ticket:', err)
    showToast("❌ Failed to delete ticket. Please try again.", 3000, "error")
  }
}

</script>

<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
}
</style>

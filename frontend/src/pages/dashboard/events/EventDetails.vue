<template>
  <div class="p-6 max-w-7xl mx-auto space-y-6">
    <headPage part="Events" title="Event Details" :enableBtn="false" href="" />

    <!-- Event Card -->
    <Card>
      <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-4">
        {{ event.title }}
      </h1>

      <div>
        <p class="font-bold py-6">
          <span class="text-xl text-gray-700 dark:text-gray-300">Description:</span> 
          {{ event.description }}
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
        <p><span class="font-bold">Type:</span> {{ event.type }}</p>
      </div>
    </Card>

    <!-- Event Details & Tickets Section -->
    <Card title="Event Details & Tickets">
      <template #header>
        <button 
          @click="loadTickets" 
          class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
        >
          <i class="fas fa-sync-alt mr-2"></i>Refresh
        </button>
      </template>

      <!-- Event Details Section -->
      <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Event Information -->
          <div class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Event Information</h3>
            <div class="space-y-3 text-gray-700 dark:text-gray-300">
              <div class="flex items-center">
                <i class="fas fa-calendar-alt w-5 h-5 mr-3 text-blue-600"></i>
                <div>
                  <span class="font-medium">Date:</span>
                  <span class="ml-2">{{ event.date }}</span>
                </div>
              </div>
              <div class="flex items-center">
                <i class="fas fa-map-marker-alt w-5 h-5 mr-3 text-green-600"></i>
                <div>
                  <span class="font-medium">Location:</span>
                  <span class="ml-2">{{ event.location }}</span>
                </div>
              </div>
              <div class="flex items-center">
                <i class="fas fa-user w-5 h-5 mr-3 text-purple-600"></i>
                <div>
                  <span class="font-medium">Created By:</span>
                  <span class="ml-2">{{ event.user?.name }} (ID: {{ event.user?.id }})</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Event Poster -->
          <div class="space-y-4">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Event Poster</h3>
            <div v-if="event.poster" class="flex justify-center">
              <img
                :src="getPosterUrl(event.poster)"
                alt="Event Poster"
                class="w-full max-w-sm rounded-lg shadow-md hover:shadow-lg transition-shadow"
              />
            </div>
            <div v-else class="flex flex-col items-center justify-center py-8 bg-gray-50 dark:bg-gray-700 rounded-lg">
              <i class="fas fa-image text-4xl text-gray-400 mb-2"></i>
              <p class="text-gray-500 dark:text-gray-400">No poster available</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tickets Section -->
      <div>
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Available Tickets</h3>
          <button 
            @click="createTicket"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            <i class="fas fa-plus mr-2"></i>Add Ticket
          </button>
        </div>

        <!-- Loading State -->
        <div v-if="ticketsLoading" class="flex justify-center items-center py-8">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
          <span class="ml-2 text-gray-600">Loading tickets...</span>
        </div>

        <!-- Error State -->
        <div v-else-if="ticketsError" class="text-red-600 bg-red-100 p-4 rounded-lg">
          {{ ticketsError }}
        </div>

        <!-- Tickets Grid -->
        <div v-else-if="tickets.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <TicketCard
            v-for="ticket in tickets" 
            :key="ticket.id"
            :ticket="ticket"
            @edit="editTicket"
            @delete="deleteTicket"
          />
        </div>

        <!-- No Tickets State -->
        <div v-else class="text-center py-8">
          <i class="fas fa-ticket-alt text-4xl text-gray-400 mb-4"></i>
          <p class="text-gray-500 dark:text-gray-400 mb-4">No tickets available for this event</p>
          <button 
            @click="createTicket"
            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors"
          >
            <i class="fas fa-plus mr-2"></i>Create First Ticket
          </button>
        </div>
      </div>
    </Card>
  </div>
</template>

<script>
import services from "@/services";
import Card from "@/components/dashboard/ui/Card.vue";
import TicketCard from "@/components/dashboard/ui/TicketCard.vue";

export default {
  components: {
    Card,
    TicketCard
  },
  data() {
    return {
      event: {},
      tickets: [],
      ticketsLoading: false,
      ticketsError: '',
    };
  },
  async mounted() {
    const id = this.$route.params.id;
    await this.loadEvent(id);
    await this.loadTickets();
  },
  methods: {
    async loadEvent(id) {
      try {
        const response = await services.EventService.getEventById(id);
        this.event = response.data.data;
      } catch (error) {
        console.error('Error loading event:', error);
      }
    },
    async loadTickets() {
      this.ticketsLoading = true;
      this.ticketsError = '';
      
      try {
        const eventId = this.$route.params.id;
        const response = await services.TicketService.getAll(eventId);
        this.tickets = response.data.data || [];
      } catch (error) {
        console.error('Error loading tickets:', error);
        this.ticketsError = 'Failed to load tickets. Please try again.';
      } finally {
        this.ticketsLoading = false;
      }
    },
    getPosterUrl(filename) {
      // Adjust the path depending on where your backend serves images
      return `http://localhost:8000/storage/${filename}`;
    },
    editTicket(ticket) {
      // Navigate to edit ticket page
      this.$router.push(`/events/${this.$route.params.id}/tickets/edit/${ticket.id}`);
    },
    async deleteTicket(ticket) {
      if (confirm(`Are you sure you want to delete the "${ticket.type}" ticket?`)) {
        try {
          const eventId = this.$route.params.id;
          await services.TicketService.delete(eventId, ticket.id);
          // Remove ticket from local array
          this.tickets = this.tickets.filter(t => t.id !== ticket.id);
          alert('Ticket deleted successfully!');
        } catch (error) {
          console.error('Error deleting ticket:', error);
          alert('Failed to delete ticket. Please try again.');
        }
      }
    },
    createTicket() {
      // Navigate to create ticket page
      this.$router.push(`/events/${this.$route.params.id}/tickets/create`);
    },
  },
};
</script>

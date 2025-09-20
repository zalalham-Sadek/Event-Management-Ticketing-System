<template>
            

  <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Header -->


    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="relative my-8">
            <img
              :src="event.poster ? getPosterUrl(event.poster) : '/images//event-banner.jpg'"
              :alt="event.title"
              class="w-full h-64 md:h-80 object-cover rounded-lg shadow-lg"
            />
            <div class="absolute inset-0 bg-opacity-20 rounded-lg"></div>
          </div>
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Main Content Area -->
        <div class="lg:col-span-2 space-y-6 bg-[var(--color-bg)] p-6 rounded-lg shadow-md">
          
          <!-- Event Banner -->


          <!-- Tabs -->
          <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="-mb-px flex space-x-8">
              <button
                @click="activeTab = 'details'"
                :class="[
                  'py-2 px-1 border-b-2 font-medium text-sm',
                  activeTab === 'details'
                    ? 'border-[var(--color-primary)] text-[var(--color-primary)]'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                ]"
              >
                Details
              </button>
              <button
                @click="activeTab = 'gallery'"
                :class="[
                  'py-2 px-1 border-b-2 font-medium text-sm',
                  activeTab === 'gallery'
                    ? 'border-blue-500 text-blue-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                ]"
              >
                Gallery
              </button>
            </nav>
          </div>

          <!-- Event Title and Description -->
          <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
              {{ event.title }}
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
              {{ event.description }}
            </p>
          </div>

          <!-- Event Information -->
          <div class="space-y-4">
            <div class="flex items-center text-gray-600 dark:text-gray-300">
              <i class="fas fa-calendar-alt w-5 h-5 mr-3 text-blue-600"></i>
              <span class="font-medium">Event Date & Time:</span>
              <span class="ml-2">{{ formatDate(event.date) }}</span>
            </div>
            <div class="flex items-center text-gray-600 dark:text-gray-300">
              <i class="fas fa-map-marker-alt w-5 h-5 mr-3 text-green-600"></i>
              <span class="font-medium">Location:</span>
              <span class="ml-2">{{ event.location }}</span>
            </div>
          </div>

          <!-- Event Details -->
          <div v-if="activeTab === 'details'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Event Information</h3>
            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
              {{ event.description }}
            </p>
          </div>

          <!-- Gallery Tab -->
          <div v-else-if="activeTab === 'gallery'">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Event Gallery</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
              <div v-for="i in 6" :key="i" class="aspect-square bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <i class="fas fa-image text-2xl text-gray-400"></i>
              </div>
            </div>
          </div>

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
          
          <!-- Reserve Spot Button -->
          <button
            @click="goToPayment"
            class="w-full bg-[var(--color-primary)] hover:bg-[var(--color-text)] text-white py-3 px-6 rounded-lg font-semibold transition-colors"
          >
            Reserve a Spot
          </button>

          <!-- Ticket Information -->
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center mb-4">
              <i class="fas fa-ticket-alt text-blue-600 mr-2"></i>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Ticket ({{ totalAvailableTickets }} seats remaining)
              </h3>
            </div>
            
            <div class="space-y-4">
              <div v-for="ticket in tickets" :key="ticket.id" class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                  <h4 class="font-medium text-gray-900 dark:text-white">{{ ticket.type }}</h4>
                  <span class="text-sm text-gray-500">{{ ticket.remaining }} left</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-2xl font-bold text-green-600">${{ ticket.price }}</span>
                  <div class="flex items-center space-x-2">
                    <button
                      @click="decreaseQuantity(ticket.id)"
                      :disabled="selectedTickets[ticket.id] <= 0"
                      class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 disabled:opacity-50"
                    >
                      <i class="fas fa-minus text-xs"></i>
                    </button>
                    <span class="w-8 text-center">{{ selectedTickets[ticket.id] || 0 }}</span>
                    <button
                      @click="increaseQuantity(ticket.id)"
                      :disabled="selectedTickets[ticket.id] >= ticket.remaining"
                      class="w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 disabled:opacity-50"
                    >
                      <i class="fas fa-plus text-xs"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="totalSelectedTickets > 0" class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
              <div class="flex justify-between items-center">
                <span class="font-semibold text-gray-900 dark:text-white">Total:</span>
                <span class="text-2xl font-bold text-green-600">${{ totalPrice.toFixed(2) }}</span>
              </div>
            </div>
          </div>

          <!-- Event Countdown -->
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center mb-4">
              <i class="fas fa-clock text-[var(--color-primary)] mr-2"></i>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Event Starts in</h3>
            </div>
            <div class="grid grid-cols-4 gap-2 text-center">
              <div class="bg-blue-50 dark:bg-[#835ec4] rounded-lg p-3">
                <div class="text-2xl font-bold text-[var(--color-primary)]">{{ countdown.days }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-300">Days</div>
              </div>
              <div class="bg-blue-50 dark:bg-[#835ec4] rounded-lg p-3">
                <div class="text-2xl font-bold text-[var(--color-primary)]">{{ countdown.hours }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-300">Hours</div>
              </div>
              <div class="bg-blue-50 dark:bg-[#835ec4] rounded-lg p-3">
                <div class="text-2xl font-bold text-[var(--color-primary)]">{{ countdown.minutes }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-300">Min</div>
              </div>
              <div class="bg-blue-50 dark:bg-[#835ec4] rounded-lg p-3">
                <div class="text-2xl font-bold text-[var(--color-primary)]">{{ countdown.seconds }}</div>
                <div class="text-xs text-gray-600 dark:text-gray-300">Sec</div>
              </div>
            </div>
          </div>

          <!-- Event Organizer -->
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center mb-4">
              <i class="fas fa-users text-[var(--color-primary)] mr-2"></i>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Event Organizer</h3>
            </div>
            <div class="flex items-center space-x-3">
              <div class="w-12 h-12 bg-[var(--color-muted)] rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white"></i>
              </div>
              <div>
                <h4 class="font-medium text-gray-900 dark:text-white">{{ event.user?.name || 'Event Organizer' }}</h4>
                <p class="text-sm text-gray-500">6 followers</p>
              </div>
            </div>
            <button class="w-full mt-4 bg-[var(--color-primary)] hover:bg-[var(--color-text)] text-white py-2 px-4 rounded-lg  transition-colors">
              Follow
            </button>
          </div>

          <!-- Share Event -->
          <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex items-center mb-4">
              <i class="fas fa-share text-[var(--color-primary)] mr-2"></i>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Share Event</h3>
            </div>
            <div class="flex space-x-3">
              <button class="w-10 h-10 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors">
                <i class="fab fa-facebook-f"></i>
              </button>
              <button class="w-10 h-10 bg-blue-400 text-white rounded-full hover:bg-blue-500 transition-colors">
                <i class="fab fa-twitter"></i>
              </button>
              <button class="w-10 h-10 bg-red-600 text-white rounded-full hover:bg-red-700 transition-colors">
                <i class="fab fa-pinterest"></i>
              </button>
              <button class="w-10 h-10 bg-blue-700 text-white rounded-full hover:bg-blue-800 transition-colors">
                <i class="fab fa-linkedin-in"></i>
              </button>
            </div>
          </div>

        </div>
      </div>
    </div>

    <!-- Booking Modal -->
    <div v-if="showBookingModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Complete Your Booking</h3>
          <button @click="showBookingModal = false" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-times"></i>
          </button>
        </div>
        
        <div class="space-y-4">
          <div v-for="ticket in tickets" :key="ticket.id" v-if="selectedTickets[ticket.id] > 0">
            <div class="flex justify-between items-center">
              <span>{{ ticket.type }} x{{ selectedTickets[ticket.id] }}</span>
              <span class="font-semibold">${{ (ticket.price * selectedTickets[ticket.id]).toFixed(2) }}</span>
            </div>
          </div>
          
          <div class="border-t pt-4">
            <div class="flex justify-between items-center">
              <span class="font-semibold">Total:</span>
              <span class="text-xl font-bold text-green-600">${{ totalPrice.toFixed(2) }}</span>
            </div>
          </div>
          
          <div class="flex space-x-3 pt-4">
            <button
              @click="showBookingModal = false"
              class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              @click="processBooking"
              :disabled="totalSelectedTickets === 0"
              class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
            >
              Book Now
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Toast Message -->
    <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />
  </div>

 

</template>

<script>
import services from "@/services";
import ToastMessage from "@/components/ToastMessage.vue";
import { useUserStore } from "@/store/user"
import { useRouter, useRoute } from "vue-router"
export default {
  name: 'TicketBooking',
  components: {
    ToastMessage
  },
  setup() {
    const router = useRouter()
    const route = useRoute()
    const userStore = useUserStore()
    const user = userStore.user

    const goToPayment = () => {
      if (!userStore.isAuthenticated) {
        alert("You must log in first.")
        router.push("/login")
        return
      }

      if ( userStore.user.role !== 'Attendee') {
        alert("Only attendees can reserve tickets.")
        return
      }

      router.push(`/events/${route.params.eventId}/payment`)
    }

    return { goToPayment }
  },
  data() {
    return {
      event: {},
      tickets: [],
      loading: true,
      error: '',
      activeTab: 'details',
      selectedTickets: {},
      showBookingModal: false,
      countdown: {
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0
      },
      toastMessage: '',
      toastVisible: false,
      toastType: 'success'
    };
  },
  computed: {
    totalAvailableTickets() {
      return this.tickets.reduce((total, ticket) => total + ticket.remaining, 0);
    },
    totalSelectedTickets() {
      return Object.values(this.selectedTickets).reduce((total, count) => total + count, 0);
    },
    totalPrice() {
      return this.tickets.reduce((total, ticket) => {
        const quantity = this.selectedTickets[ticket.id] || 0;
        return total + (ticket.price * quantity);
      }, 0);
    }
  },
  async mounted() {
    await this.loadEventData();
    this.startCountdown();
  },
  methods: {
    async loadEventData() {
      this.loading = true;
      this.error = '';

      try {
        const eventId = this.$route.params.eventId;
        
        // Load event details
        const eventResponse = await services.EventService.getEventById(eventId);
        this.event = eventResponse.data.data;
        
        // Load tickets
        const ticketsResponse = await services.TicketService.getAll(eventId);
        this.tickets = ticketsResponse.data.data || [];
        
        // Initialize selected tickets
        this.tickets.forEach(ticket => {
          this.selectedTickets[ticket.id] = 0;
        });
        
      } catch (error) {
        console.error('Error loading event data:', error);
        this.error = 'Failed to load event details. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    getPosterUrl(filename) {
      return `http://localhost:8000/storage/${filename}`;
    },
    formatDate(dateString) {
      if (!dateString) return 'TBD';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
    increaseQuantity(ticketId) {
      const ticket = this.tickets.find(t => t.id === ticketId);
      if (ticket && this.selectedTickets[ticketId] < ticket.remaining) {
        this.selectedTickets[ticketId]++;
      }
    },
    decreaseQuantity(ticketId) {
      if (this.selectedTickets[ticketId] > 0) {
        this.selectedTickets[ticketId]--;
      }
    },
    startCountdown() {
      if (!this.event.date) return;
      
      const eventDate = new Date(this.event.date);
      
      const updateCountdown = () => {
        const now = new Date();
        const diff = eventDate - now;
        
        if (diff > 0) {
          this.countdown.days = Math.floor(diff / (1000 * 60 * 60 * 24));
          this.countdown.hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          this.countdown.minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
          this.countdown.seconds = Math.floor((diff % (1000 * 60)) / 1000);
        } else {
          this.countdown = { days: 0, hours: 0, minutes: 0, seconds: 0 };
        }
      };
      
      updateCountdown();
      setInterval(updateCountdown, 1000);
    },
    async processBooking() {
      if (this.totalSelectedTickets === 0) {
        this.showToast('Please select at least one ticket', 'error');
        return;
      }

      try {
        // Close the modal and redirect to payment page
        this.showBookingModal = false;
        this.$router.push(`/events/${this.$route.params.eventId}/payment`);
        
      } catch (error) {
        console.error('Error processing booking:', error);
        this.showToast('Failed to process booking. Please try again.', 'error');
      }
    },


   
  
    showToast(message, type = 'success', duration = 3000) {
      this.toastMessage = message;
      this.toastType = type;
      this.toastVisible = true;
      setTimeout(() => {
        this.toastVisible = false;
      }, duration);
    }
  }
};
</script>

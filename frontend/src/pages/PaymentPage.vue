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
        
        <!-- Left Section: Personal Information -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow-md">
          <!-- Header -->
          <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
            <h2 class="text-xl font-semibold">Personal Information</h2>
          </div>
          
          <div class="p-6">
            <!-- Ticket Number -->
            <div class="mb-6">
              <p class="text-blue-600 font-medium">Ticket number 1</p>
            </div>

            <!-- Form Fields -->
            <form @submit.prevent="processPayment" class="space-y-6">
              <!-- Name Fields -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    First Name*
                  </label>
                  <input
                    v-model="form.firstName"
                    type="text"
                    required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Enter first name"
                  />
                </div>
                <div>
                  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Last Name*
                  </label>
                  <input
                    v-model="form.lastName"
                    type="text"
                    required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                    placeholder="Enter last name"
                  />
                </div>
              </div>

              <!-- Email Field -->
              <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                  Email*
                </label>
                <input
                  v-model="form.email"
                  type="email"
                  required
                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                  placeholder="Enter email address"
                />
              </div>

              <!-- Payment Summary -->
              <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-3">
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 dark:text-gray-300">Ticket Price:</span>
                  <span class="font-semibold text-gray-900 dark:text-white">${{ ticketPrice.toFixed(2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-gray-600 dark:text-gray-300">Number of Ticket:</span>
                  <span class="font-semibold text-gray-900 dark:text-white">{{ numberOfTickets }}</span>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-600 pt-3">
                  <div class="flex justify-between items-center">
                    <span class="text-lg font-semibold text-gray-900 dark:text-white">Total:</span>
                    <span class="text-xl font-bold text-gray-900 dark:text-white">${{ totalPrice.toFixed(2) }}</span>
                  </div>
                </div>
              </div>

              <!-- Payment Timer -->
              <div class="text-center">
                <p class="text-orange-600 font-medium">
                  You will get {{ paymentTimeLeft }} minutes to complete your payment
                </p>
              </div>

              <!-- Purchase Button -->
              <button
                type="submit"
                :disabled="isProcessing || paymentTimeLeft <= 0"
                class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 text-white py-3 px-6 rounded-lg font-semibold transition-colors"
              >
                <span v-if="isProcessing">
                  <i class="fas fa-spinner fa-spin mr-2"></i>Processing...
                </span>
                <span v-else>Purchase</span>
              </button>
            </form>
          </div>
        </div>

        <!-- Right Section: Ticket Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
          <!-- Header -->
          <div class="bg-blue-600 text-white px-6 py-4 rounded-t-lg">
            <h2 class="text-xl font-semibold">Ticket information</h2>
          </div>
          
          <div class="p-6">
            <!-- Event Image -->
            <div class="mb-6">
              <img
                :src="event.poster ? getPosterUrl(event.poster) : '/images/event-banner.jpg'"
                :alt="event.title"
                class="w-full h-48 object-cover rounded-lg"
              />
            </div>

            <!-- Event Details -->
            <div class="space-y-4">
              <!-- Event Title -->
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-5 h-5 mt-1">
                  <i class="fas fa-calendar-alt text-gray-400"></i>
                </div>
                <div>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Event Title</p>
                  <p class="text-blue-600 font-medium">{{ event.title || 'Chicago Auto Expo: A Showcase of Automotive Excellence' }}</p>
                </div>
              </div>

              <!-- Event Date and Time -->
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-5 h-5 mt-1">
                  <i class="fas fa-clock text-gray-400"></i>
                </div>
                <div>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Event Date and Time</p>
                  <p class="text-gray-900 dark:text-white">{{ formatEventDate(event.date) || 'October 4, 2025-October 6, 2025' }}</p>
                </div>
              </div>

              <!-- Location -->
              <div class="flex items-start space-x-3">
                <div class="flex-shrink-0 w-5 h-5 mt-1">
                  <i class="fas fa-map-marker-alt text-gray-400"></i>
                </div>
                <div>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Location - <span class="text-blue-600">Online Event</span></p>
                  <p class="text-gray-900 dark:text-white">{{ event.location || 'Mumbai, Maharashtra, India' }}</p>
                </div>
              </div>
            </div>
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

export default {
  name: 'PaymentPage',
  components: {
    ToastMessage
  },
  data() {
    return {
      event: {},
      form: {
        firstName: '',
        lastName: '',
        email: ''
      },
      ticketPrice: 15.00,
      numberOfTickets: 1,
      paymentTimeLeft: 20, // minutes
      isProcessing: false,
      toastMessage: '',
      toastVisible: false,
      toastType: 'success',
      paymentTimer: null
    };
  },
  computed: {
    totalPrice() {
      return this.ticketPrice * this.numberOfTickets;
    }
  },
  async mounted() {
    await this.loadEventData();
    this.startPaymentTimer();
  },
  beforeUnmount() {
    if (this.paymentTimer) {
      clearInterval(this.paymentTimer);
    }
  },
  methods: {
    async loadEventData() {
      try {
        const eventId = this.$route.params.eventId;
        if (eventId) {
          const eventResponse = await services.EventService.getEventById(eventId);
          this.event = eventResponse.data.data;
        }
      } catch (error) {
        console.error('Error loading event data:', error);
        // Use default data if API fails
        this.event = {
          title: 'Chicago Auto Expo: A Showcase of Automotive Excellence',
          date: '2025-10-04',
          location: 'Mumbai, Maharashtra, India'
        };
      }
    },
    getPosterUrl(filename) {
      return `http://localhost:8000/storage/${filename}`;
    },
    formatEventDate(dateString) {
      if (!dateString) return null;
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });
    },
    startPaymentTimer() {
      this.paymentTimer = setInterval(() => {
        if (this.paymentTimeLeft > 0) {
          this.paymentTimeLeft--;
        } else {
          this.showToast('Payment time expired. Please start over.', 'error');
          clearInterval(this.paymentTimer);
        }
      }, 60000); // Update every minute
    },
    async processPayment() {
      if (this.paymentTimeLeft <= 0) {
        this.showToast('Payment time has expired. Please start over.', 'error');
        return;
      }

      this.isProcessing = true;

      try {
        // Simulate payment processing
        await new Promise(resolve => setTimeout(resolve, 2000));
        
        // Here you would integrate with a real payment gateway
        // For now, we'll just show a success message
        this.showToast('Payment successful! You will receive a confirmation email shortly.', 'success');
        
        // Redirect to profile page after successful payment
        setTimeout(() => {
          this.$router.push('/profile');
        }, 2000);
        
      } catch (error) {
        console.error('Error processing payment:', error);
        this.showToast('Payment failed. Please try again.', 'error');
      } finally {
        this.isProcessing = false;
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

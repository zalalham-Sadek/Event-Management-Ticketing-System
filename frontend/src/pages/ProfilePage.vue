<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Header with Dashboard title and background -->
    <header class="relative h-20 md:h-32 bg-gradient-to-r from-gray-800 to-gray-900 overflow-hidden">
      <!-- Background image effect -->
      <div class="absolute inset-0 bg-black bg-opacity-40"></div>
      <div class="absolute inset-0 bg-gradient-to-r from-gray-800/90 to-gray-900/90"></div>
      
      <!-- Header content -->
      <div class="relative z-10 h-full flex items-center justify-between px-4 md:px-6">
        <h1 class="text-2xl md:text-4xl font-bold text-white">Dashboard</h1>
        <!-- Mobile menu button -->
        <button 
          @click="toggleSidebar"
          class="md:hidden text-white text-2xl"
        >
          <i class="fas fa-bars"></i>
        </button>
      </div>
    </header>

    <div class="flex relative">
      <!-- Mobile overlay -->
      <div 
        v-if="sidebarOpen && isMobile"
        @click="closeSidebar"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden"
      ></div>

      <!-- Left Sidebar -->
      <aside 
        :class="[
          'bg-white shadow-lg min-h-screen transition-transform duration-300 ease-in-out z-50',
          'fixed md:relative',
          'w-64',
          sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'
        ]"
      >
        <nav class="p-4 md:p-6 space-y-4">
          <!-- Close button for mobile -->
          <div class="flex justify-end md:hidden">
            <button @click="closeSidebar" class="text-gray-500 hover:text-gray-700">
              <i class="fas fa-times text-xl"></i>
            </button>
          </div>

          <!-- Dashboard - Clickable -->
          <div @click="activeTab = 'dashboard'" :class="[
            'flex items-center space-x-3 p-3 rounded-lg cursor-pointer',
            activeTab === 'dashboard' ? 'bg-blue-50 border-l-4 border-blue-500' : 'hover:bg-gray-50'
          ]">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="fas fa-home text-blue-600"></i>
            </div>
            <span :class="activeTab === 'dashboard' ? 'text-blue-600 font-medium' : 'text-gray-700'">Dashboard</span>
          </div>

          <!-- Manage Tickets - Clickable -->
          <div @click="activeTab = 'tickets'" :class="[
            'flex items-center space-x-3 p-3 rounded-lg cursor-pointer',
            activeTab === 'tickets' ? 'bg-blue-50 border-l-4 border-blue-500' : 'hover:bg-gray-50'
          ]">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="fas fa-ticket-alt text-gray-600"></i>
            </div>
            <span :class="activeTab === 'tickets' ? 'text-blue-600 font-medium' : 'text-gray-700'">Manage Tickets</span>
            <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
          </div>

          <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="fas fa-wallet text-gray-600"></i>
            </div>
            <span class="text-gray-700">Deposit</span>
            <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
          </div>

          <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="fas fa-university text-gray-600"></i>
            </div>
            <span class="text-gray-700">Withdraw</span>
            <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
          </div>

          <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="fas fa-list text-gray-600"></i>
            </div>
            <span class="text-gray-700">Transactions</span>
            <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
          </div>

          <div class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="fas fa-headset text-gray-600"></i>
            </div>
            <span class="text-gray-700">Support</span>
            <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
          </div>

          <div @click="handleLogout" class="flex items-center space-x-3 p-3 hover:bg-gray-50 rounded-lg cursor-pointer">
            <div class="w-6 h-6 flex items-center justify-center">
              <i class="fas fa-power-off text-gray-600"></i>
            </div>
            <span class="text-gray-700">Log Out</span>
            <i class="fas fa-chevron-right text-gray-400 ml-auto"></i>
          </div>
        </nav>
      </aside>

      <!-- Main Content -->
      <main class="flex-1 p-4 md:p-6">
        <!-- Dashboard Tab Content -->
        <div v-if="activeTab === 'dashboard'">
          <!-- Notification Banner -->
          <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6">
            <div class="flex items-center space-x-3">
              <span class="text-gray-700 text-sm md:text-base">Please Allow / Reset Browser Notification</span>
              <i class="fas fa-bell text-red-500"></i>
            </div>
            <p class="text-xs md:text-sm text-gray-500 mt-2">
              If you want to get push notification then you have to allow notification from your browser.
            </p>
          </div>

          <!-- Summary Cards Grid -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
            <!-- Balance Card -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
              <div class="flex items-center space-x-3 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-wallet text-purple-600 text-lg md:text-xl"></i>
                </div>
                <div>
                  <p class="text-gray-500 text-xs md:text-sm">Balance</p>
                  <p class="text-lg md:text-2xl font-bold text-gray-900">${{ userStats.balance.toFixed(2) }}</p>
                </div>
              </div>
            </div>

            <!-- Total Tickets Card -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
              <div class="flex items-center space-x-3 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-ticket-alt text-blue-600 text-lg md:text-xl"></i>
                </div>
                <div>
                  <p class="text-gray-500 text-xs md:text-sm">Total Tickets</p>
                  <p class="text-lg md:text-2xl font-bold text-gray-900">{{ userStats.totalTickets }}</p>
                </div>
              </div>
            </div>

            <!-- Refunded Tickets Card -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
              <div class="flex items-center space-x-3 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-green-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-undo text-green-600 text-lg md:text-xl"></i>
                </div>
                <div>
                  <p class="text-gray-500 text-xs md:text-sm">Refunded Tickets</p>
                  <p class="text-lg md:text-2xl font-bold text-gray-900">{{ userStats.refundedTickets }}</p>
                </div>
              </div>
            </div>

            <!-- Liked Events Card -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
              <div class="flex items-center space-x-3 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-heart text-cyan-600 text-lg md:text-xl"></i>
                </div>
                <div>
                  <p class="text-gray-500 text-xs md:text-sm">Liked Events</p>
                  <p class="text-lg md:text-2xl font-bold text-gray-900">{{ userStats.likedEvents }}</p>
                </div>
              </div>
            </div>

            <!-- Following Organizers Card -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
              <div class="flex items-center space-x-3 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-users text-orange-600 text-lg md:text-xl"></i>
                </div>
                <div>
                  <p class="text-gray-500 text-xs md:text-sm">Following Organizers</p>
                  <p class="text-lg md:text-2xl font-bold text-gray-900">{{ userStats.followingOrganizers }}</p>
                </div>
              </div>
            </div>

            <!-- Total Deposit Card -->
            <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
              <div class="flex items-center space-x-3 md:space-x-4">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                  <i class="fas fa-file-invoice-dollar text-purple-600 text-lg md:text-xl"></i>
                </div>
                <div>
                  <p class="text-gray-500 text-xs md:text-sm">Total Deposit</p>
                  <p class="text-lg md:text-2xl font-bold text-gray-900">${{ userStats.totalDeposit.toFixed(2) }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Event Transactions Table -->
          <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 md:p-6 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900">Event Transactions</h3>
            </div>
            
            <!-- Mobile Card View -->
            <div class="block md:hidden">
              <div v-for="transaction in transactions" :key="transaction.id" class="p-4 border-b border-gray-200 last:border-b-0">
                <div class="space-y-3">
                  <div>
                    <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                      {{ transaction.eventTitle }}
                    </a>
                  </div>
                  <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                      <span class="text-gray-500">Price:</span>
                      <span class="ml-1 font-medium">${{ transaction.price.toFixed(2) }}</span>
                    </div>
                    <div>
                      <span class="text-gray-500">Quantity:</span>
                      <span class="ml-1 font-medium">{{ transaction.quantity }}</span>
                    </div>
                    <div>
                      <span class="text-gray-500">Total:</span>
                      <span class="ml-1 font-medium">${{ transaction.total.toFixed(2) }}</span>
                    </div>
                    <div>
                      <span class="text-gray-500">Payment:</span>
                      <span :class="getPaymentStatusClass(transaction.paymentStatus)" class="ml-1 px-2 py-1 text-xs font-medium rounded-full">
                        {{ transaction.paymentStatus }}
                      </span>
                    </div>
                  </div>
                  <div class="flex justify-between items-center">
                    <span :class="getTransactionStatusClass(transaction.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                      {{ transaction.status }}
                    </span>
                    <button class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center hover:bg-blue-700">
                      <i class="fas fa-file-alt text-sm"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
              <table class="w-full">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="transaction in transactions" :key="transaction.id" class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">
                        {{ transaction.eventTitle }}
                      </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      ${{ transaction.price.toFixed(2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      {{ transaction.quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      ${{ transaction.total.toFixed(2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="getPaymentStatusClass(transaction.paymentStatus)" class="px-2 py-1 text-xs font-medium rounded-full">
                        {{ transaction.paymentStatus }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span :class="getTransactionStatusClass(transaction.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                        {{ transaction.status }}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <button class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center hover:bg-blue-700">
                        <i class="fas fa-file-alt text-sm"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Tickets Management Tab Content -->
        <div v-if="activeTab === 'tickets'">
          <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 md:p-6 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900">My Booked Tickets</h3>
              <p class="text-sm text-gray-500 mt-1">Manage all your purchased tickets</p>
            </div>
            
            <!-- Loading State -->
            <div v-if="loadingTickets" class="p-8 text-center">
              <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
              <p class="mt-2 text-gray-500">Loading your tickets...</p>
            </div>

            <!-- Empty State -->
            <div v-else-if="userTickets.length === 0" class="p-8 text-center">
              <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-ticket-alt text-gray-400 text-2xl"></i>
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">No tickets found</h3>
              <p class="text-gray-500 mb-4">You haven't purchased any tickets yet.</p>
              <router-link to="/" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>
                Browse Events
              </router-link>
            </div>

            <!-- Tickets List -->
            <div v-else>
              <!-- Mobile Card View -->
              <div class="block md:hidden">
                <div v-for="ticket in userTickets" :key="ticket.id" class="p-4 border-b border-gray-200 last:border-b-0">
                  <div class="space-y-3">
                    <div class="flex justify-between items-start">
                      <div>
                        <h4 class="font-medium text-gray-900">{{ ticket.event_title }}</h4>
                        <p class="text-sm text-gray-500">{{ ticket.ticket_type }}</p>
                      </div>
                      <span :class="getTicketStatusClass(ticket.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                        {{ ticket.status }}
                      </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                      <div>
                        <span class="text-gray-500">Price:</span>
                        <span class="ml-1 font-medium">${{ ticket.price.toFixed(2) }}</span>
                      </div>
                      <div>
                        <span class="text-gray-500">Quantity:</span>
                        <span class="ml-1 font-medium">{{ ticket.quantity }}</span>
                      </div>
                      <div>
                        <span class="text-gray-500">Total:</span>
                        <span class="ml-1 font-medium">${{ (ticket.price * ticket.quantity).toFixed(2) }}</span>
                      </div>
                      <div>
                        <span class="text-gray-500">Date:</span>
                        <span class="ml-1 font-medium">{{ formatDate(ticket.created_at) }}</span>
                      </div>
                    </div>

                    <div class="flex justify-between items-center">
                      <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ formatEventDate(ticket.event_date) }}
                      </div>
                      <div class="flex space-x-2">
                        <button @click="downloadTicket(ticket)" class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center hover:bg-blue-700">
                          <i class="fas fa-download text-sm"></i>
                        </button>
                        <button v-if="ticket.status === 'active'" @click="requestRefund(ticket)" class="w-8 h-8 bg-red-600 text-white rounded flex items-center justify-center hover:bg-red-700">
                          <i class="fas fa-undo text-sm"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Desktop Table View -->
              <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket Type</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Date</th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="ticket in userTickets" :key="ticket.id" class="hover:bg-gray-50">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div>
                          <div class="text-sm font-medium text-gray-900">{{ ticket.event_title }}</div>
                          <div class="text-sm text-gray-500">{{ formatDate(ticket.created_at) }}</div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ ticket.ticket_type }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${{ ticket.price.toFixed(2) }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ ticket.quantity }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        ${{ (ticket.price * ticket.quantity).toFixed(2) }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <span :class="getTicketStatusClass(ticket.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                          {{ ticket.status }}
                        </span>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ formatEventDate(ticket.event_date) }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex space-x-2">
                          <button @click="downloadTicket(ticket)" class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center hover:bg-blue-700" title="Download Ticket">
                            <i class="fas fa-download text-sm"></i>
                          </button>
                          <button v-if="ticket.status === 'active'" @click="requestRefund(ticket)" class="w-8 h-8 bg-red-600 text-white rounded flex items-center justify-center hover:bg-red-700" title="Request Refund">
                            <i class="fas fa-undo text-sm"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import { useUserStore } from '@/store/user';
import { useRouter } from 'vue-router';
import TicketService from '@/services/TicketService';

export default {
  name: 'ProfilePage',
  setup() {
    const userStore = useUserStore();
    const router = useRouter();
    
    // Responsive state
    const sidebarOpen = ref(false);
    const windowWidth = ref(window.innerWidth);
    
    // Tab state
    const activeTab = ref('dashboard');
    
    // User statistics
    const userStats = ref({
      balance: 0.00,
      totalTickets: 1,
      refundedTickets: 0,
      likedEvents: 0,
      followingOrganizers: 0,
      totalDeposit: 0.00
    });

    // Sample transaction data
    const transactions = ref([
      {
        id: 1,
        eventTitle: "Adventurer's Expedition: Discovering the Unknown",
        price: 15.00,
        quantity: 2,
        total: 30.00,
        paymentStatus: 'Pending',
        status: 'Cancelled'
      }
    ]);

    // User tickets state
    const userTickets = ref([]);
    const loadingTickets = ref(false);

    // Computed properties
    const isMobile = computed(() => windowWidth.value < 768);

    // Methods
    const toggleSidebar = () => {
      sidebarOpen.value = !sidebarOpen.value;
    };

    const closeSidebar = () => {
      sidebarOpen.value = false;
    };

    const handleResize = () => {
      windowWidth.value = window.innerWidth;
      // Close sidebar on desktop
      if (windowWidth.value >= 768) {
        sidebarOpen.value = false;
      }
    };

    const handleLogout = () => {
      // Clear user data from store
      userStore.logout();
      
      // Clear any additional tokens or data
      localStorage.removeItem('api_token');
      
      // Redirect to login page
      router.push('/login');
    };

    const getPaymentStatusClass = (status) => {
      switch (status) {
        case 'Pending':
          return 'bg-orange-100 text-orange-800';
        case 'Completed':
          return 'bg-green-100 text-green-800';
        case 'Failed':
          return 'bg-red-100 text-red-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    };

    const getTransactionStatusClass = (status) => {
      switch (status) {
        case 'Cancelled':
          return 'bg-red-100 text-red-800';
        case 'Completed':
          return 'bg-green-100 text-green-800';
        case 'Pending':
          return 'bg-yellow-100 text-yellow-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    };

    const getTicketStatusClass = (status) => {
      switch (status) {
        case 'active':
          return 'bg-green-100 text-green-800';
        case 'used':
          return 'bg-blue-100 text-blue-800';
        case 'cancelled':
          return 'bg-red-100 text-red-800';
        case 'refunded':
          return 'bg-gray-100 text-gray-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    };

    const formatDate = (dateString) => {
      if (!dateString) return 'N/A';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    };

    const formatEventDate = (dateString) => {
      if (!dateString) return 'N/A';
      const date = new Date(dateString);
      return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      });
    };

    const loadUserTickets = async () => {
      loadingTickets.value = true;
      try {
        const response = await TicketService.getUserTickets();
        userTickets.value = response.data || [];
        
        // Update user stats with actual ticket count
        userStats.value.totalTickets = userTickets.value.length;
        userStats.value.refundedTickets = userTickets.value.filter(ticket => ticket.status === 'refunded').length;
      } catch (error) {
        console.error('Error loading user tickets:', error);
        // For demo purposes, add some sample tickets
        userTickets.value = [
          {
            id: 1,
            event_title: "Tech Conference 2024",
            ticket_type: "General Admission",
            price: 50.00,
            quantity: 2,
            status: 'active',
            created_at: '2024-01-15T10:30:00Z',
            event_date: '2024-03-15T09:00:00Z'
          },
          {
            id: 2,
            event_title: "Music Festival",
            ticket_type: "VIP",
            price: 150.00,
            quantity: 1,
            status: 'used',
            created_at: '2024-01-10T14:20:00Z',
            event_date: '2024-02-20T18:00:00Z'
          }
        ];
      } finally {
        loadingTickets.value = false;
      }
    };

    const downloadTicket = (ticket) => {
      // Implement ticket download functionality
      console.log('Downloading ticket:', ticket);
      // This would typically generate a PDF or open a download dialog
      alert(`Downloading ticket for ${ticket.event_title}`);
    };

    const requestRefund = (ticket) => {
      // Implement refund request functionality
      console.log('Requesting refund for ticket:', ticket);
      if (confirm(`Are you sure you want to request a refund for ${ticket.event_title}?`)) {
        // This would typically make an API call to request refund
        alert('Refund request submitted successfully');
      }
    };

    const loadUserData = async () => {
      try {
        // Load user data from store or API
        userStore.loadUserFromStorage();
        
        // Load user tickets when tickets tab is active
        if (activeTab.value === 'tickets') {
          await loadUserTickets();
        }
      } catch (error) {
        console.error('Error loading user data:', error);
      }
    };

    // Watch for tab changes to load tickets
    watch(activeTab, (newTab) => {
      if (newTab === 'tickets' && userTickets.value.length === 0) {
        loadUserTickets();
      }
    });

    // Lifecycle
    onMounted(() => {
      loadUserData();
      window.addEventListener('resize', handleResize);
    });

    onUnmounted(() => {
      window.removeEventListener('resize', handleResize);
    });

    return {
      userStats,
      transactions,
      userTickets,
      loadingTickets,
      activeTab,
      sidebarOpen,
      isMobile,
      toggleSidebar,
      closeSidebar,
      handleLogout,
      getPaymentStatusClass,
      getTransactionStatusClass,
      getTicketStatusClass,
      formatDate,
      formatEventDate,
      downloadTicket,
      requestRefund
    };
  }
};
</script>

<style scoped>
/* Custom styles for the profile page */
</style>

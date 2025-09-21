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
          'bg-white shadow-lg min-h-screen transition-transform duration-300 ease-in-out z-41',
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

        <!-- Orders Management Tab Content -->
        <div v-if="activeTab === 'tickets'">
          <div class="bg-white rounded-lg shadow-md">
            <div class="p-4 md:p-6 border-b border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900">My Orders</h3>
              <p class="text-sm text-gray-500 mt-1">Manage all your ticket orders</p>
            </div>
            
            <!-- Loading State -->
            <div v-if="loadingOrders" class="p-8 text-center">
              <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
              <p class="mt-2 text-gray-500">Loading your orders...</p>
            </div>

            <!-- Empty State -->
            <div v-else-if="userOrders.length === 0" class="p-8 text-center">
              <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
              </div>
              <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
              <p class="text-gray-500 mb-4">You haven't made any orders yet.</p>
              <router-link to="/" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>
                Browse Events
              </router-link>
            </div>

            <!-- Orders List -->
            <div v-else>
              <!-- Mobile Card View -->
              <div class="block md:hidden">
                <div v-for="order in userOrders" :key="order.id" class="p-4 border-b border-gray-200 last:border-b-0">
                  <div class="space-y-3">
                    <div class="flex justify-between items-start">
                      <div>
                        <h4 class="font-medium text-gray-900">{{ order.event.title }}</h4>
                        <p class="text-sm text-gray-500">Order #{{ order.order_number }}</p>
                      </div>
                      <div class="text-right">
                        <span :class="getTicketStatusClass(order.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                          {{ order.status }}
                        </span>
                        <p class="text-xs text-gray-500 mt-1">{{ order.payment_status }}</p>
                      </div>
                    </div>
                    
                    <!-- Order Items -->
                    <div class="space-y-2">
                      <div v-for="item in order.order_items" :key="item.id" class="bg-gray-50 p-2 rounded">
                        <div class="flex justify-between items-center">
                          <span class="text-sm font-medium">{{ item.ticket_type }}</span>
                          <span class="text-sm text-gray-600">Qty: {{ item.quantity }}</span>
                        </div>
                        <div class="flex justify-between items-center mt-1">
                          <span class="text-xs text-gray-500">${{ parseFloat(item.unit_price || 0).toFixed(2) }} each</span>
                          <span class="text-sm font-medium">${{ parseFloat(item.total_price || 0).toFixed(2) }}</span>
                        </div>
                      </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                      <div>
                        <span class="text-gray-500">Total:</span>
                        <span class="ml-1 font-medium">${{ parseFloat(order.total_amount || 0).toFixed(2) }}</span>
                      </div>
                      <div>
                        <span class="text-gray-500">Date:</span>
                        <span class="ml-1 font-medium">{{ formatDate(order.created_at) }}</span>
                      </div>
                    </div>

                    <div class="flex justify-between items-center">
                      <div class="text-sm text-gray-500">
                        <i class="fas fa-calendar mr-1"></i>
                        {{ formatEventDate(order.event.date) }}
                      </div>
                      <div class="flex space-x-2">
                        <button v-if="order.status === 'confirmed'" @click="downloadTicket(order)" class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center hover:bg-blue-700" title="Download Tickets">
                          <i class="fas fa-download text-sm"></i>
                        </button>
                        <button v-if="order.status === 'pending'" @click="cancelOrder(order)" class="w-8 h-8 bg-orange-600 text-white rounded flex items-center justify-center hover:bg-orange-700">
                          <i class="fas fa-times text-sm"></i>
                        </button>
                        <button v-if="order.status === 'confirmed' && order.payment_status === 'paid'" @click="requestRefund(order)" class="w-8 h-8 bg-red-600 text-white rounded flex items-center justify-center hover:bg-red-700">
                          <i class="fas fa-undo text-sm"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Desktop Table View -->
<div class="hidden md:block">
  <!-- Scrollable container -->
 <!-- Scrollable Table Wrapper -->
<div class="overflow-x-auto rounded-lg shadow-md border border-gray-200">
  <table class="min-w-[900px]  divide-y divide-gray-200">
    <thead class="bg-gray-50 sticky top-0 z-10">
      <tr>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event Date</th>
        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <tr v-for="order in userOrders" :key="order.id" class="hover:bg-gray-50">
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="text-sm font-medium text-gray-900">#{{ order.order_number }}</div>
          <div class="text-sm text-gray-500">{{ formatDate(order.created_at) }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="text-sm font-medium text-gray-900">{{ order.event.title }}</div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="space-y-1">
            <div v-for="item in order.order_items" :key="item.id" class="text-sm text-gray-900">
              {{ item.ticket_type }} ({{ item.quantity }})
            </div>
          </div>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
          ${{ parseFloat(order.total_amount || 0).toFixed(2) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <span :class="getTicketStatusClass(order.status)" class="px-2 py-1 text-xs font-medium rounded-full">
            {{ order.status }}
          </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <span :class="getPaymentStatusClass(order.payment_status)" class="px-2 py-1 text-xs font-medium rounded-full">
            {{ order.payment_status }}
          </span>
        </td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
          {{ formatEventDate(order.event.date) }}
        </td>
        <td class="px-6 py-4 whitespace-nowrap">
          <div class="flex space-x-2">
            <button v-if="order.status === 'confirmed'" @click="downloadTicket(order)" class="w-8 h-8 bg-blue-600 text-white rounded flex items-center justify-center hover:bg-blue-700" title="Download Tickets">
              <i class="fas fa-download text-sm"></i>
            </button>
            <button v-if="order.status === 'pending'" @click="cancelOrder(order)" class="w-8 h-8 bg-orange-600 text-white rounded flex items-center justify-center hover:bg-orange-700" title="Cancel Order">
              <i class="fas fa-times text-sm"></i>
            </button>
            <button v-if="order.status === 'confirmed' && order.payment_status === 'paid'" @click="requestRefund(order)" class="w-8 h-8 bg-red-600 text-white rounded flex items-center justify-center hover:bg-red-700" title="Request Refund">
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
import OrderService from '@/services/OrderService';

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
            paymentStatus: 'pending',
            status: 'cancelled'
          }
        ]);

    // User orders state
    const userOrders = ref([]);
    const loadingOrders = ref(false);

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
        case 'pending':
          return 'bg-yellow-100 text-yellow-800';
        case 'paid':
          return 'bg-green-100 text-green-800';
        case 'failed':
          return 'bg-red-100 text-red-800';
        case 'refunded':
          return 'bg-gray-100 text-gray-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    };

    const getTransactionStatusClass = (status) => {
      switch (status) {
        case 'cancelled':
          return 'bg-red-100 text-red-800';
        case 'confirmed':
          return 'bg-green-100 text-green-800';
        case 'pending':
          return 'bg-yellow-100 text-yellow-800';
        case 'refunded':
          return 'bg-gray-100 text-gray-800';
        default:
          return 'bg-gray-100 text-gray-800';
      }
    };

    const getTicketStatusClass = (status) => {
      switch (status) {
        case 'pending':
          return 'bg-yellow-100 text-yellow-800';
        case 'confirmed':
          return 'bg-green-100 text-green-800';
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

    const loadUserOrders = async () => {
      loadingOrders.value = true;
      try {
        const response = await OrderService.getUserOrders();
        console.log('Raw API Response:', response);
        
        // Handle different response structures
        let ordersData = [];
        if (response.data && response.data.data) {
          // If response.data.data is an array, use it directly
          if (Array.isArray(response.data.data)) {
            ordersData = response.data.data;
          } 
          // If response.data.data has a data property (pagination), use that
          else if (response.data.data.data && Array.isArray(response.data.data.data)) {
            ordersData = response.data.data.data;
          }
          // If response.data.data has items property, use that
          else if (response.data.data.items && Array.isArray(response.data.data.items)) {
            ordersData = response.data.data.items;
          }
        }
        
        userOrders.value = ordersData;
        console.log('Processed User Orders:', userOrders.value);
        
        // Update user stats with actual order data
        userStats.value.totalTickets = userOrders.value.reduce((total, order) => {
          return total + (order.order_items ? order.order_items.reduce((sum, item) => sum + item.quantity, 0) : 0);
        }, 0);
        userStats.value.refundedTickets = userOrders.value.filter(order => order.status === 'refunded').length;
      } catch (error) {
        console.error('Error loading user orders:', error);
        // For demo purposes, add some sample orders
        userOrders.value = [
          {
            id: 1,
            order_number: 'ORD-123456',
            event: {
              title: "Tech Conference 2024",
              date: '2024-03-15T09:00:00Z'
            },
            status: 'confirmed',
            payment_status: 'paid',
            total_amount: 100.00,
            created_at: '2024-01-15T10:30:00Z',
            order_items: [
              {
                id: 1,
                ticket_type: "General Admission",
                unit_price: 50.00,
                quantity: 2,
                total_price: 100.00
              }
            ]
          },
          {
            id: 2,
            order_number: 'ORD-123457',
            event: {
              title: "Music Festival",
              date: '2024-02-20T18:00:00Z'
            },
            status: 'refunded',
            payment_status: 'refunded',
            total_amount: 150.00,
            created_at: '2024-01-10T14:20:00Z',
            order_items: [
              {
                id: 2,
                ticket_type: "VIP",
                unit_price: 150.00,
                quantity: 1,
                total_price: 150.00
              }
            ]
          }
        ];
      } finally {
        loadingOrders.value = false;
      }
    };

    const showToast = (message, duration = 3000, type = 'success') => {
      // Simple toast implementation - you can replace this with a proper toast library
      const toast = document.createElement('div');
      toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 
        type === 'error' ? 'bg-red-500' : 
        type === 'info' ? 'bg-blue-500' : 'bg-gray-500'
      }`;
      toast.textContent = message;
      document.body.appendChild(toast);
      
      setTimeout(() => {
        document.body.removeChild(toast);
      }, duration);
    };

    // const downloadTicket = async (order) => {
    //   try {
    //     console.log('Downloading tickets for order:', order);
        
    //     // Check if order is confirmed
    //     if (order.status !== 'confirmed') {
    //       showToast('Tickets can only be downloaded for confirmed orders.', 3000, 'error');
    //       return;
    //     }

    //     // Show loading state
    //     showToast('Preparing tickets for download...', 2000, 'info');
        
    //     // Get the API base URL and token
    //     const apiBaseUrl = 'http://127.0.0.1:8000/api';
    //     const token = localStorage.getItem('api_token');
        
    //     // Create download URL with authentication
    //     const downloadUrl = `${apiBaseUrl}/orders/${order.id}/download-tickets?token=${token}`;
        
    //     // Open download in new window/tab
    //     const downloadWindow = window.open(downloadUrl, '_blank');
        
    //     if (downloadWindow) {
    //       showToast(`Tickets for order ${order.order_number} are being prepared for download!`, 3000, 'success');
    //     } else {
    //       showToast('Please allow popups to download tickets.', 3000, 'error');
    //     }
        
    //   } catch (error) {
    //     console.error('Error downloading tickets:', error);
        
    //     if (error.response && error.response.status === 422) {
    //       showToast('Tickets can only be downloaded for confirmed orders.', 3000, 'error');
    //     } else if (error.response && error.response.status === 403) {
    //       showToast('You are not authorized to download these tickets.', 3000, 'error');
    //     } else {
    //       showToast('Failed to download tickets. Please try again.', 3000, 'error');
    //     }
    //   }
    // };
  const downloadTicket = async (order) => {
    try {
      const token = localStorage.getItem("api_token"); // adjust if you store token differently

      const response = await fetch(
        `http://127.0.0.1:8000/api/orders/${order.id}/download-tickets`,
        {
          method: "GET",
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      if (!response.ok) {
        // throw new Error("Failed to download tickets");
      }

      // const blob = await response.blob();
      // const url = window.URL.createObjectURL(blob);
      // const link = document.createElement("a");
      // link.href = url;
      // link.download = `tickets_${order.order_number}.html`;
      // document.body.appendChild(link);
      // link.click();
      // link.remove();
      // window.URL.revokeObjectURL(url);
    } catch (error) {
      console.error(error);
// alert("Failed to download tickets");
    }
  };
    const requestRefund = async (order) => {
      // Implement refund request functionality
      console.log('Requesting refund for order:', order);
      if (confirm(`Are you sure you want to request a refund for order ${order.order_number}?`)) {
        try {
          await OrderService.refundOrder(order.id);
          alert('Refund request submitted successfully');
          // Reload orders
          await loadUserOrders();
        } catch (error) {
          console.error('Error requesting refund:', error);
          alert('Failed to request refund. Please try again.');
        }
      }
    };

    const cancelOrder = async (order) => {
      console.log('Cancelling order:', order);
      if (confirm(`Are you sure you want to cancel order ${order.order_number}?`)) {
        try {
          await OrderService.cancelOrder(order.id);
          alert('Order cancelled successfully');
          // Reload orders
          await loadUserOrders();
        } catch (error) {
          console.error('Error cancelling order:', error);
          alert('Failed to cancel order. Please try again.');
        }
      }
    };

    const loadUserData = async () => {
      try {
        // Load user data from store or API
        userStore.loadUserFromStorage();
        console.log('User Data:', userStore.user);
        // Load user orders when tickets tab is active
        if (activeTab.value === 'tickets') {
          await loadUserOrders();
        }
      } catch (error) {
        console.error('Error loading user data:', error);
      }
    };

    // Watch for tab changes to load orders
    watch(activeTab, (newTab) => {
      if (newTab === 'tickets' && userOrders.value.length === 0) {
        loadUserOrders();
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
      userOrders,
      loadingOrders,
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
      requestRefund,
      cancelOrder
    };
  }
};
</script>

<style scoped>
/* Custom styles for the profile page */
</style>


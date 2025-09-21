<template>
  <div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th v-for="(title, index) in colTitle" :key="index" scope="col" class="px-6 py-3">
            {{ title }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="loading" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <td :colspan="colTitle.length" class="px-6 py-4 text-center">
            <div class="flex justify-center items-center">
              <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
              <span class="ml-2">Loading orders...</span>
            </div>
          </td>
        </tr>
        <tr v-else-if="paginatedOrders.length === 0" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
          <td :colspan="colTitle.length" class="px-6 py-4 text-center text-gray-500">
            No orders found
          </td>
        </tr>
        <tr v-else v-for="(order, index) in paginatedOrders" :key="order.id" 
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          
          <!-- Order Number -->
          <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
            <span class="font-mono text-sm">{{ order.order_number }}</span>
          </td>
          
          <!-- Customer -->
          <td class="px-6 py-4">
            <div class="flex flex-col">
              <span class="font-medium text-gray-900 dark:text-white">
                {{ order.user ? order.user.name : 'N/A' }}
              </span>
              <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ order.user ? order.user.email : 'N/A' }}
              </span>
            </div>
          </td>
          
          <!-- Event -->
          <td class="px-6 py-4">
            <div class="flex flex-col">
              <span class="font-medium text-gray-900 dark:text-white">
                {{ order.event ? order.event.title : 'N/A' }}
              </span>
              <span class="text-sm text-gray-500 dark:text-gray-400">
                {{ order.event ? formatDate(order.event.date) : 'N/A' }}
              </span>
            </div>
          </td>
          
          <!-- Status -->
          <td class="px-6 py-4">
            <span :class="getStatusBadgeClass(order.status)" class="px-2 py-1 text-xs font-medium rounded-full">
              {{ order.status }}
            </span>
          </td>
          
          <!-- Payment Status -->
          <td class="px-6 py-4">
            <span :class="getPaymentStatusBadgeClass(order.payment_status)" class="px-2 py-1 text-xs font-medium rounded-full">
              {{ order.payment_status }}
            </span>
          </td>
          
          <!-- Total -->
          <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
            ${{ parseFloat(order.total_amount || 0).toFixed(2) }}
          </td>
          
          <!-- Date -->
          <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
            {{ formatDate(order.created_at) }}
          </td>
          
          <!-- Actions -->
          <td class="px-6 py-4">
            <div class="flex items-center space-x-2">
              <!-- View Details -->
              <button @click="viewOrder(order)" 
                      class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                      title="View Details">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
              </button>
              
              <!-- Download Tickets (only for confirmed orders) -->
              <button v-if="order.status === 'confirmed'" 
                      @click="downloadTickets(order)"
                      class="text-green-600 hover:text-green-800 dark:text-green-400 dark:hover:text-green-300"
                      title="Download Tickets">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
              </button>
              
              <!-- Action Dropdown -->
              <div class="relative">
                <button @click="toggleDropdown(index)" 
                        class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-300">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                  </svg>
                </button>
                
                <!-- Dropdown Menu -->
                <div v-if="openDropdown === index" 
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-10 border border-gray-200 dark:border-gray-600">
                  <div class="py-1">
                    <!-- Confirm Order -->
                    <button v-if="order.status === 'pending'" 
                            @click="confirmOrder(order)"
                            class="block w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                      Confirm Order
                    </button>
                    
                    <!-- Cancel Order -->
                    <button v-if="order.status === 'pending'" 
                            @click="cancelOrder(order)"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                      Cancel Order
                    </button>
                    
                    <!-- Refund Order -->
                    <button v-if="order.status === 'confirmed' && order.payment_status === 'paid'" 
                            @click="refundOrder(order)"
                            class="block w-full text-left px-4 py-2 text-sm text-orange-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                      Refund Order
                    </button>
                    
                    <!-- Update Order -->
                    <button @click="editOrder(order)"
                            class="block w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                      Update Order
                    </button>
                    
                    <!-- Delete Order (Admin only) -->
                    <button v-if="canDeleteOrder(order)" 
                            @click="deleteOrder(order)"
                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                      Delete Order
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'TableOrder',
  props: {
    colTitle: {
      type: Array,
      required: true
    },
    paginatedOrders: {
      type: Array,
      required: true
    },
    title: {
      type: String,
      required: true
    },
    service: {
      type: Object,
      required: true
    },
    loading: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      openDropdown: null
    };
  },
  methods: {
    toggleDropdown(index) {
      this.openDropdown = this.openDropdown === index ? null : index;
    },
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      const date = new Date(dateString);
      return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    },
    getStatusBadgeClass(status) {
      const classes = {
        'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'confirmed': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'cancelled': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        'refunded': 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'
      };
      return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    },
    getPaymentStatusBadgeClass(status) {
      const classes = {
        'pending': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        'paid': 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
        'failed': 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
        'refunded': 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'
      };
      return classes[status] || 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
    },
    canDeleteOrder(order) {
      // Only allow deletion for cancelled or refunded orders
      return order.status === 'cancelled' || order.status === 'refunded';
    },
    viewOrder(order) {
      this.$emit('viewOrder', order);
    },
async downloadTickets(order) {
  try {
    console.log("Downloading tickets for order:", order);

    if (order.status !== "confirmed") {
      alert("Tickets can only be downloaded for confirmed orders.");
      return;
    }

    const token = localStorage.getItem("api_token");

    const response = await fetch(
      `http://127.0.0.1:8000/api/orders/${order.id}/download-tickets`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
          Accept: "application/pdf", // tell backend we expect PDF
        },
      }
    );

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    // Convert response to Blob
    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);

    // Create hidden <a> to download the file
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", `tickets_${order.order_number}.pdf`);
    document.body.appendChild(link);
    link.click();

    // Cleanup
    link.remove();
    window.URL.revokeObjectURL(url);

    alert(`Tickets for order ${order.order_number} downloaded successfully!`);
  } catch (error) {
    console.error("Error downloading tickets:", error);

    if (error.response && error.response.status === 422) {
      alert("Tickets can only be downloaded for confirmed orders.");
    } else if (error.response && error.response.status === 403) {
      alert("You are not authorized to download these tickets.");
    } else {
      alert("Failed to download tickets. Please try again.");
    }
  }
}
,
    editOrder(order) {
      this.$emit('editOrder', order);
    },
    async confirmOrder(order) {
      if (confirm('Are you sure you want to confirm this order?')) {
        this.$emit('confirmOrder', order);
        this.openDropdown = null;
      }
    },
    async cancelOrder(order) {
      if (confirm('Are you sure you want to cancel this order?')) {
        this.$emit('cancelOrder', order);
        this.openDropdown = null;
      }
    },
    async refundOrder(order) {
      if (confirm('Are you sure you want to refund this order?')) {
        this.$emit('refundOrder', order);
        this.openDropdown = null;
      }
    },
    async deleteOrder(order) {
      if (confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
        try {
          await this.service.deleteOrder(order.id);
          this.$emit('refreshData');
        } catch (error) {
          console.error('Failed to delete order:', error);
          alert('Failed to delete order. Please try again.');
        }
        this.openDropdown = null;
      }
    }
  },
  mounted() {
    // Close dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.relative')) {
        this.openDropdown = null;
      }
    });
  }
};
</script>

<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
      <!-- Modal Header -->
      <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
          Order Details - {{ order.order_number }}
        </h3>
        <button @click="$emit('close')" 
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="p-6 space-y-6">
        <!-- Order Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Order Details -->
          <div class="space-y-4">
            <h4 class="text-md font-semibold text-gray-900 dark:text-white">Order Information</h4>
            <div class="space-y-2">
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Order Number:</span>
                <span class="font-mono text-sm">{{ order.order_number }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Status:</span>
                <span :class="getStatusBadgeClass(order.status)" class="px-2 py-1 text-xs font-medium rounded-full">
                  {{ order.status }}
                </span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Payment Status:</span>
                <span :class="getPaymentStatusBadgeClass(order.payment_status)" class="px-2 py-1 text-xs font-medium rounded-full">
                  {{ order.payment_status }}
                </span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                <span>{{ order.payment_method || 'N/A' }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Created:</span>
                <span>{{ formatDate(order.created_at) }}</span>
              </div>
              <div v-if="order.confirmed_at" class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Confirmed:</span>
                <span>{{ formatDate(order.confirmed_at) }}</span>
              </div>
              <div v-if="order.cancelled_at" class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Cancelled:</span>
                <span>{{ formatDate(order.cancelled_at) }}</span>
              </div>
            </div>
          </div>

          <!-- Customer Information -->
          <div class="space-y-4">
            <h4 class="text-md font-semibold text-gray-900 dark:text-white">Customer Information</h4>
            <div class="space-y-2">
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Name:</span>
                <span>{{ order.user ? order.user.name : 'N/A' }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Email:</span>
                <span>{{ order.user ? order.user.email : 'N/A' }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Phone:</span>
                <span>{{ order.user ? order.user.phone : 'N/A' }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Event Information -->
        <div class="space-y-4">
          <h4 class="text-md font-semibold text-gray-900 dark:text-white">Event Information</h4>
          <div v-if="order.event" class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <h5 class="font-medium text-gray-900 dark:text-white">{{ order.event.title }}</h5>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ order.event.description }}</p>
              </div>
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-gray-600 dark:text-gray-400">Date:</span>
                  <span>{{ formatDate(order.event.date) }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-gray-600 dark:text-gray-400">Location:</span>
                  <span>{{ order.event.location }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Items -->
        <div class="space-y-4">
          <h4 class="text-md font-semibold text-gray-900 dark:text-white">Order Items</h4>
          <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th class="px-4 py-2">Ticket Type</th>
                  <th class="px-4 py-2">Unit Price</th>
                  <th class="px-4 py-2">Quantity</th>
                  <th class="px-4 py-2">Total</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in order.order_items" :key="item.id" 
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">
                    {{ item.ticket_type }}
                  </td>
                  <td class="px-4 py-2">${{ parseFloat(item.unit_price || 0).toFixed(2) }}</td>
                  <td class="px-4 py-2">{{ item.quantity }}</td>
                  <td class="px-4 py-2 font-medium">${{ parseFloat(item.total_price || 0).toFixed(2) }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-4">
          <h4 class="text-md font-semibold text-gray-900 dark:text-white">Order Summary</h4>
          <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <div class="space-y-2">
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Subtotal:</span>
                <span>${{ parseFloat(order.subtotal || 0).toFixed(2) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Service Fee:</span>
                <span>${{ parseFloat(order.service_fee || 0).toFixed(2) }}</span>
              </div>
              <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Tax:</span>
                <span>${{ parseFloat(order.tax_amount || 0).toFixed(2) }}</span>
              </div>
              <div class="flex justify-between font-semibold text-lg border-t border-gray-300 dark:border-gray-600 pt-2">
                <span>Total:</span>
                <span>${{ parseFloat(order.total_amount || 0).toFixed(2) }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Notes -->
        <div v-if="order.notes" class="space-y-4">
          <h4 class="text-md font-semibold text-gray-900 dark:text-white">Notes</h4>
          <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
            <p class="text-gray-700 dark:text-gray-300">{{ order.notes }}</p>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
          <button @click="$emit('close')" 
                  class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 dark:bg-gray-600 dark:text-gray-300 dark:border-gray-500 dark:hover:bg-gray-500">
            Close
          </button>
          
          <!-- Action buttons based on order status -->
          <button v-if="order.status === 'pending'" 
                  @click="confirmOrder"
                  class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
            Confirm Order
          </button>
          
          <button v-if="order.status === 'pending'" 
                  @click="cancelOrder"
                  class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
            Cancel Order
          </button>
          
          <button v-if="order.status === 'confirmed'" 
                  @click="downloadTickets"
                  class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
            Download Tickets
          </button>
          <button 
  @click="downloadOrderDetails"
  class="px-4 py-2 text-sm font-medium text-white bg-purple-600 border border-transparent rounded-md hover:bg-purple-700">
  Download Order Details
</button>

          <button v-if="order.status === 'confirmed' && order.payment_status === 'paid'" 
                  @click="refundOrder"
                  class="px-4 py-2 text-sm font-medium text-white bg-orange-600 border border-transparent rounded-md hover:bg-orange-700">
            Refund Order
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import services from '@/services';

export default {
  name: 'OrderDetailsModal',
  props: {
    order: {
      type: Object,
      required: true
    }
  },
  methods: {
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
    async confirmOrder() {
      if (confirm('Are you sure you want to confirm this order?')) {
        try {
          await services.OrderService.confirmOrder(this.order.id);
          this.$emit('refresh');
          this.$emit('close');
        } catch (error) {
          console.error('Failed to confirm order:', error);
          alert('Failed to confirm order. Please try again.');
        }
      }
    },
    async cancelOrder() {
      if (confirm('Are you sure you want to cancel this order?')) {
        try {
          await services.OrderService.cancelOrder(this.order.id);
          this.$emit('refresh');
          this.$emit('close');
        } catch (error) {
          console.error('Failed to cancel order:', error);
          alert('Failed to cancel order. Please try again.');
        }
      }
    },
    async refundOrder() {
      if (confirm('Are you sure you want to refund this order?')) {
        try {
          await services.OrderService.refundOrder(this.order.id);
          this.$emit('refresh');
          this.$emit('close');
        } catch (error) {
          console.error('Failed to refund order:', error);
          alert('Failed to refund order. Please try again.');
        }
      }
    },
    async downloadOrderDetails() {
  try {
    const token = localStorage.getItem("api_token");

    const response = await fetch(
      `http://127.0.0.1:8000/api/orders/${this.order.id}/download-details`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${token}`,
          // Accept: "application/pdf",
        },
      }
    );

    if (!response.ok) throw new Error("Failed to fetch PDF");

    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);

    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", `order_${this.order.order_number}.pdf`);
    document.body.appendChild(link);
    link.click();
    link.remove();

    window.URL.revokeObjectURL(url);
  } catch (error) {
    console.error("Error downloading order details:", error);
    alert("Failed to download order details.");
  }
},
    async downloadTickets() {
      try {
        console.log('Downloading tickets for order:', this.order);
        
        // Get the API base URL and token
        const apiBaseUrl = 'http://127.0.0.1:8000/api';
        const token = localStorage.getItem('api_token');
        
        // Create download URL with authentication
        const downloadUrl = `${apiBaseUrl}/orders/${this.order.id}/download-tickets?token=${token}`;
        
        // Open download in new window/tab
        const downloadWindow = window.open(downloadUrl, '_blank');
        
        if (downloadWindow) {
          alert(`Tickets for order ${this.order.order_number} are being prepared for download!`);
        } else {
          alert('Please allow popups to download tickets.');
        }
        
      } catch (error) {
        console.error('Error downloading tickets:', error);
        
        if (error.response && error.response.status === 422) {
          alert('Tickets can only be downloaded for confirmed orders.');
        } else if (error.response && error.response.status === 403) {
          alert('You are not authorized to download these tickets.');
        } else {
          alert('Failed to download tickets. Please try again.');
        }
      }
    }
  }
};
</script>

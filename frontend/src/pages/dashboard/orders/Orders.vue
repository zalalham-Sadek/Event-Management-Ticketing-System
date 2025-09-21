<template>
  <div class="p-6 max-w-7xl mx-auto">
    <headPage part="Orders" title="overview" :enableBtn="false" />

    <div class="col-span-12 md:col-span-6">
      <div
        class="bg-background-secondary space-y-3 dark:bg-box-dark m-0 p-0 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative">
        <div class="px-5 pt-2">
          <p class="text-xl inline dark:text-gray-400">Filters</p>
        </div>
        <OrderFilterPanel v-model:filters="filters" :orderStatuses="orderStatuses" :paymentStatuses="paymentStatuses" :events="events" />
        <SearchAndPerpage v-model:searchQuery="searchQuery" v-model:itemsPerPage="itemsPerPage" />
        
        <!-- Orders Table -->
        <div class="max-w-full overflow-x-auto shadow-md rounded-xl">
          <TableOrder 
            :colTitle="['Order #', 'Customer', 'Event', 'Status', 'Payment', 'Total', 'Date', 'Actions']"
            :paginatedOrders="paginatedOrders" 
            title="Order" 
            :service="services.OrderService" 
            @refreshData="refreshOrders"
            @updateOrder="handleUpdateOrder"
            @cancelOrder="handleCancelOrder"
            @confirmOrder="handleConfirmOrder"
            @refundOrder="handleRefundOrder"
            @viewOrder="viewOrder"
          />
          
          <!-- Pagination -->
          <Pagination 
            v-model:currentPage="currentPage" 
            :totalPages="totalPages" 
            :itemsPerPage="itemsPerPage"
            :totalItems="filteredOrders.length" 
          />
        </div>
      </div>
    </div>

    <!-- Order Details Modal -->
    <OrderDetailsModal 
      v-if="selectedOrder"
      :order="selectedOrder"
      @close="selectedOrder = null"
      @refresh="refreshOrders"
    />
  </div>
</template>

<script>
import SearchAndPerpage from '@/components/dashboard/ui/SearchAndPerpage.vue';
import OrderFilterPanel from '@/components/dashboard/orders/OrderFilterPanel.vue';
import HeadPage from '@/components/dashboard/ui/HeadPage.vue';
import TableOrder from '@/components/dashboard/ui/TableOrder.vue';
import Pagination from '@/components/dashboard/ui/Pagination.vue';
import OrderDetailsModal from '@/components/dashboard/orders/OrderDetailsModal.vue';
import services from '@/services';
import echo from '@/plugins/echo';
export default {
  name: 'OrdersOverview',
  data() {
    return {
      services,
      orders: [],
      events: [],
      filters: {
        status: '',
        payment_status: '',
        event_id: ''
      },
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 10,
      loading: false,
      error: '',
      selectedOrder: null
    };
  },
  async mounted() {
    await Promise.all([
      this.loadOrders(),
      this.loadEvents()
    ]);
    await echo.channel('channel-order')
        .listen('event-order', (e) => {
            console.log('Order event received:', e.order);
            alert('Order received!');
        });
  },
  
  components: {
    SearchAndPerpage,
    OrderFilterPanel,
    HeadPage,
    TableOrder,
    Pagination,
    OrderDetailsModal
  },
  computed: {
    orderStatuses() {
      return ['pending', 'confirmed', 'cancelled', 'refunded'];
    },
    paymentStatuses() {
      return ['pending', 'paid', 'failed', 'refunded'];
    },
    filteredOrders() {
      return this.orders
        .filter(order => {
          return (
            (!this.filters.status || order.status === this.filters.status) &&
            (!this.filters.payment_status || order.payment_status === this.filters.payment_status) &&
            (!this.filters.event_id || order.event_id == this.filters.event_id)
          );
        })
        .filter(order => {
          const q = this.searchQuery.toLowerCase();
          return (
            order.order_number.toLowerCase().includes(q) ||
            (order.user && order.user.name && order.user.name.toLowerCase().includes(q)) ||
            (order.event && order.event.title && order.event.title.toLowerCase().includes(q))
          );
        });
    },
    totalPages() {
      return Math.ceil(this.filteredOrders.length / this.itemsPerPage);
    },
    paginatedOrders() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredOrders.slice(start, end);
    }
  },
  methods: {
    async loadOrders() {
      this.loading = true;
      this.error = '';
      try {
        const response = await services.OrderService.getAllOrders();
        console.log('Raw Orders API Response:', response);
        
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
        
        this.orders = ordersData;
        console.log('Processed Orders:', this.orders);
      } catch (err) {
        console.error('Error loading orders:', err);
        this.error = 'Failed to load orders. Please try again.';
        // Add some sample data for testing
        this.orders = [
          {
            id: 1,
            order_number: 'ORD-123456',
            user: { name: 'John Doe', email: 'john@example.com' },
            event: { title: 'Tech Conference 2024', date: '2024-03-15' },
            status: 'confirmed',
            payment_status: 'paid',
            total_amount: 100.00,
            created_at: '2024-01-15T10:30:00Z',
            order_items: [
              {
                id: 1,
                ticket_type: 'General Admission',
                unit_price: 50.00,
                quantity: 2,
                total_price: 100.00
              }
            ]
          }
        ];
      } finally {
        this.loading = false;
      }
    },
    async loadEvents() {
      try {
        const response = await services.EventService.getAllEvents();
        console.log('Raw Events API Response:', response);
        
        // Handle different response structures
        let eventsData = [];
        if (response.data && response.data.data) {
          // If response.data.data is an array, use it directly
          if (Array.isArray(response.data.data)) {
            eventsData = response.data.data;
          } 
          // If response.data.data has a data property (pagination), use that
          else if (response.data.data.data && Array.isArray(response.data.data.data)) {
            eventsData = response.data.data.data;
          }
          // If response.data.data has items property, use that
          else if (response.data.data.items && Array.isArray(response.data.data.items)) {
            eventsData = response.data.data.items;
          }
        }
        
        this.events = eventsData;
        console.log('Processed Events:', this.events);
      } catch (err) {
        console.error('Error loading events:', err);
        // Add some sample data for testing
        this.events = [
          { id: 1, title: 'Tech Conference 2024' },
          { id: 2, title: 'Music Festival' },
          { id: 3, title: 'Art Exhibition' }
        ];
      }
    },
    async refreshOrders() {
      await this.loadOrders();
    },
    async handleUpdateOrder(order, updateData) {
      try {
        await services.OrderService.updateOrder(order.id, updateData);
        await this.refreshOrders();
      } catch (err) {
        console.error('Failed to update order:', err);
        this.error = 'Failed to update order. Please try again.';
      }
    },
    async handleCancelOrder(order) {
      try {
        await services.OrderService.cancelOrder(order.id);
        await this.refreshOrders();
      } catch (err) {
        console.error('Failed to cancel order:', err);
        this.error = 'Failed to cancel order. Please try again.';
      }
    },
    async handleConfirmOrder(order) {
      try {
        await services.OrderService.confirmOrder(order.id);
        await this.refreshOrders();
      } catch (err) {
        console.error('Failed to confirm order:', err);
        this.error = 'Failed to confirm order. Please try again.';
      }
    },
    async handleRefundOrder(order) {
      try {
        await services.OrderService.refundOrder(order.id);
        await this.refreshOrders();
      } catch (err) {
        console.error('Failed to refund order:', err);
        this.error = 'Failed to refund order. Please try again.';
      }
    },
    viewOrderDetails(order) {
      this.selectedOrder = order;
    },
    viewOrder(order) {
      this.selectedOrder = order;
    }
  }
};
</script>

<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
}
</style>

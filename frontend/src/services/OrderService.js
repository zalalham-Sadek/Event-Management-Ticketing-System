import api from './api';

const OrderService = {
  // Get all orders (for admin/organizer)
  getAllOrders(params = {}) {
    return api.get('/orders', { params });
  },

  // Get user's orders (for attendees)
  getUserOrders(params = {}) {
    return api.get('/user/orders', { params });
  },

  // Get order by ID
  getOrderById(orderId) {
    return api.get(`/orders/${orderId}`);
  },

  // Create new order (purchase tickets)
  createOrder(orderData) {
    return api.post('/orders', orderData);
  },

  // Update order
  updateOrder(orderId, orderData) {
    return api.put(`/orders/${orderId}`, orderData);
  },

  // Cancel order
  cancelOrder(orderId) {
    return api.post(`/orders/${orderId}/cancel`);
  },

  // Confirm order
  confirmOrder(orderId) {
    return api.post(`/orders/${orderId}/confirm`);
  },

  // Refund order
  refundOrder(orderId) {
    return api.post(`/orders/${orderId}/refund`);
  },

  // Delete order (admin only)
  deleteOrder(orderId) {
    return api.delete(`/orders/${orderId}`);
  },

  // Get orders by event (for organizers)
  getOrdersByEvent(eventId, params = {}) {
    return api.get('/orders', { 
      params: { 
        event_id: eventId, 
        ...params 
      } 
    });
  },

  // Get orders by status
  getOrdersByStatus(status, params = {}) {
    return api.get('/orders', { 
      params: { 
        status, 
        ...params 
      } 
    });
  },

  // Get orders by payment status
  getOrdersByPaymentStatus(paymentStatus, params = {}) {
    return api.get('/orders', { 
      params: { 
        payment_status: paymentStatus, 
        ...params 
      } 
    });
  },

  // Download tickets for an order
  downloadTickets(orderId) {
    return api.get(`/orders/${orderId}/download-tickets`, {
      responseType: 'blob' // Important for file downloads
    });
  }
};

export default OrderService;

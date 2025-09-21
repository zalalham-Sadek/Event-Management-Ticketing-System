import api from './api';

const TicketService = {

  // Get all tickets (for admin/organizer overview)
  getAllTickets() {
    return api.get('/tickets');
  },

  // Get tickets for a specific event
  getAll(eventId) {
    return api.get(`/events/${eventId}/tickets`);
  },

  // Get ticket by ID
  getTicketById(eventId, ticketId) {
    return api.get(`/events/${eventId}/tickets/${ticketId}`);
  },

  // Create new ticket for an event
  createTicket(eventId, ticketData) {
    return api.post(`/events/${eventId}/tickets`, ticketData);
  },

  // Update ticket
  updateTicket(eventId, ticketId, ticketData) {
    return api.put(`/events/${eventId}/tickets/${ticketId}`, ticketData);
  },

  // Delete ticket
  delete(eventId, ticketId) {
    return api.delete(`/events/${eventId}/tickets/${ticketId}`);
  },

  // Get tickets for current user
  getUserTickets() {
    return api.get('/user/tickets');
  },

  // Purchase ticket (legacy method - use OrderService.createOrder instead)
  purchaseTicket(eventId, ticketId, quantity) {
    return api.post(`/events/${eventId}/tickets/${ticketId}/purchase`, {
      quantity: quantity
    });
  },

  // Purchase multiple tickets (create order)
  purchaseTickets(eventId, items, paymentMethod = null, notes = null) {
    return api.post('/orders', {
      event_id: eventId,
      items: items,
      payment_method: paymentMethod,
      notes: notes
    });
  }

};

export default TicketService;
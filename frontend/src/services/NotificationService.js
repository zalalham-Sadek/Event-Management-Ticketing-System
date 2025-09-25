import api from './api';
const NotificationService = {

  fetchNotifications() {
    return api.get('/admin/notifications');
  },

  markAsRead(notificationId) {
    return api.post(`/admin/notifications/${notificationId}/mark-read`);
  },

  markAllAsRead() {
    return api.post('/notifications/read-all');
  }
};

export default NotificationService;
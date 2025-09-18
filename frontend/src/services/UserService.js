import api from './api';

const UserService = {

  // Get all users
  getAllUsers() {
    return api.get('/api/users');
  },

  // Get user by ID
  getUserById(id) {
    return api.get(`/api/users/${id}`);
  },

  // Create new user
  createUser(userData) {
    return api.post('/api/users/create', userData);
  },

  // Update user
  updateUser(id, userData) {
    return api.put(`/api/users/${id}`, userData);
  },

  // Delete user
  delete(id) {
    return api.delete(`/api/users/${id}`);
  },

  // Get current user profile
  getCurrentUser() {
    return api.get('/api/me');
  },

  // Update current user profile
  updateProfile(userData) {
    return api.put('/api/profile', userData);
  },

  // Change password
  changePassword(passwordData) {
    return api.post('/api/change-password', passwordData);
  },

  // Get users with pagination
  getUsersWithPagination(page = 1, limit = 10, search = '') {
    return api.get('/api/users', {
      params: {
        page,
        limit,
        search
      }
    });
  },

  // Get users by role
  getUsersByRole(role) {
    return api.get('/api/users', {
      params: { role }
    });
  },

  // Bulk delete users
  bulkDeleteUsers(userIds) {
    return api.post('/api/users/bulk-delete', { userIds });
  },

  // Export users
  exportUsers(format = 'csv') {
    return api.get('/api/users/export', {
      params: { format },
      responseType: 'blob'
    });
  }
};

export default UserService;

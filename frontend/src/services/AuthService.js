import api from './api';

const AuthService = {

  login(credentials) {
    return api.post('/login', credentials);
  },


  register(userData) {
    return api.post('/register', userData);
  },


  getCurrentUser() {
    return api.get('/user');
  },


  logout() {
    return api.post('/api/logout');
  },


  checkSetup() {
    return api.get('/setup-admin');
  },


  setupAdmin(adminData) {
    return api.post('/setup-admin', adminData);
  }
};

export default AuthService;
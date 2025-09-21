import api from './api';

const StatisticsService = {
  // Get dashboard statistics
  getDashboardStats() {
    return api.get('/statistics/dashboard');
  }
};

export default StatisticsService;

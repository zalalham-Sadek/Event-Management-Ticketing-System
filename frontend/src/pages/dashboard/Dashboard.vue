<template>
  <!-- 🎉 Toast after login or API message -->
  <ToastMessage
    :message="toastMessage"
    :visible="showToast"
    :type="toastType"
  />

  <div class="p-6 space-y-10 bg-background-secondary">
    <WellcomeCard :userName="userName" />

    <!-- Loading State -->
    <div v-if="loading" class="flex justify-center items-center py-12">
      <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
    </div>

    <!-- Statistics Cards -->
    <div v-else-if="statistics" class="space-y-8">
      <!-- Main Statistics Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Events Statistics -->
        <StatisticsCard
          title="Total Events"
          :value="statistics.events?.total || 0"
          subtitle="All events"
          icon="fas fa-calendar-alt"
          icon-class="bg-blue-100 text-blue-600 dark:bg-blue-700 dark:text-blue-200"
        />
        <StatisticsCard
          title="Upcoming Events"
          :value="statistics.events?.upcoming || 0"
          subtitle="Future events"
          icon="fas fa-calendar-check"
          icon-class="bg-green-100 text-green-600 dark:bg-green-700 dark:text-green-200"
        />
        <StatisticsCard
          title="Total Orders"
          :value="statistics.orders?.total || 0"
          subtitle="All orders"
          icon="fas fa-shopping-cart"
          icon-class="bg-purple-100 text-purple-600 dark:bg-purple-700 dark:text-purple-200"
        />
        <StatisticsCard
          title="Total Revenue"
          :value="formatCurrency(statistics.revenue?.total || 0)"
          subtitle="All time"
          icon="fas fa-dollar-sign"
          icon-class="bg-yellow-100 text-yellow-600 dark:bg-yellow-700 dark:text-yellow-200"
        />
      </div>

      <!-- Secondary Statistics Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <StatisticsCard
          title="Confirmed Orders"
          :value="statistics.orders?.confirmed || 0"
          subtitle="Paid orders"
          icon="fas fa-check-circle"
          icon-class="bg-green-100 text-green-600 dark:bg-green-700 dark:text-green-200"
        />
        <StatisticsCard
          title="Pending Orders"
          :value="statistics.orders?.pending || 0"
          subtitle="Awaiting payment"
          icon="fas fa-clock"
          icon-class="bg-orange-100 text-orange-600 dark:bg-orange-700 dark:text-orange-200"
        />
        <StatisticsCard
          title="Tickets Sold"
          :value="statistics.tickets?.total_sold || 0"
          subtitle="Total sold"
          icon="fas fa-ticket-alt"
          icon-class="bg-indigo-100 text-indigo-600 dark:bg-indigo-700 dark:text-indigo-200"
        />
        <StatisticsCard
          title="This Month Revenue"
          :value="formatCurrency(statistics.revenue?.this_month || 0)"
          subtitle="Current month"
          icon="fas fa-chart-line"
          icon-class="bg-emerald-100 text-emerald-600 dark:bg-emerald-700 dark:text-emerald-200"
        />
      </div>

      <!-- Admin Only Statistics -->
      <div v-if="userStore.isAdmin" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <StatisticsCard
          title="Total Users"
          :value="statistics.users?.total || 0"
          subtitle="All users"
          icon="fas fa-users"
          icon-class="bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-200"
        />
        <StatisticsCard
          title="Organizers"
          :value="statistics.users?.organizers || 0"
          subtitle="Event organizers"
          icon="fas fa-user-tie"
          icon-class="bg-blue-100 text-blue-600 dark:bg-blue-700 dark:text-blue-200"
        />
        <StatisticsCard
          title="Attendees"
          :value="statistics.users?.attendees || 0"
          subtitle="Event attendees"
          icon="fas fa-user"
          icon-class="bg-green-100 text-green-600 dark:bg-green-700 dark:text-green-200"
        />
        <StatisticsCard
          title="New Users This Month"
          :value="statistics.users?.new_this_month || 0"
          subtitle="Current month"
          icon="fas fa-user-plus"
          icon-class="bg-purple-100 text-purple-600 dark:bg-purple-700 dark:text-purple-200"
        />
      </div>

      <!-- Charts and Analytics -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Chart -->
        <RevenueChart :monthly-revenue="statistics.monthly_revenue || []" />
        
        <!-- Top Events -->
        <TopEventsCard :top-events="statistics.top_events || []" />
      </div>

      <!-- Events by Location & Events by Month -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="text-xl font-semibold mb-3 text-gray-800 dark:text-white">
            <i class="fa-solid fa-location-dot"></i> Events by Location
          </h3>
          <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md h-full">
            <BaseBarChart :chartData="eventsLocationData" :chartOptions="chartOptions" />
          </div>
        </div>
        <div>
          <h3 class="text-xl font-semibold mb-3 text-gray-800 dark:text-white">
            <i class="fa-solid fa-calendar-days"></i> Order Status Distribution
          </h3>
          <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md h-full">
            <BaseDoughnutChart :chartData="orderStatusData" :chartOptions="chartOptions" />
          </div>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else class="text-center py-12">
      <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
      <p class="text-gray-600 dark:text-gray-400">Failed to load statistics</p>
      <button @click="fetchStatistics" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Try Again
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useUserStore } from '@/store/user'
import BaseBarChart from '@/components/dashboard/ui/BarChart.vue'
import BaseDoughnutChart from '@/components/dashboard/ui/BaseDoughnutChart.vue'
import StatisticsCard from '@/components/dashboard/ui/StatisticsCard.vue'
import RevenueChart from '@/components/dashboard/ui/RevenueChart.vue'
import TopEventsCard from '@/components/dashboard/ui/TopEventsCard.vue'
import WellcomeCard from '@/components/dashboard/ui/WellcomeCard.vue'
import service from '@/services'

// 📦 State
const statistics = ref(null)
const loading = ref(true)
const showToast = ref(false)
const toastMessage = ref('')
const toastType = ref('success')

// User store
const userStore = useUserStore()
const userName = computed(() => userStore.user?.name || 'Admin')

// Fetch statistics data
const fetchStatistics = async () => {
  try {
    loading.value = true
    
    // Check if user is authenticated
    if (!userStore.isAuthenticated) {
      toastMessage.value = 'Please log in to view statistics'
      toastType.value = 'error'
      showToast.value = true
      setTimeout(() => showToast.value = false, 3000)
      return
    }
    
    const response = await service.StatisticsService.getDashboardStats()
    statistics.value = response.data.data
  } catch (err) {
    console.error('Failed to load statistics:', err)
    
    // Handle authentication errors
    if (err.response?.status === 401) {
      toastMessage.value = 'Please log in to view statistics'
      userStore.logout()
      // Redirect to login page
      window.location.href = '/login'
    } else {
      toastMessage.value = 'Failed to load statistics'
    }
    
    toastType.value = 'error'
    showToast.value = true
    setTimeout(() => showToast.value = false, 3000)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  userStore.loadUserFromStorage()
  fetchStatistics()
})

// 📊 Chart Data
const eventsLocationData = computed(() => {
  if (!statistics.value?.events_by_location) {
    return { labels: [], datasets: [{ label: 'Events per Location', backgroundColor: '#3b82f6', data: [] }] }
  }
  
  return {
    labels: statistics.value.events_by_location.map(item => item.location),
    datasets: [{
      label: 'Events per Location',
      backgroundColor: '#3b82f6',
      data: statistics.value.events_by_location.map(item => item.count)
    }]
  }
})

const orderStatusData = computed(() => {
  if (!statistics.value?.order_status_distribution) {
    return { labels: [], datasets: [{ label: 'Order Status', backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'], data: [] }] }
  }
  
  return {
    labels: statistics.value.order_status_distribution.map(item => item.status),
    datasets: [{
      label: 'Order Status Distribution',
      backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
      data: statistics.value.order_status_distribution.map(item => item.count)
    }]
  }
})

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  scales: { y: { beginAtZero: true } }
}

// Utility functions
const formatCurrency = (amount) => {
  return parseFloat(amount || 0).toLocaleString('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
  })
}
</script>

<style scoped>
div :deep(canvas) {
  height: 300px !important;
}
</style>

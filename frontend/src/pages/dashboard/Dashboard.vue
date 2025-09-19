<template>
  <!-- 🎉 Toast after login or API message -->
  <ToastMessage
    :message="toastMessage"
    :visible="showToast"
    :type="toastType"
  />

  <div class="p-6 space-y-10 bg-background-secondary">
    <WellcomeCard :userName="userName" />

    <!-- cards to the total events , event without speakers, upcoming event -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
      <CardAnalytic title="Total Events" class="p-4 rounded-full bg-blue-100 dark:bg-blue-700" :total="totalEvents">
        <i class="fas fa-calendar-alt text-blue-700 dark:text-blue-200 text-xl"></i>
      </CardAnalytic>
      <CardAnalytic title="Upcoming Events" class="p-4 rounded-full bg-green-100 dark:bg-green-700" :total="upcomingEvents.length">
        <i class="fas fa-calendar-check text-green-700 dark:text-green-200 text-xl"></i>
      </CardAnalytic>
      <CardAnalytic title="Events Without Speakers" class="p-4 rounded-full bg-red-100 dark:bg-red-700" :total="eventsWithoutSpeakers.length">
        <i class="fas fa-user-slash text-red-700 dark:text-red-200 text-xl"></i>
      </CardAnalytic>
    </div>

    <!--  Events by Location &  Events by Month -->
    <div class="mb-12 grid grid-cols-1 md:grid-cols-2 gap-6">
      <div class="mt-12">
        <h3 class="text-xl font-semibold mb-3 text-gray-800 dark:text-white"><i class="fa-solid fa-location-dot"></i> Events by Location</h3>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md h-full">
          <BaseBarChart :chartData="eventsLocationData" :chartOptions="chartOptions" />
        </div>
      </div>
      <div class="mt-12">
        <h3 class="text-xl font-semibold mb-3 text-gray-800 dark:text-white"><i class="fa-solid fa-calendar-days"></i> Events by Month</h3>
        <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-md h-full">
          <BaseDoughnutChart :chartData="eventsByMonthData" :chartOptions="chartOptions" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
// import service from '@/services'
import { useUserStore } from '@/store/user'
import BaseBarChart from '@/components/dashboard/ui/BarChart.vue'
import BaseDoughnutChart from '@/components/dashboard/ui/BaseDoughnutChart.vue'
import CardAnalytic from '@/components/dashboard/ui/CardAnalytic.vue'
import WellcomeCard from '@/components/dashboard/ui/WellcomeCard.vue'
import service from '@/services'

// 📦 State
const events = ref([])
const speakers = ref([])
const showToast = ref(false)
const toastMessage = ref('')
const toastType = ref('success')

// User store
const userStore = useUserStore()
const userName = computed(() => userStore.user?.name || 'Admin')

// Fetch API data
const fetchData = async () => {
  try {
    const [eventsRes] = await Promise.all([
      service.EventService.getAllEvents(),
    ])
    events.value = eventsRes.data.events
  } catch (err) {
    toastMessage.value = 'Failed to load data from API'
    toastType.value = 'error'
    showToast.value = true
    setTimeout(() => showToast.value = false, 3000)
    console.error(err)
  }
}

onMounted(() => {
  userStore.loadUserFromStorage()
  fetchData()
})

// 📊 Analytics
const totalEvents = computed(() => events.value.length)
const upcomingEvents = computed(() => events.value.filter(e => new Date(e.date) > new Date()))
const eventsWithoutSpeakers = computed(() => events.value.filter(e => !e.speakerIds || e.speakerIds.length === 0))

const eventsByLocation = computed(() => {
  const result = {}
  events.value.forEach(e => {
    result[e.location] = (result[e.location] || 0) + 1
  })
  return result
})

const eventsLocationData = computed(() => ({
  labels: Object.keys(eventsByLocation.value),
  datasets: [{
    label: 'Events per Location',
    backgroundColor: '#3b82f6',
    data: Object.values(eventsByLocation.value)
  }]
}))

const eventsByMonth = computed(() => {
  const monthMap = {}
  events.value.forEach(e => {
    const month = new Date(e.date).toLocaleString('default', { month: 'short', year: 'numeric' })
    monthMap[month] = (monthMap[month] || 0) + 1
  })
  return monthMap
})

const eventsByMonthData = computed(() => ({
  labels: Object.keys(eventsByMonth.value),
  datasets: [{
    label: 'Events per Month',
    backgroundColor: [
      '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6',
      '#ec4899', '#22d3ee', '#14b8a6', '#f43f5e', '#eab308'
    ],
    data: Object.values(eventsByMonth.value)
  }]
}))

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  scales: { y: { beginAtZero: true } }
}
</script>

<style scoped>
div :deep(canvas) {
  height: 300px !important;
}
</style>

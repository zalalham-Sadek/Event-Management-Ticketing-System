<template>
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
      <i class="fas fa-trophy text-yellow-600 mr-2"></i>
      Top Events by Revenue
    </h3>
    <div v-if="topEvents && topEvents.length > 0" class="space-y-3">
      <div 
        v-for="(event, index) in topEvents" 
        :key="event.id"
        class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg"
      >
        <div class="flex items-center">
          <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-700 text-blue-600 dark:text-blue-200 font-semibold text-sm mr-3">
            {{ index + 1 }}
          </div>
          <div>
            <p class="font-medium text-gray-900 dark:text-white">{{ event.title }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              {{ formatDate(event.date) }}
            </p>
          </div>
        </div>
        <div class="text-right">
          <p class="font-semibold text-green-600 dark:text-green-400">
            ${{ formatCurrency(event.total_revenue || 0) }}
          </p>
        </div>
      </div>
    </div>
    <div v-else class="text-center py-8 text-gray-500 dark:text-gray-400">
      <i class="fas fa-trophy text-4xl mb-2"></i>
      <p>No events data available</p>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  topEvents: {
    type: Array,
    default: () => []
  }
})

const formatDate = (dateString) => {
  if (!dateString) return 'N/A'
  const date = new Date(dateString)
  return date.toLocaleDateString('en-US', { 
    month: 'short', 
    day: 'numeric', 
    year: 'numeric' 
  })
}

const formatCurrency = (amount) => {
  return parseFloat(amount || 0).toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  })
}
</script>

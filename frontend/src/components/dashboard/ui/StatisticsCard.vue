<template>
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between">
      <div>
        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ title }}</p>
        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ value }}</p>
        <p v-if="subtitle" class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ subtitle }}</p>
      </div>
      <div :class="iconClass" class="p-3 rounded-full">
        <i :class="icon" class="text-xl"></i>
      </div>
    </div>
    <div v-if="trend" class="mt-4 flex items-center">
      <span :class="trendClass" class="text-sm font-medium">
        <i :class="trendIcon"></i>
        {{ trend }}
      </span>
      <span v-if="trendPeriod" class="text-xs text-gray-500 dark:text-gray-400 ml-2">{{ trendPeriod }}</span>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  value: {
    type: [String, Number],
    required: true
  },
  subtitle: {
    type: String,
    default: ''
  },
  icon: {
    type: String,
    required: true
  },
  iconClass: {
    type: String,
    default: 'bg-blue-100 text-blue-600 dark:bg-blue-700 dark:text-blue-200'
  },
  trend: {
    type: String,
    default: ''
  },
  trendType: {
    type: String,
    default: 'neutral', // 'positive', 'negative', 'neutral'
    validator: (value) => ['positive', 'negative', 'neutral'].includes(value)
  },
  trendPeriod: {
    type: String,
    default: ''
  }
})

const trendClass = computed(() => {
  const baseClass = 'text-sm font-medium'
  switch (props.trendType) {
    case 'positive':
      return `${baseClass} text-green-600 dark:text-green-400`
    case 'negative':
      return `${baseClass} text-red-600 dark:text-red-400`
    default:
      return `${baseClass} text-gray-600 dark:text-gray-400`
  }
})

const trendIcon = computed(() => {
  switch (props.trendType) {
    case 'positive':
      return 'fas fa-arrow-up'
    case 'negative':
      return 'fas fa-arrow-down'
    default:
      return 'fas fa-minus'
  }
})
</script>

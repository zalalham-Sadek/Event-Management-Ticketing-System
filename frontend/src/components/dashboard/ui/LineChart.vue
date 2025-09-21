<template>
  <div class="relative h-full">
    <canvas ref="chartCanvas"></canvas>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, nextTick } from 'vue'
import { Chart, registerables } from 'chart.js'

Chart.register(...registerables)

const props = defineProps({
  chartData: {
    type: Object,
    required: true
  },
  chartOptions: {
    type: Object,
    default: () => ({})
  }
})

const chartCanvas = ref(null)
let chartInstance = null

const initChart = () => {
  if (chartInstance) {
    chartInstance.destroy()
  }

  if (chartCanvas.value) {
    chartInstance = new Chart(chartCanvas.value, {
      type: 'line',
      data: props.chartData,
      options: props.chartOptions
    })
  }
}

onMounted(() => {
  nextTick(() => {
    initChart()
  })
})

watch(() => props.chartData, () => {
  if (chartInstance) {
    chartInstance.data = props.chartData
    chartInstance.update()
  }
}, { deep: true })

watch(() => props.chartOptions, () => {
  if (chartInstance) {
    chartInstance.options = props.chartOptions
    chartInstance.update()
  }
}, { deep: true })
</script>

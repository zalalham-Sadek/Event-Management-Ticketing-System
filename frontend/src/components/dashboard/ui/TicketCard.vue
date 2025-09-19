<template>
  <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600 hover:shadow-md transition-shadow">
    <!-- Header -->
    <div class="flex justify-between items-start mb-3">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
        {{ ticket.type }}
      </h3>
      <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
        {{ ticket.remaining }} left
      </span>
    </div>
    
    <!-- Ticket Details -->
    <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
      <div class="flex justify-between">
        <span>Price:</span>
        <span class="font-semibold text-green-600">${{ ticket.price }}</span>
      </div>
      <div class="flex justify-between">
        <span>Total Quantity:</span>
        <span>{{ ticket.quantity }}</span>
      </div>
      <div class="flex justify-between">
        <span>Sold:</span>
        <span>{{ ticket.sold }}</span>
      </div>
      <div class="flex justify-between">
        <span>Remaining:</span>
        <span class="font-semibold">{{ ticket.remaining }}</span>
      </div>
    </div>

    <!-- Progress Bar -->
    <div class="mt-4">
      <div class="flex justify-between text-xs text-gray-500 mb-1">
        <span>Sales Progress</span>
        <span>{{ Math.round((ticket.sold / ticket.quantity) * 100) }}%</span>
      </div>
      <div class="w-full bg-gray-200 rounded-full h-2">
        <div 
          class="bg-blue-600 h-2 rounded-full transition-all duration-300"
          :style="{ width: `${(ticket.sold / ticket.quantity) * 100}%` }"
        ></div>
      </div>
    </div>

    <!-- Actions -->
    <div class="mt-4 flex gap-2">
      <button 
        @click="$emit('edit', ticket)"
        class="flex-1 px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors"
      >
        <i class="fas fa-edit mr-1"></i>Edit
      </button>
      <button 
        @click="$emit('delete', ticket)"
        class="flex-1 px-3 py-2 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors"
      >
        <i class="fas fa-trash mr-1"></i>Delete
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TicketCard',
  props: {
    ticket: {
      type: Object,
      required: true
    }
  },
  emits: ['edit', 'delete']
}
</script>

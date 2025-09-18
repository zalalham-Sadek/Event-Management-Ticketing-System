<template>
  <div
    class="flex flex-col sm:flex-row sm:items-center sm:justify-between px-4 py-4 sm:px-6 text-sm text-gray-600 dark:text-gray-400 gap-2">
    <span>
      Showing {{ (currentPage - 1) * itemsPerPage + 1 }}
      to {{ Math.min(currentPage * itemsPerPage, totalItems) }}
      of {{ totalItems }} entries
    </span>
    <div class="flex flex-wrap items-center gap-2">
      <div class="flex flex-wrap gap-1">
        <button
          @click="$emit('update:currentPage', currentPage - 1)"
          class="px-2 py-1 rounded text-gray-400 bg-gray-200 dark:bg-[ #5189AC] dark:-text-gray-700"
          :disabled="currentPage === 1">
          <i class="fas fa-angle-double-left"></i>
        </button>
        <button
          v-for="page in totalPages"
          :key="page"
          @click="$emit('update:currentPage', page)"
          :class="[
            'px-2 py-1 rounded',
            currentPage === page ? 'text-primary-text bg-background-primary' : 'text-gray-500 bg-gray-200 dark:bg-[#cbdae6] '
          ]">
          {{ page }}
        </button>
        <button
          @click="$emit('update:currentPage', currentPage + 1)"
          class="px-2 py-1 rounded text-gray-400 bg-gray-200"
          :disabled="currentPage === totalPages">
          <i class="fas fa-angle-double-right"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PaginationComponent',
  props: {
    currentPage: {
      type: Number,
      required: true
    },
    totalItems: {
      type: Number,
      required: true
    },
    itemsPerPage: {
      type: Number,
      required: true
    }
  },
  computed: {
    totalPages() {
      return Math.ceil(this.totalItems / this.itemsPerPage);
    }
  }
};
</script>

<style scoped>
button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
<template>
  <div class="relative w-24">
    <select
      :value="modelValue"
      @change="handleChange($event)"
      class="appearance-none w-full px-4 py-2 pr-10 text-sm rounded-md border border-primary-border dark:border-gray-600 bg-background-secondary  text-secondary-text focus:outline-none focus:ring-2  focus:ring-primary-border"
    >
      <option :value="5">5</option>
      <option :value="10">10</option>
      <option :value="20">20</option>
    </select>

    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-500">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M19 9l-7 7-7-7" />
      </svg>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: Number,
  },
  emits: ['update:modelValue'],
  methods: {
    handleChange(event) {
      const value = +event.target.value;
      console.log('PaginationSelect: value changed to:', value);
      this.$emit('update:modelValue', value);
    }
  }
}
</script>

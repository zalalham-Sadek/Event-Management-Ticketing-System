<template>
  <div class="relative w-full flex items-center">
    <span class="absolute right-3 text-gray-400 pointer-events-none">
      <i :class="icon"></i>
    </span>
    <select
      :value="modelValue"
      @change="$emit('update:modelValue', $event.target.value)"
      class="appearance-none w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-primary-border dark:border-gray-600 bg-background-secondary  text-secondary-text  focus:outline-none focus:ring-2 focus:ring-primary-border"
    >
  <option value="">All {{ label }}</option> <!-- ← Add this -->
      <option v-for="item in data" :key="getItemValue(item)" :value="getItemValue(item)">{{ getItemLabel(item) }}</option>
    </select>
  </div>
</template>

<script>
export default {
  props: {
    icon: String,
    label: String,
    data: {
      type: Array,
      required: true
    },
    modelValue: String
  },
  emits: ['update:modelValue'],
  methods: {
    getItemValue(item) {
      return typeof item === 'object' ? item.value : item;
    },
    getItemLabel(item) {
      return typeof item === 'object' ? item.label : item;
    }
  }
}
</script>

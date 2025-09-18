<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 px-5 border-b border-gray-300 pb-5">
    <SelectField
      icon="fas fa-chevron-down"
      :modelValue="filters.type"
      label="Type"
      :data="eventTypes"
      @update:modelValue="updateFilter('type', $event)"
    />
    <SelectField
      icon="fas fa-chevron-down"
      label="Location"
      :data="eventLocations"
      :modelValue="filters.location"
      @update:modelValue="updateFilter('location', $event)"
    />
    <InputField
      :type="'date'"
      :placeholder="' Date '"
      :modelValue="filters.date"
      @update:modelValue="updateFilter('date', $event)"
    />
  </div>
</template>

<script>
import SelectField from './SelectField.vue';
import InputField from './InputField.vue';

export default {
  name: 'EventFilters',
  components: {
    SelectField,
    InputField
  },
  props: {
    filters: Object,
    eventTypes: Array,
    eventLocations: Array
  },
  emits: ['update:filters'],
  methods: {
    updateFilter(key, value) {
      this.$emit('update:filters', {
        ...this.filters,
        [key]: value
      });
    }
  }
};
</script>

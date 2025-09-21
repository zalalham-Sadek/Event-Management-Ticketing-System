<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 px-5 border-b border-gray-300 pb-5">
    <SelectField
      icon="fas fa-chevron-down"
      :modelValue="filters.status"
      label="Status"
      :data="orderStatuses"
      @update:modelValue="updateFilter('status', $event)"
    />
    <SelectField
      icon="fas fa-chevron-down"
      label="Payment Status"
      :data="paymentStatuses"
      :modelValue="filters.payment_status"
      @update:modelValue="updateFilter('payment_status', $event)"
    />
    <SelectField
      icon="fas fa-chevron-down"
      label="Event"
      :data="eventOptions"
      :modelValue="filters.event_id"
      @update:modelValue="updateFilter('event_id', $event)"
    />
  </div>
</template>

<script>
import SelectField from '@/components/dashboard/ui/SelectField.vue';

export default {
  name: 'OrderFilterPanel',
  components: {
    SelectField
  },
  props: {
    filters: Object,
    orderStatuses: Array,
    paymentStatuses: Array,
    events: Array
  },
  emits: ['update:filters'],
  computed: {
    eventOptions() {
      return this.events.map(event => ({
        value: event.id,
        label: event.title
      }));
    }
  },
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

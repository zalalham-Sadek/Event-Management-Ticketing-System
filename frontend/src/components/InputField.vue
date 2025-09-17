<template>
  <div class="mb-4">
    <!-- Label -->
    <label :for="inputId" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">
      {{ label }}
    </label>

    <!-- Input Field -->
    <div class="relative">
      <input
        :id="inputId"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :type="type"
        :placeholder="placeholder"
        :required="required"
        :class="inputClasses"
      />
      
      <!-- Optional Icon -->
      <span v-if="icon && !showPasswordToggle" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
        <i :class="icon"></i>
      </span>
    </div>

    <!-- Error Message -->
    <p v-if="errorMessage" class="text-red-500 dark:text-red-400 text-xs mt-1">{{ errorMessage }}</p>
  </div>
</template>

<script setup>
import { defineProps, defineEmits, computed } from 'vue';

const props = defineProps({
  modelValue: [String, Number],
  label: { type: String, default: '' },
  type: { type: String, default: 'text' },
  placeholder: { type: String, default: '' },
  id: { type: String, default: '' },
  required: { type: Boolean, default: false },
  icon: { type: String, default: '' },
  errorMessage: { type: String, default: '' },
  showPasswordToggle: { type: Boolean, default: false }
});

const emit = defineEmits(['update:modelValue']);

// Generate unique ID if not provided
const inputId = computed(() => {
  return props.id || `input-${Math.random().toString(36).substr(2, 9)}`;
});

// Dynamic input classes based on icon presence
const inputClasses = computed(() => {
  const baseClasses = 'w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors duration-200 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400';
  return props.icon ? `${baseClasses} pr-10` : baseClasses;
});

</script>

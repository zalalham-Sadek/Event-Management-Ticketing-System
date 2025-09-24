<script setup>
import { ref, watch } from 'vue'

const props = defineProps({
  modelValue: String,
  icon: String,
  type: { type: String, default: 'text' },
  placeholder: String,
})

const emit = defineEmits(['update:modelValue'])
const internalValue = ref(props.modelValue)

// watch for changes from parent
watch(() => props.modelValue, (val) => {
  internalValue.value = val
})
</script>

<template>
  <div class="relative flex items-center w-full">
    <span v-if="icon" class="absolute left-3 text-gray-400 pointer-events-none">
      <i :class="icon"></i>
    </span>
    <input
      :type="type"
      :placeholder="placeholder"
      v-model="internalValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="appearance-none w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-primary-border dark:border-gray-600 bg-background-secondary text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-border"
    />
  </div>
</template>

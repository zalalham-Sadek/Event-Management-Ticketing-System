<template>
  <div class="relative flex items-center w-full ">
    <span class="absolute left-3 text-secondary-text pointer-events-none" v-if="icon">
      <i :class="icon"></i>
    </span>
    <input
      :type="type"
      :placeholder="placeholder"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      class="appearance-none w-full pl-10 pr-4 py-2 text-sm rounded-xl border border-primary-border dark:border-gray-600 bg-background-secondary  text-secondary-text  focus:outline-none focus:ring-2 focus:ring-primary-border"
    />
  </div>
</template>

<script>
export default {
  props: {
    modelValue: String,
    icon: String, // optional icon
    type: {
      type: String,
      default: 'text' // 'date' or 'text'
    },
    placeholder: String
  },
  emits: ['update:modelValue']
}
</script>

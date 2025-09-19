<template>
  <div
    :class="[
      'bg-white dark:bg-gray-800 shadow-md rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700',
      paddingClass,
      hoverClass
    ]"
  >
    <!-- Header Section -->
    <div v-if="title || $slots.header" class="px-6 pt-6 pb-4">
      <div class="flex justify-between items-center">
        <h2 v-if="title" class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
          {{ title }}
        </h2>
        <slot name="header"></slot>
      </div>
    </div>

    <!-- Content Section -->
    <div :class="contentPaddingClass">
      <slot></slot>
    </div>

    <!-- Footer Section -->
    <div v-if="$slots.footer" class="px-6 pb-6 pt-4 border-t border-gray-200 dark:border-gray-700">
      <slot name="footer"></slot>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Card',
  props: {
    title: {
      type: String,
      default: ''
    },
    padding: {
      type: String,
      default: 'default', // 'none', 'small', 'default', 'large'
      validator: (value) => ['none', 'small', 'default', 'large'].includes(value)
    },
    hover: {
      type: Boolean,
      default: false
    }
  },
  computed: {
    paddingClass() {
      const paddingMap = {
        none: '',
        small: 'p-4',
        default: 'p-6',
        large: 'p-8'
      }
      return paddingMap[this.padding]
    },
    contentPaddingClass() {
      if (this.title || this.$slots.header) {
        return 'px-6 pb-6'
      }
      return ''
    },
    hoverClass() {
      return this.hover ? 'transform transition duration-300 hover:shadow-lg hover:-translate-y-1' : ''
    }
  }
}
</script>

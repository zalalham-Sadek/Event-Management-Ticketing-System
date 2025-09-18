<template>
  <div class="flex items-center justify-between gap-4 px-5 border-b border-gray-300 pb-5 pt-2">
    <div class="w-80">
          <InputField
      icon="fas fa-search"
      type="text"
      placeholder="Search..."
      v-model="localSearchQuery"
    />
    </div>
    <PaginationSelection
      v-model="localItemsPerPage"
    />
  </div>
</template>

<script>
import InputField from './InputField.vue';
import PaginationSelection from './PaginationSelect.vue';
export default {
  name: 'SearchAndPerpage',
  props: {
    searchQuery: String,
    itemsPerPage: Number,
  },
  emits: ['update:searchQuery', 'update:itemsPerPage'],
  data() {
    return {
      localSearchQuery: this.searchQuery || '',
      localItemsPerPage: this.itemsPerPage || 5,
    };
  },
  watch: {
    localSearchQuery(val) {
      this.$emit('update:searchQuery', val);
    },
    localItemsPerPage(val) {
      console.log('SearchAndPerpage: itemsPerPage changed to:', val);
      this.$emit('update:itemsPerPage', val);
    },
    searchQuery(val) {
      this.localSearchQuery = val;
    },
    itemsPerPage(val) {
      this.localItemsPerPage = val;
    }
  },
  components: {
    InputField,
    PaginationSelection,
  }
}
</script>

<template>
  <div ref="tableWrapper" class="relative">
    <table class="min-w-full text-sm text-left">
      <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr >
          <th v-for="(col, index) in colTitle" :key="index" class="px-2 py-3">
            {{ col }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="(item, index) in paginatedEvents"
          :key="index"
          class="bg-white border-b dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"        >

          <td
  v-for="(col, colIndex) in colTitle"
  :key="colIndex"
  class="bg-white border-b dark:bg-gray-800 border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 px-1 py-2 whitespace-nowrap text-sm text-gray-900 dark:text-white"
>
  <!-- ✅ Action Column -->
  <template v-if="col.toLowerCase() === 'action'">
    <div class="relative inline-block text-left">
      <!-- Trigger button -->
      <button
        @click.stop="toggleDropdown(index)"
        class="inline-flex justify-center w-full px-3 py-1 text-sm font-medium 
               dark:text-secondary-text hover:cursor-pointer"
      >
        <i class="fas fa-ellipsis-v"></i>
      </button>

      <!-- Dropdown -->
      <div
        v-if="openDropdown === index"
        class="absolute right-0 top-full mt-2 w-40 rounded-xl shadow-lg 
               bg-[var(--color-bg)] ring-1 ring-black/5 z-50 animate-fade-in"
      >
        <div class="py-1 text-sm">
          <a
            href="#"
            class="flex items-center gap-2 px-4 py-2 rounded-lg 
                   hover:bg-primary-border/20 transition-colors"
            @click.prevent="editItem(item)"
          >
            <i class="fas fa-edit text-xs text-blue-500"></i>
            <span>Edit</span>
          </a>
          <a
            href="#"
            class="flex items-center gap-2 px-4 py-2 rounded-lg 
                   hover:bg-primary-border/20 transition-colors"
            @click.prevent="deleteItem(item)"
          >
            <i class="fas fa-trash text-xs text-red-500"></i>
            <span>Delete</span>
          </a>
          <a
            href="#"
            class="flex items-center gap-2 px-4 py-2 rounded-lg 
                   hover:bg-primary-border/20 transition-colors"
            @click.prevent="handleView(item)"
          >
            <i class="fas fa-eye text-xs text-green-500"></i>
            <span>View</span>
          </a>
        </div>
      </div>
    </div>
  </template>

  <!-- ✅ Poster column -->
  <template v-else-if="col.toLowerCase() === 'poster'">
    <img
      :src="'http://127.0.0.1:8000/storage/' + item[col.toLowerCase()]"
      alt="Poster"
      class="w-16 h-16 object-cover rounded-md"
    />
  </template>

  <!-- ✅ Default column -->
<template v-else>
  {{ item[col.toLowerCase()]?.length > 100 
      ? item[col.toLowerCase()].substring(0, 60) + '...' 
      : item[col.toLowerCase()] }}
</template>

</td>

        </tr>
      </tbody>
    </table>

    <!-- Modal -->
    <EventDetailModal
      v-if="viewMode === 'modal'"
      :title="title"
      :visible="showModal"
      :event="selectedEvent"
      @close="closeModal"
      :allEvents="allEvents"
    />

    <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />
  </div>
</template>

<script>
import EventDetailModal from '@/components/dashboard/ui/Modal.vue'
import ToastMessage from '@/components/ToastMessage.vue'

export default {
  components: {
    EventDetailModal,
    ToastMessage,
  },
  props: {
    colTitle: Array,
    paginatedEvents: Array,
    title: String,
    service: Object, // ✅ Pass the service dynamically (EventService, UserService, etc.)
    deleteMethod: {
      type: String,
      default: "delete", // default method to call
    },
    baseRoute: {
      type: String,
      default: "events", // fallback
    },
    viewMode: {
      type: String,
      default: "modal",
    },
  },
  data() {
    return {
      openDropdown: null,
      showModal: false,
      selectedEvent: null,
      toastMessage: "",
      toastVisible: false,
      toastType: "success",
      allEvents: JSON.parse(localStorage.getItem("events")) || [],
    };
  },
  mounted() {
    document.addEventListener("click", this.handleClickOutside);
  },
  beforeUnmount() {
    document.removeEventListener("click", this.handleClickOutside);
  },
  methods: {
    toggleDropdown(index) {
      this.openDropdown = this.openDropdown === index ? null : index;
    },
    handleClickOutside(event) {
      const wrapper = this.$refs.tableWrapper;
      if (wrapper && !wrapper.contains(event.target)) {
        this.openDropdown = null;
      }
    },
    editItem(item) {
      this.$router.push(`/${this.baseRoute}/edit/${item.id}`);
    },
    async deleteItem(item) {
      console.log("Attempting to delete item:", this.service, this.deleteMethod, item);
      if (!this.service || !this.service[this.deleteMethod]) {
        console.error("Service or delete method not provided!");
        return;
      }
      try {
        await this.service[this.deleteMethod](item.id);
        this.showToast("Deleted successfully", "success");
        setTimeout(() => this.$emit("refreshData"), 1500);
      } catch (err) {
        console.error("Delete error:", err);
        this.showToast("Failed to delete. Please try again.", "error");
      }
    },
    handleView(item) {
      if (this.viewMode === "page") {
        this.$router.push(`/${this.baseRoute}/${item.id}`);
      } else {
        this.viewItem(item);
      }
    },
    viewItem(item) {
      this.selectedEvent = item;
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
      this.selectedEvent = null;
    },
    showToast(message, type = "success", duration = 3000) {
      this.toastMessage = message;
      this.toastType = type;
      this.toastVisible = true;
      setTimeout(() => (this.toastVisible = false), duration);
    },
  },
};
</script>

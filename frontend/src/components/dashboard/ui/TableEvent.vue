<template>
  <div ref="tableWrapper" class="relative">
    <table class="min-w-full text-sm text-left">
      <thead class="text-xs text-secondary-text uppercase">
        <tr class="border-b border-primary-border">
          <th class="px-4 sm:px-6">#</th>
          <th v-for="(col, index) in colTitle" :key="index" class="px-4 py-3 sm:px-6 relative">
            <div class="absolute top-1/4 bottom-1/4 right-0 w-px bg-primary-border"></div>
            {{ col }}
          </th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="(item, index) in paginatedEvents"
          :key="index"
          class="border-b border-primary-border hover:bg-background-primary/30"
        >
          <td class="px-4 py-4 sm:px-6">#</td>

          <td
            v-for="(col, colIndex) in colTitle"
            :key="colIndex"
            class="px-4 py-4 sm:px-6 whitespace-nowrap dark:text-secondary-text"
          >
            <template v-if="col.toLowerCase() === 'action'">
              <div class="relative inline-block text-left">
                <button
                  @click.stop="toggleDropdown(index)"
                  class="inline-flex justify-center w-full px-3 py-1 text-sm font-medium dark:text-secondary-text hover:cursor-pointer"
                >
                  <i class="fas fa-ellipsis-v"></i>
                </button>
                <div
                  v-if="openDropdown === index"
                  class="origin-top-right absolute left-0 mt-2 rounded-md shadow-lg bg-background-secondary z-50 focus:outline-none"
                >
                  <div class="py-1 text-sm text-gray-700 dark:text-secondary-text">
                    <a
                      href="#"
                      class="block px-4 py-2 hover:bg-background-primary/30"
                      @click.prevent="editItem(item)"
                    >
                      <i class="fas fa-edit pr-3 text-xs"></i>Edit
                    </a>
                    <a
                      href="#"
                      class="block px-4 py-2 hover:bg-background-primary/30"
                      @click.prevent="deleteItem(item)"
                    >
                      <i class="fas fa-trash pr-3 text-xs"></i>Delete
                    </a>
                    <a
                      href="#"
                      class="block px-4 py-2 hover:bg-background-primary/30"
                      @click.prevent="handleView(item)"
                    >
                      <i class="fas fa-eye pr-3 text-xs"></i>View
                    </a>
                  </div>
                </div>
              </div>
            </template>
            <template v-else>
              {{ item[col.toLowerCase()] }}
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

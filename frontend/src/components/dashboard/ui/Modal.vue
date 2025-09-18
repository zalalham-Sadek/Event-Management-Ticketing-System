<template>
  <transition name="modal-fade">
    <div
      v-if="visible"
      class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center px-4 sm:px-0"
    >
      <div
        class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg sm:max-w-xl p-4 sm:p-6 relative"
      >
        <!-- Header -->
        <div class="flex justify-between items-center border-b border-gray-300 dark:border-gray-700 pb-2">
          <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">{{singularTitle}} Details</h1>
          <button
            @click="closeModal"
            class="text-2xl text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white"
          >
            &times;
          </button>
        </div>

        <!-- Modal content -->
        <div class="mt-4 space-y-2 text-gray-700 dark:text-gray-200 text-sm sm:text-base">
          <p v-if="event.title"><strong class="inline-block w-24">Title:</strong> {{ event?.title }}</p>
          <p v-if="event.type"><strong class="inline-block w-24">Type:</strong> {{ event?.type }}</p>
          <p v-if="event.date"><strong class="inline-block w-24">Date:</strong> {{ event?.date }}</p>
          <p v-if="event.audience"><strong class="inline-block w-24">Audience:</strong> {{ event?.audience }}</p>
          <p v-if="event.location"><strong class="inline-block w-24">Location:</strong> {{ event?.location }}</p>
          <p v-if="event.speakers"><strong class="inline-block w-24">Speakers:</strong> {{ event?.speakers?.join(', ') }}</p>
          <p v-if="event.name"><strong class="inline-block w-24">name:</strong> {{ event?.name}}</p>
          <p v-if="event.availableDates"><strong class="inline-block w-24">available date:</strong> {{ event?.availableDates?.join(', ')}}</p>
          <p v-if="event.topics"><strong class="inline-block w-24">topics:</strong> {{ event?.topics?.join(', ')}}</p>
<p v-if="event.events && allEvents">
  <strong class="inline-block w-24">Events:</strong>
  {{ getEventTitles(event.events).join(', ') }}
</p>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: "EventDetailModal",
  props: {
    visible: {
      type: Boolean,
      required: true,
    },
    event: {
      type: Object,
      default: () => ({}),
    },
    title:String,
    allEvents:Object
  },
  emits: ["close"],
  methods: {
    closeModal() {
      this.$emit("close");
    },
    getEventTitles(eventIds) {
        // console.log("hhhh" +eventIds);
        
    if (!Array.isArray(eventIds) || !Array.isArray(this.allEvents)) return [];
    return this.allEvents
      .filter(ev => eventIds.includes(ev.id))
      .map(ev => ev.title);
  }
  },
  computed: {
  singularTitle() {
    // Basic singularization: remove last 's' if present
    if (!this.title) return '';
    return this.title.endsWith('s') ? this.title.slice(0, -1) : this.title;
  }
}

};
</script>

<style scoped>
.modal-fade-enter-active,
.modal-fade-leave-active {
  transition: opacity 0.3s ease;
}

.modal-fade-enter-from,
.modal-fade-leave-to {
  opacity: 0;
}

.modal-fade-enter-to,
.modal-fade-leave-from {
  opacity: 1;
}
.fixed.inset-0.bg-black.bg-opacity-50 {
    backdrop-filter: blur(4px);
    /* subtle blur behind modal */
}

.fixed.inset-0.bg-black {
    background-color: rgba(143, 141, 141, 0.164);
}
</style>

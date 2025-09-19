<template>
  <div class="p-6 max-w-7xl mx-auto space-y-6">
    <headPage part="Events" title="Event Details" :enableBtn="false" href="" />

    <!-- Event Card -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
      <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-4">
        {{ event.title }}
      </h1>

      <div>
        <p class="font-bold py-6">
          <span class="text-xl text-gray-700 dark:text-gray-300">Description:</span> 
          {{ event.description }}
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 dark:text-gray-300">
        <p><span class="font-bold">Date:</span> {{ event.date }}</p>
        <p><span class="font-bold">Type:</span> {{ event.type }}</p>
        <p><span class="font-bold">Location:</span> {{ event.location }}</p>
        <p><span class="font-bold">Created By:</span> {{ event.user?.name }} (ID: {{ event.user?.id }})</p>
      </div>
    </div>

    <!-- Poster -->
    <div class="bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Poster</h2>

      <div v-if="event.poster">
        <img
          :src="getPosterUrl(event.poster)"
          alt="Event Poster"
          class="w-full max-w-md rounded-lg shadow-md"
        />
      </div>
      <p v-else class="text-gray-500 dark:text-gray-400">No poster available.</p>
    </div>
  </div>
</template>

<script>
import services from "@/services";

export default {
  data() {
    return {
      event: {},
    };
  },
  async mounted() {
    const id = this.$route.params.id;
    const response = await services.EventService.getEventById(id);
    this.event = response.data.data;
  },
  methods: {
    getPosterUrl(filename) {
      // Adjust the path depending on where your backend serves images
      return `http://localhost:8000/storage/${filename}`;
    },
  },
};
</script>

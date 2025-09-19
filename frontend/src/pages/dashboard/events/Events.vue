<template>
  <div class="p-6 max-w-7xl mx-auto ">

    <headPage part="Events" title="overview" :enableBtn="true" btnTitle="Add Event" href="/events/create"  />

    <div class="col-span-12 md:col-span-6">
      <div
        class="bg-background-secondary space-y-3 dark:bg-box-dark m-0 p-0 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative">
        <div class="px-5 pt-2 ">
          <p class="text-xl inline dark:text-gray-400">Filters</p>
        </div>
        <FilterPanel v-model:filters="filters" :eventTypes="eventTypes" :eventLocations="eventLocations" />
        <SearchAndPerpage v-model:searchQuery="searchQuery" v-model:itemsPerPage="itemsPerPage" />
        <!-- Events Table -->
        <div class="max-w-full overflow-x-auto shadow-md rounded-xl">
          <TableEvent :colTitle="['Title','description', 'Location', 'date', 'poster', 'Action']"
            :paginatedEvents="paginatedEvents" title="Event" baseRoute="events" viewMode="page" :service="services.EventService" 
            @refreshData="refreshEvents" />
          <!-- Pagination -->
          <Pagination v-model:currentPage="currentPage" :totalPages="totalPages" :itemsPerPage="itemsPerPage"
            :totalItems="filteredEvents.length" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import SearchAndPerpage from '@/components/dashboard/ui/SearchAndPerpage.vue';
import SelectField from '@/components/dashboard/ui/SelectField.vue';
import InputField from '@/components/dashboard/ui/InputField.vue';
import FilterPanel from '@/components/dashboard/ui/FilterPanel.vue';
import HeadPage from '@/components/dashboard/ui/HeadPage.vue';
import TableEvent from '@/components/dashboard/ui/TableEvent.vue';
import Pagination from '@/components/dashboard/ui/Pagination.vue';
import services from '@/services';

export default {
  name: 'EventsOverview',
  data() {
    return {
      services,
      events: [],
      filters: {
        type: '',
        location: '',
        date: ''
      },
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 5,
      openDropdown: null,
      loading: false,
      error: ''
    };
  },
  async mounted() {
    await this.loadEvents();
  },
  components: {
    SearchAndPerpage,
    SelectField, InputField, FilterPanel, HeadPage, TableEvent, Pagination
  },
  computed: {
    eventTypes() {
      return [...new Set(this.events.map(e => e.type))];
    },
    eventLocations() {
      return [...new Set(this.events.map(e => e.location))];
    },
    filteredEvents() {
      return this.events
        .filter(event => {
          return (
            (!this.filters.type || event.type === this.filters.type) &&
            (!this.filters.location || event.location === this.filters.location) &&
            (!this.filters.date || event.date >= this.filters.date)
          );
        })
        .filter(event => {
          const q = this.searchQuery.toLowerCase();
          return (
            event.title.toLowerCase().includes(q) ||
            event.location.toLowerCase().includes(q)
          );
        });
    },
    totalPages() {
      return Math.ceil(this.filteredEvents.length / this.itemsPerPage);
    },
    paginatedEvents() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.filteredEvents.slice(start, end);
    }
  },
  methods: {
    async loadEvents() {
      this.loading = true;
      this.error = '';
      try {
        const response = await services.EventService.getAllEvents();
        // Adjust response shape depending on API
        // console.log("response events",response.data.data);
        this.events = response.data.data || response.data.data || [];
      } catch (err) {
        console.error('Error loading events:', err);
        this.error = 'Failed to load events. Please try again.';
      } finally {
        this.loading = false;
      }
    },
    prevPage() {
      if (this.currentPage > 1) this.currentPage--;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) this.currentPage++;
    },
    toggleDropdown(index) {
      this.openDropdown = this.openDropdown === index ? null : index;
    },
    async deleteEvent(event) {
      try {
        await services.EventService.delete(event.id);
        this.events = this.events.filter(e => e.id !== event.id);
      } catch (err) {
        console.error('Failed to delete event:', err);
      }
    },
    editEvent(event) {
      alert('Edit feature coming soon!');
    },
    viewEvent(event) {
      console.log('View event:', event);
    },
    async refreshEvents() {
      await this.loadEvents();
    }
  }
};
</script>


<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
}
</style>

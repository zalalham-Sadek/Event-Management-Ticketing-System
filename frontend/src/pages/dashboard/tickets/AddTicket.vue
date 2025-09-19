<template>
  <div class="p-6 max-w-4xl mx-auto space-y-6">
    <headPage 
      part="Tickets" 
      title="Add New Ticket" 
      :enableBtn="false" 
      href="" 
    />

    <!-- Form Card -->
    <Card title="Ticket Information">
      <form @submit.prevent="submitForm" class="space-y-6">
        <!-- Ticket Type -->
        <div>
          <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Ticket Type <span class="text-red-500">*</span>
          </label>
          <input
            id="type"
            v-model="form.type"
            type="text"
            required
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
            placeholder="e.g., VIP, Regular, Early Bird, Student"
            :class="{ 'border-red-500': errors.type }"
          />
          <p v-if="errors.type" class="mt-1 text-sm text-red-600">{{ errors.type }}</p>
        </div>

        <!-- Price and Quantity Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- Price -->
          <div>
            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              Price ($) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <span class="text-gray-500 sm:text-sm">$</span>
              </div>
              <input
                id="price"
                v-model="form.price"
                type="number"
                step="0.01"
                min="0"
                required
                class="w-full pl-8 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                placeholder="0.00"
                :class="{ 'border-red-500': errors.price }"
              />
            </div>
            <p v-if="errors.price" class="mt-1 text-sm text-red-600">{{ errors.price }}</p>
          </div>

          <!-- Quantity -->
          <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              Total Quantity <span class="text-red-500">*</span>
            </label>
            <input
              id="quantity"
              v-model="form.quantity"
              type="number"
              min="1"
              required
              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
              placeholder="100"
              :class="{ 'border-red-500': errors.quantity }"
            />
            <p v-if="errors.quantity" class="mt-1 text-sm text-red-600">{{ errors.quantity }}</p>
          </div>
        </div>

        <!-- Description -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Description (Optional)
          </label>
          <textarea
            id="description"
            v-model="form.description"
            rows="4"
            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
            placeholder="Describe what this ticket includes or any special benefits..."
          ></textarea>
        </div>

        <!-- Ticket Features -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
            Ticket Features (Optional)
          </label>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center">
              <input
                id="includesFood"
                v-model="form.features.includesFood"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              />
              <label for="includesFood" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                Includes Food & Beverages
              </label>
            </div>
            <div class="flex items-center">
              <input
                id="includesMerchandise"
                v-model="form.features.includesMerchandise"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              />
              <label for="includesMerchandise" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                Includes Merchandise
              </label>
            </div>
            <div class="flex items-center">
              <input
                id="prioritySeating"
                v-model="form.features.prioritySeating"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              />
              <label for="prioritySeating" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                Priority Seating
              </label>
            </div>
            <div class="flex items-center">
              <input
                id="backstageAccess"
                v-model="form.features.backstageAccess"
                type="checkbox"
                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
              />
              <label for="backstageAccess" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                Backstage Access
              </label>
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
          <button
            type="button"
            @click="cancelForm"
            class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors flex items-center"
          >
            <div v-if="loading" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
            <i v-else class="fas fa-plus mr-2"></i>
            {{ loading ? 'Creating...' : 'Create Ticket' }}
          </button>
        </div>
      </form>
    </Card>

    <!-- Preview Card -->
    <Card title="Ticket Preview" v-if="form.type || form.price || form.quantity">
      <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
        <div class="flex justify-between items-start mb-3">
          <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
            {{ form.type || 'Ticket Type' }}
          </h3>
          <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
            {{ form.quantity || 0 }} available
          </span>
        </div>
        
        <div class="space-y-2 text-sm text-gray-600 dark:text-gray-300">
          <div class="flex justify-between">
            <span>Price:</span>
            <span class="font-semibold text-green-600">${{ form.price || '0.00' }}</span>
          </div>
          <div class="flex justify-between">
            <span>Total Quantity:</span>
            <span>{{ form.quantity || 0 }}</span>
          </div>
          <div class="flex justify-between">
            <span>Sold:</span>
            <span>0</span>
          </div>
          <div class="flex justify-between">
            <span>Remaining:</span>
            <span class="font-semibold">{{ form.quantity || 0 }}</span>
          </div>
        </div>

        <div v-if="form.description" class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
          <p class="text-sm text-gray-600 dark:text-gray-300">{{ form.description }}</p>
        </div>

        <div v-if="hasFeatures" class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
          <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Features:</p>
          <div class="flex flex-wrap gap-2">
            <span v-if="form.features.includesFood" class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
              Food & Beverages
            </span>
            <span v-if="form.features.includesMerchandise" class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">
              Merchandise
            </span>
            <span v-if="form.features.prioritySeating" class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full">
              Priority Seating
            </span>
            <span v-if="form.features.backstageAccess" class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">
              Backstage Access
            </span>
          </div>
        </div>
      </div>
    </Card>

    <!-- Toast Message -->
    <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />
  </div>
</template>

<script>
import services from "@/services";
import Card from "@/components/dashboard/ui/Card.vue";
import ToastMessage from "@/components/ToastMessage.vue";

export default {
  name: 'AddTicket',
  components: {
    Card,
    ToastMessage
  },
  data() {
    return {
      loading: false,
      form: {
        type: '',
        price: '',
        quantity: '',
        description: '',
        features: {
          includesFood: false,
          includesMerchandise: false,
          prioritySeating: false,
          backstageAccess: false
        }
      },
      errors: {},
      toastMessage: '',
      toastVisible: false,
      toastType: 'success'
    };
  },
  computed: {
    hasFeatures() {
      return Object.values(this.form.features).some(feature => feature);
    },
    eventId() {
      return this.$route.params.eventId;
    }
  },
  methods: {
    validateForm() {
      this.errors = {};

      if (!this.form.type.trim()) {
        this.errors.type = 'Ticket type is required';
      }

      if (!this.form.price || this.form.price <= 0) {
        this.errors.price = 'Price must be greater than 0';
      }

      if (!this.form.quantity || this.form.quantity < 1) {
        this.errors.quantity = 'Quantity must be at least 1';
      }

      return Object.keys(this.errors).length === 0;
    },
    async submitForm() {
      if (!this.validateForm()) {
        this.showToast('Please fix the errors above', 'error');
        return;
      }

      this.loading = true;

      try {
        const ticketData = {
          type: this.form.type.trim(),
          price: parseFloat(this.form.price),
          quantity: parseInt(this.form.quantity),
          description: this.form.description.trim(),
          features: this.form.features
        };

        await services.TicketService.createTicket(this.eventId, ticketData);
        
        this.showToast('Ticket created successfully!', 'success');
        
        // Redirect to event details page
        setTimeout(() => {
          this.$router.push(`/events/${this.eventId}`);
        }, 1500);

      } catch (error) {
        console.error('Error creating ticket:', error);
        this.showToast('Failed to create ticket. Please try again.', 'error');
      } finally {
        this.loading = false;
      }
    },
    cancelForm() {
      this.$router.push(`/events/${this.eventId}`);
    },
    showToast(message, type = 'success', duration = 3000) {
      this.toastMessage = message;
      this.toastType = type;
      this.toastVisible = true;
      setTimeout(() => {
        this.toastVisible = false;
      }, duration);
    }
  }
};
</script>

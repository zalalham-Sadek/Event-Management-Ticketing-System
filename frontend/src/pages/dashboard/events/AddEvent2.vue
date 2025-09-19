<template>
  <div class="p-6">
    <HeadPage 
      :title="$t('events.addEvent')" 
      :description="$t('events.addEventDescription')"
      :showBackButton="true"
      @back-clicked="goBack"
    />

    <div class="bg-white rounded-lg shadow-sm p-6">
      <form @submit.prevent="handleSubmit" class="space-y-6">
        <!-- Event Title -->
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $t('events.eventTitle') }} <span class="text-red-500">*</span>
          </label>
          <InputField
            id="title"
            v-model="form.title"
            type="text"
            :placeholder="$t('events.eventTitlePlaceholder')"
            :error="errors.title"
            required
          />
        </div>

        <!-- Event Description -->
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $t('events.eventDescription') }} <span class="text-red-500">*</span>
          </label>
          <textarea
            id="description"
            v-model="form.description"
            rows="4"
            :placeholder="$t('events.eventDescriptionPlaceholder')"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
            :class="{ 'border-red-500': errors.description }"
            required
          ></textarea>
          <p v-if="errors.description" class="mt-1 text-sm text-red-600">
            {{ errors.description }}
          </p>
        </div>

        <!-- Event Date and Time -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">
              {{ $t('events.eventDate') }} <span class="text-red-500">*</span>
            </label>
            <InputField
              id="date"
              v-model="form.date"
              type="date"
              :error="errors.date"
              :min="minDate"
              required
            />
          </div>
          <div>
            <label for="time" class="block text-sm font-medium text-gray-700 mb-2">
              {{ $t('events.eventTime') }} <span class="text-red-500">*</span>
            </label>
            <InputField
              id="time"
              v-model="form.time"
              type="time"
              :error="errors.time"
              required
            />
          </div>
        </div>

        <!-- Event Location -->
        <div>
          <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $t('events.eventLocation') }} <span class="text-red-500">*</span>
          </label>
          <InputField
            id="location"
            v-model="form.location"
            type="text"
            :placeholder="$t('events.eventLocationPlaceholder')"
            :error="errors.location"
            required
          />
        </div>

        <!-- Event Poster -->
        <div>
          <label for="poster" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $t('events.eventPoster') }}
          </label>
          <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
            <div class="space-y-1 text-center">
              <div v-if="!posterPreview" class="mx-auto h-12 w-12 text-gray-400">
                <svg fill="none" stroke="currentColor" viewBox="0 0 48 48">
                  <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </div>
              <div v-else class="mx-auto">
                <img :src="posterPreview" alt="Poster preview" class="max-h-32 rounded-lg" />
              </div>
              <div class="flex text-sm text-gray-600">
                <label for="poster" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                  <span>{{ posterPreview ? $t('events.changePoster') : $t('events.uploadPoster') }}</span>
                  <input
                    id="poster"
                    type="file"
                    accept="image/*"
                    class="sr-only"
                    @change="handlePosterUpload"
                  />
                </label>
                <p class="pl-1">{{ $t('events.orDragAndDrop') }}</p>
              </div>
              <p class="text-xs text-gray-500">
                {{ $t('events.posterFormats') }}
              </p>
            </div>
          </div>
          <p v-if="errors.poster" class="mt-1 text-sm text-red-600">
            {{ errors.poster }}
          </p>
        </div>

        <!-- Event Category (Future Enhancement) -->
        <div>
          <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $t('events.eventCategory') }}
          </label>
          <select
            id="category"
            v-model="form.category"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          >
            <option value="">{{ $t('events.selectCategory') }}</option>
            <option value="conference">{{ $t('events.categories.conference') }}</option>
            <option value="workshop">{{ $t('events.categories.workshop') }}</option>
            <option value="seminar">{{ $t('events.categories.seminar') }}</option>
            <option value="networking">{{ $t('events.categories.networking') }}</option>
            <option value="social">{{ $t('events.categories.social') }}</option>
            <option value="sports">{{ $t('events.categories.sports') }}</option>
            <option value="cultural">{{ $t('events.categories.cultural') }}</option>
            <option value="other">{{ $t('events.categories.other') }}</option>
          </select>
        </div>

        <!-- Event Capacity (Future Enhancement) -->
        <div>
          <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $t('events.eventCapacity') }}
          </label>
          <InputField
            id="capacity"
            v-model="form.capacity"
            type="number"
            min="1"
            :placeholder="$t('events.eventCapacityPlaceholder')"
            :error="errors.capacity"
          />
        </div>

        <!-- Event Price (Future Enhancement) -->
        <div>
          <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $t('events.eventPrice') }}
          </label>
          <div class="relative">
            <span class="absolute left-3 top-2 text-gray-500">$</span>
            <InputField
              id="price"
              v-model="form.price"
              type="number"
              min="0"
              step="0.01"
              :placeholder="$t('events.eventPricePlaceholder')"
              :error="errors.price"
              class="pl-8"
            />
          </div>
          <p class="mt-1 text-sm text-gray-500">
            {{ $t('events.priceNote') }}
          </p>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
          <button
            type="button"
            @click="goBack"
            class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition-colors"
          >
            {{ $t('common.cancel') }}
          </button>
          <button
            type="submit"
            :disabled="loading"
            class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
          >
            {{ loading ? $t('common.creating') : $t('events.createEvent') }}
          </button>
        </div>
      </form>
    </div>

    <!-- Toast Messages -->
    <ToastMessage
      v-if="toast.show"
      :message="toast.message"
      :type="toast.type"
      @close="toast.show = false"
    />
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useI18n } from 'vue-i18n'
import EventService from '@/services/EventService'
import HeadPage from '@/components/dashboard/ui/HeadPage.vue'
import InputField from '@/components/dashboard/ui/InputField.vue'
import ToastMessage from '@/components/ToastMessage.vue'

export default {
  name: 'AddEvent',
  components: {
    HeadPage,
    InputField,
    ToastMessage
  },
  setup() {
    const router = useRouter()
    const { t } = useI18n()

    // Reactive data
    const loading = ref(false)
    const posterPreview = ref(null)
    const posterFile = ref(null)
    const toast = ref({
      show: false,
      message: '',
      type: 'success'
    })

    const form = ref({
      title: '',
      description: '',
      date: '',
      time: '',
      location: '',
      category: '',
      capacity: '',
      price: ''
    })

    const errors = ref({})

    // Computed properties
    const minDate = computed(() => {
      const today = new Date()
      return today.toISOString().split('T')[0]
    })

    // Methods
    const validateForm = () => {
      errors.value = {}

      if (!form.value.title.trim()) {
        errors.value.title = t('events.validation.titleRequired')
      }

      if (!form.value.description.trim()) {
        errors.value.description = t('events.validation.descriptionRequired')
      }

      if (!form.value.date) {
        errors.value.date = t('events.validation.dateRequired')
      }

      if (!form.value.time) {
        errors.value.time = t('events.validation.timeRequired')
      }

      if (!form.value.location.trim()) {
        errors.value.location = t('events.validation.locationRequired')
      }

      if (form.value.capacity && form.value.capacity < 1) {
        errors.value.capacity = t('events.validation.capacityMinimum')
      }

      if (form.value.price && form.value.price < 0) {
        errors.value.price = t('events.validation.priceMinimum')
      }

      return Object.keys(errors.value).length === 0
    }

    const handlePosterUpload = (event) => {
      const file = event.target.files[0]
      if (!file) return

      // Validate file type
      if (!file.type.startsWith('image/')) {
        showToast(t('events.validation.invalidImageType'), 'error')
        return
      }

      // Validate file size (max 5MB)
      if (file.size > 5 * 1024 * 1024) {
        showToast(t('events.validation.imageTooLarge'), 'error')
        return
      }

      posterFile.value = file

      // Create preview
      const reader = new FileReader()
      reader.onload = (e) => {
        posterPreview.value = e.target.result
      }
      reader.readAsDataURL(file)
    }

    const handleSubmit = async () => {
      if (!validateForm()) {
        showToast(t('events.validation.formErrors'), 'error')
        return
      }

      loading.value = true

      try {
        // Combine date and time
        const eventDateTime = `${form.value.date} ${form.value.time}`

        // Prepare form data
        const formData = new FormData()
        formData.append('title', form.value.title)
        formData.append('description', form.value.description)
        formData.append('date', eventDateTime)
        formData.append('location', form.value.location)
        
        if (form.value.category) {
          formData.append('category', form.value.category)
        }
        
        if (form.value.capacity) {
          formData.append('capacity', form.value.capacity)
        }
        
        if (form.value.price) {
          formData.append('price', form.value.price)
        }

        if (posterFile.value) {
          formData.append('poster', posterFile.value)
        }

        await EventService.createEvent(formData)
        
        showToast(t('events.createSuccess'), 'success')
        
        // Redirect to events list after a short delay
        setTimeout(() => {
          router.push('/events')
        }, 1500)

      } catch (error) {
        console.error('Error creating event:', error)
        
        if (error.response?.data?.errors) {
          errors.value = error.response.data.errors
        }
        
        showToast(
          error.response?.data?.message || t('events.createError'),
          'error'
        )
      } finally {
        loading.value = false
      }
    }

    const goBack = () => {
      router.push('/events')
    }

    const showToast = (message, type = 'success') => {
      toast.value = {
        show: true,
        message,
        type
      }
    }

    return {
      form,
      errors,
      loading,
      posterPreview,
      toast,
      minDate,
      handlePosterUpload,
      handleSubmit,
      goBack
    }
  }
}
</script>

<template>
  <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />

  <div class="p-6 max-w-7xl mx-auto">
    <headPage part="Events" title="Add Event" :enableBtn="false" href="" />

    <div class="col-span-12 md:col-span-4">
      <div
        class="bg-background-secondary space-y-3 dark:bg-box-dark m-0 p-8 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative"
      >
        <form @submit.prevent="saveEvent" enctype="multipart/form-data">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Title -->
            <div>
              <InputField v-model="newEvent.title" type="text" placeholder="Enter Event Title" />
              <p v-if="submitted && errors.title" class="text-red-500 text-xs pl-3">{{ errors.title }}</p>
            </div>

            <!-- Type -->
            <div>
              <select
                v-model="newEvent.type"
                class="appearance-none w-full pl-4 pr-4 py-2 text-sm rounded-xl border border-primary-border dark:border-gray-600 bg-background-secondary text-secondary-text focus:outline-none focus:ring-2 focus:ring-primary-border"
              >
                <option value="" disabled>Select Event Type</option>
                <option v-for="type in eventTypes" :key="type" :value="type">{{ type }}</option>
              </select>
              <p v-if="submitted && errors.type" class="text-red-500 text-xs pl-3">{{ errors.type }}</p>
            </div>

            <!-- Date -->
            <div>
              <InputField v-model="newEvent.date" type="datetime-local" placeholder="Enter Event Date" />
              <p v-if="submitted && errors.date" class="text-red-500 text-xs pl-3">{{ errors.date }}</p>
            </div>

            <!-- Location -->
            <div>
              <InputField v-model="newEvent.location" type="text" placeholder="Enter Location" />
              <p v-if="submitted && errors.location" class="text-red-500 text-xs pl-3">{{ errors.location }}</p>
            </div>

            <!-- Poster -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
              <input
                type="file"
                @change="handleFileUpload"
                accept="image/*"
                class="w-full px-4 py-2 border border-primary-border rounded-xl bg-background-secondary text-secondary-text"
              />
              <p v-if="submitted && errors.poster" class="text-red-500 text-xs pl-3">{{ errors.poster }}</p>

              <!-- Image Preview -->
              <div v-if="imagePreview" class="mt-3">
                <img
                  :src="imagePreview"
                  alt="Poster Preview"
                  class="max-h-48 rounded-lg border border-gray-300 shadow-md object-cover"
                />
              </div>
            </div>

            <!-- Description -->
            <div class="col-span-1 sm:col-span-2 lg:col-span-3">
              <textarea
                v-model="newEvent.description"
                rows="3"
                placeholder="Enter Event Description"
                class="appearance-none w-full px-4 py-2 text-sm rounded-xl border border-primary-border dark:border-gray-600 bg-background-secondary text-secondary-text focus:outline-none focus:ring-2 focus:ring-primary-border"
              ></textarea>
              <p v-if="submitted && errors.description" class="text-red-500 text-xs pl-3">{{ errors.description }}</p>
            </div>

          </div>

          <div class="pt-6">
            <button
              class="bg-[var(--color-primary)] text-white hover:opacity-50 dark:outline-1 px-6 py-2 rounded-xl transition"
            >
              Save Event
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import services from "@/services";
import InputField from "@/components/dashboard/ui/InputField.vue";
import HeadPage from "@/components/dashboard/ui/HeadPage.vue";
import ToastMessage from "@/components/ToastMessage.vue";

// Errors object
const errors = reactive({
  title: "", type: "", date: "", location: "", description: "", poster: ""
});

// Toast
const toastMessage = ref("");
const toastVisible = ref(false);
const toastType = ref("success");
const submitted = ref(false);

// Event types
const eventTypes = ref([]);

// Event form
const newEvent = ref({
  title: "",
  type: "",
  date: "",
  location: "",
  description: "",
  poster: null,
});

const imagePreview = ref(null);

// Fetch event types from DB
const fetchEventTypes = async () => {
  try {
    const response = await services.EventService.getAllTypes(); // adjust your API
    eventTypes.value = Array.isArray(response.data?.data) ? response.data.data : [];
  } catch (err) {
    console.error("Failed to load event types", err);
    eventTypes.value = [];
  }
};

// Validate form
function validate() {
  errors.title = newEvent.value.title.trim() ? "" : "Title is required";
  errors.type = newEvent.value.type.trim() ? "" : "Event type is required";
  errors.date = newEvent.value.date.trim() ? "" : "Date is required";
  errors.location = newEvent.value.location.trim() ? "" : "Location is required";
  errors.description = newEvent.value.description.trim() ? "" : "Description is required";
  errors.poster = newEvent.value.poster ? "" : "Poster is required";

  return Object.values(errors).every(e => e === "");
}

// Handle poster upload
function handleFileUpload(event) {
  const file = event.target.files[0];
  if (file) {
    newEvent.value.poster = file;
    imagePreview.value = URL.createObjectURL(file);
  } else {
    newEvent.value.poster = null;
    imagePreview.value = null;
  }
}

// Save event
async function saveEvent() {
  submitted.value = true;

  if (!validate()) {
    showToast("⚠️ Please fill in all fields correctly", 3000, "error");
    return;
  }

  try {
    const formData = new FormData();
    formData.append('title', newEvent.value.title);
    formData.append('type', newEvent.value.type);
    formData.append('date', newEvent.value.date);
    formData.append('location', newEvent.value.location);
    formData.append('description', newEvent.value.description);

    // Only append poster if it exists
    if (newEvent.value.poster) {
      formData.append('poster', newEvent.value.poster);
    }

    // Debug: check all entries
    for (const pair of formData.entries()) {
      console.log(pair[0], pair[1]);
    }

    // Pass FormData, not object
    const response = await services.EventService.createEvent(formData);
    showToast(response.data?.message || "✅ Event saved successfully");

    // Reset form
    newEvent.value = { title: "", type: "", date: "", location: "", description: "", poster: null };
    imagePreview.value = null;
    submitted.value = false;
  } catch (err) {
    const apiErrors = err.response?.data?.errors;
    if (apiErrors) {
      Object.keys(apiErrors).forEach(key => {
        if (errors[key] !== undefined) {
          errors[key] = apiErrors[key][0];
        }
      });
    }
    showToast(`❌ Failed to save event`, 5000, "error");
    console.error(err);
  }
}


// Show toast
function showToast(message, duration = 3000, type = "success") {
  toastMessage.value = message;
  toastVisible.value = true;
  toastType.value = type;
  setTimeout(() => (toastVisible.value = false), duration);
}

onMounted(() => {
  fetchEventTypes();
});
</script>

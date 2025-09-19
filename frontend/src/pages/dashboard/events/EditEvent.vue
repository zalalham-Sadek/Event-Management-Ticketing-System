<template>
  <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />

  <div class="p-6 max-w-7xl mx-auto">
    <headPage part="Events" title="Edit Event" :enableBtn="false" href="" />

    <div class="col-span-12 md:col-span-4">
      <div
        class="bg-background-secondary space-y-3 dark:bg-box-dark m-0 p-8 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative"
      >
        <form @submit.prevent="updateEvent" enctype="multipart/form-data">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Title -->
            <div>
              <InputField v-model="event.title" type="text" placeholder="Enter Event Title" />
              <p v-if="submitted && errors.title" class="text-red-500 text-xs pl-3">{{ errors.title }}</p>
            </div>

            <!-- Type -->
            <div>
              <select
                v-model="event.type"
                class="appearance-none w-full pl-4 pr-4 py-2 text-sm rounded-xl border border-primary-border dark:border-gray-600 bg-background-secondary text-secondary-text focus:outline-none focus:ring-2 focus:ring-primary-border"
              >
                <option value="" disabled>Select Event Type</option>
                <option v-for="type in eventTypes" :key="type" :value="type">{{ type }}</option>
              </select>
              <p v-if="submitted && errors.type" class="text-red-500 text-xs pl-3">{{ errors.type }}</p>
            </div>

            <!-- Date -->
            <div>
              <InputField v-model="event.date" type="datetime-local" placeholder="Enter Event Date" />
              <p v-if="submitted && errors.date" class="text-red-500 text-xs pl-3">{{ errors.date }}</p>
            </div>

            <!-- Location -->
            <div>
              <InputField v-model="event.location" type="text" placeholder="Enter Location" />
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
                v-model="event.description"
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
              Update Event
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { useRoute } from "vue-router";
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

// Route to get event id
const route = useRoute();
const eventId = route.params.id;

// Event form
const event = ref({
  title: "",
  type: "",
  date: "",
  location: "",
  description: "",
  poster: null,
});

const imagePreview = ref(null);

// 🔹 Format date for datetime-local input
function formatForDatetimeLocal(dateStr) {
  if (!dateStr) return "";
  const date = new Date(dateStr);
  const tzOffset = date.getTimezoneOffset() * 60000;
  return new Date(date - tzOffset).toISOString().slice(0, 16);
}

// 🔹 Format date for Laravel (Y-m-d H:i:s)
function formatForLaravel(dateStr) {
  if (!dateStr) return "";
  const d = new Date(dateStr);
  const year = d.getFullYear();
  const month = String(d.getMonth() + 1).padStart(2, "0");
  const day = String(d.getDate()).padStart(2, "0");
  const hours = String(d.getHours()).padStart(2, "0");
  const minutes = String(d.getMinutes()).padStart(2, "0");
  const seconds = String(d.getSeconds()).padStart(2, "0");
  return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

// Fetch event types
const fetchEventTypes = async () => {
  try {
    const response = await services.EventService.getAllTypes();
    eventTypes.value = Array.isArray(response.data?.data) ? response.data.data : [];
  } catch (err) {
    console.error("Failed to load event types", err);
    eventTypes.value = [];
  }
};

// Fetch existing event data
const fetchEvent = async () => {
  try {
    const response = await services.EventService.getEventById(eventId);
    const data = response.data.data;

    event.value.title = data.title;
    event.value.type = data.type;
    event.value.date = formatForDatetimeLocal(data.date);
    event.value.location = data.location;
    event.value.description = data.description;

    if (data.poster_url) imagePreview.value = data.poster_url;
  } catch (err) {
    console.error("Failed to load event", err);
    showToast("❌ Failed to load event", 5000, "error");
  }
};

// Validate form
function validate() {
  errors.title = event.value.title.trim() ? "" : "Title is required";
  errors.type = event.value.type.trim() ? "" : "Event type is required";
  errors.date = event.value.date.trim() ? "" : "Date is required";
  errors.location = event.value.location.trim() ? "" : "Location is required";
  errors.description = event.value.description.trim() ? "" : "Description is required";
  errors.poster = "";
  return Object.values(errors).every(e => e === "");
}

// Handle poster upload
function handleFileUpload(e) {
  const file = e.target.files[0];
  if (file) {
    event.value.poster = file;
    imagePreview.value = URL.createObjectURL(file);
  }
}

// Update event
async function updateEvent() {
  submitted.value = true;

  if (!validate()) {
    showToast("⚠️ Please fill in all fields correctly", 3000, "error");
    return;
  }

  try {
    const formData = new FormData();
    formData.append("title", event.value.title);
    formData.append("type", event.value.type);
    formData.append("date", formatForLaravel(event.value.date)); // ✅ formatted for Laravel
    formData.append("location", event.value.location);
    formData.append("description", event.value.description);

    if (event.value.poster) {
      formData.append("poster", event.value.poster);
    }

    // Debug: check all entries
    for (const pair of formData.entries()) {
      console.log(pair[0], pair[1]);
    }

    const response = await services.EventService.updateEvent(eventId, formData);
    showToast(response.data?.message || "✅ Event updated successfully");
  } catch (err) {
    const apiErrors = err.response?.data?.errors;
    if (apiErrors) {
      Object.keys(apiErrors).forEach(key => {
        if (errors[key] !== undefined) errors[key] = apiErrors[key][0];
      });
    }
    showToast("❌ Failed to update event", 5000, "error");
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
  fetchEvent();
});
</script>

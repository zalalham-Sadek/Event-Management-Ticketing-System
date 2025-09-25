<template>
  <div class="flex items-center gap-4 shrink-0">
    <!-- Language & Mode -->
    <LanguageSwitcher @language-changed="handleLanguageChange" />
    <BtnMode />

    <!-- Notifications -->
    <div class="relative" ref="notifRef">
      <!-- Icon -->
      <span
        class="text-xl text-gray-300 cursor-pointer relative"
        @click.stop="toggleNotifDropdown"
      >
        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24">
          <path
            fill="currentColor"
            d="M21 19v1H3v-1l2-2v-6c0-3.1 2.03-5.83 5-6.71V4a2 2 0 0 1 
               2-2a2 2 0 0 1 2 2v.29c2.97.88 5 3.61 5 6.71v6zM14 21a2 2 0 0 1-4 0"
          />
        </svg>

        <!-- Badge -->
        <span
          v-if="unreadCount > 0"
          :class="[
            'absolute -top-1 bg-red-500 text-white text-xs font-bold rounded-full px-1',
            isRTL ? '-left-1' : '-right-1'
          ]"
        >
          {{ unreadCount }}
        </span>
      </span>

      <!-- Dropdown -->
      <div
        v-if="isNotifOpen"
        :class="[
          'absolute mt-2 w-80 bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden z-50',
          isRTL ? 'left-0' : 'right-0'
        ]"
      >
        <div class="p-3 border-b  border-gray-100 dark:border-gray-500 text-[var(--color-black)] dark:text-[var(--color-white)] font-cairo flex items-center justify-between">
          <span>Notifications</span>
          <button
            v-if="!loading"
            @click.stop="markAllAsRead"
            :disabled="unreadCount === 0 || markingAll"
            :class="[
              'text-xs inline-flex items-center gap-1 px-2 py-1 rounded transition-colors',
              (unreadCount === 0 || markingAll)
                ? 'text-gray-400 dark:text-gray-500 cursor-not-allowed'
                : 'text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30'
            ]"
          >
            <svg v-if="!markingAll" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>
            <svg v-else class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10h-2A8 8 0 1 1 12 4z"/></svg>
            <span>{{ markingAll ? 'Marking…' : 'Mark all as read' }}</span>
          </button>
        </div>

        <ul class="max-h-80 overflow-y-auto">
          <li v-if="loading" class="p-3 text-gray-500">Loading...</li>
          <li v-else-if="error" class="p-3 text-red-500">{{ error }}</li>
          <li
            v-for="n in notifications"
            :key="n.id"
            :class="[
              'p-3 border-b border-gray-100 dark:border-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer flex justify-between items-center',
              // !n.read_at ? 'bg-blue-50 dark:bg-gray-700/40' : ''
            ]"
          >
            <div class="flex-1" :class="isRTL ? 'text-right' : 'text-left'">
              <div class="flex items-center gap-2" :class="isRTL ? 'flex-row-reverse' : ''">
                <span v-if="!n.read_at" class="inline-block w-2 h-2 rounded-full bg-blue-500 dark:bg-blue-400"></span>
                <p class="text-sm text-gray-800 dark:text-gray-200">{{ n.data.message }}</p>
              </div>
              <small class="text-xs text-gray-500">
                {{ new Date(n.created_at).toLocaleString() }}
              </small>
            </div>
            <button
              v-if="!n.read_at"
              @click.stop="markAsRead(n.id)"
              :disabled="markingMap[n.id] === true"
              :class="[
                'text-xs inline-flex items-center gap-1 px-2 py-1 rounded transition-colors',
                markingMap[n.id] === true
                  ? 'text-gray-400 dark:text-gray-500 cursor-not-allowed'
                  : 'text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30'
              ]"
            >
              <svg v-if="markingMap[n.id] !== true" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4z"/></svg>
              <svg v-else class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10h-2A8 8 0 1 1 12 4z"/></svg>
              <span>{{ markingMap[n.id] === true ? 'Marking…' : 'Mark as read' }}</span>
            </button>
          </li>
          <li v-if="!loading && !error && notifications.length === 0" class="p-3 text-gray-500">
            No notifications
          </li>
        </ul>
      </div>
    </div>

    <!-- User Dropdown -->
    <div v-if="isLoggedIn" class="relative">
      <router-link to="/profile" class="w-10 h-10 rounded-full overflow-hidden block">
        <img
          v-if="user?.avatar"
          :src="user.avatar"
          alt="Profile"
          class="w-full h-full object-cover"
        />
        <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          class="w-full h-full text-gray-300 object-cover"
          viewBox="0 0 24 24"
        >
          <path
            fill="currentColor"
            d="M12 2A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 
               0 0 0 10-10A10 10 0 0 0 12 2M12 
               6a3.5 3.5 0 0 1 3.5 
               3.5A3.5 3.5 0 0 1 12 
               13a3.5 3.5 0 0 1-3.5-3.5A3.5 
               3.5 0 0 1 12 6m0 
               14c-1.86 0-3.57-.64-4.93-1.72
               c.43-.9 3.05-1.78 
               4.93-1.78s4.5.88 
               4.93 1.78A7.9 7.9 
               0 0 1 12 20z"
          />
        </svg>
      </router-link>
    </div>

    <!-- If not logged in -->
    <div v-else>
      <router-link to="/login" class="text-sm text-blue-600 hover:underline">
        login
      </router-link>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useUserStore } from "@/store/user";
import BtnMode from "@/components/BtnMode.vue";
import LanguageSwitcher from "@/components/LanguageSwitcher.vue";
import { useRouter } from "vue-router";
import services from "@/services";

const userStore = useUserStore();
const router = useRouter();

const isLoggedIn = computed(() => userStore.isAuthenticated);
const user = computed(() => userStore.user);

// استعلام اللغة (لتحديد RTL)
const isRTL = computed(() => document.dir === "rtl");

// Sync document direction with language switcher
function handleLanguageChange(lang) {
  const dir = lang === 'ar' || lang === 'ar-SA' ? 'rtl' : 'ltr';
  if (document.dir !== dir) {
    document.dir = dir;
  }
}

// Notifications
const notifications = ref([]);
const isNotifOpen = ref(false);
const notifRef = ref(null);
const loading = ref(false);
const error = ref("");
const markingMap = ref({});
const markingAll = ref(false);

const unreadCount = computed(() =>
  Array.isArray(notifications.value)
    ? notifications.value.filter((n) => !n.read_at).length
    : 0
);

function toggleNotifDropdown() {
  isNotifOpen.value = !isNotifOpen.value;
}

// Fetch notifications
async function fetchNotifications() {
  try {
    loading.value = true;
    error.value = "";
    const res = await services.NotificationService.fetchNotifications();
    notifications.value = res.data?.notifications
      ? [...res.data.notifications]
      : [];
  } catch (e) {
    console.error("Failed to fetch notifications", e);
    error.value = "Failed to load notifications";
    notifications.value = [];
  } finally {
    loading.value = false;
  }
}

// Mark as read
async function markAsRead(id) {
  try {
    markingMap.value = { ...markingMap.value, [id]: true };
    await services.NotificationService.markAsRead(id);
    fetchNotifications();
  } catch (e) {
    console.error("Failed to mark notification as read", e);
  } finally {
    // Clear marking state regardless of success/failure
    const { [id]: _, ...rest } = markingMap.value;
    markingMap.value = rest;
  }
}

async function markAllAsRead() {
  try {
    markingAll.value = true;
    await services.NotificationService.markAllAsRead();
    fetchNotifications();
  } catch (e) {
    console.error('Failed to mark all as read', e);
  } finally {
    markingAll.value = false;
  }
}

// Close dropdown on outside click
function handleClickOutside(event) {
  if (notifRef.value && !notifRef.value.contains(event.target)) {
    isNotifOpen.value = false;
  }
}

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
  document.addEventListener("keydown", handleKeydown);
  fetchNotifications();
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
  document.removeEventListener("keydown", handleKeydown);
});

// Close on Escape
function handleKeydown(e) {
  if (e.key === 'Escape') {
    isNotifOpen.value = false;
  }
}
</script>

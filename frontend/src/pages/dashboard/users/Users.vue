<template>
    <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />

  <div class="p-6 max-w-7xl mx-auto ">

    <headPage :part="$t('users.part')" :title="$t('users.add.title')" :enableBtn="true" :btnTitle="$t('users.add.title')" href="/users/create" />

    <!-- Error Message -->
    <div v-if="error" class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
      {{ error }}
    </div>

    <div class="col-span-12 md:col-span-6">
      <div
        class="bg-background-secondary space-y-3 dark:bg-box-dark m-0 p-0 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative">
        <div class="px-5 pt-2 ">
          <p class="text-xl inline dark:text-gray-400">{{ $t('common.filters') }}</p>
        </div>
        <SearchAndPerpage v-model:searchQuery="searchQuery" v-model:itemsPerPage="itemsPerPage" />
        
        <!-- Loading State -->
        <div v-if="loading" class="flex justify-center items-center py-8">
          <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
          <span class="ml-2 text-gray-600">{{ $t('users.loading') }}</span>
        </div>
        
        <!-- Users Table -->
        <div v-else class="max-w-full overflow-x-auto shadow-md rounded-xl">
          <DynamicTable 
            :colTitle="['Name', 'Email', 'Role', 'Created_At', 'Action']"
            :paginatedEvents="paginatedUsers" 
              @refreshData="refreshUsers"
            baseRoute="users"
            :title="$t('users.titleSingular')"
             :service="services.UserService"
            />
          <!-- Pagination -->
          <Pagination v-model:currentPage="currentPage" :totalPages="totalPages" :itemsPerPage="itemsPerPage"
            :totalItems="filteredUsers.length" />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/store/user'
import services from '@/services'
import SearchAndPerpage from '@/components/dashboard/ui/SearchAndPerpage.vue'
import HeadPage from '@/components/dashboard/ui/HeadPage.vue'
import DynamicTable from '@/components/dashboard/ui/TableEvent.vue'
import Pagination from '@/components/dashboard/ui/Pagination.vue'
import ToastMessage from '@/components/ToastMessage.vue'

const router = useRouter()
const userStore = useUserStore()

// Toast state
const toastMessage = ref("")
const toastVisible = ref(false)
const toastType = ref("success")

function showToast(message, duration = 3000, type = "success") {
  toastMessage.value = message
  toastVisible.value = true
  toastType.value = type
  setTimeout(() => (toastVisible.value = false), duration)
}

// Check if user is admin
onMounted(() => {
  if (!userStore.isAdmin) {
    router.push('/')
  }
})

const users = ref([])
const searchQuery = ref('')
const currentPage = ref(1)
const itemsPerPage = ref(5)
const loading = ref(false)
const error = ref('')

// Load users from API
const loadUsers = async () => {
  loading.value = true
  error.value = ''
  
  try {
    const response = await services.UserService.getAllUsers()
    users.value = response.data || response.data || []
  } catch (err) {
    console.error('Error loading users:', err)
    error.value = 'Failed to load users. Please try again.'
    
    // Fallback sample users
    users.value = [
      { id: 1, name: 'Admin User', email: 'admin@example.com', created_at: '2024-01-15', role: 'admin' },
      { id: 2, name: 'John Doe', email: 'john@example.com', created_at: '2024-01-20', role: 'user' },
      { id: 3, name: 'Jane Smith', email: 'jane@example.com', created_at: '2024-01-25', role: 'user' }
    ]
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  refreshUsers()
})

// Computed
const filteredUsers = computed(() => {
  const q = searchQuery.value.toLowerCase()
  // make sure users.value is an array
  return (Array.isArray(users.value) ? users.value : []).filter(user =>
    user.name.toLowerCase().includes(q) ||
    user.email.toLowerCase().includes(q) ||
    user.role.toLowerCase().includes(q)
  )
})


const totalPages = computed(() =>
  Math.ceil(filteredUsers.value.length / itemsPerPage.value)
)

const paginatedUsers = computed(() => {
  const start = (currentPage.value - 1) * itemsPerPage.value
  return filteredUsers.value.slice(start, start + itemsPerPage.value)
})

// Watchers
watch(searchQuery, () => { currentPage.value = 1 })
watch(itemsPerPage, () => { currentPage.value = 1 })

// Methods
// const deleteUser = async (user) => {
//   try {
//     await services.UserService.deleteUser(user.id)
//     users.value = users.value.filter(u => u.id !== user.id)
//     showToast(`✅ User "${user.name}" deleted successfully`, 3000, "success")
//   } catch (err) {
//     console.error('Error deleting user:', err)
//     showToast("❌ Failed to delete user. Please try again.", 3000, "error")
//   }
// }

const editUser = (user) => {
  alert('Edit user feature coming soon!')
}

const viewUser = (user) => {
  console.log('View user:', user)
}

const refreshUsers = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await services.UserService.getAllUsers()

    // ✅ make sure data is an array
    if (Array.isArray(response.data)) {
      users.value = response.data
    } else if (response.data && response.data.data) {
      // sometimes Laravel returns { data: [...] }
      users.value = response.data.data
    } else {
      users.value = []
    }

  } catch (err) {
    console.error('Error refreshing users:', err)
    error.value = 'Failed to load users. Please try again.'
  } finally {
    loading.value = false
  }
}

</script>


<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
}
</style>

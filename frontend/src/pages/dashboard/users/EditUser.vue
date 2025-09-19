<template>
  <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />

  <div class="p-6 max-w-4xl mx-auto">
    <HeadPage :part="$t('users.part')" :title="$t('users.edit.title')" :enableBtn="false" href="" />

    <div class="col-span-12 md:col-span-6">
      <div
        class="bg-background-secondary space-y-3 dark:bg-box-dark m-0 p-8 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative"
      >
        <form @submit.prevent="updateUserData">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
              <InputField v-model="user.name" type="text" :placeholder="$t('users.form.fullName')" />
              <p v-if="submitted && errors.name" class="text-red-500 text-xs pl-3">{{ errors.name }}</p>
            </div>

            <!-- Email -->
            <div>
              <InputField v-model="user.email" type="email" :placeholder="$t('users.form.email')" />
              <p v-if="submitted && errors.email" class="text-red-500 text-xs pl-3">{{ errors.email }}</p>
            </div>

            <!-- Role -->
            <div>
              <select
                v-model="user.role"
                class="appearance-none w-full px-4 py-2 text-sm rounded-xl border border-primary-border dark:border-gray-600 bg-background-secondary text-secondary-text focus:outline-none focus:ring-2 focus:ring-primary-border"
              >
                <option disabled value="">{{ $t('users.form.selectRole') }}</option>
                <option value="Attendee">{{ $t('roles.Attendee') }}</option>
                <option value="Admin">{{ $t('roles.Admin') }}</option>
                <option value="Organizer">{{ $t('roles.Organizer') }}</option>
              </select>
              <p v-if="submitted && errors.role" class="text-red-500 text-xs pl-3">{{ errors.role }}</p>
            </div>

            <!-- Password -->
            <div>
              <InputField v-model="user.password" type="password" :placeholder="$t('users.form.newPasswordOptional')" />
              <p v-if="submitted && errors.password" class="text-red-500 text-xs pl-3">{{ errors.password }}</p>
            </div>
          </div>

          <!-- Update Button -->
          <div class="pt-6">
            <button
              class="bg-[var(--color-primary)] text-white hover:opacity-50 px-6 py-2 rounded-xl transition"
            >
              {{ $t('users.edit.updateButton') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from "vue";
import { useI18n } from "vue-i18n";
import { useRoute, useRouter } from "vue-router";
import HeadPage from "@/components/dashboard/ui/HeadPage.vue";
import InputField from "@/components/dashboard/ui/InputField.vue";
import ToastMessage from "@/components/ToastMessage.vue";
import services from "@/services";

const route = useRoute();
const router = useRouter();
const userId = route.params.id; // expects /users/:id/edit route

const user = reactive({
  name: "",
  email: "",
  role: "",
  password: "",
});


const errors = reactive({ name: "", email: "", role: "", password: "" });
const submitted = ref(false);
const toastMessage = ref("");
const toastVisible = ref(false);
const toastType = ref("success");
const { t } = useI18n();

function validate() {
  errors.name = user.name.trim() ? "" : t('validation.nameRequired');
  errors.email = user.email.trim() ? "" : t('validation.emailRequired');
  errors.role = user.role ? "" : t('validation.roleRequired');

  // password is optional on update, so no validation required
  return Object.values(errors).every((e) => e === "");
}

const updateUserData = () => {
  submitted.value = true;
  if (!validate()) {
    showToast("⚠️ " + t('validation.fillRequired'), 3000, "error");
    return;
  }

  // Do not send empty password on update
  const normalizedRole = (user.role || "").toString();
  const payload = {
    name: user.name,
    email: user.email,
    role: normalizedRole || undefined,
    ...(user.password ? { password: user.password } : {}),
  };

  services.UserService.updateUser(userId, payload)
    .then(() => {
      showToast("✅ " + t('users.edit.success'));
      router.push("/users"); // redirect to user list after update
    })
    .catch((err) => {
      console.error("Error updating user:", err?.response?.data || err);
      let message = "❌ " + t('users.edit.failed');
      const resp = err?.response?.data;
      if (resp && resp.errors) {
        const firstKey = Object.keys(resp.errors)[0];
        if (firstKey && resp.errors[firstKey]?.length) {
          message = `❌ ${resp.errors[firstKey][0]}`;
        }
      } else if (resp && resp.message) {
        message = `❌ ${resp.message}`;
      }
      showToast(message, 5000, "error");
    });
};

function showToast(message, duration = 3000, type = "success") {
  toastMessage.value = message;
  toastVisible.value = true;
  toastType.value = type;
  setTimeout(() => (toastVisible.value = false), duration);
}

// Load existing user data on mount
onMounted(() => {
  services.UserService.getUserById(userId)
    .then((res) => {
      console.log("API response:", res);
      if (res && res.data) {
        const raw = (res.data && res.data.user) ? res.data.user : (res.data && res.data.data) ? res.data.data : res.data;
        const mapRoleToOption = (val) => {
          if (!val && val !== 0) return "";
          const s = String(val).toLowerCase();
          if (s === "admin") return "Admin";
          if (s === "organizer") return "Organizer";
          if (s === "user" || s === "attendee") return "Attendee";
          return val; // assume already "Admin"/"Organizer"/"Attendee"
        };

        user.name = raw?.name || "";
        user.email = raw?.email || "";
        const roleVal = raw?.role ?? raw?.role_name ?? raw?.user_type ?? raw?.role_id ?? "";
        user.role = mapRoleToOption(roleVal);
        user.password = "";
      }
    })
    .catch((err) => {
      console.error("Error loading user:", err);
      showToast("❌ " + t('users.edit.loadFailed'), 5000, "error");
    });
});


</script>

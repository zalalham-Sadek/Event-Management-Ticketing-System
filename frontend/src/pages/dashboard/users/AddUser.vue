<template>
  <ToastMessage :message="toastMessage" :visible="toastVisible" :type="toastType" />

  <div class="p-6 max-w-4xl mx-auto">
    <headPage :part="$t('users.part')" :title="$t('users.add.title')" :enableBtn="false" href="" />
    <div class="col-span-12 md:col-span-6">
      <div
        class="bg-background-secondary space-y-3 dark:bg-box-dark m-0 p-8 text-body dark:text-subtitle-dark text-[15px] rounded-10 relative"
      >
        <form @submit.prevent="saveUser">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
              <InputField v-model="newUser.name" type="text" :placeholder="$t('users.form.fullName')" />
              <p v-if="submitted && errors.name" class="text-red-500 text-xs pl-3">{{ errors.name }}</p>
            </div>

            <!-- Email -->
            <div>
              <InputField v-model="newUser.email" type="email" :placeholder="$t('users.form.email')" />
              <p v-if="submitted && errors.email" class="text-red-500 text-xs pl-3">{{ errors.email }}</p>
            </div>

            <!-- Role -->
            <div>
              <select
                v-model="newUser.role"
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
              <InputField v-model="newUser.password" type="password" :placeholder="$t('users.add.passwordPlaceholder')" />
              <p v-if="submitted && errors.password" class="text-red-500 text-xs pl-3">{{ errors.password }}</p>
            </div>
          </div>

          <!-- Save Button -->
          <div class="pt-6">
            <button
              class="bg-[var(--color-primary)] to-background-primary/81 text-white hover:opacity-50 px-6 py-2 rounded-xl transition"
            >
              {{ $t('users.add.saveButton') }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from "vue";
import { useI18n } from "vue-i18n";
import HeadPage from "@/components/dashboard/ui/HeadPage.vue";
import InputField from "@/components/dashboard/ui/InputField.vue";
import services from "@/services";

const newUser = ref({
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
  errors.name = newUser.value.name.trim() ? "" : t('validation.nameRequired');
  errors.email = newUser.value.email.trim() ? "" : t('validation.emailRequired');
  errors.role = newUser.value.role ? "" : t('validation.roleRequired');
  errors.password = newUser.value.password.trim() ? "" : t('validation.passwordRequired');

  return Object.values(errors).every((e) => e === "");
}

const saveUser = () => {
  submitted.value = true;
  if (!validate()) {
    showToast("⚠️ " + t('validation.fillRequired'), 3000, "error");
    return;
  }

    // Call API to create user
    services.UserService.createUser(newUser.value)
    .then(() => {
      showToast("✅ " + t('users.add.success'));
      newUser.value = { name: "", email: "", role: "", password: "" };
      submitted.value = false;
    })
    .catch((err) => {
      console.error("Error creating user:", err);
      showToast("❌ " + t('users.add.failed'), 5000, "error");
    });

  // Store in localStorage (simulate DB)
//   const storedUsers = localStorage.getItem("users");
//   const users = storedUsers ? JSON.parse(storedUsers) : [];
//   const nextId = users.length > 0 ? Math.max(...users.map((u) => u.id)) + 1 : 1;

//   const userToSave = { id: nextId, ...newUser.value };
//   users.push(userToSave);

//   localStorage.setItem("users", JSON.stringify(users));

  newUser.value = { name: "", email: "", role: "", password: "" };
  submitted.value = false;
  showToast("✅ " + t('users.add.saved'));
};

function showToast(message, duration = 3000, type = "success") {
  toastMessage.value = message;
  toastVisible.value = true;
  toastType.value = type;
  setTimeout(() => (toastVisible.value = false), duration);
}
</script>

<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import InputError from "../components/InputError.vue";

const router = useRouter();
const user = ref(null);
const error = ref("");
const errors = ref({ email: "" });
const loading = ref(true);
const processing = ref(false);

const token = localStorage.getItem("token");
const getUser = async () => {
  if (!token) {
    router.push("/login");
    return;
  }
  try {
    const response = await fetch("http://127.0.0.1:8000/api/user", {
      method: "GET",
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
    });
    if (!response.ok) {
      localStorage.removeItem("token");
      router.push("/login");
      return;
    }
    user.value = await response.json();
  } catch (err) {
    error.value = "ارتباط با سرور برقرار نشد.";
  } finally {
    loading.value = false;
  }
};
const logout = async () => {
  try {
    await fetch("http://127.0.0.1:8000/api/logout", {
      method: "POST",
      headers: {
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
    });
  } catch (err) {
    console.log(err);
  }
  localStorage.removeItem("token");
  router.push("/login");
};

const editProfile = async () => {
  processing.value = true;
  errors.value = {
    email: "",
  };
  try {
    const response = await fetch("http://127.0.0.1:8000/api/user", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },
      body: JSON.stringify({
        email: user.value.email,
      }),
    });

    const data = await response.json();
    console.log("data is:", data.errors);
    if (!response.ok) {
      if (data.errors) {
        errors.value.email = data.errors.email?.[0] || "";
      } else {
        error.value = data.message;
      }
      return;
    }

    router.push("/dashboard");
  } catch (err) {
    error.value = "ارتباط با سرور برقرار نشد.";
  } finally {
    processing.value = false;
  }
};

const changePassword = () => {
  router.push("/change-password");
};

onMounted(() => {
  getUser();
});
</script>

<template>
  <div class="flex min-h-screen items-center justify-center bg-grey-100">
    <div v-if="loading" class="text-center text-gray-500">
      در حال دریافت اطلاعات....
    </div>
    <div v-else class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-md">
      <div
        class="
          max-w-2xl
          mx-auto
          mb-6
          flex
          items-start
          justify-between
          bg-gray-300
          rounded-2xl
          px-4
          py-4
        "
      >
        <div class="text-right">
          <h1 class="text-2xl font-bold text-gray-800">داشبورد</h1>

          <p class="text-gray-500 mt-2">خوش آمدید، {{ user?.name }}</p>
        </div>
        <button
          @click="logout"
          class="
            rounded-lg
            bg-red-500
            px-3
            py-2
            text-sm
            font-semibold
            text-white
            hover:bg-red-600
            transition
          "
        >
          خروج
        </button>
      </div>
      <h2 class="text-xl font-bold text-gray-800 text-center mb-6">
        اطلاعات کاربر
      </h2>
      <div class="space-y-5">
        <p v-if="error" class="mt-4 text-sm text-red-600 text-center">
          {{ error }}
        </p>
        <!-- نام کاربری -->
        <div>
          <label
            for="name"
            class="block text-sm font-medium text-gray-700 mb-2 text-right"
          >
            نام کاربری
          </label>

          <input
            id="name"
            :value="user.name"
            readonly
            type="text"
            class="
              w-full
              rounded-xl
              border border-gray-300
              text-gray-500
              cursor-not-allowed
              px-4
              py-3
              text-right
            "
            placeholder="نام کاربری"
          />
        </div>

        <!-- ایمیل -->
        <div>
          <label
            for="email"
            class="block text-sm font-medium text-gray-700 mb-2 text-right"
          >
            ایمیل
          </label>

          <input
            id="email"
            v-model="user.email"
            type="email"
            class="
              w-full
              rounded-xl
              border border-gray-300
              px-4
              py-3
              text-right
              focus:outline-none
              focus:ring-2
              focus:ring-indigo-500
              focus:border-indigo-500
              transition
            "
            :class="
              errors.email ? '!border-red-500 !ring-red-500' : 'border-gray-300'
            "
            placeholder="ایمیل"
          />
          <InputError class="mt-2" :message="errors.email" />
        </div>
      </div>

      <div class="flex gap-3 mt-6">
        <button
          type="button"
          @click="editProfile"
          class="
            w-full
            mt-6
            rounded-xl
            bg-indigo-600
            px-4
            py-3
            text-sm
            font-semibold
            text-white
            hover:bg-indigo-700
            disabled:opacity-50 disabled:cursor-not-allowed
            transition
          "
        >
          {{ processing ? "در حال تغییر..." : " ذخیره تغییرات " }}
        </button>
        <button
          type="button"
          @click="changePassword"
          :disabled="processing"
          class="
            w-full
            mt-6
            rounded-xl
            bg-indigo-600
            px-4
            py-3
            text-sm
            font-semibold
            text-white
            hover:bg-indigo-700
            disabled:opacity-50 disabled:cursor-not-allowed
            transition
          "
        >
          تغییر رمز عبور
        </button>
      </div>
    </div>
  </div>
</template>

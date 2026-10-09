<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

import InputError from "../components/InputError.vue";
const router = useRouter();

const form = ref({
  current_password: "",
  password: "",
  password_confirmation: "",
});
const errors = ref({
  current_password: "",
  password: "",
  password_confirmation: "",
});
const error = ref("");
const success = ref("");
const processing = ref(false);

const changePassword = async () => {
  error.value = "";
  errors.value = {
    current_password: "",
    password: "",
    password_confirmation: "",
  };
  success.value = "";
  processing.value = true;

  try {
    const token = localStorage.getItem("token");

    if (!token) {
      router.push("/login");
      return;
    }

    const response = await fetch("http://127.0.0.1:8000/api/change-password", {
      method: "POST",

      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${token}`,
      },

      body: JSON.stringify({
        current_password: form.value.current_password,
        password: form.value.password,
        password_confirmation: form.value.password_confirmation,
      }),
    });

    const data = await response.json();

    if (!response.ok) {
      if (data.errors) {
        errors.value.current_password = data.errors.current_password?.[0] || "";
        errors.value.password = data.errors.password?.[0] || "";
        errors.value.password_confirmation =
          data.errors.password_confirmation?.[0] || "";
      } else {
        error.value = data.message;
      }
      return;
    }

    success.value = data.message;

    localStorage.removeItem("token");

    setTimeout(() => {
      router.push("/login");
    }, 1500);
  } catch (err) {
    error.value = "ارتباط با سرور برقرار نشد.";
  } finally {
    processing.value = false;
  }
};

const cancel = () => {
  router.push("/dashboard");
};
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex items-center justify-center">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg p-8">
      <h1 class="text-2xl font-bold text-gray-800 text-center mb-2">
        تغییر رمز عبور
      </h1>
      <p class="text-sm text-gray-00 text-center mb-8">
        برای تغییر رمز عبور، اطلاعات زیر را وارد کنید
      </p>

      <form @submit.prevent="changePassword">
        <!-- Error -->
        <InputError :message="error" />
        <!-- رمز فعلی -->
        <div class="mb-5">
          <label
            for="current_password"
            class="block text-sm font-medium text-gray-700 mb-2 text-right"
          >
            رمز عبور فعلی
          </label>

          <input
            id="current_password"
            v-model="form.current_password"
            type="password"
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
              errors.current_password
                ? '!border-red-500 !ring-red-500'
                : 'border-gray-300'
            "
          />

          <div
            v-if="errors.current_password"
            class="text-red-500 text-sm mt-2 text-right"
          >
            {{ errors.current_password }}
          </div>
        </div>

        <!-- رمز جدید -->
        <div class="mb-5">
          <label
            for="password"
            class="block text-sm font-medium text-gray-700 mb-2 text-right"
          >
            رمز عبور جدید
          </label>

          <input
            id="password"
            v-model="form.password"
            type="password"
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
              errors.password
                ? '!border-red-500 !ring-red-500'
                : 'border-gray-300'
            "
          />

          <div
            v-if="errors.password"
            class="text-red-500 text-sm mt-2 text-right"
          >
            {{ errors.password }}
          </div>
        </div>

        <!-- تکرار رمز -->
        <div class="mb-6">
          <label
            for="password_confirmation"
            class="block text-sm font-medium text-gray-700 mb-2 text-right"
          >
            تکرار رمز عبور جدید
          </label>

          <input
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
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
              errors.password_confirmation
                ? '!border-red-500 !ring-red-500'
                : 'border-gray-300'
            "
          />
          <div
            v-if="errors.password"
            class="text-red-500 text-sm mt-2 text-right"
          >
            {{ errors.password }}
          </div>
        </div>

        <!-- Success -->
        <p v-if="success" class="mt-2 text-sm text-green-600 text-right">
          {{ success }}
        </p>
        <div class="flex gap-3 mt-6">
          <button
            type="submit"
            :disabled="processing"
            class="
              w-full
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
            {{ processing ? "در حال تغییر..." : "تغییر رمز عبور" }}
          </button>
          <button
            type="button"
            @click="cancel"
            class="
              flex-1
              rounded-xl
              border border-gray-300
              bg-red-500
              px-4
              py-3
              text-sm text-white
              font-semibold
              hover:bg-red-600
              transition
            "
          >
            انصراف
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

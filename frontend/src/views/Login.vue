<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import InputLabel from "../components/InputLabel.vue";
import TextInput from "../components/TextInput.vue";
import InputError from "../components/InputError.vue";

const router = useRouter();

const form = ref({
  name: "",
  password: "",
});
const errors = ref({
  name: "",
  password: "",
});
const error = ref("");
const processing = ref(false);

const submit = async () => {
  error.value = "";
  errors.value = {
    name: "",
    password: "",
  };
  processing.value = true;

  try {
    const response = await fetch("http://127.0.0.1:8000/api/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
      },
      body: JSON.stringify({
        name: form.value.name,
        password: form.value.password,
      }),
    });

    const data = await response.json();

    if (!response.ok) {
      if (data.errors) {
        errors.value.name = data.errors.name?.[0] || "";
        errors.value.password = data.errors.password?.[0] || "";
      } else {
        error.value = data.message;
      }

      return;
    }

    localStorage.setItem("token", data.token);

    router.push("/dashboard");
  } catch (err) {
    error.value = "ارتباط با سرور برقرار نشد.";
  } finally {
    processing.value = false;
  }
};
</script>

<template>
  <div
    dir="rtl"
    class="min-h-screen bg-gray-100 flex items-center justify-center px-4"
  >
    <div class="w-full max-w-md">
      <div class="bg-white rounded-2xl shadow-xl p-8">
        <div class="flex justify-center mb-6">
          <img
            src="/images/logo.jpg"
            alt="Logo"
            class="w-20 h-20 object-contain"
          />
        </div>
        <div class="text-center mb-8">
          <h1 class="text-2xl font-bold text-gray-800">ورود به حساب کاربری</h1>

          <p class="text-sm text-gray-500 mt-2">
            نام کاربری و رمز عبور خود را وارد کنید
          </p>
        </div>
        <p v-if="error" class="mt-4 text-sm text-red-600 text-center">
          {{ error }}
        </p>
        <form @submit.prevent="submit">
          <div class="mb-5">
            <InputLabel
              for="name"
              value="Username"
              class="block text-sm font-medium text-gray-700 mb-2 text-right"
            />

            <TextInput
              id="name"
              type="text"
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
                errors.name || error
                  ? '!border-red-500 !ring-red-500'
                  : 'border-gray-300'
              "
              v-model="form.name"
              autofocus
              autocomplete="off"
              placeholder="نام کاربری"
              :error="!errors.name"
            />

            <InputError class="mt-2" :message="errors.name" />
          </div>

          <div class="mb-6">
            <InputLabel
              for="password"
              value="Password"
              class="block text-sm font-medium text-gray-700 mb-2 text-right"
            />

            <TextInput
              id="password"
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
                errors.password || error
                  ? '!border-red-500 !ring-red-500'
                  : 'border-gray-300'
              "
              v-model="form.password"
              autocomplete="new-password"
              placeholder="رمز عبور"
              :error="!errors.password"
            />

            <InputError class="mt-2" :message="errors.password" />
          </div>

          <div class="mt-4 flex items-center justify-end">
            <button
              type="submit"
              :disabled="processing"
              class="
                w-full
                rounded-xl
                bg-indigo-600
                text-white
                py-3
                font-semibold
                hover:bg-indigo-700
                transition
                duration-200
                disabled:opacity-50 disabled:cursor-not-allowed
              "
            >
              {{ processing ? "در حال ورود..." : "ورود" }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

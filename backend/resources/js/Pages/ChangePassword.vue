<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    current_password: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.put("/change-password");
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

            <form @submit.prevent="submit">
                <!-- رمز فعلی -->
                <div class="mb-5">
                    <label
                        for="current_password"
                        class="
                            block
                            text-sm
                            font-medium
                            text-gray-700
                            mb-2
                            text-right
                        "
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
                    />

                    <div
                        v-if="form.errors.current_password"
                        class="text-red-500 text-sm mt-2 text-right"
                    >
                        {{ form.errors.current_password }}
                    </div>
                </div>

                <!-- رمز جدید -->
                <div class="mb-5">
                    <label
                        for="password"
                        class="
                            block
                            text-sm
                            font-medium
                            text-gray-700
                            mb-2
                            text-right
                        "
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
                    />

                    <div
                        v-if="form.errors.password"
                        class="text-red-500 text-sm mt-2 text-right"
                    >
                        {{ form.errors.password }}
                    </div>
                </div>

                <!-- تکرار رمز -->
                <div class="mb-6">
                    <label
                        for="password_confirmation"
                        class="
                            block
                            text-sm
                            font-medium
                            text-gray-700
                            mb-2
                            text-right
                        "
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
                    />
                    <div
                        v-if="form.errors.password"
                        class="text-red-500 text-sm mt-2 text-right"
                    >
                        {{ form.errors.password }}
                    </div>
                </div>
                <div class="flex gap-3 mt-6">
                    <button
                        type="submit"
                        :disabled="form.processing"
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
                        {{
                            form.processing
                                ? "در حال تغییر..."
                                : "تغییر رمز عبور"
                        }}
                    </button>
                    <button
                        type="button"
                        @click="$inertia.visit('/dashboard')"
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

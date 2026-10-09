<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    name: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
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
                    <h1 class="text-2xl font-bold text-gray-800">
                        ورود به حساب کاربری
                    </h1>

                    <p class="text-sm text-gray-500 mt-2">
                        نام کاربری و رمز عبور خود را وارد کنید
                    </p>
                </div>
                <form @submit.prevent="submit">
                    <div class="mb-5">
                        <InputLabel
                            for="name"
                            value="Username"
                            class="
                                block
                                text-sm
                                font-medium
                                text-gray-700
                                mb-2
                                text-right
                            "
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
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="نام کاربری"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div class="mb-6">
                        <InputLabel
                            for="password"
                            value="Password"
                            class="
                                block
                                text-sm
                                font-medium
                                text-gray-700
                                mb-2
                                text-right
                            "
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
                            v-model="form.password"
                            required
                            autocomplete="current-password"
                            placeholder="رمز عبور"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.password"
                        />
                    </div>

                    <div class="mt-4 flex items-center justify-end">
                        <button
                            type="submit"
                            :disabled="form.processing"
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
                            {{ form.processing ? "در حال ورود..." : "ورود" }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

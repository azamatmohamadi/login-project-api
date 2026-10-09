<script setup>
import { usePage, router, Link, useForm } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth.user;
const form = useForm({
    name: user.name,
    email: user.email,
});
const submit = () => {
    form.patch("/profile");
};
const logout = () => {
    router.post("/logout");
};
</script>

<template>
    <div class="flex min-h-screen items-center justify-center bg-grey-100">
        <div
            v-if="user"
            class="bg-white rounded-2xl shadow-lg p-6 w-full max-w-md"
        >
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

                    <p class="text-gray-500 mt-2">خوش آمدید، {{ user.name }}</p>
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
                <!-- نام کاربری -->
                <div>
                    <label
                        for="name"
                        class="
                            block
                            text-sm
                            font-medium
                            text-gray-700
                            mb-2
                            text-right
                        "
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
                        class="
                            block
                            text-sm
                            font-medium
                            text-gray-700
                            mb-2
                            text-right
                        "
                    >
                        ایمیل
                    </label>

                    <input
                        id="email"
                        v-model="form.email"
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
                        placeholder="ایمیل"
                    />
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <Link
                    href="change-password"
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
                    >تغییررمزعبور</Link
                >
                <button
                    type="button"
                    @click="submit"
                    :disabled="form.processing"
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
                    {{ form.processing ? "در حال ذخیره..." : "ذخیره تغییرات" }}
                </button>
            </div>
            <!-- <PrimaryButton class="ms-4"> change Password </PrimaryButton> -->
        </div>
    </div>
</template>

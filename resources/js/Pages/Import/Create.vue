<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import Layout from "@/Components/Layout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    file: null,
});

const handleFileChange = (event) => {
    const files = event.target.files;
    if (files.length > 0) {
        form.file = files[0];
        form.errors.file = null;
    }
};

const submit = () => {
    if (!form.file) {
        form.errors.file = 'No file selected';
        return;
    }

    const formData = new FormData();
    formData.append('file', form.file);

    form.post(route('import.store'), {
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data',
        },
        onSuccess: () => {
            // Handle success
        },
        onError: (errors) => {
            form.errors = errors;
        },
    });
};
</script>

<template>
    <Layout></Layout>
    <div class="w-full lg:ps-64 -mt-12">
        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
                            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                        {{ $t('Create Import') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        {{ $t('Add imports, edit and more.') }}
                                    </p>
                                </div>
                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <Link :href="route('import.index')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                                                {{ $t('View all') }}
                                            </a>
                                        </Link>
                                        <Link :href="route('import.create')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none">
                                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M5 12h14"></path>
                                                    <path d="M12 5v14"></path>
                                                </svg>
                                                {{ $t('Add import') }}
                                            </a>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <form class="w-1/2 py-5 space-y-3" @submit.prevent="submit" enctype="multipart/form-data">
                                    <input
                                        type="file"
                                        name="file"
                                        id="file"
                                        @change="handleFileChange"
                                        class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                        file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4 dark:file:bg-neutral-700 dark:file:text-neutral-400"
                                    />
                                    <InputError class="mt-2" :message="form.errors.file" />
                                    <div class="flex justify-center">
                                        <PrimaryButton>
                                            {{ $t('Create Import') }}
                                        </PrimaryButton>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



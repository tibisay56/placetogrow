<script setup>
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Layout from "@/Components/Layout.vue";

const { props } = usePage();
const retryInterval = props.retryInterval;
const maxRetries = props.maxRetries;

const form = useForm({
    retry_interval: retryInterval,
    max_retries: maxRetries,
    setting: props.settings.id
});

const submit = () => {
    console.log("Form data before submit:", form);
    form.put(route('setting.update', { setting: props.settings.id }), {
        onSuccess: (response) => {
            console.log("Response after update:", response);
            form.reset();
        },
        onError: (errors) => {
            console.error("Error during update:", errors);
        },
    });
};

</script>

<template>
    <Head title="Settings" />
    <Layout></Layout>
    <!-- Content -->
    <div class="w-full lg:ps-64 -mt-12">
        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            <!-- Card -->
            <div class="flex flex-col">
                <div class="-m-1.5 overflow-x-auto">
                    <div class="p-1.5 min-w-full inline-block align-middle">
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
                            <!-- Header -->
                            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                        {{ $t('Settings') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        {{ $t('Add settings, edit and more.') }}
                                    </p>
                                </div>
                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <Link :href="route('setting.index')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                {{ $t('View all') }}
                                            </a>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <!-- End Header -->
                            <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <form class="w-1/2 py-5 space-y-3" @submit.prevent="submit">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                                            <div class="mt-4">
                                                <InputLabel for="retry_interval" :value="$t('Retry Interval')" />
                                                <TextInput v-model="form.retry_interval" id="retry_interval" type="number" class="mt-1 block w-full" autocomplete="retry_interval" :placeholder="$t('Retry interval')"/>
                                                <InputError class="mt-2" :message="form.errors.retry_interval" />
                                            </div>
                                            <div class="mt-4">
                                                <InputLabel for="max_retries" :value="$t('Max Retries')" />
                                                <TextInput v-model="form.max_retries" id="max_retries" type="number" class="mt-1 block w-full" autocomplete="max_retries" :placeholder="$t('Max Retries')"/>
                                                <InputError class="mt-2" :message="form.errors.max_retries" />
                                            </div>
                                        </div>
                                        <div class="flex justify-center">
                                            <PrimaryButton>
                                                {{ $t('Update Setting') }}
                                            </PrimaryButton>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>
</template>


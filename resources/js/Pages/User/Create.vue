<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Layout from "@/Components/Layout.vue";
import {ref} from "vue";

const { props } = usePage();
const roles = ref(props.roles || []);
const sites = ref(props.sites || []);

console.log(props.roles);
const form = useForm({
    name: '',
    email: '',
    roles: [],
    site_id: null,
});


const submit = () => {
    form.post(route('user.store'));
};
</script>

<template>
    <Head title="Create Users" />
    <AuthenticatedLayout>
        <Layout></Layout>
        <!-- Content -->
        <div class="w-full lg:ps-64">
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
                                            {{ $t('Create Users') }}
                                        </h2>
                                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                                            {{ $t('Add users, edit and more.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <div class="inline-flex gap-x-2">
                                            <Link :href="route('user.index')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                {{ $t('View all') }}
                                            </a>
                                            </Link>
                                            <Link :href="route('user.create')">
                                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" >
                                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                    {{ $t('Add user') }}
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
                                            <div>
                                                <InputLabel for="first_name" :value="$t('Name')" />
                                                <TextInput v-model="form.name" id="name" type="text" class="mt-1 block w-full" autocomplete="name" :placeholder="$t('Name')"/>
                                                <InputError class="mt-2" :message="form.errors.name" />
                                            </div>
                                            <div>
                                                <InputLabel for="email" :value="$t('Email')" />
                                                <TextInput v-model="form.email" id="email" type="email" class="mt-1 block w-full" autocomplete="email" :placeholder="$t('Email')"/>
                                                <InputError :message="form.errors.email" class="mt-2" />
                                            </div>
                                            </div>
                                            <div>
                                                <InputLabel for="site_id" :value="$t('Site')" />
                                                <select v-model="form.site_id" id="site_id"
                                                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option :value="null">{{ $t('Select a site') }}</option>
                                                    <option v-for="site in sites" :key="site.id" :value="site.id">{{ site.name }}</option>
                                                </select>
                                                <InputError :message="form.errors.site_id" class="mt-2" />
                                            </div>
                                            <div>
                                                <div>
                                                    <InputLabel for="role" :value="$t('Role')" />
                                                    <div v-for="role in roles" :key="role.id" class="flex items-center space-x-2">
                                                        <input type="checkbox" :value="role.id" v-model="form.roles" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"/>
                                                        <span>{{ role.name }}</span>
                                                    </div>
                                                    <InputError :message="form.errors.roles" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="flex justify-center">
                                                <PrimaryButton>
                                                    {{ $t('Create User') }}
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
    </AuthenticatedLayout>
</template>





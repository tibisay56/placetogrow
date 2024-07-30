<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref, watch} from 'vue';
import Layout from "@/Components/Layout.vue";

const page = usePage();
const role = ref(page.props.role);
const permissions = ref(page.props.permissions);
const selectedPermissions = ref(role.value.permissions.map(p => p.id));

const form = useForm({
    name: role.value.name,
    permissions: selectedPermissions.value,
});

const submit = () => {
    form.patch(route('role.update', role.value.id), {
        onSuccess: (e) => {
            role.value = e.props.role;
        }
    });
};

const togglePermission = (permissionId) => {
    const index = selectedPermissions.value.indexOf(permissionId);
    if (index !== -1) {
        selectedPermissions.value.splice(index, 1);
    } else {
        selectedPermissions.value.push(permissionId);
    }
    form.permissions = selectedPermissions.value;
};

watch(selectedPermissions, (newPermissions) => {
    form.permissions = newPermissions;
});

const filteredPermissions = (category) => {
    return permissions.value.filter(permission => permission.name.startsWith(`${category}_`));
};

</script>

<template>
    <Head title="Update Roles" />

    <AuthenticatedLayout>
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
                                            {{ $t('Edit Roles') }}
                                        </h2>
                                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                                            {{ $t('Add roles, edit and more.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <div class="inline-flex gap-x-2">
                                            <Link :href="route('role.index')">
                                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                    {{ $t('View all') }}
                                                </a>
                                            </Link>
                                            <Link :href="route('role.create')">
                                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M5 12h14"/>
                                                        <path d="M12 5v14"/>
                                                    </svg>
                                                    {{ $t('Add role') }}
                                                </a>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Header -->
                                <div class="py-12">
                                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                        <p class="text-sm text-gray-600 dark:text-neutral-400 mb-4">
                                            {{ $t('Role') }}: {{ $t(role.name) }}
                                        </p>

                                        <div class="flex flex-col">
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="border rounded-lg divide-y divide-gray-200 dark:border-neutral-700 dark:divide-neutral-700">
                                                        <div class="overflow-hidden">
                                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                                                <thead class="bg-gray-50 dark:bg-neutral-700">
                                                                <tr>
                                                                    <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">{{ $t('Management') }} </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $t('User') }}</td>
                                                                    <td class="py-3 ps-4">
                                                                        <div class="flex space-x-20 ml-6">
                                                                            <div v-for="permission in filteredPermissions('users')" :key="permission.id" class="flex items-center h-5">
                                                                                <input id="hs-table-search-checkbox-1" type="checkbox" v-model="selectedPermissions" :value="permission.id" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                                <label class="ml-2 text-sm text-gray-800 dark:text-neutral-200">
                                                                                    {{ $t (permission.name) }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $t('Sites') }}</td>
                                                                    <td class="py-3 ps-4">
                                                                        <div class="flex space-x-20 ml-6">
                                                                            <div v-for="permission in filteredPermissions('sites')" :key="permission.id" class="flex items-center h-5">
                                                                                <input id="hs-table-search-checkbox-1" type="checkbox" v-model="selectedPermissions" :value="permission.id" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                                <label class="ml-2 text-sm text-gray-800 dark:text-neutral-200">
                                                                                    {{ $t (permission.name) }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $t('Roles') }}</td>
                                                                    <td class="py-3 ps-4">
                                                                        <div class="flex space-x-20 ml-6">
                                                                            <div v-for="permission in filteredPermissions('roles')" :key="permission.id" class="flex items-center h-5">
                                                                                <input id="hs-table-search-checkbox-1" type="checkbox" v-model="selectedPermissions" :value="permission.id" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                                <label class="ml-2 text-sm text-gray-800 dark:text-neutral-200">
                                                                                    {{ $t (permission.name) }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">{{ $t('Payments') }}</td>
                                                                    <td class="py-3 ps-4">
                                                                        <div class="flex space-x-20 ml-6">
                                                                            <div v-for="permission in filteredPermissions('payments')" :key="permission.id" class="flex items-center h-5">
                                                                                <input id="hs-table-search-checkbox-1" type="checkbox" v-model="selectedPermissions" :value="permission.id" class="border-gray-200 rounded text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                                                                                <label class="ml-2 text-sm text-gray-800 dark:text-neutral-200">
                                                                                    {{ $t (permission.name) }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-3 flex justify-center mt-4">
                                            <PrimaryButton @click="submit()">
                                                {{ $t('Update Role') }}
                                            </PrimaryButton>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>



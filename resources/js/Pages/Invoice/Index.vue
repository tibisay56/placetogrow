<script setup>

import Layout from "@/Components/Layout.vue";
import {Link, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import {format} from "date-fns";
import PrimaryButton from "@/Components/PrimaryButton.vue";


const page = usePage()
const invoices = ref(page.props.invoices || []);

const colorByType = {
    paid: 'bg-green-100 text-green-800 dark:bg-green-500/10 dark:text-green-500',
    overdue: 'bg-blue-100 text-blue-800 dark:bg-blue-500/10 dark:text-blue-500',
    pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-500',
};

const getBadgeClasses = (type) => {
    return colorByType[type] || 'bg-gray-100 text-gray-800 dark:bg-gray-500/10 dark:text-gray-500';
};

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return format(date, " yyyy-MM-dd ");
};

</script>

<template>
    <Layout></Layout>
    <div class="w-full lg:ps-64 -mt-8">
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
                                        {{ $t('Invoices') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        {{ $t('Add invoices, edit and more.') }}
                                    </p>
                                </div>

                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <Link :href="route('import.index')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                {{ $t('View all') }}
                                            </a>
                                        </Link>
                                        <Link :href="route('import.create')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none" >
                                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                {{ $t('Add invoice') }}
                                            </a>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <!-- End Header -->
                            <!-- Table -->
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                <thead class="bg-gray-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="ps-6 py-3 text-start">
                                        <label for="hs-at-with-checkboxes-main" class="flex">
                                            <input type="checkbox" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-at-with-checkboxes-main">
                                            <span class="sr-only">Checkbox</span>
                                        </label>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Site') }}
                                              </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Reference') }}
                                              </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Amount') }}
                                              </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Currency') }}
                                              </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Customer name') }}
                                              </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('DNI') }}
                                              </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Status') }}
                                              </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Expiration Date') }}
                                              </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Creation date') }}
                                              </span>
                                        </div>
                                    </th>
                                    <th scope="col" class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                              <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                                                {{ $t('Actions') }}
                                              </span>
                                        </div>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                <tr v-for="invoice in invoices" :key="invoice.id">
                                    <td class="size-px whitespace-nowrap">
                                        <div class="ps-6 py-3">
                                            <label for="hs-at-with-checkboxes-1" class="flex">
                                                <input type="checkbox" class="shrink-0 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800" id="hs-at-with-checkboxes-1">
                                                <span class="sr-only">Checkbox</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-3">
                                            <span class="block text-sm text-gray-500 dark:text-neutral-500">{{ invoice.site ? invoice.site.name : 'Sin sitio' }}</span>
                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                            <div class="flex items-center gap-x-3">
                                                <div class="grow">
                                                            <span :class="`capitalize py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-full`">
                                                                {{ invoice.reference }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-3">
                                            <span class="block text-sm text-gray-500 dark:text-neutral-500">  {{ invoice.amount }}</span>
                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-3">
                                            <span class="block text-sm text-gray-500 dark:text-neutral-500">  {{ invoice.currency }}</span>
                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-3">
                                            <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">  {{ invoice.customer_name }}</span>
                                        </div>
                                    </td>
                                    <td class="size-px whitespace-nowrap">
                                        <div class="px-6 py-3">
                                            <span class="block text-sm text-gray-500 dark:text-neutral-500">  {{ invoice.dni }}</span>
                                        </div>
                                    </td>
                                    <td  class="size-px whitespace-nowrap">
                                        <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                            <div class="flex items-center gap-x-3">
                                                <div class="grow">
                                                    <span :class="`capitalize py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-full ${getBadgeClasses(invoice.status)}`">
                                                        <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                                        </svg>
                                                        {{ invoice.status  }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td  class="size-px whitespace-nowrap">
                                        <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                            <div class="flex items-center gap-x-3">
                                                <div class="grow">
                                                    <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">  {{ formatDate(invoice.expired_at) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td  class="size-px whitespace-nowrap">
                                        <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                            <div class="flex items-center gap-x-3">
                                                <div class="grow">
                                                    <span class="block text-sm font-semibold text-gray-800 dark:text-neutral-200">  {{ formatDate(invoice.created_at) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td  class="size-px whitespace-nowrap">
                                        <div class="ps-6 lg:ps-3 xl:ps-0 pe-6 py-3">
                                            <div class="flex items-center gap-x-3">
                                                <div class="flex justify-center">
                                                    <Link :href="route('invoice.show', invoice.id)">
                                                        <PrimaryButton>
                                                            {{ $t('Pay Now') }}
                                                        </PrimaryButton>
                                                    </Link>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!-- Footer -->
                            <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200 dark:border-neutral-700">
                                <div class="max-w-sm space-y-3">
                                    <select class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option selected>9</option>
                                        <option>20</option>
                                    </select>
                                </div>

                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                            Prev
                                        </button>

                                        <button type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                            Next
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- End Footer -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>

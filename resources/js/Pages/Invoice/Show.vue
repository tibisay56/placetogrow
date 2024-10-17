<script setup>

import {Link, useForm, usePage} from "@inertiajs/vue3";
import Layout from "@/Components/Layout.vue";
import dayjs from 'dayjs';

const { props } = usePage();
const invoice = props.invoice;

const formatDate = (date) => {
    return dayjs(date).format('DD/MM/YYYY');
};
</script>

<template>
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
                                        {{ $t('Show Invoice') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        {{ $t('Add invoices, edit and more.') }}
                                    </p>
                                </div>
                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <Link :href="route('invoice.index')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                {{ $t('View all') }}
                                            </a>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <!-- End Header -->
                                <!-- Invoice -->
                                <div class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto my-4 sm:my-10">
                                    <div class="sm:w-11/12 lg:w-3/4 mx-auto">
                                        <!-- Card -->
                                        <div class="flex flex-col p-4 sm:p-10 bg-white shadow-md rounded-xl dark:bg-neutral-800">
                                            <!-- Grid -->
                                            <div class="flex justify-between">
                                                <div>
                                                    <h1 class="mt-2 text-lg md:text-xl font-semibold text-orange-500 dark:text-white">Evertec</h1>
                                                </div>
                                                <!-- Col -->

                                                <div class="text-end">
                                                    <h2 class="text-2xl md:text-3xl font-semibold text-gray-800 dark:text-neutral-200">Invoice #</h2>
                                                    <span class="mt-1 block text-gray-500 dark:text-neutral-500">{{ invoice.reference }}</span>
                                                </div>
                                                <!-- Col -->
                                            </div>
                                            <!-- End Grid -->

                                            <!-- Grid -->
                                            <div class="mt-8 grid sm:grid-cols-2 gap-3">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Bill to:</h3>
                                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">{{ invoice.customer_name }}</h3>
                                                </div>
                                                <!-- Col -->

                                                <div class="sm:text-end space-y-2">
                                                    <!-- Grid -->
                                                    <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                                                        <dl class="grid sm:grid-cols-5 gap-x-3">
                                                            <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Invoice date:</dt>
                                                            <dd class="col-span-2 text-gray-500 dark:text-neutral-500">{{ formatDate(invoice.created_at) }}</dd>
                                                        </dl>
                                                        <dl class="grid sm:grid-cols-5 gap-x-3">
                                                            <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Due date:</dt>
                                                            <dd class="col-span-2 text-gray-500 dark:text-neutral-500">{{ formatDate(invoice.expired_at) }}</dd>
                                                        </dl>
                                                    </div>
                                                    <!-- End Grid -->
                                                </div>
                                                <!-- Col -->
                                            </div>
                                            <!-- End Grid -->

                                            <!-- Table -->
                                            <div class="mt-6">
                                                <div class="border border-gray-200 p-4 rounded-lg space-y-4 dark:border-neutral-700">
                                                    <div class="hidden sm:grid sm:grid-cols-5">
                                                        <div class="sm:col-span-2 text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Item</div>
                                                        <div class="text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Qty</div>
                                                        <div class="text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Rate</div>
                                                        <div class="text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Amount</div>
                                                    </div>

                                                    <div class="hidden sm:block border-b border-gray-200 dark:border-neutral-700"></div>

                                                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                                                        <div class="col-span-full sm:col-span-2">
                                                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Item</h5>
                                                            <p class="font-medium text-gray-800 dark:text-neutral-200">{{ invoice.description }}</p>
                                                        </div>
                                                        <div>
                                                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Qty</h5>
                                                            <p class="text-gray-800 dark:text-neutral-200">1</p>
                                                        </div>
                                                        <div>
                                                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Rate</h5>
                                                            <p class="text-gray-800 dark:text-neutral-200">5</p>
                                                        </div>
                                                        <div>
                                                            <h5 class="sm:hidden text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Amount</h5>
                                                            <p class="sm:text-end text-gray-800 dark:text-neutral-200">${{ invoice.amount }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="sm:hidden border-b border-gray-200 dark:border-neutral-700"></div>
                                                </div>
                                            </div>
                                            <!-- End Table -->

                                            <!-- Flex -->
                                            <div class="mt-8 flex sm:justify-end">
                                                <div class="w-full max-w-2xl sm:text-end space-y-2">
                                                    <!-- Grid -->
                                                    <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:gap-2">
                                                        <dl class="grid sm:grid-cols-5 gap-x-3">
                                                            <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Subtotal:</dt>
                                                            <dd class="col-span-2 text-gray-500 dark:text-neutral-500">${{ invoice.amount }}</dd>
                                                        </dl>

                                                        <dl class="grid sm:grid-cols-5 gap-x-3">
                                                            <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Fee:</dt>
                                                            <dd class="col-span-2 text-gray-500 dark:text-neutral-500">${{ invoice.late_fee }}</dd>
                                                        </dl>

                                                        <dl class="grid sm:grid-cols-5 gap-x-3">
                                                            <dt class="col-span-3 font-semibold text-gray-800 dark:text-neutral-200">Total:</dt>
                                                            <dd class="col-span-2 text-gray-500 dark:text-neutral-500">${{ invoice.total_amount }}</dd>
                                                        </dl>

                                                    </div>
                                                    <!-- End Grid -->
                                                </div>
                                            </div>
                                            <!-- End Flex -->

                                            <div class="mt-8 sm:mt-12">
                                                <h4 class="text-lg font-semibold text-gray-800 dark:text-neutral-200">Thank you!</h4>
                                                <p class="text-gray-500 dark:text-neutral-500">If you have any questions concerning this invoice, use the following contact information:</p>
                                                <div class="mt-2">
                                                    <p class="block text-sm font-medium text-gray-800 dark:text-neutral-200">example@site.com</p>
                                                    <p class="block text-sm font-medium text-gray-800 dark:text-neutral-200">+1 (062) 109-9222</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Card -->

                                        <!-- Buttons -->
                                        <div class="mt-6 flex justify-end gap-x-3">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                                Invoice PDF
                                            </a>
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="#">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                                                Print
                                            </a>
                                        </div>
                                        <!-- End Buttons -->
                                    </div>
                                </div>
                                <!-- End Invoice -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>

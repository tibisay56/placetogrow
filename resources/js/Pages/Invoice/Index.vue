<script setup>

import Layout from "@/Components/Layout.vue";
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <Layout></Layout>
    <!-- Content -->
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
                                        {{ $t('Add plans, edit and more.') }}
                                    </p>
                                </div>

                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <Link :href="route('plan.index')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                {{ $t('View all') }}
                                            </a>
                                        </Link>
                                        <Link :href="route('plan.create')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none" >
                                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                {{ $t('Add plan') }}
                                            </a>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <!-- End Header -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>

<script setup>

import Layout from "@/Components/Layout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Dropdown from "@/Components/Dropdown.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import DatePicker from "@/Components/DatePicker.vue";
import InputError from "@/Components/InputError.vue";
import { computed, ref } from "vue";
import PieChart from "@/Components/PieChart.vue";
import BarChart from "@/Components/BarChart.vue";
import HorizontalBarChart from "@/Components/HorizontalBarChart.vue";



const props = defineProps({
    sites: Array,
    metrics: Array,
    siteId: Number
});


const selectedDate = ref(null);
const form = ref({
    site_id: null,
    errors: { site_id: null },
});

const filteredMetrics = computed(() => {
    if (form.value.site_id) {
        return props.metrics.filter(metric => metric.site.id === form.value.site_id);
    }
    return [];
});

function handleSelectedDate(date) {
    selectedDate.value = date;
}

function handleSiteChange() {
    const siteId = form.value.site_id;
    const date = selectedDate.value ? new Date(selectedDate.value).toISOString().split('T')[0] : null;

    if (date && siteId && siteId !== 'all') {
        window.location.href = route('metrics.show', { id: siteId, date: date });
    }
}


</script>

<template>
<Layout/>
    <div class="w-full lg:ps-64 -mt-12">
        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            <div class="max-w-[85rem] flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800 h-38 ml-20 mr-20">
                <div class="p-4 md:p-5 flex justify-between gap-x-3 h-full">
                    <div class="mt-4">
                        <InputLabel for="site_id" :value="$t('Site')" />
                        <select v-model="form.site_id" name="site_id" id="site_id" @change="handleSiteChange"
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="all">{{ $t('Select a site') }}</option>
                            <option v-for="site in sites" :key="site.id" :value="site.id">
                                {{ site.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.site_id" />
                    </div>
                    <div class="mt-5 flex-1">
                        <InputLabel for="date" :value="$t('Select a date')" />
                        <Dropdown align="left" width="88">
                            <template #trigger>
                                <button class="border border-gray-300 rounded-md p-2 flex items-center">
                                    <font-awesome-icon :icon="['far', 'calendar']" class="mr-8"/>
                                    {{ selectedDate && selectedDate !== 'null' ? new Date(selectedDate).toLocaleDateString() : 'Today' }}
                                    <font-awesome-icon :icon="['fas', 'chevron-down']" class="ml-8" />
                                </button>
                            </template>

                            <template #content>
                                <div class="flex flex-col p-4">
                                    <DatePicker @update:selectedDate="handleSelectedDate" class="mb-2" @click.stop/>
                                    <button
                                        class="mt-2 bg-orange-500 text-white rounded-md p-2"
                                        @click="confirmDate"
                                    >
                                        Confirm
                                    </button>
                                </div>
                            </template>
                        </Dropdown>
                    </div>
                </div>
            </div>
            <!-- Card Section -->
            <div  class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                <!-- Grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <!-- Card -->
                    <div v-for="metric in filteredMetrics" :key="metric.site.id"
                         class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                        <div class="p-4 md:p-5 flex justify-between gap-x-3">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                    {{$t('Total invoices')}}
                                </p>
                                <div class="mt-1 flex items-center gap-x-2">
                                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                        {{ metric.totalInvoices }}
                                    </h3>
                                    <span class="flex items-center gap-x-1 text-green-600">
                                      <svg class="inline-block size-5 self-center" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                                      <span class="inline-block text-lg">
                                         {{ metric.percentageChange }}%
                                      </span>
                                    </span>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2">
                                    <p class="mt-1 text-sm text-gray-800 dark:text-neutral-200">
                                        {{$t('Amount')}}:
                                    </p>
                                    <h3 class="mt-1 text-xl font-medium text-gray-800 dark:text-neutral-200">
                                        ${{ metric.totalAmount}}
                                    </h3>
                                </div>
                            </div>
                            <div class="shrink-0 flex justify-center items-center size-[46px] bg-orange-500 text-white rounded-full dark:bg-orange-900 dark:text-orange-200">
                                <font-awesome-icon :icon="['fas', 'receipt']" />
                            </div>

                        </div>

                        <a class="py-3 px-4 md:px-5 inline-flex justify-between items-center text-sm text-gray-600 border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 rounded-b-xl dark:border-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                            {{$t('View reports')}}
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div v-for="metric in filteredMetrics" :key="metric.site.id" class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                        <div class="p-4 md:p-5 flex justify-between gap-x-3">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                    {{$t('Paid')}}
                                </p>
                                <div class="mt-1 flex items-center gap-x-2">
                                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                        {{ metric.totalPaid }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-800 dark:text-neutral-200">
                                        {{$t('from')}}
                                    </p>
                                    <h3 class="mt-1 text-xl font-medium text-gray-800 dark:text-neutral-200">
                                        {{ metric.totalInvoices }}
                                    </h3>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2">
                                    <p class="mt-1 text-sm text-gray-800 dark:text-neutral-200">
                                        {{$t('Amount')}}:
                                    </p>
                                    <h3 class="mt-1 text-xl font-medium text-gray-800 dark:text-neutral-200">
                                        ${{ metric.totalPaidAmount}}
                                    </h3>
                                </div>
                            </div>
                            <div class="shrink-0 flex justify-center items-center size-[46px] bg-orange-500 text-white rounded-full dark:bg-orange-900 dark:text-orange-200">
                                <font-awesome-icon :icon="['fas', 'check-to-slot']" />
                            </div>
                        </div>

                        <a class="py-3 px-4 md:px-5 inline-flex justify-between items-center text-sm text-gray-600 border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 rounded-b-xl dark:border-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                            {{$t('View reports')}}
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div v-for="metric in filteredMetrics" :key="metric.site.id" class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                        <div class="p-4 md:p-5 flex justify-between gap-x-3">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                    {{$t('Pending')}}
                                </p>
                                <div class="mt-1 flex items-center gap-x-2">
                                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                        {{ metric.totalPending }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-800 dark:text-neutral-200">
                                        {{$t('from')}}
                                    </p>
                                    <h3 class="mt-1 text-xl font-medium text-gray-800 dark:text-neutral-200">
                                        {{ metric.totalInvoices }}
                                    </h3>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2">
                                    <p class="mt-1 text-sm text-gray-800 dark:text-neutral-200">
                                        {{$t('Amount')}}:
                                    </p>
                                    <h3 class="mt-1 text-xl font-medium text-gray-800 dark:text-neutral-200">
                                        ${{ metric.totalPendingAmount}}
                                    </h3>
                                </div>
                            </div>
                            <div class="shrink-0 flex justify-center items-center size-[46px] bg-orange-500 text-white rounded-full dark:bg-orange-900 dark:text-orange-200">
                                <font-awesome-icon :icon="['fas', 'hourglass-half']" />
                            </div>
                        </div>

                        <a class="py-3 px-4 md:px-5 inline-flex justify-between items-center text-sm text-gray-600 border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 rounded-b-xl dark:border-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                            {{$t('View reports')}}
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    </div>
                    <!-- End Card -->

                    <!-- Card -->
                    <div v-for="metric in filteredMetrics" :key="metric.site.id" class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
                        <div class="p-4 md:p-5 flex justify-between gap-x-3">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                    {{$t('Overdue')}}
                                </p>
                                <div class="mt-1 flex items-center gap-x-2">
                                    <h3 class="mt-1 text-xl font-medium text-gray-800 dark:text-neutral-200">
                                        {{ metric.totalOverdue }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-800 dark:text-neutral-200">
                                        {{$t('from')}}
                                    </p>
                                    <h3 class="mt-1 text-xl font-medium text-gray-800 dark:text-neutral-200">
                                        {{ metric.totalInvoices }}
                                    </h3>
                                </div>
                                <div class="mt-1 flex items-center gap-x-2">
                                    <p class="mt-1 text-sm text-gray-800 dark:text-neutral-200">
                                        {{$t('Amount')}}:
                                    </p>
                                    <h3 class="mt-1 text-xl font-medium text-gray-800 dark:text-neutral-200">
                                        ${{ metric.totalOverdueAmount}}
                                    </h3>
                                </div>
                            </div>
                            <div class="shrink-0 flex justify-center items-center size-[46px] bg-orange-500 text-white rounded-full dark:bg-orange-900 dark:text-orange-200">
                                <font-awesome-icon :icon="['fas', 'ban']" />
                            </div>
                        </div>

                        <a class="py-3 px-4 md:px-5 inline-flex justify-between items-center text-sm text-gray-600 border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 rounded-b-xl dark:border-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                            {{$t('View reports')}}
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>

                    </div>
                    <!-- End Card -->
                </div>


                <!-- Card -->
                <div  v-if="form.site_id && form.site_id !== 'all'" class="mt-10 p-4 md:p-5 min-h-[410px] flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <!-- Header -->
                    <div  v-for="metric in filteredMetrics" :key="metric.site.id"  class="flex justify-between items-center">
                        <div>
                            <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                                {{$t('Total Invoices')}}
                            </h2>
                            <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                ${{ metric.totalAmount}}
                            </p>
                        </div>

                        <div>
                            <span class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-orange-100 text-orange-800 dark:bg-teal-500/10 dark:text-teal-500">
                                <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                                %
                            </span>
                        </div>
                    </div>
                    <!-- End Header -->
                    <PieChart :selectedSite="filteredMetrics"/>
                </div>
                <!-- End Card -->
                <!-- End Grid -->

                <!-- Card -->
                <div  v-if="form.site_id && form.site_id !== 'all'" class="mt-10 p-4 md:p-5 min-h-[410px] flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <!-- Header -->
                    <div v-for="metric in filteredMetrics" :key="metric.site.id" class="flex justify-between items-center">
                        <div>
                            <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                                {{$t('Paid Invoices vs Pending Invoices')}}
                            </h2>
                            <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                ${{ metric.totalPaidAmount}}
                            </p>
                        </div>
                        <div>
                            <span class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-orange-100 text-orange-800 dark:bg-teal-500/10 dark:text-teal-500">
                                <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                                %
                            </span>
                        </div>
                    </div>
                    <!-- End Header -->
                    <BarChart :selectedSite="filteredMetrics"/>
                </div>
                <!-- End Card -->
                <!-- End Grid -->

                <!-- Card -->
                <div  v-for="metric in filteredMetrics" :key="metric.site.id" class="mt-10 p-4 md:p-5 min-h-[410px] flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                    <!-- Header -->
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                                {{$t('Pending Invoices vs Overdue Invoices')}}
                            </h2>
                            <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                ${{ metric.totalPendingAmount}}
                            </p>
                        </div>

                        <div>
                            <span class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-orange-100 text-orange-800 dark:bg-teal-500/10 dark:text-teal-500">
                                <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                                {{ metric.pendingToOverdueRatio }}%
                            </span>
                        </div>
                    </div>
                    <!-- End Header -->
                    <HorizontalBarChart :selectedSite="filteredMetrics"/>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Card Section -->
                <!-- End Grid -->
            </div>
            <!-- End Card Section -->
        </div>
</template>

<style scoped>

</style>

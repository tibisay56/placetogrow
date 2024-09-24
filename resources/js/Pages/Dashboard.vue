<script setup>
import Layout from "@/Components/Layout.vue";
import {onMounted, ref} from "vue";
import ApexCharts from 'apexcharts';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const props = defineProps([
    'totalpaidInvoices',
    'totalpendingInvoices',
    'totaloverdueInvoices',
    'totalPaidAmount',
    'totalPendingAmount',
    'totalOverdueAmount']);

const totalPaidInvoices = ref(props.totalpaidInvoices);
const totalPendingInvoices = ref(props.totalpendingInvoices);
const totalOverdueInvoices = ref(props.totaloverdueInvoices);

const totalPaidAmount = ref(props.totalPaidAmount);
const totalPendingAmount = ref(props.totalPendingAmount);
const totalOverdueAmount = ref(props.totalOverdueAmount);

const difference = totalPaidAmount.value - totalPendingAmount.value;
const percentagePaid = ((totalPaidAmount.value / (totalPaidAmount.value + totalPendingAmount.value)) * 100).toFixed(2);

const difference2 = totalPendingAmount.value - totalOverdueAmount.value;
const percentagePaid2 = ((totalPendingAmount.value / (totalPendingAmount.value + totalOverdueAmount.value)) * 100).toFixed(2);

onMounted(() => {
    const barOptions1 = {
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            zoom: { enabled: false },
        },
        series: [
            {
                name: "Paid Invoices",
                data: [totalPaidAmount.value],
            },
            {
                name: "Pending Invoices",
                data: [totalPendingAmount.value],
            },
        ],
        colors: ['#cfc9c9', '#9494b8'],
        plotOptions: {
            bar: {
                columnWidth: '50%',
            },
        },
        xaxis: {
            categories: ['September'],
        },
    };

    const barChart1 = new ApexCharts(document.querySelector("#paid-vs-pending-chart"), barOptions1);
    barChart1.render();

    const barOptions2 = {
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            zoom: { enabled: false },
        },
        series: [
            {
                name: "Pending Invoices",
                data: [totalPendingAmount.value],
            },
            {
                name: "Overdue Invoices",
                data: [totalOverdueAmount.value],
            },
        ],
        colors: ['#9fbfdf', '#c2d6d6'],
        plotOptions: {
            bar: {
                columnWidth: '50%',
            },
        },
        xaxis: {
            categories: ['September'],
        },
    };

    const barChart2 = new ApexCharts(document.querySelector("#pending-vs-overdue-chart"), barOptions2);
    barChart2.render();
});



</script>

<template>
        <Layout></Layout>
                        <!-- Content -->
            <div class="w-full lg:ps-64 -mt-12">
                <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Dashboard') }}</h2>

                            <!-- Card Section -->
                            <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                                <!-- Grid -->
                                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6">
                                    <!-- Card -->
                                    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800 h-38">
                                        <div class="p-4 md:p-5 flex justify-between gap-x-3 h-full">
                                            <div>
                                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                                    Total Paid Invoices
                                                </p>
                                                <div class="mt-1 flex items-center gap-x-2">
                                                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                                        {{ totalPaidInvoices }}
                                                    </h3>
                                                    <span class="flex items-center gap-x-1 text-green-600">
                                                      <svg class="inline-block size-5 self-center" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                                                      <span class="inline-block text-lg">
                                                        1.7%
                                                      </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="shrink-0 flex justify-center items-center size-[46px] bg-orange-500 text-white rounded-full dark:bg-blue-900 dark:text-orange-200">
                                                <font-awesome-icon :icon="['fas', 'user-check']" />
                                            </div>
                                        </div>

                                        <a class="py-3 px-4 md:px-5 inline-flex justify-between items-center text-sm text-gray-600 border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 rounded-b-xl dark:border-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                                            View reports
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                        </a>
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800 h-38">
                                        <div class="p-4 md:p-5 flex justify-between gap-x-3 h-full">
                                            <div>
                                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                                    Total Pending Invoices
                                                </p>
                                                <div class="mt-1 flex items-center gap-x-2">
                                                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                                        {{ totalPendingInvoices }}
                                                    </h3>
                                                    <span class="flex items-center gap-x-1 text-green-600">
                                                      <svg class="inline-block size-5 self-center" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                                                      <span class="inline-block text-lg">
                                                        1.7%
                                                      </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="shrink-0 flex justify-center items-center size-[46px] bg-orange-500 text-white rounded-full dark:bg-orange-900 dark:text-blue-200">
                                                <font-awesome-icon :icon="['fas', 'hourglass-half']" />
                                            </div>
                                        </div>

                                        <a class="py-3 px-4 md:px-5 inline-flex justify-between items-center text-sm text-gray-600 border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 rounded-b-xl dark:border-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                                            View reports
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                        </a>
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800 h-38">
                                        <div class="p-4 md:p-5 flex justify-between gap-x-3 h-full">
                                            <div>
                                                <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500">
                                                    Total Overdue Invoices
                                                </p>
                                                <div class="mt-1 flex items-center gap-x-2">
                                                    <h3 class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                                        {{ totalOverdueInvoices }}
                                                    </h3>
                                                    <span class="flex items-center gap-x-1 text-red-600">
                                                      <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
                                                      <span class="inline-block text-lg">
                                                        1.7%
                                                      </span>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="shrink-0 flex justify-center items-center size-[46px] bg-orange-500 text-white rounded-full dark:bg-orange-900 dark:text-blue-200">
                                                <font-awesome-icon :icon="['fas', 'ban']" />
                                            </div>
                                        </div>

                                        <a class="py-3 px-4 md:px-5 inline-flex justify-between items-center text-sm text-gray-600 border-t border-gray-200 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 rounded-b-xl dark:border-neutral-800 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" href="#">
                                            View reports
                                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                        </a>
                                    </div>
                                    <!-- End Card -->
                                </div>
                                <!-- Card -->
                                <div class="mt-10 p-4 md:p-5 min-h-[410px] flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                                    <!-- Header -->
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                                                Paid Invoices vs Pending Invoices
                                            </h2>
                                            <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                                ${{ difference }}
                                            </p>
                                        </div>

                                        <div>
                                          <span class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-orange-100 text-orange-800 dark:bg-teal-500/10 dark:text-teal-500">
                                            <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                                            {{ percentagePaid }}%
                                          </span>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <div id="paid-vs-pending-chart"></div>
                                </div>
                                <!-- End Card -->
                                <!-- End Grid -->

                                <!-- Card -->
                                <div class="mt-10 p-4 md:p-5 min-h-[410px] flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                                    <!-- Header -->
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h2 class="text-sm text-gray-500 dark:text-neutral-500">
                                                Pending Invoices vs Overdue Invoices
                                            </h2>
                                            <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200">
                                                ${{ difference2 }}
                                            </p>
                                        </div>

                                        <div>
                                          <span class="py-[5px] px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-md bg-orange-100 text-orange-800 dark:bg-teal-500/10 dark:text-teal-500">
                                            <svg class="inline-block size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>
                                            {{ percentagePaid2 }}%
                                          </span>
                                        </div>
                                    </div>
                                    <!-- End Header -->

                                    <div id="pending-vs-overdue-chart"></div>
                                </div>
                                <!-- End Card -->
                            </div>
                            <!-- End Card Section -->
                        </div>
                    </div>


</template>

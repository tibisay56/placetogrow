<template>
    <div class="p-4">
        <div class="h-[300px] flex flex-col justify-center items-center">
            <div id="hs-pie-chart" class="w-full h-full"></div>

            <!-- Legend Indicator -->
            <div class="flex justify-center sm:justify-end items-center gap-x-4 mt-3 sm:mt-6">
                <div class="inline-flex items-center">
                    <span class="size-2.5 inline-block bg-blue-600 rounded-sm me-2"></span>
                    <span class="text-[13px] text-gray-600 dark:text-neutral-400">{{$t('Paid')}}</span>
                </div>
                <div class="inline-flex items-center">
                    <span class="size-2.5 inline-block bg-cyan-500 rounded-sm me-2"></span>
                    <span class="text-[13px] text-gray-600 dark:text-neutral-400">{{$t('Pending')}}</span>
                </div>
                <div class="inline-flex items-center">
                    <span class="size-2.5 inline-block bg-gray-300 rounded-sm me-2 dark:bg-neutral-700"></span>
                    <span class="text-[13px] text-gray-600 dark:text-neutral-400">{{$t('Overdue')}}</span>
                </div>
            </div>
            <!-- End Legend Indicator -->
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch, onBeforeUnmount } from 'vue';
import ApexCharts from 'apexcharts';

const props = defineProps(['selectedSite']);
let chart = null;

const buildPieChart = () => {
    if (!props.selectedSite || props.selectedSite.length === 0) {
        return;
    }

    const siteData = props.selectedSite[0];

    const chartElement = document.querySelector("#hs-pie-chart");
    if (!chartElement) {
        return;
    }

    if (chart) {
        chart.destroy();
    }

    const percentagePaid = parseFloat(siteData.percentagePaid) || 0;
    const percentagePending = parseFloat(siteData.percentagePending) || 0;
    const percentageOverdue = parseFloat(siteData.percentageOverdue) || 0;

    const chartOptions = {
        chart: {
            height: '100%',
            type: 'pie',
            zoom: {
                enabled: false
            }
        },
        series: [percentagePaid, percentagePending, percentageOverdue],
        labels: ['Paid', 'Pending','InvoiceOverdue'],
        dataLabels: {
            style: {
                fontSize: '20px',
                fontWeight: '400',
                colors: ['#fff']
            },
            formatter: (value) => `${value.toFixed(1)} %`
        },
        colors: ['#3b82f6', '#22d3ee', '#e5e7eb'],
    };

    chart = new ApexCharts(chartElement, chartOptions);
    chart.render();
};

onMounted(() => {
    buildPieChart();
});

watch(() => props.selectedSite, (newValue) => {
    buildPieChart();
});

onBeforeUnmount(() => {
    if (chart) {
        chart.destroy();
    }
});
</script>

<style scoped>
</style>



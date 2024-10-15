<template>
    <!-- Legend Indicator -->
    <div class="flex justify-center sm:justify-end items-center gap-x-4 mb-3 sm:mb-6">
        <div class="inline-flex items-center">
            <span class="size-2.5 inline-block bg-cyan-400 rounded-sm me-2"></span>
            <span class="text-[13px] text-gray-600 dark:text-neutral-400">
      Paid
    </span>
        </div>
        <div class="inline-flex items-center">
            <span class="size-2.5 inline-block bg-gray-300 rounded-sm me-2 dark:bg-neutral-700"></span>
            <span class="text-[13px] text-gray-600 dark:text-neutral-400">
     Pending
    </span>
        </div>
    </div>
    <!-- End Legend Indicator -->

    <div id="hs-multiple-bar-charts"></div>

</template>

<script setup>
import ApexCharts from 'apexcharts';
import {onBeforeUnmount, onMounted, watch} from "vue";

const props = defineProps(['selectedSite']);
let chart = null;

const buildBarChart = () => {

    if (!props.selectedSite || props.selectedSite.length === 0) {
        return;
    }

    const chartElement = document.querySelector("#hs-multiple-bar-charts");
    if (!chartElement) {
        return;
    }

    if (chart) {
        chart.destroy();
    }
    const siteData = props.selectedSite[0];

    const totalPaidAmount = parseFloat(siteData.totalPaidAmount) || 0;
    const totalPendingAmount = parseFloat(siteData.totalPendingAmount) || 0;

    const options = {
        chart: {
            type: 'bar',
            height: 300,
            toolbar: { show: false },
            zoom: { enabled: false },
        },
        series: [
            { name: 'Paid', data: [totalPaidAmount] },
            { name: 'Pending', data: [totalPendingAmount] }
        ],
        colors: ['#22d3ee', '#e5e7eb'],
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                borderRadius: 0
            }
        },
        legend: { show: false },
        dataLabels: { enabled: false },
        stroke: {
            show: true,
            width: 8,
            colors: ['transparent']
        },
        xaxis: {
            categories: ['October'],
            labels: {
                style: { colors: '#9ca3af', fontSize: '13px', fontFamily: 'arial', fontWeight: 400 },
                offsetX: -2,
                formatter: (title) => title.slice(0, 3)
            }
        },
        yaxis: {
            labels: {
                style: { colors: '#9ca3af', fontSize: '13px', fontFamily: 'arial', fontWeight: 400 },
                formatter: (value) => value
            }
        },
        tooltip: {
            y: { formatter: (value) => `$${value}` }
        },
        responsive: [{
            breakpoint: 568,
            options: {
                chart: { height: 300 },
                plotOptions: { bar: { columnWidth: '50%' } },
                stroke: { width: 8 },
                labels: {
                    style: { colors: '#9ca3af', fontSize: '11px', fontFamily: 'arial', fontWeight: 400 },
                    offsetX: -2,
                    formatter: (title) => title.slice(0, 3)
                },
                yaxis: {
                    labels: {
                        style: { colors: '#9ca3af', fontSize: '11px', fontFamily: 'arial', fontWeight: 400 },
                        formatter: (value) => value >= 1000 ? `${value / 1000}` : value
                    }
                }
            }
        }]
    };
    chart = new ApexCharts(document.querySelector('#hs-multiple-bar-charts'), options);
    chart.render();
};

onMounted(() => {
    buildBarChart();
});

watch(() => props.selectedSite, (newValue) => {
    console.log('New selectedSite value:', newValue);
    buildBarChart();
});

onBeforeUnmount(() => {
    if (chart) {
        chart.destroy();
    }
});

</script>

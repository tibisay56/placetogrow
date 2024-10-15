<template>

    <div id="hs-horizontal-bar-chart"></div>
</template>

<script setup>
import ApexCharts from 'apexcharts';
import {onBeforeUnmount, onMounted, watch} from "vue";

const props = defineProps(['selectedSite']);
let chart = null;

const buildHorizontalBarChart = () => {

    if (!props.selectedSite || props.selectedSite.length === 0) {
        return;
    }

    const chartElement = document.querySelector("#hs-horizontal-bar-chart");
    if (!chartElement) {
        return;
    }

    if (chart) {
        chart.destroy();
    }
    const siteData = props.selectedSite[0];

    const totalPendingAmount = parseFloat(siteData.totalPendingAmount) || 0;
    const totalOverdueAmount = parseFloat(siteData.totalOverdueAmount) || 0;

            const options = {
                chart: {
                    type: 'bar',
                    height: 300,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                series: [
                    { name: 'Pending', data: [totalPendingAmount] },
                    { name: 'Overdue', data: [totalOverdueAmount] }
                ],
                colors: ['#22d3ee', '#e5e7eb'],
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: '16px',
                        borderRadius: 0
                    }
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: [
                        'October',
                    ],
                    crosshairs: {
                        show: false
                    },
                    labels: {
                        style: {
                            colors: '#9ca3af',
                            fontSize: '13px',
                            fontFamily: 'arial',
                            fontWeight: 400
                        },
                        offsetX: -2,
                        formatter: (value) => value >= 1000 ? `${value / 1000}` : value
                    }
                },
                yaxis: {
                    crosshairs: {
                        show: false
                    },
                    labels: {
                        align: 'left',
                        minWidth: 0,
                        maxWidth: 140,
                        style: {
                            colors: '#9ca3af',
                            fontSize: '13px',
                            fontFamily: 'arial',
                            fontWeight: 400
                        },
                        offsetX: -10,
                        formatter: (value) => value
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'darken',
                            value: 0.9
                        }
                    }
                },
                tooltip: {
                    y: {
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
                }
            };

    chart = new ApexCharts(chartElement, options);
    chart.render();
};


onMounted(() => {
    buildHorizontalBarChart();
});

watch(() => props.selectedSite, (newValue) => {
    console.log('New selectedSite value:', newValue);
    buildHorizontalBarChart();
});

onBeforeUnmount(() => {
    if (chart) {
        chart.destroy();
    }
});

</script>

<style scoped>
</style>


<script setup>

import {ref} from "vue";

const months = [
    'January',
    'February',
    'March',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'December'
];
const years = [
    '2023',
    '2024',
    '2025'
];
const selectedMonth = ref(9);
const selectedYear = ref(1);

const selectedDay = ref(null);
const selectedDate = ref(null);

const emit = defineEmits(['update:selectedDate']);
const selectDay = (day) => {
    const month = (selectedMonth.value + 1).toString().padStart(2, '0');
    const formattedDay = day.toString().padStart(2, '0');
    selectedDay.value = day;

    const date = new Date(`${years[selectedYear.value]}-${month}-${formattedDay}T00:00:00`);
    selectedDate.value = date.toISOString().split('T')[0];

    console.log("Fecha seleccionada:", selectedDate.value);
    emit('update:selectedDate', selectedDate.value);
};
const previousMonth = () => {
    if (selectedMonth.value > 0) {
        selectedMonth.value--;
    } else {
        selectedMonth.value = 11;
    }
};

const nextMonth = () => {
    if (selectedMonth.value < 11) {
        selectedMonth.value++;
    } else {
        selectedMonth.value = 0;
    }
};

</script>

<template>
    <div class="w-80 flex flex-col bg-white border shadow-lg rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">
        <!-- Calendar -->
        <div class="p-3 space-y-0.5">
            <!-- Months -->
            <div class="grid grid-cols-5 items-center gap-x-3 mx-1.5 pb-3">
                <!-- Prev Button -->
                <div class="col-span-1">
                    <button @click="previousMonth" type="button" class="size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-label="Previous">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    </button>
                </div>
                <!-- End Prev Button -->

                <!-- Month / Year -->
                <div class="col-span-3 flex justify-center items-center gap-x-1">
                    <div class="relative">
                        {{ months[selectedMonth] }}
                    </div>

                    <span class="text-gray-800 dark:text-neutral-200">/</span>

                    <div class="relative">
                        {{ years[selectedYear] }}
                    </div>
                </div>
                <!-- End Month / Year -->
                <!-- Next Button -->
                <div class="col-span-1 flex justify-end">
                    <button @click="nextMonth" type="button" class=" size-8 flex justify-center items-center text-gray-800 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800" aria-label="Next">
                        <svg class="shrink-0 size-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                    </button>
                </div>
                <!-- End Next Button -->
            </div>
            <!-- Months -->

            <!-- Weeks -->
            <div class="flex pb-1.5">
                <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">Mo</span>
                <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">Tu</span>
                <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">We</span>
                <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">Th</span>
                <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">Fr</span>
                <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">Sa</span>
                <span class="m-px w-10 block text-center text-sm text-gray-500 dark:text-neutral-500">Su</span>
            </div>
            <!-- Weeks -->
            <div class="flex flex-wrap">
                <div v-for="day in 31" :key="day" class="w-10">
                    <button
                        @click="selectDay(day)"
                        type="button"
                        class="m-px size-10 flex justify-center items-center border border-transparent text-sm text-gray-800 rounded-full hover:border-orange-500 hover:text-orange-500 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:border-orange-500 focus:text-orange-500 dark:text-neutral-200"
                    >
                        {{ day }}
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-4 text-center">
            <p v-if="selectedDate" class="text-gray-800 dark:text-neutral-200">
                Selected Date: {{ selectedDate }}
            </p>
        </div>
    </div>
</template>

<style scoped>

</style>

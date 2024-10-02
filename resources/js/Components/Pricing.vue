<script setup>
import { usePage, Link} from '@inertiajs/vue3';
import { ref } from "vue";

const { props } = usePage();
const plans = ref(props.plans || []);
const selectedPlan = ref(null);

const emit = defineEmits(['plan-selected']);

function selectPlan(planId) {
    emit('plan-selected', planId);
    emit('plan-selected', planId);
    console.log("Plan seleccionado:", planId);
}



</script>

<template>
    <!-- Pricing -->
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 ml-48">
        <!-- Grid -->
        <div  v-if="plans.length" class="mt-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:items-center">
            <!-- Card -->
            <div v-for="plan in plans" :key="plan.id" class="flex flex-col border border-gray-200 text-center rounded-xl p-8 dark:border-neutral-800">
                <p class="mb-3"><span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-xs uppercase font-semibold bg-orange-100 text-orange-800 dark:bg-orange-600 dark:text-white">{{ plan.billing_frequency }}</span></p>
                <h4 class="font-medium text-lg text-gray-800 dark:text-neutral-200"> {{ plan.name }} </h4>
                <span class="mt-7 font-bold text-5xl text-gray-800 dark:text-neutral-200"> ${{ plan.amount }}</span>
                <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500"> {{ plan.description }}</p>
                <ul class="mt-7 space-y-2.5 text-sm">
                    <li class="flex gap-x-2">
                        <svg class="shrink-0 mt-0.5 size-4 text-orange-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-800 dark:text-neutral-400">
                            1 user
                          </span>
                    </li>
                    <li class="flex gap-x-2">
                        <svg class="shrink-0 mt-0.5 size-4 text-orange-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-800 dark:text-neutral-400">
                        Plan features
                      </span>
                    </li>
                    <li class="flex gap-x-2">
                        <svg class="shrink-0 mt-0.5 size-4 text-orange-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        <span class="text-gray-800 dark:text-neutral-400">
                        Product support
                      </span>
                    </li>
                </ul>
                <button
                    @click="selectPlan(plan.id)"
                    class="mt-5 py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:bg-orange-600 focus:text-white active:bg-orange-700 disabled:opacity-50 disabled:pointer-events-none">
                    Sign up
                </button>
            </div>
            <!-- End Card -->
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Pricing -->
</template>


<style scoped>

</style>

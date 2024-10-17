<script setup>

import {ref, watch} from 'vue';
import { useForm } from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";

const props = defineProps({
    selectedPlan: {
        type: Number,
        default: null
    }
});


const emit = defineEmits(['update-step']);


const form = useForm ({
    email:"",
    reference:"",
    plan_id: props.selectedPlan
});

watch(() => props.selectedPlan, (newPlanId) => {
    console.log("New Plan ID in watcher:", newPlanId);
    form.plan_id = newPlanId;
});

const submit = () => {
    console.log("Plan ID before submitting:", form.plan_id);
    form.post(route('subscription.store'), {
        onSuccess: () => {
            emit('update-step', 3);
        }
    });
};


</script>

<template>
        <div class="flex justify-center p-4 sm:p-7">
            <div class="mt-5 w-full max-w-sm">
                <div class="flex justify-center mb-4">
                <svg class="items-center shrink-0 mt-2 size-10 text-orange-600 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                    <!-- Form -->
                <form @submit.prevent="submit">
                    <div class="grid gap-y-4">

                        <!-- Form Group -->
                        <div>
                            <div class="relative">
                                <input type="email" id="email" name="email"  v-model="form.email"  placeholder="Email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required aria-describedby="email-error">
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div>
                            <div class="relative">
                                <input type="text" id="reference" name="reference"  v-model="form.reference"  placeholder="Reference" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required aria-describedby="reference-error">
                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                    </svg>
                                </div>
                            </div>
                            <InputError class="mt-2" :message="form.errors.reference" />
                        </div>
                        <!-- End Form Group -->
                    </div>
                </form>
                <!-- End Form -->
            </div>
        </div>
</template>

<style scoped>

</style>

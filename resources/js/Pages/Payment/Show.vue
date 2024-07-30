<script setup>
import { usePage } from "@inertiajs/vue3";

const { props } = usePage();
const payment = props.payment;
</script>

<template>

    <!-- Card Section -->
    <div class="max-w-4xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <form>
            <!-- Card -->
            <div class="bg-white rounded-xl shadow dark:bg-neutral-900">
                <div class="relative h-40 rounded-t-xl bg-[url('https://www.evertecinc.com/wp-content/uploads/2022/04/Evertec-lanza-nueva-plataforma-de-pagos-en-linea.jpg')] bg-no-repeat bg-cover bg-center">
                </div>

                <div class="pt-0 p-4 sm:pt-0 sm:p-7">
                    <!-- Grid -->
                    <div class="space-y-4 sm:space-y-6">
                        <div>
                            <label class="sr-only">
                                Product photo
                            </label>

                            <div class="flex flex-col items-center  sm:flex-row sm:items-center sm:gap-x-5">
                                <img class="-mt-8 relative z-10 size-24 rounded-full ring-4 ring-white dark:ring-neutral-900 mx-auto"
                                     src="/Documents/check.jpg" alt="Avatar">
                            </div>
                            <div class="bg-white items-center border-b  sm:items-center rounded-t-xl py-2 px-3 dark:bg-neutral-900 dark:border-neutral-700">
                                <h3 class="text-lg font-bold text-orange-500 dark:text-white">
                                    Payment Completed Succesfully!!
                                </h3>
                                <p class="mt-2 text-gray-500 dark:text-neutral-400">Thank you for your payment. We will be in contact shortly </p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center space-y-4">
                            <div class="w-full max-w-sm">
                                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 mx-auto">
                                    <div class="bg-white border-b rounded-t-xl py-2 px-3 dark:bg-neutral-900 dark:border-neutral-700">
                                        <h3 class="text-lg font-bold text-orange-500 dark:text-white">
                                            Payment Description
                                        </h3>
                                    </div>
                                    <div class="p-3 dark:bg-neutral-900">
                                        <p class="mt-2 text-gray-500 dark:text-neutral-400">
                                            {{ payment.description }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full max-w-sm">
                                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 mx-auto">
                                    <div class="bg-white border-b rounded-t-xl py-2 px-3 dark:bg-neutral-900 dark:border-neutral-700">
                                        <h3 class="text-lg font-bold text-orange-500 dark:text-white">
                                            Amount
                                        </h3>
                                    </div>
                                    <div class="p-3 dark:bg-neutral-900">
                                        <p class="mt-2 text-gray-500 dark:text-neutral-400">
                                            {{ payment.amount }} {{ payment.currency }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full max-w-sm">
                                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 mx-auto">
                                    <div class="bg-white border-b rounded-t-xl py-2 px-3 dark:bg-neutral-900 dark:border-neutral-700">
                                        <h3 class="text-lg font-bold text-orange-500 dark:text-white">
                                            Status
                                        </h3>
                                    </div>
                                    <div class="p-3 dark:bg-neutral-900">
                                        <p class="mt-2 text-gray-500 dark:text-neutral-400">
                                            {{ payment.status }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full max-w-sm">
                                <div class="flex flex-col bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70 mx-auto">
                                    <div class="bg-white border-b rounded-t-xl py-2 px-3 dark:bg-neutral-900 dark:border-neutral-700">
                                        <h3 class="text-lg font-bold text-orange-500 dark:text-white">
                                            Date
                                        </h3>
                                    </div>
                                    <div class="p-3 dark:bg-neutral-900">
                                        <p class="mt-2 text-gray-500 dark:text-neutral-400">
                                            {{ payment.created_at }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                        <!-- End Grid -->

                    <div class="mt-5 flex justify-center gap-x-2">
                        <button type="button" class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-orange-400 text-white hover:bg-orange-600 focus:outline-none focus:bg-orange-400 disabled:opacity-50 disabled:pointer-events-none">
                            Done
                        </button>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </form>
    </div>
    <!-- End Card Section -->

</template>

<style scoped>

</style>

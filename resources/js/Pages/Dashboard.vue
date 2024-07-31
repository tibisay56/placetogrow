<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Layout from "@/Components/Layout.vue";
</script>

<template>
        <Layout></Layout>
                        <!-- Content -->
            <div class="w-full lg:ps-64 -mt-12">
                <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $t('Dashboard') }}</h2>
                    <div class="py-12">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">{{ $t('You\'re logged in!') }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ref } from 'vue';
import Layout from "@/Components/Layout.vue";

const page = usePage()
const site = ref(page.props.site);
const types = ref(page.props.types);
const currencies = ref(page.props.currencies);

const initialValues = {
    name: site.value.name,
    avatar:null,
    type_id: site.value.type_id,
    category: site.value.category,
    currency: site.value.currency,
    payment_expiration_time: 30,
}
const form = useForm(initialValues);

const props = defineProps({
    types: Array,
    currencies: Array,
});

</script>

<template>
    <Head title="Show Sites" />

    <AuthenticatedLayout>
        <Layout></Layout>
        <!-- Content -->
        <div class="w-full lg:ps-64">
            <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
                <!-- Card -->
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-neutral-800 dark:border-neutral-700">
                                <!-- Header -->
                                <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                                    <div>
                                        <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                            {{ $t('Show Sites') }}
                                        </h2>
                                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                                            {{ $t('Add sites, edit and more.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <div class="inline-flex gap-x-2">
                                            <Link :href="route('site.index')">
                                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                    {{ $t('View all') }}
                                                </a>
                                            </Link>
                                            <Link :href="route('site.create')">
                                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" >
                                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                    {{ $t('Add site') }}
                                                </a>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Header -->
                                <div class="py-12">
                                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                                        <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                            <form class="w-1/2 py-5 space-y-3">
                                                <Transition
                                                    enter-active-class="transition ease-in-out"
                                                    enter-from-class="opacity-0"
                                                    leave-active-class="transition ease-in-out"
                                                    leave-to-class="opacity-0"
                                                >
                                                    <p v-if="form.recentlySuccessful" class="text-sm text-green-600 text-center" >{{ $t('Site updated') }} </p>
                                                </Transition>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                                                <div>
                                                    <InputLabel for="name" :value="$t('Name')" />
                                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                                                    <InputError class="mt-2" :message="form.errors.name" />
                                                </div>
                                                <div>
                                                    <InputLabel for="type_id" :value="$t('Type')" />
                                                    <select v-model="form.type_id" name="type_id" id="type_id"
                                                            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                        <option v-for="(type, index) in types" :key="index+1" :value="index+1">{{ $t(type) }}</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="form.errors.type_id" />
                                                </div>
                                                </div>
                                                <div>
                                                    <InputLabel for="category" :value="$t('Category')" />
                                                    <TextInput id="category" type="text" class="mt-1 block w-full" v-model="form.category" />
                                                    <InputError class="mt-2" :message="form.errors.category" />
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                                                <div>
                                                    <InputLabel for="currency" :value="$t('Currency')" />
                                                    <select v-model="form.currency" name="currency" id="currency"
                                                            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                        <option v-for="currency in currencies" :key="currency" :value="currency">{{ currency }}</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="form.errors.currency" />
                                                </div>
                                                <div>
                                                    <InputLabel for="payment_expiration_time" :value="$t('Payment Expiration Time')" />
                                                    <TextInput id="payment_expiration_time" type="number" class="mt-1 block w-full" v-model="form.payment_expiration_time" />
                                                    <InputError class="mt-2" :message="form.errors.payment_expiration_time" />
                                                </div>
                                                </div>
                                                <div>
                                                    <img class="h-16" :src="`/storage/${site.avatar}`" />
                                                </div>
                                                <div class="mt-4">
                                                    <InputLabel for="avatar" value="Logo" />
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<script setup>
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Layout from "@/Components/Layout.vue";
import {ref} from "vue";

const page = usePage();
const plan = ref(page.props.plan);
const billingFrequencies = ref(page.props.billingFrequencies);
const currencies = ref(page.props.currencies);
const planTypes = ref(page.props.planTypes || []);
const sites = ref(page.props.sites || []);

const form = useForm({
    name: plan.value.name,
    plan_type_id: plan.value.plan_type_id,
    description: plan.value.description,
    currency: plan.value.currency,
    amount: plan.value.amount,
    billing_frequency: plan.value.billing_frequency,
    subscription_expiration: plan.value.subscription_expiration,
    site_id: plan.value.site_id || null,
});

const submit = () => {
    form.post(route('subscription.store'));
};


const props = defineProps({
    billingFrequencies: Array,
    currencies: Array,
});
const capitalize = (text) => {
    if (!text) return '';
    return text.charAt(0).toUpperCase() + text.slice(1).toLowerCase();
};

</script>

<template>
    <Head title="Show Plans" />
    <Layout></Layout>
    <!-- Content -->
    <div class="w-full lg:ps-64 -mt-12">
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
                                        {{ $t('Show Plans') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-neutral-400">
                                        {{ $t('Add plans, edit and more.') }}
                                    </p>
                                </div>
                                <div>
                                    <div class="inline-flex gap-x-2">
                                        <Link :href="route('plan.index')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                {{ $t('View all') }}
                                            </a>
                                        </Link>
                                        <Link :href="route('plan.create')">
                                            <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none" >
                                                <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                {{ $t('Add plan') }}
                                            </a>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                            <!-- End Header -->
                            <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
                                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                    <form class="w-1/2 py-5 space-y-3" @submit.prevent="submit">
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">

                                            <div class="mt-4">
                                                <InputLabel for="site_id" :value="$t('Site')" />
                                                <select v-model="form.site_id" name="sites_id" id="site_id"
                                                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option v-for="site in sites" :key="site.id" :value="site.id" >
                                                        {{ site.name }}
                                                    </option>
                                                </select>
                                                <InputError class="mt-2" :message="form.errors.site_id" />
                                            </div>
                                            <div class="mt-4">
                                                <InputLabel for="name" :value="$t('Name')" />
                                                <TextInput v-model="form.name" id="name" type="text" class="mt-1 block w-full" autocomplete="name" :placeholder="$t('Name')"/>
                                                <InputError class="mt-2" :message="form.errors.name" />
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">

                                            <div class="mt-4">
                                                <InputLabel for="plan_type_id" :value="$t('Plan Type')" />
                                                <select v-model="form.plan_type_id" name="plan_type_id" id="plan_type_id"
                                                        class="capitalize w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option v-for="(planType, index) in planTypes" :key="index+1" :value="index+1">{{ $t(planType) }} </option>
                                                </select>
                                                <InputError class="mt-2" :message="form.errors.plan_type_id || ''" />
                                            </div>
                                            <div class="mt-4">
                                                <InputLabel for="description" :value="$t('Description')" />
                                                <TextInput v-model="form.description" id="name" type="text" class="mt-1 block w-full" autocomplete="name" :placeholder="$t('Description')"/>
                                                <InputError class="mt-2" :message="form.errors.description" />
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">

                                            <div>
                                                <InputLabel for="amount" :value="$t('Amount')" />
                                                <input v-model="form.amount" type="number" id="amount" class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Amount"><InputError :message="form.errors.amount" class="mt-2"/>

                                            </div>
                                            <div>
                                                <InputLabel for="currency" :value="$t('Currency')" />
                                                <select v-model="form.currency" name="currency" id="currency"
                                                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option v-for="currency in currencies" :key="currency" :value="currency">{{ currency }}</option>
                                                </select>
                                                <InputError class="mt-2" :message="form.errors.currency" />
                                            </div>
                                            <div>
                                                <InputLabel for="billingFrequency" :value="$t('Billing Frequency')" />
                                                <select v-model="form.billingFrequency" name="billingFrequency" id="billingFrequency"
                                                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                    <option v-for="frequency in billingFrequencies" :key="frequency.value" :value="frequency.value">{{ capitalize($t(frequency)) }}</option>
                                                </select>
                                                <InputError class="mt-2" :message="form.errors.billingFrequency" />
                                            </div>

                                            <div>
                                                <InputLabel for="subscription_expiration" :value="$t('Plan Expiration (Days)')" />
                                                <TextInput v-model="form.subscription_expiration" id="subscription_expiration" type="number" class="mt-1 block w-full"  />
                                                <InputError class="mt-2" :message="form.errors.subscription_expiration" />
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>
</template>


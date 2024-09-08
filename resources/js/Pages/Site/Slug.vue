<script setup>
import {Head, Link, router, useForm, usePage} from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import {onMounted, reactive, ref} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Stepper from "@/Components/Stepper.vue";
import {loadLanguageAsync} from "laravel-vue-i18n";
import DropdownLink from "@/Components/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown.vue";

const { props } = usePage();
const documentTypes = ref(props.documentTypes || []);
const currencies = ref(props.currencies || []);
const gateways = ref(props.gateways || []);
const site = ref(props.site || []);
const requiredFields = ref(props.required_fields || []);

const form = useForm({
    name: '',
    last_name: '',
    email: '',
    document_number: '',
    document_type: documentTypes.value[0] || null,
    description: '',
    amount: '',
    currency: currencies.value[0] || null,
    gateway: gateways.value[0] || null,
    site_id: site.value.id || null,
    required_Fields: requiredFields,
});


const goBack = () => {
    window.history.back();
};

const submit = () => {
    form.post(route('payment.store'), {
        onSuccess: () => {
            console.log('Form submitted successfully');
        }
    });
};

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

//Language

const langTitle = ref (localStorage.getItem('langTitle') || 'English')
const items= reactive({
    item: [
        {title: 'English', value:'en'},
        {title: 'Spanish', value:'es'},
    ]
})

const changeLocale = async (item) => {
    localStorage.setItem('langTitle', item.title);
    await router.get(route('language', item.value));
    localStorage.setItem('lang', item.value);
    await loadLanguageAsync(item.value);
};

onMounted(() => {
    if (site.value.type && site.value.type.name === 'subscriptions') {
        const url = route('subscription.create', { siteId: site.value.id });
        window.location.href = url;
    }
});

</script>

<template>
    <Head title="Show Sites" />
    <header class="fixed top-0 left-0 w-full bg-white border-b border-gray-100 dark:bg-black dark:border-neutral-700 z-50">
        <div class="relative w-full max-w-9xl px-4 lg:px-6 py-2 flex items-center justify-between">
            <div class="flex items-center">
                <img src="/Documents/logo.png" alt="Logo" class="h-10 w-auto">
            </div>
            <div class="ms-20 relative max-w-xs">
                <label class="sr-only">Search</label>
                <input type="text" name="hs-table-with-pagination-search" id="hs-table-with-pagination-search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Search for items">
                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                    <svg class="size-4 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg>
                </div>
            </div>
            <div class="flex-grow"></div>
            <div class="ms-3 relative">
                <Dropdown align="right" width="48">
                    <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-10 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    {{ langTitle }}
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </span>
                    </template>
                    <template #content>
                        <DropdownLink href="#" v-for="(item, index) in items.item" :key="index" @click="changeLocale(item)">
                            {{ item.title }}
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <nav v-if="canLogin" class="flex items-center space-x-2 ml-auto">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-md px-2 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-md px-2 py-2 text-gray-500 bg-white hover:text-gray-700 ring-1 ring-transparent transition focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        {{ $t('Login') }}
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md px-2 py-2 text-gray-500 bg-white hover:text-gray-700 ring-1 ring-transparent transition focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        {{ $t('Register') }}
                    </Link>
                </template>
            </nav>
        </div>
    </header>
    <div class="max-w-full px-6 py-10 sm:px-8 lg:px-10 lg:py-14 mt-10">
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-neutral-800 mx-12 lg:mx-12">
            <div v-if="site.avatar" class="flex justify-center items-center h-20">
                <img class="mx-auto flex flex-col items-center rounded-lg border border-gray-300 shadow mb-10" width="100" height="100" :src="`/storage/${site.avatar}`" alt="avatar"/>
            </div>
            <div>
                <h1 v-if="site.name" class="text-xl font-semibold text-gray-800 dark:text-neutral-200"> {{ site.name }}</h1>
                <p v-if="site.category" class="text-sm text-gray-600 dark:text-neutral-400 mb-2"> {{ site.category }}</p>
                <p v-if="site.type" class="capitalize text-sm text-gray-600 dark:text-neutral-400"> {{ $t(site.type.name) }}</p>
            </div>
            <div v-if="site.type && site.type.name === 'subscriptions'">
            </div>
            <div  v-if="site.type.name !== 'subscriptions'"  class="space-y-8">
                <div class="bg-white dark:bg-neutral-800 p-4 border border-gray-200 rounded-lg">
                    <form @submit.prevent="submit">
                        <div v-if="form.required_Fields.length" class="flex flex-col sm:flex-row gap-4">
                            <label class="inline-block text-sm font-medium dark:text-white">Required Fields:</label>
                            <div v-for="(field, index) in form.required_Fields" :key="index" class="mb-2">
                                <input v-model="field.value" :type="field.field_type" :placeholder="field.name" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"/>
                            </div>
                        </div>

                        <div class="py-6 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 dark:border-neutral-700 dark:first:border-transparent">
                            <label for="af-payment-billing-contact" class="inline-block text-sm font-medium dark:text-white">
                                Billing contact
                            </label>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="mt-2 space-y-3 sm:w-1/2">
                                    <input v-model="form.name" id="af-payment-billing-contact" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="First Name"><InputError :message="form.errors.name" class="mt-2" />
                                    <input v-model="form.last_name" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Last Name"><InputError :message="form.errors.last_name" class="mt-2" />
                                    <input v-model="form.email" type="email" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Email"><InputError :message="form.errors.email" class="mt-2" />
                                </div>
                                <div class="mt-2 space-y-3 sm:w-1/2">
                                    <select v-model="form.document_type" id="document_type" name="document_type" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option :value="null">Select option...</option>
                                        <option v-for="documentType in documentTypes" :key="documentType" :value="documentType">{{ documentType }}</option>
                                    </select><InputError :message="form.errors.documentType" class="mt-2"/>
                                    <input v-model="form.document_number" type="number" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Document Number"><InputError :message="form.errors.document_number" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-white dark:bg-neutral-800 p-4 border border-gray-200 rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="py-6 first:pt-0 last:pb-0 border-t first:border-transparent border-gray-200 dark:border-neutral-700 dark:first:border-transparent">
                            <label for="af-payment-billing-contact" class="inline-block text-sm font-medium dark:text-white">
                                Payment Method
                            </label>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="mt-2 space-y-3 sm:w-1/2">
                                    <textarea v-model="form.description" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 resize-none overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500" placeholder="Description" rows="1" data-hs-default-height="48"></textarea><InputError :message="form.errors.description"/>
                                    <select v-model="form.currency" id="currency" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option v-for="currency in currencies" :key="currency" :value="currency">{{ currency }}</option>
                                    </select><InputError :message="form.errors.currency" class="mt-2" />
                                </div>
                                <div class="mt-2 space-y-3 sm:w-1/2">
                                    <input v-model="form.amount" type="number" id="amount" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Amount"><InputError :message="form.errors.amount" class="mt-2"/>
                                    <select v-model="form.gateway" id="gateway" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option v-for="gateway in gateways" :key="gateway.value" :value="gateway.value">{{ gateway.text }}</option>
                                    </select><InputError :message="form.errors.gateway" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 flex justify-end gap-x-2">
                            <button @click="goBack" type="button" class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                {{ $t('Cancel') }}
                            </button>
                            <PrimaryButton class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 focus:outline-none focus:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none">{{ $t('Submit') }}</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

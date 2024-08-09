<script setup>
import { Head, useForm, usePage } from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import {ref} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const { props } = usePage();
const documentTypes = ref(props.documentTypes || []);
const currencies = ref(props.currencies || []);
const gateways = ref(props.gateways || []);
const site = ref(props.site || []);
const requiredFields = ref(props.required_fields || []);

const form = useForm({
    name: '',
    lastname: '',
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
        onError: (errors) => {
            console.log('Errores de validación:', errors);
        },
        onSuccess: () => {
            console.log('Formulario enviado con éxito');
        }
    });
};

</script>

<template>
    <Head title="Show Sites" />
    <div class="max-w-[85rem] px-6 py-10 sm:px-8 lg:px-10 lg:py-14 mx-auto">
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-neutral-800 mx-12 lg:mx-64">
            <div v-if="site.avatar" class="flex justify-center items-center h-20">
                <img class="mx-auto flex flex-col items-center rounded-lg border border-gray-300 shadow mb-10" width="100" height="100" :src="`/storage/${site.avatar}`" alt="avatar"/>
            </div>
            <div>
                <h1 v-if="site.name" class="text-xl font-semibold text-gray-800 dark:text-neutral-200"> {{ site.name }}</h1>
                <p v-if="site.category" class="text-sm text-gray-600 dark:text-neutral-400 mb-4"> {{ site.category }}</p>
                <p v-if="site.type" class="capitalize text-sm text-gray-600 dark:text-neutral-400 mb-4"> {{ site.type.name }}</p>
            </div>
            <div class="space-y-8">
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
                                    <input v-model="form.lastname" type="text" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Last Name"><InputError :message="form.errors.lastname" class="mt-2" />
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

<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {ref} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";

const { props } = usePage();
const documentTypes = ref(props.documentTypes || []);
const currencies = ref(props.currencies || []);
const gateways = ref(props.gateways || []);
const site = ref(props.site || []);

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
        <PrimaryButton @click="goBack" class="mb-4 px-4 py-2 bg-blue-500 text-white rounded"> {{ $t('Go Back') }}</PrimaryButton>
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-neutral-800 mx-12 lg:mx-64">
            <div v-if="site.avatar" class="flex justify-center items-center h-20">
                <img class="mx-auto flex flex-col items-center rounded-lg border border-gray-300 shadow mb-10" width="100" height="200" :src="`/storage/${site.avatar}`" alt="avatar"/>
            </div>
            <div>
                <h1 v-if="site.name" class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    {{ site.name }}
                </h1>
                <p v-if="site.category" class="text-sm text-gray-600 dark:text-neutral-400 mb-4">
                    {{ site.category }}
                </p>
                <p v-if="site.type" class="capitalize text-sm text-gray-600 dark:text-neutral-400 mb-4">
                    {{ site.type.name }}
                </p>
            </div>
            <div class="space-y-8">
                <div class="bg-white dark:bg-neutral-800 p-4 border border-gray-200 rounded-lg">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 mb-8">
                        Personal Information
                    </h2>
                    <form @submit.prevent="submit">
                        <div class="space-y-2">
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="w-full sm:w-1/2">
                                    <label for="name" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Name</label>
                                    <input v-model="form.name" type="text" id="name" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>
                                <div class="w-full sm:w-1/2">
                                    <label for="lastname" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Last Name</label>
                                    <input v-model="form.lastname" type="text" id="lastname" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <InputError :message="form.errors.lastname" class="mt-2" />
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Email</label>
                                <input v-model="form.email" type="email" id="email" autocomplete="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <InputError :message="form.errors.email" class="mt-2" />
                            </div>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="w-full sm:w-1/2">
                                    <label for="document_type" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Document Type</label>
                                    <select v-model="form.document_type" id="document_type" name="document_type" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option :value="null">Select option...</option>
                                        <option v-for="documentType in documentTypes" :key="documentType" :value="documentType">{{ documentType }}</option>
                                    </select>
                                    <InputError :message="form.errors.documentType" class="mt-2" />
                                </div>
                                <div class="w-full sm:w-1/2">
                                    <label for="document_number" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Document Number</label>
                                    <input v-model="form.document_number" type="number" id="document_number" name="document_number" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <InputError :message="form.errors.document_number" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="bg-white dark:bg-neutral-800 p-4 border border-gray-200 rounded-lg">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 mb-8">
                        Payment Details
                    </h2>
                    <form @submit.prevent="submit">
                        <div class="space-y-2">
                            <div class="flex flex-col sm:flex-row gap-4"> <!-- Cambio aquí para diseño responsivo -->
                                <div class="w-full sm:w-1/2">
                                    <label for="description" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Description</label>
                                    <textarea v-model="form.description" id="hs-default-height-with-autoheight-script" class="max-h-36 py-3 ps-4 pe-20 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 resize-none overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500" placeholder="Message..." rows="1" data-hs-default-height="48"></textarea>
                                </div>
                                <div class="w-full sm:w-1/2">
                                    <InputLabel for="currency" :value="$t('Currency')" class="mb-2"/>
                                    <select v-model="form.currency" id="currency" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option v-for="currency in currencies" :key="currency" :value="currency">{{ currency }}</option>
                                    </select>
                                    <InputError :message="form.errors.currency" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-4"> <!-- Cambio aquí para diseño responsivo -->
                                <div class="w-full sm:w-1/2">
                                    <InputLabel for="amount" :value="$t('Amount')" class="mb-2"/>
                                    <input v-model="form.amount" type="text" id="amount" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <InputError :message="form.errors.amount" class="mt-2" />
                                </div>
                                <div class="w-full sm:w-1/2">
                                    <InputLabel for="gateway" :value="$t('Gateway')" class="mb-2"/>
                                    <select v-model="form.gateway" id="gateway" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option v-for="gateway in gateways" :key="gateway.value" :value="gateway.value">{{ gateway.text }}</option>
                                    </select>
                                    <InputError :message="form.errors.gateway" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-10 grid">
                            <PrimaryButton class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" :processing="processing">{{ $t('Submit') }}</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>

import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {ref} from "vue";

const { props } = usePage();
const documentTypes = ref(props.documentTypes || []);
const currencies = ref(props.currencies || []);
const gateways = ref(props.gateways || []);
const sites = ref(props.sites || []);



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
    site_id: sites.value[0]?.id || null,
});

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
    <div class="max-w-[85rem]  px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-neutral-800">
            <div>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                    Payment Solutions
                </h1>
                <p class="text-sm text-gray-600 dark:text-neutral-400 mb-4">
                    Effortless Payments for Your Business.
                </p>
            </div>
            <div class="flex w-full space-x-4">
                <div class="flex-1 bg-white dark:bg-neutral-800 p-4 border border-gray-200 rounded-lg">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 mb-8">
                        Billing Information
                    </h2>
                    <form @submit.prevent="submit">
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label for="name" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Name</label>
                                    <input v-model="form.name" type="text" id="name" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>
                                <div class="w-1/2">
                                    <label for="lastname" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Last Name</label>
                                    <input v-model="form.lastname" type="text" id="lastname" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <InputError :message="form.errors.lastname" class="mt-2" />
                                </div>
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Email</label>
                                <input v-model="form.email" type="email" id="email" autocomplete="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <label for="document_type" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Document Type</label>
                                    <select v-model="form.document_type" id="document_type" name="document_type" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option :value="null">Select option...</option>
                                        <option v-for="documentType in documentTypes" :key="documentType" :value="documentType">{{ documentType }}</option>
                                    </select>
                                    <InputError :message="form.errors.documentType" class="mt-2" />
                                </div>
                                <div class="w-1/2">
                                    <label for="document_number" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Document Number</label>
                                    <input v-model="form.document_number" type="number" id="document_number" name="document_number" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <InputError :message="form.errors.document_number" class="mt-2" />
                                </div>
                            </div>
                            <div>
                                <label for="description" class="block mb-2 text-sm text-gray-700 font-medium dark:text-white">Description</label>
                                <textarea v-model="form.description" id="description" rows="4" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="flex-1 bg-white dark:bg-neutral-800 p-4 border border-gray-200 rounded-lg">
                    <h2 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 mb-8">
                        Payment Information
                    </h2>
                    <form @submit.prevent="submit">
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <InputLabel for="currency" :value="$t('Currency')" class="mb-2"/>
                                    <select v-model="form.currency" id="currency" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option v-for="currency in currencies" :key="currency" :value="currency">{{ currency }}</option>
                                    </select>
                                    <InputError :message="form.errors.currency" class="mt-2" />
                                </div>
                                <div class="w-1/2">
                                    <InputLabel for="amount" :value="$t('Amount')" class="mb-2"/>
                                    <input v-model="form.amount" type="text" id="amount" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                    <InputError :message="form.errors.amount" class="mt-2" />
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1/2">
                                    <InputLabel for="site_id" :value="$t('Available Sites')" class="mb-2"/>
                                    <select v-model="form.site_id" id="site_id" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option v-for="site in sites" :key="site.id" :value="site.id">{{ site.name }}</option>
                                    </select>
                                    <InputError :message="form.errors.site_id" class="mt-2" />
                                </div>
                                <div class="w-1/2">
                                    <InputLabel for="gateway" :value="$t('Gateway')" class="mb-2"/>
                                    <select v-model="form.gateway" id="gateway" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                        <option v-for="gateway in gateways" :key="gateway.value" :value="gateway.value">{{ gateway.text }}</option>
                                    </select>
                                    <InputError :message="form.errors.gateway" class="mt-2" />
                                </div>
                            </div>
                            <div class="mt-6 grid">
                                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Submit Payment
                                </PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>

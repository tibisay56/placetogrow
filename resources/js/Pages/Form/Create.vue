<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FileInput from "@/Components/FileInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Layout from "@/Components/Layout.vue";
import {computed, ref, watch} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import {HSCopyMarkup} from "preline";



const props = defineProps({
    sites: Array,
    types: Array,
    fieldTypes: Array
});

const sites = ref(props.sites || []);
const types = ref(props.types || []);
const fieldTypes = ref(props.fieldTypes || []);

const form = useForm({
    type_id: "",
    field_name: "",
    field_type: "",
    label: "",
    site_id: null,
    fields: [{ type:'text', name:'first Name'}]
});

const filteredTypes = computed(() => {
    if (form.site_id) {
        const site = sites.value.find(site => site.id === form.site_id);
        if (site) {
            return types.value.filter(type => type.id === site.type_id);
        }
    }
    return [];
});

watch(() => form.site_id, (newSiteId) => {
    if (newSiteId) {
        const site = sites.value.find(site => site.id === newSiteId);
        if (site && site.type_id) {
            form.type_id = site.type_id;
        }
    } else {
        form.type_id = '';
    }
});


document.addEventListener('DOMContentLoaded', () => {
    if (typeof HSCopyMarkup !== 'undefined') {
        const copyMarkupButton = document.querySelector('#hs-copy-content');

        if (copyMarkupButton) {
            const copyMarkup = new HSCopyMarkup(copyMarkupButton);

            const deleteBtn = document.querySelector('#delete-btn');

            if (deleteBtn) {
                deleteBtn.addEventListener('click', () => {
                    const itemToDelete = document.querySelector('#copy-markup-item-1');
                    if (itemToDelete) {
                        copyMarkup.delete(itemToDelete);
                    } else {
                        console.error('Elemento con ID "copy-markup-item-1" no encontrado.');
                    }
                });
            } else {
                console.error('Elemento con ID "delete-btn" no encontrado.');
            }
        } else {
            console.error('Elemento con ID "hs-copy-content" no encontrado.');
        }
    } else {
        console.error('HSCopyMarkup no está definido.');
    }
});
const removeField = (index) => {
    form.fields.splice(index, 1);
};
const submit = () => {
    form.post(route('form.store'));
};

</script>


<template>
    <Head title="Create Forms" />
    <AuthenticatedLayout>
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
                                            {{ $t('Create Forms') }}
                                        </h2>
                                        <p class="text-sm text-gray-600 dark:text-neutral-400">
                                            {{ $t('Add forms, edit and more.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <div class="inline-flex gap-x-2">
                                            <Link :href="route('form.index')">
                                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800" href="#">
                                                    {{ $t('View all') }}
                                                </a>
                                            </Link>
                                            <Link :href="route('form.create')">
                                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" >
                                                    <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                                    {{ $t('Add form') }}
                                                </a>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Header -->
                                <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
                                    <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                        <form class="w-3/4 py-5 space-y-3" @submit.prevent="submit">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                                                <div class="mt-4">
                                                    <InputLabel for="site_id" :value="$t('Site')" />
                                                    <select v-model="form.site_id" id="site_id"
                                                            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                        <option :value="null">{{ $t('Select a site') }}</option>
                                                        <option v-for="site in sites" :key="site.id" :value="site.id">{{ site.name }}</option>
                                                    </select>
                                                    <InputError :message="form.errors.site_id" class="mt-2" />
                                                </div>
                                                <div class="mt-4">
                                                    <InputLabel for="type_id" :value="$t('Type')" />
                                                    <select v-model="form.type_id" name="type_id" id="type_id"
                                                            class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                        <option v-for="type in filteredTypes" :key="type.id" :value="type.id">{{ type.name }}</option>
                                                    </select>
                                                    <InputError class="mt-2" :message="form.errors.type_id" />
                                                </div>
                                            </div>
                                            <div v-for="(field, index) in form.fields" :key="index" class="grid grid-cols-1 gap-4 md:grid-cols-5">
                                                    <!-- Field Name -->
                                                    <div class="mt-4">
                                                        <InputLabel :for="'field_name_' + index" :value="$t('Field Name')" />
                                                        <TextInput v-model="field.field_name" :id="'field_name_' + index" type="text" class="mt-1 block w-full" autocomplete="name" :placeholder="$t('Name')" />
                                                        <InputError :message="form.errors.fields && form.errors.fields[index] && form.errors.fields[index].field_name" class="mt-2" />
                                                    </div>

                                                    <!-- Field Type -->
                                                    <div class="mt-4">
                                                        <InputLabel :for="'field_type_' + index" :value="$t('Field Type')" />
                                                        <select v-model="field.field_type" :id="'field_type_' + index"
                                                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                            <option :value="null">{{ $t('Select a field type') }}</option>
                                                            <option v-for="type in fieldTypes" :key="type.value" :value="type.value">{{ $t(type.text) }}</option>
                                                        </select>
                                                        <InputError :message="form.errors.fields && form.errors.fields[index] && form.errors.fields[index].field_type" class="mt-2" />
                                                    </div>

                                                    <!-- Label -->
                                                    <div class="mt-4">
                                                        <InputLabel :for="'label_' + index" :value="$t('Label')" />
                                                        <TextInput v-model="field.label" :id="'label_' + index" type="text" class="mt-1 block w-full" />
                                                        <InputError :message="form.errors.fields && form.errors.fields[index] && form.errors.fields[index].label" class="mt-2" />
                                                    </div>
                                                    <div class="flex-none mt-4 self-end">
                                                        <PrimaryButton @click="addField">
                                                            {{ $t('Add Input') }}
                                                        </PrimaryButton>
                                                    </div>
                                                    <div class="flex-none mt-4 self-end">
                                                        <SecondaryButton @click="removeField(index)">
                                                            {{ $t('Remove') }}
                                                        </SecondaryButton>
                                                    </div>
                                            </div>

                                            <div class="p-4 w-full bg-white rounded-lg shadow-md dark:bg-neutral-800">
                                                <div id="hs-wrapper-for-copy" class="space-y-3">
                                                    <input id="hs-content-for-copy" type="text" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm text-gray-800 focus:z-10 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200 dark:placeholder:text-neutral-500" placeholder="Enter name">
                                                </div>

                                                <p class="mt-3 text-end">
                                                    <button type="button" data-hs-copy-markup='{
        "targetSelector": "#hs-content-for-copy",
        "wrapperSelector": "#hs-wrapper-for-copy",
        "limit": 3
      }' id="hs-copy-content" class="py-1.5 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-full border border-dashed border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M5 12h14"></path>
                                                            <path d="M12 5v14"></path>
                                                        </svg>
                                                        Add Name
                                                    </button>
                                                </p>
                                            </div>

                                            <div class="flex justify-center">
                                                <PrimaryButton>
                                                    {{ $t('Create Form') }}
                                                </PrimaryButton>
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
    </AuthenticatedLayout>
</template>





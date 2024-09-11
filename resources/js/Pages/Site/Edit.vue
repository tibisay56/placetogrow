<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FileInput from "@/Components/FileInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { computed, ref } from 'vue';
import Layout from "@/Components/Layout.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

const page = usePage();
const site = ref(page.props.site);
const types = ref(page.props.types);
const currencies = ref(page.props.currencies);
const field_types = ref(page.props.field_types);

const form = useForm({
    name: site.value.name,
    avatar: null,
    type_id: site.value.type_id,
    user_id: site.value.user_id,
    category: site.value.category,
    currency: site.value.currency,
    payment_expiration_time: String(30),
    required_fields: site.value.required_fields,
    field_type: site.value.field_type,
});
const onSelectAvatar = (e) => {
    const files = e.target.files;
    if (files.length) {
        form.avatar = files[0];
    }
};

const submit = () => {
    if(dynamicFields.value[dynamicFields.value.length - 1].name=="" && dynamicFields.value[dynamicFields.value.length - 1].field_type=="" ){
        dynamicFields.value.pop();
    }

    dynamicFields.value.forEach(item => {
        item.required = true;
        item.value = "";
    });
    console.log(form.required_fields);
    form.required_fields = [...form.required_fields, ...dynamicFields.value];

    form.post(route('site.update', site.value),{
        onSuccess: (e) => {
            site.value = e.props.contact;
        }
    })

}

const props = defineProps({
types: Array,
currencies: Array,
field_types: Array,
});

const dynamicFields = ref([
{ name: '', field_type: '' }
]);

const addField = () => {
const allFieldsValid = dynamicFields.value.every(field => field.name.trim() !== '' && field.field_type.trim() !== '');

if (allFieldsValid) {
    dynamicFields.value.push({
        name: '',
        field_type: ''
    });
} else {
    alert('Please fill out all fields before adding a new row.');
}
};
const removeField = (index) => {
if (dynamicFields.value.length > 1) {
    dynamicFields.value.splice(index, 1);
}
};

const removeFieldRequire = (index) => {
    if (form.required_fields.length > 1) {
        form.required_fields.splice(index, 1);
        console.log(form.required_fields);
    }
};

const canAddField = computed(() => {
return dynamicFields.value.every(field => field.name.trim() !== '' && field.field_type.trim() !== '');
});

</script>

<template>
    <Head title="Update Contacts"  />
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
                                            {{ $t('Edit Sites') }}
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
                                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-orange-500 text-white hover:bg-orange-600 disabled:opacity-50 disabled:pointer-events-none" >
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
                                            <form class="w-1/2 py-5 space-y-3" @submit.prevent="submit">
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                                                <div>
                                                    <InputLabel for="name" :value="$t('Name')" />
                                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" placeholder="Name"/>
                                                    <InputError class="mt-2" :message="form.errors.name" />
                                                </div>
                                                <div>
                                                    <InputLabel for="type_id" :value="$t('Type')" />
                                                    <select v-model="form.type_id" name="type_id" id="type_id"
                                                            class="capitalize w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
                                                    <InputLabel for="payment_expiration_time" :value="$t('Payment Expiration Time (Minutes)')" />
                                                    <TextInput id="payment_expiration_time" type="number" class="mt-1 block w-full" v-model="form.payment_expiration_time" />
                                                    <InputError class="mt-2" :message="form.errors.payment_expiration_time" />
                                                </div>
                                                </div>
                                                <div class="mt-4">
                                                    <form class="max-w-sm">
                                                        <InputLabel for="avatar" value="Logo" />
                                                        <FileInput name="avatar" @change="onSelectAvatar" class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                                                                file:bg-gray-50 file:border-0
                                                                file:me-4
                                                                file:py-3 file:px-4
                                                                dark:file:bg-neutral-700 dark:file:text-neutral-400"/>
                                                        <InputError class="mt-2" :message="form.errors.avatar" />
                                                    </form>
                                                </div>
                                                <!--FIELD-->
                                                <div class="space-y-4">
                                                    <div v-for="(field, index) in form.required_fields" :key="index" class="flex items-center gap-2 ml-1.3">
                                                    <input v-model="form[field.name]" :id="field.name" :type="field.field_type" :placeholder="field.name.charAt(0).toUpperCase() + field.name.slice(1)" class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"><InputError :message="form.errors[field.name]" class="mt-2" />
                                                        <button
                                                            type="button"
                                                            class="inline-flex items-center justify-center gap-x-2 p-2 text-sm font-medium bg-transparent text-red-500 focus:outline-none focus:ring-0 dark:border-red-600 dark:text-red-500 dark:hover:bg-red-700 dark:focus:bg-red-700"
                                                            @click="removeFieldRequire(index)"
                                                            aria-label="Remove Field"
                                                        >
                                                            <font-awesome-icon :icon="['fas', 'trash']" class="text-lg"/>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Campos dinámicos -->
                                                <div>
                                                    <div v-for="(field, index) in dynamicFields" :key="index" class="flex items-center gap-4 mb-4">
                                                        <div class="flex-1">
                                                            <!-- Nombre del campo -->
                                                            <InputLabel :for="'name_' + index" :value="$t('Name')" />
                                                            <TextInput
                                                                :id="'name_' + index"
                                                                type="text"
                                                                class="mt-1 block w-full"
                                                                autocomplete="name"
                                                                placeholder="Name"
                                                                v-model="field.name"
                                                            />
                                                            <InputError class="mt-2" :message="form.errors.name" />
                                                        </div>
                                                        <div class="flex-1">
                                                            <!-- Tipo de campo -->
                                                            <InputLabel :for="'field_type_' + index" :value="$t('Field Type')" />
                                                            <select
                                                                v-model="field.field_type"
                                                                :name="'field_type_' + index"
                                                                :id="'field_type_' + index"
                                                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                                            >
                                                                <option v-for="fieldType in field_types" :key="fieldType" :value="fieldType">
                                                                    {{ fieldType }}
                                                                </option>
                                                            </select>
                                                            <InputError class="mt-2" :message="form.errors.field_type" />
                                                        </div>

                                                        <div class="flex items-center gap-2 ml-4">
                                                            <button
                                                                type="button"
                                                                class="mt-6 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-full border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                                                                @click="addField"
                                                                :disabled="!canAddField"
                                                                aria-label="Add Field"
                                                            >
                                                                <svg
                                                                    class="shrink-0 size-6"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    width="32"
                                                                    height="32"
                                                                    viewBox="0 0 24 24"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="2"
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                >
                                                                    <path d="M5 12h14"></path>
                                                                    <path d="M12 5v14"></path>
                                                                </svg>
                                                            </button>

                                                            <!-- Botón de eliminar -->
                                                            <button
                                                                type="button"
                                                                class="mt-6 inline-flex items-center justify-center gap-x-2 p-2 text-sm font-medium bg-transparent text-red-500 focus:outline-none focus:ring-0 dark:border-red-600 dark:text-red-500 dark:hover:bg-red-700 dark:focus:bg-red-700"
                                                                @click="removeField(index)"
                                                                aria-label="Remove Field"
                                                            >
                                                                <font-awesome-icon :icon="['fas', 'trash']" class="text-lg"/>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="flex justify-center">
                                                    <PrimaryButton>
                                                        {{ $t('Update Site') }}
                                                    </PrimaryButton>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="flex flex-col">
                                            <div>
                                                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200 mt-4 mb-4">
                                                    {{ $t('Users') }}
                                                </h2>
                                            </div>
                                            <div class="-m-1.5 overflow-x-auto">
                                                <div class="p-1.5 min-w-full inline-block align-middle">
                                                    <div class="border rounded-lg shadow overflow-hidden dark:border-neutral-700 dark:shadow-gray-900">
                                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                                            <thead class="bg-gray-50 dark:bg-neutral-700">
                                                            <tr>
                                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Name</th>
                                                                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Email</th>
                                                                <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">Action</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                                            <template v-if="site.user">
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                                    {{ site.user.name }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                                    {{ site.user.email }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                                    <button type="button" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-orange-500 hover:text-orange-600 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400">Delete</button>
                                                                </td>
                                                            </tr>
                                                            </template>
                                                            <template v-else>
                                                                <tr>
                                                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-neutral-400">
                                                                        No users assigned
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>



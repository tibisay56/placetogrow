<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FileInput from "@/Components/FileInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from 'vue';

const page = usePage();
const site = ref(page.props.site);
const types = ref(page.props.types);
const currencies = ref(page.props.currencies);

const form = useForm({
    name: site.value.name,
    avatar: null,
    type_id: site.value.type_id,
    category: site.value.category,
    currency: site.value.currency,
    payment_expiration_time: 30,
});

const onSelectAvatar = (e) => {
    const files = e.target.files;
    if (files.length) {
        form.avatar = files[0];
    }
};

const submit = () => {
    form.post(route('site.update', site.value),{
        onSuccess: (e) => {
            site.value = e.props.contact;
        }
    })
}
const props = defineProps({
    types: Array,
    currencies: Array,
});


</script>

<template>
    <Head title="Update Contacts"  />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Site</h2>
                <Link :href="route('site.index')">
                    List Sites
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3" @submit.prevent="submit">
                        <div class="mt-4">
                            <InputLabel for="name" value="Name" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" placeholder="Name"/>
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="type_id" value="Type" />
                            <select v-model="form.type_id" name="type_id" id="type_id"
                                    class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option v-for="(type, index) in types" :key="index+1" :value="index+1">{{ type }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.type_id" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="category" value="Category" />
                            <TextInput id="category" type="text" class="mt-1 block w-full" v-model="form.category" />
                            <InputError class="mt-2" :message="form.errors.category" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="currency" value="Currency" />
                            <select v-model="form.currency" name="currency" id="currency"
                                    class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option v-for="currency in currencies" :key="currency" :value="currency">{{ currency }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.currency" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="payment_expiration_time" value="Payment Expiration Time (in minutes)" />
                            <TextInput id="payment_expiration_time" type="number" class="mt-1 block w-full" v-model="form.payment_expiration_time" />
                            <InputError class="mt-2" :message="form.errors.payment_expiration_time" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="avatar" value="Logo" />
                            <FileInput name="avatar" @change="onSelectAvatar"/>
                            <InputError class="mt-2" :message="form.errors.avatar" />
                        </div>
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Update Site
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>



<template>
    <Head title="Create Sites" />
    <AuthenticatedLayout>
        <template #header>
            <div class= "flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Sites</h2>
                <Link :href="route('site.index')">List sites</Link>
            </div>
        </template>
            <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3" @submit.prevent="submit">
                        <div class="mt-4">
                            <InputLabel for="name" value="Name" />
                            <TextInput v-model="form.name" id="name" type="text" class="mt-1 block w-full"  autocomplete="name" placeholder="Name"/>
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
                            <TextInput v-model="form.category" id="category" type="text" class="mt-1 block w-full"  />
                            <InputError class="mt-2" :message="form.errors.category" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="currency" value="Currency" />
                            <select v-model="form.currency" name="currency" id="currency"
                                    class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option v-for="(currency, key) in currencies" :key="key" :value="key">{{ currency }}</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.currency" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="payment_expiration_time" value="Payment Expiration Time (in minutes)" />
                            <TextInput v-model="form.payment_expiration_time" id="payment_expiration_time" type="text" class="mt-1 block w-full"  />
                            <InputError class="mt-2" :message="form.errors.payment_expiration_time" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="avatar" value="Logo" />
                            <FileInput name="avatar" @change="onSelectAvatar"/>
                            <InputError class="mt-2" :message="form.errors.avatar" />
                        </div>
                        <div class="flex justify-center">
                            <PrimaryButton>
                                Create Site
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, useForm, usePage} from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import FileInput from "@/Components/FileInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref} from 'vue';

const form = useForm({
    name: "",
    avatar: null,
    type_id: "",
    category: "",
    currency: "",
    payment_expiration_time: "",
});

const onSelectAvatar = (e) => {
    const files = e.target.files;
    if (files.length) {
        form.avatar = files[0];
    }
    console.log(form.avatar);
};

const submit = () => {
    form.post(route('site.store'));
};

const props = defineProps({
    types: Array,
    currencies: Array,
});

const types = ref(props.types);
const currencies = ref(props.currencies);

</script>



<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ref } from 'vue';

const page = usePage()
const site = ref(page.props.site);
const types = ref(page.props.types);

console.log('types:', types.value);

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
});

</script>

<template>
    <Head title="Show Sites" />

    <AuthenticatedLayout>
        <template #header>
            <div class= "flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Show Sites</h2>
                <Link :href="route('site.index')">
                    List sites
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form class="w-1/3 py-5 space-y-3">
                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="form.recentlySuccessful" class="text-sm text-green-600 text-center">Site updated</p>
                        </Transition>
                        <div class="mt-4">
                            <InputLabel for="name" value="Name" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" placeholder="Name"/>
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="type_id" value="Type" />
                            <select v-model="form.type_id" name="type_id" id="type_id"
                                    class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option v-for="(name, id) in types" :key="id" :value="id">{{ name }}</option>
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
                                <option value="COP">COP</option>
                                <option value="USD">USD</option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.currency" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="payment_expiration_time" value="Payment Expiration Time (in minutes)" />
                            <TextInput id="payment_expiration_time" type="number" class="mt-1 block w-full" v-model="form.payment_expiration_time" />
                            <InputError class="mt-2" :message="form.errors.payment_expiration_time" />
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
    </AuthenticatedLayout>
</template>

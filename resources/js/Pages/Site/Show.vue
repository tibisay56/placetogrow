<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { ref } from 'vue';

const page = usePage()

const site = ref(page.props.site);

const initialValues = {
    name: site.value.name,
    document_type: site.value.document_type,
    document: site.value.document,
    slug: site.value.name,
    avatar:null,
}
const form = useForm(initialValues)



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
                        <InputLabel for="document_type" value="Document type" />
                        <select v-model="form.document_type" name="document_type" id="document_type"
                                class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="cc">CC</option>
                            <option value="ce">CE</option>
                            <option value="nit">NIT</option>
                            <option value="ppt">PPT</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.document_type" />
                    </div>
                        <div class="mt-4">
                            <InputLabel for="document" value="Document" />
                            <TextInput id="document" type="text" class="mt-1 block w-full" v-model="form.document"/>
                            <InputError class="mt-2" :message="form.errors.document" />
                        </div>
                        <div class="mt-4">
                            <InputLabel for="slug" value="Slug" />
                            <TextInput id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" autocomplete="slug" placeholder="Slug"/>
                            <InputError class="mt-2" :message="form.errors.slug" />
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

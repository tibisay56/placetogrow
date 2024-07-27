<script setup>
import { Head, Link, useForm, usePage} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";

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

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
const page = usePage()
const sites = ref(page.props.sites || []);

</script>

<template>
    <Head title="Welcome" />
    <div class="bg-white text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="fixed top-0 left-0 w-full bg-white border-b border-gray-100 dark:bg-black dark:border-neutral-700 z-50">
                    <div class="relative w-full max-w-7xl mx-auto px-6 lg:px-8 py-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="/Documents/logo.png" alt="Logo" class="h-10 w-auto">
                            </div>
                            <nav v-if="canLogin" class="space-x-4">
                                <Link
                                    v-if="$page.props.auth.user"
                                    :href="route('dashboard')"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Dashboard
                                </Link>
                                <template v-else>
                                    <Link
                                        :href="route('login')"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Log in
                                    </Link>

                                    <Link
                                        v-if="canRegister"
                                        :href="route('register')"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Register
                                    </Link>
                                </template>
                            </nav>
                    </div>
                </header>

                <main class="mt-10 max-w-7xl ml-24 mr-2 pl-24 lg:pl-28 px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                    <!-- Clients -->
                    <div>
                        <!-- Title -->
                        <div class="sm:w-1/2 xl:w-1/3 mx-auto text-center mb-6">
                            <h2 class="text-xl font-semibold md:text-2xl md:leading-tight text-gray-800 dark:text-neutral-200">Trusted by Open Source, enterprise, and more than 99,000 of you</h2>
                        </div>
                        <!-- End Title -->

                        <!-- Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-3 lg:gap-6">
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(0, 1)" :key="site.id"  :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(1, 2)" :key="site.id" :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block  mx-auto size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(2, 3)" :key="site.id"  :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(3, 4)" :key="site.id"  :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(4, 5)" :key="site.id"  :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(5, 6)" :key="site.id" :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(6, 7)" :key="site.id" :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(7, 8)" :key="site.id" :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(8, 9)" :key="site.id"  :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(9, 10)" :key="site.id" :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>
                            <div class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a v-for="site in sites.slice(10, 11)" :key="site.id" :href="site.link" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/${site.avatar}`" :alt="site.name"/>
                                    <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ site.name }}</p>
                                </a>
                            </div>

                    </div>
                    </div>
                        <!-- End Grid -->
                    <!-- End Clients -->
                </main>
            </div>
        </div>
</template>

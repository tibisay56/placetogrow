<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import {ref, reactive, computed} from "vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown.vue";
import { loadLanguageAsync } from "laravel-vue-i18n";
import Pagination from "@/Components/Pagination.vue";
import Footer from "@/Components/Footer.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

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

const page = usePage()
const sites = ref(page.props.sites || []);
const selectedType = ref('');

const filteredSites = computed(() => {
    if (!selectedType.value) return sites.value.data;
    return sites.value.data.filter(site => site.type.name === selectedType.value);
});

const filterByType = (type) => {
    selectedType.value = type;
};

//Language

const langTitle = ref (localStorage.getItem('langTitle') || 'English')
const items= reactive({
    item: [
        {title: 'English', value:'en'},
        {title: 'Spanish', value:'es'},
    ]
})

const changeLocale = async (item) => {
    localStorage.setItem('langTitle', item.title);
    await router.get(route('language', item.value));
    localStorage.setItem('lang', item.value);
    await loadLanguageAsync(item.value);
};

</script>

<template>
    <Head title="Welcome" />
            <header class="fixed top-0 left-0 w-full bg-white border-b border-gray-100 dark:bg-black dark:border-neutral-700 z-50">
                <div class="relative w-full max-w-9xl px-4 lg:px-6 py-2 flex items-center justify-between">
                    <div class="flex items-center">
                        <a href="/">
                        <img src="/Documents/logo.png" alt="Logo" class="h-10 w-auto">
                        </a>
                    </div>
                    <div class="ms-20 relative max-w-xs">
                        <label class="sr-only">Search</label>
                        <input type="text"
                               name="hs-table-with-pagination-search"
                               id="hs-table-with-pagination-search"
                               class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                               placeholder="Search for items">
                        <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
                            <svg class="size-4 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-grow"></div>
                    <div class="ms-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                            <span class="inline-flex rounded-md">
                                <button type="button" class="inline-flex items-center px-10 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    {{ langTitle }}
                                    <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </span>
                            </template>
                            <template #content>
                                <DropdownLink href="#" v-for="(item, index) in items.item" :key="index" @click="changeLocale(item)">
                                    {{ item.title }}
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                    <nav v-if="canLogin" class="flex items-center space-x-2 ml-auto">
                        <Link
                            v-if="$page.props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-2 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link
                                :href="route('login')"
                                class="rounded-md px-2 py-2 text-gray-500 bg-white hover:text-gray-700 ring-1 ring-transparent transition focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                {{ $t('Login') }}
                            </Link>
                            <Link
                                v-if="canRegister"
                                :href="route('register')"
                                class="rounded-md px-2 py-2 text-gray-500 bg-white hover:text-gray-700 ring-1 ring-transparent transition focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                {{ $t('Register') }}
                            </Link>
                        </template>
                    </nav>
                </div>
            </header>
            <main class="max-w-full px-6 py-10 sm:px-8 lg:px-10 lg:py-14 mt-10">
                <div>
                    <h2 class="text-xl font-semibold md:text-2xl md:leading-tight text-gray-800 dark:text-neutral-200 mb-10 text-center">{{ $t('Categories') }}</h2>
                </div>
                <!-- Filter Buttons -->
                <div class="flex space-x-4 mb-4 ml-36">
                    <button @click="filterByType('donations')" class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1 flex items-center">
                        <font-awesome-icon :icon="['fas', 'hand-holding-heart']"  class="mr-2 text-orange-500"/>
                        {{ $t('Donations') }}
                    </button>
                    <button @click="filterByType('invoicing')" class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                        <font-awesome-icon :icon="['fas', 'receipt']" class="mr-2 text-orange-500"/>
                        {{ $t('Invoicing') }}
                    </button>
                    <button @click="filterByType('subscriptions')" class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                        <font-awesome-icon :icon="['far', 'calendar-check']" class="mr-2 text-orange-500"/>
                        {{ $t('Subscriptions') }}
                    </button>
                    <button @click="filterByType('')" class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">Reset Filter</button>
                </div>

                <!-- Clients -->
                <div class="p-4 bg-white rounded-lg dark:bg-neutral-800 mx-12 lg:mx-12">
                    <!-- Title -->
                    <div>
                        <h2 class="text-xl font-semibold md:text-2xl md:leading-tight text-gray-800 dark:text-neutral-200 mb-20 mt-10 text-center">{{ $t('Microsites') }}</h2>
                    </div>
                    <!-- End Title -->

                    <!-- Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-3 lg:gap-6 mr-20 ml-20 mb-20">
                        <div v-for="(item, index) in filteredSites"  :key="index" class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                            <a :href="`/dashboard/sites/${encodeURIComponent(item.slug)}`" class="flex flex-col items-center">
                                <img class="inline-block size-[38px]" :src="`/storage/${item.avatar}`" :alt="item.name"/>
                                <p class="mt-2 text-center text-sm text-gray-800 dark:text-neutral-200 font-bold">{{ item.name }}</p>
                                <p class="capitalize mt-2 text-center text-sm text-gray-800 dark:text-neutral-200">{{ $t(item.type.name) }}</p>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End Grid -->
                <!-- End Clients -->
               <Pagination class="mt-4 flex justify-center items-center" :links="sites.links"/>
            </main>
    <Footer/>

</template>

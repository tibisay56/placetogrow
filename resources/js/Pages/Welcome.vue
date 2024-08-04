<script setup>
import { Head, Link, useForm, router, usePage} from '@inertiajs/vue3';
import {ref, reactive, computed} from "vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import Dropdown from "@/Components/Dropdown.vue";
import {loadLanguageAsync} from "laravel-vue-i18n";

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
console.log(sites.value);

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
    <div class="bg-white text-black/50 dark:bg-black dark:text-white/50">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="fixed top-0 left-0 w-full bg-white border-b border-gray-100 dark:bg-black dark:border-neutral-700 z-50">
                    <div class="relative w-full max-w-7xl px-4 lg:px-6 py-2 flex items-center justify-between">
                            <div class="flex items-center">
                                <img src="/Documents/logo.png" alt="Logo" class="h-10 w-auto">
                            </div>
                        <!-- Settings Dropdown -->
                        <div class="ms-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ langTitle }}
                                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/></svg>
                                            </button>
                                        </span>
                                </template>
                                <template #content>
                                    <DropdownLink href="#" v-for="(item, index) in items.item" :key="index" @click= "changeLocale(item)">
                                        {{ item.title }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>
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
                                        {{ $t('Login') }}
                                    </Link>

                                    <Link
                                        v-if="canRegister"
                                        :href="route('register')"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        {{ $t('Register') }}
                                    </Link>
                                </template>
                            </nav>
                    </div>
                </header>

                <main class="mt-20 max-w-7xl ml-24 mr-2 pl-24 lg:pl-28 px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                    <!-- Clients -->
                    <div>
                        <!-- Title -->
                        <div class="sm:w-1/2 xl:w-1/2 mx-auto text-center mb-6">
                            <h2 class="text-xl font-semibold md:text-2xl md:leading-tight text-gray-800 dark:text-neutral-200">{{ $t('Microsites') }}</h2>
                        </div>
                        <!-- End Title -->

                        <!-- Grid -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-3 lg:gap-6">
                            <div v-for="site in sites" :key="site.id" class="p-4 md:p-7 bg-gray-100 rounded-lg dark:bg-neutral-800 shrink-0 transition hover:-translate-y-1">
                                <a :href="`/dashboard/sites/${encodeURIComponent(site.slug)}`" class="flex flex-col items-center">
                                    <img class="inline-block size-[38px]" :src="`/storage/avatars/${site.avatar}`" :alt="site.name"/>
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

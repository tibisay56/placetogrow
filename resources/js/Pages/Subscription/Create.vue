<script setup>
import Pricing from "@/Components/Pricing.vue";
import Login from "@/Components/Login.vue";
import VerifyEmail from "@/Components/VerifyEmail.vue";
import {computed, reactive, ref} from "vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import {Link, router, useForm, usePage} from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import {loadLanguageAsync} from "laravel-vue-i18n";
import InputError from "@/Components/InputError.vue";

const { props } = usePage();
const site = ref(props.site || []);
const documentTypes = ref(props.documentTypes || []);
const requiredFields = ref(props.required_fields || []);

const step = ref(1);
const selectedPlan = ref(null);

const stepperProgress = computed(() => {
    return (100 / 3) * (step.value - 1) + '%';
});

const handlePlanSelected = (planId) => {
    selectedPlan.value = planId;
    console.log("Plan seleccionado en el componente padre:", planId);
};

const canProceedToNextStep = computed(() => {
    switch (step.value) {
        case 1:
            return selectedPlan.value !== null;
        case 2:
            return form.email !== '';
        case 3:
            return form.name !== '' && form.document_type !== null && form.document_number !== '';
        default:
            return true;
    }
});

const form = useForm({
    name:'',
    email: '',
    document_number: '',
    document_type: documentTypes.value[0] || null,
    plan_id: null,
    password: '',
    required_Fields: requiredFields,
    site_id: site.value.id,
});

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

const submitForm = () => {
    console.log('Submit form triggered');

    if (!selectedPlan.value) {
        console.log('No plan selected');
        return;
    }

    form.plan_id = selectedPlan.value;

    if (step.value === 4) {
        form.post(route('subscription.store'), {
            onSuccess: () => {
                console.log('Form submission successful');
                form.reset();
            },
            onError: (errors) => {
                console.log('Form submission failed', errors);
            }
        });
    } else {
        step.value++;
    }
};

</script>


<template>
    <header class="fixed top-0 left-0 w-full bg-white border-b border-gray-100 dark:bg-black dark:border-neutral-700 z-50">
        <div class="relative w-full max-w-9xl px-4 lg:px-6 py-2 flex items-center justify-between">
            <div class="flex items-center">
                <a href="/">
                <img src="/Documents/logo.png" alt="Logo" class="h-10 w-auto">
                </a>
            </div>
            <div class="ms-20 relative max-w-xs">
                <label class="sr-only">Search</label>
                <input type="text" name="hs-table-with-pagination-search" id="hs-table-with-pagination-search" class="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Search for items">
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
    <div class="max-w-full px-6 py-10 sm:px-8 lg:px-10 lg:py-14 mt-10">
        <div class="p-4 bg-white rounded-lg shadow-md dark:bg-neutral-800 mx-12 lg:mx-12">
            <div v-if="site.avatar" class="flex justify-center items-center h-20">
                <img class="mx-auto flex flex-col items-center rounded-lg border border-gray-300 shadow mb-10" width="100" height="100" :src="`/storage/${site.avatar}`" alt="avatar"/>
            </div>
            <div>
                <h1 v-if="site.name" class="text-xl font-semibold text-gray-800 dark:text-neutral-200">{{ site.name }}</h1>
                <p v-if="site.category" class="text-sm text-gray-600 dark:text-neutral-400 mb-2">{{ site.category }}</p>
                <p v-if="site.type" class="capitalize text-sm text-gray-600 dark:text-neutral-400">{{ site.type.name }}</p>
            </div>
            <div class="wrapper-stepper">
                <div class="stepper">
                    <div class="stepper-progress">
                        <div class="stepper-progress-bar" :style="{ width: stepperProgress }"></div>
                    </div>
                    <div class="stepper-item" :class="{ 'current': step === item, 'success': step > item }" v-for="item in 4" :key="item">
                        <div class="stepper-item-counter">
                            <svg class="icon-success" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            <span class="number">{{ item }}</span>
                        </div>
                        <span class="stepper-item-title">{{ $t('Step') }} {{ item }}</span>
                    </div>
                </div>
                <div class="stepper-content" v-for="item in 4" :key="item">
                    <div class="stepper-pane" v-if="step === item">
                        <template v-if="step === 1">
                            <h2 class="font-medium text-lg text-gray-800 dark:text-neutral-200">{{ $t('choosePlan') }}</h2>
                            <form @submit.prevent="submitForm">
                            <Pricing @plan-selected="handlePlanSelected"/>
                            </form>
                            </template>
                            <template v-if="step === 2">
                                <h2 class="font-medium text-lg text-gray-800 dark:text-neutral-200">{{ $t('createPassword') }}</h2>
                                <div class="flex justify-center p-4 sm:p-7">
                                    <div class="mt-5 w-full max-w-sm">
                                        <div class="flex justify-center mb-4">
                                            <svg class="items-center shrink-0 mt-2 size-10 text-orange-600 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        </div>
                                        <!-- Form -->
                                        <form @submit.prevent="submitForm">
                                            <input type="hidden" v-model="form.site_id" />
                                            <div class="grid gap-y-4">
                                                <div>
                                                    <div class="relative">
                                                        <input type="email" id="email" name="email"  v-model="form.email"  placeholder="Email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required aria-describedby="email-error">
                                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                                            <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <InputError class="mt-2" :message="form.errors.email" />
                                                </div>
                                                <!-- End Form Group -->
                                                <div>
                                                    <div class="relative">
                                                        <input type="password" id="password" name="password"  v-model="form.password"  placeholder="Password" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required aria-describedby="password-error">
                                                        <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                                            <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <InputError class="mt-2" :message="form.errors.password" />
                                                </div>
                                            </div>
                                        </form>
                                        <!-- End Form -->
                                    </div>
                                </div>
                            </template>
                            <template v-if="step === 3">
                                <div class="flex justify-center p-4 sm:p-7">
                                    <div class="mt-5 w-full max-w-sm">
                                        <div class="flex justify-center mb-4">
                                            <svg class="items-center shrink-0 mt-2 size-10 text-orange-600 dark:text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                        </div>
                                <!-- Form -->
                                <form @submit.prevent="submitForm">
                                    <div class="grid gap-y-4">
                                        <!-- Form Group -->
                                        <div>
                                            <div class="relative">
                                                <input type="text" id="name" name="name"  v-model="form.name"  placeholder="Name" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required aria-describedby="name-error">
                                                <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                                    <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                                                    </svg>
                                                </div>
                                            </div>
                                            <InputError class="mt-2" :message="form.errors.name" />
                                        </div>
                                        <div class="relative">
                                            <select v-model="form.document_type" id="document_type" name="document_type" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 mb-4">
                                                <option :value="null">Select option...</option>
                                                <option v-for="documentType in documentTypes" :key="documentType" :value="documentType">{{ documentType }}</option>
                                            </select><InputError :message="form.errors.documentType" class="mb-8"/>
                                            <input v-model="form.document_number" type="number" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" placeholder="Document Number"><InputError :message="form.errors.document_number" class="mt-2" />
                                        </div>
                                        <div v-if="form.required_Fields.length" class="relative">
                                            <div v-for="(field, index) in form.required_Fields" :key="index" class="mb-2">
                                                <input v-model="field.value" :type="field.field_type" :placeholder="field.name" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600" required aria-describedby="file-error"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- End Form -->
                        </div>
                    </div>
                        </template>
                        <template v-if="step === 4">
                            <h2 class="font-medium text-lg text-gray-800 dark:text-neutral-200">{{ $t('emailVerification') }}</h2>
                            <VerifyEmail/>
                        </template>
                    </div>
                </div>
                <div class="controls">
                    <button class="btn" @click="step--" :disabled="step === 1">{{ $t('Prev') }}</button>
                    <button
                        class="btn btn--orange-1"
                        @click="step === 4 ? submitForm() : step++"
                        :disabled="!canProceedToNextStep || step > 4"
                        :type="step === 4 ? 'submit' : 'button'"
                    >
                        {{ step < 4 ? $t('Next') : $t('Finish') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
@import "../../../scss/stepper.scss";

</style>

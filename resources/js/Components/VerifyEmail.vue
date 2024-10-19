<script setup>
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import {usePage} from "@inertiajs/vue3";


const { props } = usePage();
const email = props.value?.email || '';
console.log(props);

</script>

<template>
    <font-awesome-icon :icon="['fas', 'check-to-slot']" class="mt-10 text-4xl text-orange-500"/>
    <h1 class="mt-10 text-xl text-gray-800 font-bold md:text-2xl md:leading-tight lg:text-3xl lg:leading-tight dark:text-neutral-200">
        {{ $t ('Click the link we sent to') }} <br/> {{ $t('your email: ') }} <span class="text-orange-600 dark:text-orange-500">{{ email }}</span> <br/>
        {{ $t ('to complete the verification') }}
    </h1>
</template>

<style scoped>

</style>

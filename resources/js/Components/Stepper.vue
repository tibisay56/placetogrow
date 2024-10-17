<script setup>
import Pricing from "@/Components/Pricing.vue";
import Login from "@/Components/Login.vue";
import VerifyEmail from "@/Components/VerifyEmail.vue";
import {computed, ref} from "vue";

const step = ref(1);
const selectedPlan = ref(null);

const stepperProgress = computed(() => {
    return (100 / 3) * (step.value - 1) + '%';
});

const handlePlanSelected = (planId) => {
    selectedPlan.value = planId;
};

</script>


<template>
<div class="wrapper-stepper">
    <div class="stepper">
        <div class="stepper-progress">
            <div class="stepper-progress-bar" :style="{ width: stepperProgress }"></div>
        </div>
        <div class="stepper-item" :class="{ 'current': step === item, 'success': step > item }"  v-for="item in 4" :key="item">
            <div class="stepper-item-counter">
                <svg class="icon-success" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span class="number">
                    {{ item }}
                </span>
            </div>
            <span class="stepper-item-title">
                    {{ $t('Step') }} {{ item }}
            </span>
        </div>
    </div>

    <div class="stepper-content" v-for="item in 4" :key="item">
        <div class="stepper-pane" v-if="step === item">
            <template v-if="step === 1">
                <h2 class="font-medium text-lg text-gray-800 dark:text-neutral-200">{{ $t('choosePlan') }}</h2>
                <Pricing @plan-selected="handlePlanSelected"/>
            </template>
            <template v-if="step === 2">
                <h2 class="font-medium text-lg text-gray-800 dark:text-neutral-200">{{ $t('createPassword') }}</h2>
                <Login  :selected-plan="selectedPlan"/>
            </template>
            <template v-if="step === 3">
                <h2 class="font-medium text-lg text-gray-800 dark:text-neutral-200">{{ $t('emailVerification') }}</h2>
                <VerifyEmail/>
            </template>
            <template v-if="step === 4">
                <h2>Contenido del Paso 4</h2>
                <p>Aquí puedes agregar el contenido específico para el cuarto paso.</p>
            </template>
        </div>
    </div>

    <div class="controls">
        <button class="btn" @click="step--" :disabled="step === 1">
            {{ $t('Prev') }}
        </button>
        <button class="btn btn--orange-1" @click="step++" :disabled="step === 4">
            {{ $t('Next') }}
        </button>
    </div>
</div>
</template>

<style scoped lang="scss">
@import "../../scss/stepper.scss";

</style>

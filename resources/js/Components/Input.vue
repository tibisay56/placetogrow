<script setup>

defineEmits(['update:modelValue']);
</script>

<template>
<div>
    <label :for="name" class="block text-sm font-medium mb-2 dark:text-white"/>
    <input
        type="text"
        :name="name"
        :placeholder="label"
        :value ="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        class="py-3 px-4 block w-full border-gray200 rounded-md text-sm focus"
    />
</div>
</template>

<style scoped>

</style>

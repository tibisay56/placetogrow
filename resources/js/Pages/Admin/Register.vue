<template>
    <form @submit.prevent="submitForm">
        <input type="email" v-model="form.email" placeholder="Email" required>
        <input type="password" v-model="form.password" placeholder="Password" required>
        <button type="submit">Register Admin</button>
    </form>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/vue3';

export default {
    setup() {
        const { data, post, resetForm } = useForm({
            email: '',
            password: ''
        });

        const submitForm = () => {
            post('/admin/register', data)
                .then(() => {
                    resetForm();
                    // Handle success, e.g., show success message
                })
                .catch((error) => {
                    // Handle error, e.g., show error message
                });
        };

        return {
            form: data,
            submitForm
        };
    }
}
</script>

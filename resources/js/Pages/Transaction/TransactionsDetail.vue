<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Head from '@/Components/Head.vue';
import Invoice from '@/Pages/Transaction/Invoice.vue';

// Define props from controller
defineProps({
    data: {
        type: Object,
    }
});
</script>

<template>    
    <AuthenticatedLayout>
        <Head title="Detail Pesanan" />

        <Invoice :data="data" />
    </AuthenticatedLayout>
</template>
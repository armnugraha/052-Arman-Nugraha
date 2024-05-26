<script setup>
import { reactive, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import Head from '@/Components/Head.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Invoice from '@/Pages/Invoice.vue';

defineProps({
    data: {
        type: Object,
    }
});

let state = reactive({
    loading: false,
    data: null
})

onMounted(() => {
})

const deleteTransaction = (index) => {
    transaction.orders.splice(index, 1);
};
const addDots = (e, val, obj) => {
    val[obj] = Number(e.target.value.replace(/[^0-9]/g, '')).toLocaleString('id-ID', {maximumFractionDigits:0})
}
</script>

<template>    
    <AuthenticatedLayout>
        <Head title="Detail Pesanan" />

        <Invoice :data="data" />
    </AuthenticatedLayout>
</template>
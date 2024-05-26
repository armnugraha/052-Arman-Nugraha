<script setup>
import { reactive, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import Head from '@/Components/Head.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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

const addDots = (num) => {
    return num.toLocaleString('id-ID', {maximumFractionDigits:0})
}
const removeSeparator = (val) => {
    return val?.toString()?.replaceAll('.', '')
}

const discount = (val, e) => {
    const priceNumber = removeSeparator(e.total_price),
        total_payment   = removeSeparator(val.total_payment),
        total_price = removeSeparator(val.total_price),
        total_discount = priceNumber ? Math.round( ((priceNumber) / total_payment*total_price) ) : 0;

    return !isNaN(total_discount) ? total_discount : 0;
}

const copyText = (val) => {
    navigator.clipboard.writeText(val).then(() => {
        alertify.success("Data berhasil disalin")
    }).catch((error) => {
        alertify.failed("Data gagal disalin")
    });
}
</script>

<template>    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Pesanan:</h5>
                                <h5 class="font-size-15 mb-2">{{ data.user?.name }}</h5>
                                <p class="mb-1">{{ data.name }}</p>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">No Faktur:</h5>
                                    <p>#{{ data.trx_code }}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Tanggal Faktur:</h5>
                                    <p>{{ data.formatted_created_at }}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">No Pesan:</h5>
                                    <p>#{{ data.id }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                    
                    <div class="py-2">
                        <h5 class="font-size-15">Ringkasan Pesanan</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 70px;">No.</th>
                                        <th>Item</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th class="text-end" style="width: 120px;">Total</th>
                                    </tr>
                                </thead><!-- end thead -->
                                <tbody>
                                    <tr v-for="(trx, i) in data.orders" :key="i">
                                        <th scope="row">{{ i+1 }}</th>
                                        <td>
                                            <div>
                                                <h5 class="text-truncate font-size-14 mb-1">{{ trx.name ? `${trx.name}:` :'-' }}</h5>
                                                <p v-for="(detail, d) in trx.order_details" :key="d" class="text-muted mb-0">
                                                    {{ `${detail.name} Rp ${addDots(detail.price)} x (${detail.qty})` }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>Rp {{ addDots(trx.total_price) }}</td>
                                        <td>- Rp {{ addDots( discount(data, trx) ) }}</td>
                                        <td class="text-end">Rp {{ addDots(trx.total_price - discount(data, trx)) }}</td>
                                    </tr>
                                    <!-- end tr -->
                                    <tr>
                                        <th scope="row" colspan="4" class="text-end">Sub Total :</th>
                                        <td class="text-end">Rp {{ addDots(data.total_payment) }}</td>
                                    </tr>
                                    <!-- end tr -->
                                    <tr>
                                        <th scope="row" colspan="4" class="border-0 text-end">Diskon :</th>
                                        <td class="border-0 text-end">- Rp {{ addDots(data.total_payment - data.total_price) }}</td>
                                    </tr>
                                    <!-- end tr -->
                                    <tr>
                                        <th scope="row" colspan="4" class="border-0 text-end">Total :</th>
                                        <td class="border-0 text-end"><h4 class="m-0 fw-semibold">Rp {{ addDots(data.total_price) }}</h4></td>
                                    </tr>
                                    <!-- end tr -->
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive -->
                        <div class="d-print-none mt-4">
                            <div class="float-end">
                                <button type="button" class="btn btn-soft-secondary mr-4">{{ data.short_url }}</button>
                                <button type="button" @click="copyText(data.short_url)" class="btn btn-primary"><i class="mdi mdi-content-copy me-2"></i> Salin URL</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    </div><!-- end row -->
</template>
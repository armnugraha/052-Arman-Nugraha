<script setup>
import { reactive, ref, onMounted, watch } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Head from '@/Components/Head.vue';
// import { Inertia } from '@inertiajs/inertia';
import { Link, useForm, router } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    data: {
        type: Boolean,
    }
});

let state = reactive({
    loading: false
})
const search = ref('')
const form = useForm({});

onMounted(() => {
})
watch(search, async (newData, oldData) => {
    form.get(route('transactions', {search: newData}));
})

const changePage = (url) => {
    // Inertia.visit(url);
}

const deleteData = (id) => {
    if(confirm('Apakah anda yakin untuk menghapus data?')){
        state.loading = true
        form.delete(route('transactions.destroy', {id: id}), {
            // preserveScroll: true,
            onSuccess: (e) => {
                alertify.success("Data berhasil dihapus")
                state.loading = false
            },
            // onError: () => null,
            // onFinish: () => null,
            onError: (e) => {
                alertify.failed("Oops something went wrong")
                state.loading = false
            }
        });
    }
};
</script>

<template>
    
    <AuthenticatedLayout>
        <!-- start page title -->
        <Head title="Transaction" />
        <!-- end page title -->

        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <div class="search-box ">
                                        <div class="position-relative">
                                            <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="search">
                                            <i class="mdi mdi-table-search search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
                            <div class="col-md-3 text-right">
                                <div class="mb-3">
                                    <Link :href="route('dashboard')">
                                        <PrimaryButton :loading="state.loading" icon="mdi-plus">Tambah Data</PrimaryButton>
                                    </Link>
                                </div>
                            </div><!-- end col -->
                        </div><!-- end row -->
                    </div><!-- end card header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>TRX Code</th>
                                        <th>Nama</th>
                                        <th>Total Harga</th>
                                        <th>Total Bayar</th>
                                        <th>Waktu dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="!data.data.length">
                                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                    <tr v-for="(item, i) in data.data" :key="i">
                                        <th scope="row">{{ i+1 }}</th>
                                        <td>{{ item.trx_code }}</td>
                                        <td>{{ item.name }}</td>
                                        <td>Rp {{ item.total_payment.toLocaleString('id-ID', {maximumFractionDigits:0}) }}</td>
                                        <td>Rp {{ item.total_price.toLocaleString('id-ID', {maximumFractionDigits:0}) }}</td>
                                        <td>{{ item.formatted_created_at }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle card-drop"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i
                                                        class="mdi mdi-dots-horizontal font-size-18 text-muted"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a :href="route('transactions.show', {id: item.id})" class="dropdown-item">
                                                            <i class="mdi mdi-information-outline font-size-16 text-primary me-1"></i> Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item">
                                                            <i class="mdi mdi-pencil font-size-16 text-success me-1"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item" @click="deleteData(item.id)">
                                                            <i class="mdi mdi-trash-can font-size-16 text-danger me-1"></i> Hapus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                        </div><!-- end table responsive-->
                    </div><!-- end card body -->

                    <div class="row m-2">
                        <div class="col-sm-6">
                            <div>
                                <p class="mb-sm-0">{{ `Showing ${data.current_page} to ${data.last_page} of ${data.total} entries` }}</p>
                            </div>
                        </div><!-- end col -->
                        <div class="col-sm-6">
                            <div class="float-sm-end">
                                <ul class="pagination pagination-rounded mb-sm-0">
                                    <li v-for="(page, i) in data?.links" :key="i" class="page-item" :class="!page.url ? 'disabled' : page.active ? 'active' : ''">
                                        <Link :href="page.url" class="page-link">
                                            <template v-if="page?.label.includes('Previous')">
                                                <i class="mdi mdi-chevron-left"></i>
                                            </template>
                                            <template v-else-if="page?.label.includes('Next')">
                                                <i class="mdi mdi-chevron-right"></i>
                                            </template>
                                            <template v-else>{{ page?.label }}</template>
                                        </Link>
                                    </li>
                                </ul><!-- end ul -->
                            </div>
                        </div><!-- end col -->
                    </div><!-- end row -->
                </div><!-- end card -->
            </div><!-- end card body -->
        </div><!-- end row -->
    </AuthenticatedLayout>
</template>
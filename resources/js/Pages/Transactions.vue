<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Head from '@/Components/Head.vue';
// import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/vue3';

defineProps({
    data: {
        type: Boolean,
    }
});

const changePage = (url) => {
    // Inertia.visit(url);
}
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
                                            <input type="text" class="form-control bg-light border-light rounded" placeholder="Search...">
                                            <i class="mdi mdi-table-search search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
                            <div class="col-md-3 text-right">
                                <div class="mb-3">
                                    <a href="projects-create.html" class="btn btn-sm btn-outline-success">
                                        <i class="mdi mdi-plus me-1"></i> Add New
                                    </a>
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
                                        <td></td>
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
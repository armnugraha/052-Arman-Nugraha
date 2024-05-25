<script setup>
import { reactive, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm, router } from '@inertiajs/vue3';
import Head from '@/Components/Head.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

let state = reactive({
    loading: false,
    data: null
})
let transaction = useForm({
    name: '',
    total_payment: 0,
    total_price: 0,
    orders: []
})

onMounted(() => {
    // router.get(route('test'), {
    //     onFinish: () => {
    //         console.log('asd')
    //     }
    // })
    generateOrders()
})

const generateOrders = () => {
    for (let index = 0; index < 4; index++) {
        transaction.orders.push({
            name: null,
            total_price: 0,
            detail: [
                {
                    name: null,
                    qty: 0,
                    price: 0,
                }
            ],
            temp: {
                is_detail: false,
                discount_price: 0,
                discount_percent: 0
            }
        })
    }
}

const changeDetail = (e) => {
    e.total_price = 0

    e.temp.is_detail = !e.temp.is_detail
    e.temp.discount_price = 0
    e.temp.discount_percent = 0
}

const addTransaction = () => {
    transaction.orders.push(
        {
            name: null,
            total_price: 0,
            detail: [
                {
                    name: null,
                    qty: 0,
                    price: 0,
                }
            ],
            temp: {
                is_detail: false,
                discount_price: 0,
                discount_percent: 0
            }
        }
    )
};
const deleteTransaction = (index) => {
    transaction.orders.splice(index, 1);
};

const addDetailTransaction = (item) => {
    item.detail.push(
        {
            name: null,
            qty: 0,
            price: 0
        }
    )
};
const deleteDetailTransaction = (item, index) => {
    item.detail.splice(index, 1);
};

const number = (e) => {
    e = (e) ? e : window.event;
    var charCode = (e.which) ? e.which : e.keyCode;
    
    if (charCode === 46) {
        e.preventDefault();
    }

    if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
        e.preventDefault();
    } else {
        return true;
    }
}
const addDots = (e, val, obj) => {
    val[obj] = Number(e.target.value.replace(/[^0-9]/g, '')).toLocaleString('id-ID', {maximumFractionDigits:0})
}
const removeSeparator = (val) => {
    return val?.toString()?.replaceAll('.', '')
}

const sumPrice = (item) => {
    const sum = item.detail?.reduce((i, trx) => i + (parseInt(trx.qty) * removeSeparator(trx.price)), 0);
    item.total_price = Number(sum).toLocaleString('id-ID', {maximumFractionDigits:0})
}

const discount = (e) => {
    const priceNumber = removeSeparator(e.total_price),
        total_payment   = removeSeparator(transaction.total_payment),
        total_price = removeSeparator(transaction.total_price);

    e.temp.discount_price = priceNumber ? Math.round( ((priceNumber) / total_payment*total_price) ).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 0
    return !isNaN(e.temp.discount_price) ? e.temp.discount_price : 0;
}
const percentDiscount = (e) => {
    const price = removeSeparator(transaction.total_price),
        discount = removeSeparator(e.temp.discount_price),
        percent = ((discount / price) * 100).toFixed();
        e.temp.discount_percent = percent

    return !isNaN(percent) ? percent : 0
}

const submit = () => {
    if(confirm('Apakah data sudah benar?')){
        state.loading = true
        transaction.post(route('transactions.create'), {
            onFinish: () => {
                alertify.success("Data berhasil dibuat")
                transaction.reset('name', 'total_payment', 'total_price')
                transaction.name = ''
                transaction.total_payment = 0
                transaction.total_price = 0
                transaction.orders = []
                generateOrders()
                state.loading = false
            },
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
        <Head title="Dashboard" />

        <form @submit.prevent="submit">
            <div class="d-xl-flex">
                <div class="w-100">
                    <div class="d-md-flex">
                        <div class="w-100">
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <div class="row mb-3">
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="search-box mb-2">
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control bg-light border-light rounded" placeholder="Search...">
                                                        <i class="mdi mdi-close-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col-sm-6">
                                                <div class="mt-4 mt-sm-0 d-flex align-items-center justify-content-sm-end">
                                                    <div class="mb-2">
                                                        <button @click="addTransaction" class="btn btn-primary" type="button">
                                                            <i class="mdi mdi-plus"></i> Tambah List
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="row">
                                            <div v-for="(item, i) in transaction.orders" :key="i" class="col-xl-4 col-sm-6">
                                                <div class="card shadow-none border">
                                                    <div class="card-body p-3">
                                                        <div>
                                                            <div class="float-end ms-2">
                                                                <div class="mb-2">
                                                                    <a @click="deleteTransaction(i)" class="font-size-16 text-muted" role="button">
                                                                        <i class="mdi mdi-close"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <div class="me-3 mb-3">
                                                                <div class="form-check form-switch form-switch-md mb-2">
                                                                    <input class="form-check-input" type="checkbox" :disabled="!$page.props.auth.user" @change="$page.props.auth.user ? changeDetail(item) : null">
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <p class="text-center mb-4">
                                                                    <input type="text" v-model="item.total_price" :disabled="item.temp.is_detail" @keypress="[number($event)]" @input="addDots($event, item, 'total_price')" :class="item.temp.is_detail ? 'disabled' : ''" class="price-input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm border-gray-300 rounded-md" placeholder="xxx">
                                                                </p>
                                                                <div class="mt-3">
                                                                    <div class="d-flex space-between align-center mb-1">
                                                                        <p class="text-muted font-size-13">Diskon Voucher: Rp {{ discount(item)  }}</p>
                                                                        <template v-if="percentDiscount(item) <= 100">
                                                                            <span class="badge badge-outline-primary">
                                                                                {{ `${percentDiscount(item)}%` }}
                                                                                <i v-if="percentDiscount(item) > 0" class="mdi mdi-arrow-down text-primary"></i>
                                                                            </span>
                                                                        </template>
                                                                        <template v-else>
                                                                            <span class="badge badge-outline-danger">
                                                                                {{ `${percentDiscount(item)}%` }}
                                                                                <i class="mdi mdi-arrow-up text-danger"></i>
                                                                            </span>
                                                                        </template>
                                                                    </div>
                                                                    <div class="progress animated-progess custom-progress">
                                                                        <div class="progress-bar" :class="percentDiscount(item) > 100 ? 'bg-danger' : null" role="progressbar" :style="`width: ${percentDiscount(item)}%`" :aria-valuenow="percentDiscount(item)" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <template v-if="item.temp.is_detail">
                                                                <div class="mt-4 result">
                                                                    <div v-for="(detail, d) in item.detail" :key="d" class="detail-item">
                                                                        <div class="flex space-between">
                                                                            <div class="mb-2 mr-4">
                                                                                <label for="total-price-input" class="block text-sm font-medium text-gray-700">Nama</label>
                                                                                <input type="text" v-model="detail.name" placeholder="Kasih nama / judul dong" name="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <a @click="deleteDetailTransaction(item, d)" class="font-size-16 text-muted" role="button">
                                                                                    <i class="mdi mdi-close"></i>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="flex">
                                                                            <div class="mb-2 mr-4">
                                                                                <label for="total-amount-input" class="block text-sm font-medium text-gray-700">Qty</label>
                                                                                <input type="text" v-model="detail.qty" placeholder="xxx" @keypress="[number($event)]" @input="addDots($event, detail, 'qty')" name="total-amount-input" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                                            </div>
                                                                            <div class="mb-2">
                                                                                <label for="total-price-input" class="block text-sm font-medium text-gray-700">Harga</label>
                                                                                <input type="text" v-model="detail.price" placeholder="xxx" @keypress="[number($event)]" @input="[addDots($event, detail, 'price'), sumPrice(item)]" name="total-price-input" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="result pt-4 text-center">
                                                                    <p @click="addDetailTransaction(item)" class="cursor-pointer"><span class="mdi mdi-plus text-center"></span> Tambah List</p>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div><!-- end card body -->
                                                </div><!-- end card -->
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                    </div>

                                </div><!-- end cardbody-->
                            </div><!-- end card -->
                        </div><!-- end w-100 -->
                    </div>
                </div>

                <div class="card filemanager-sidebar ms-lg-3">
                    <div class="card-body">
                        <div class="mb-4">
                            <p>Detail Informasi:</p>
                        </div>
                        <div v-if="$page.props.auth.user" class="mb-4">
                            <label for="total-price-input" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input type="text" v-model="transaction.name" placeholder="Kasih nama / judul dong" name="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            <InputError class="mt-2" :message="transaction.errors.name" />
                        </div>
                        <div class="mb-4">
                            <label for="total-price-input" class="block text-sm font-medium text-gray-700">Total Harga</label>
                            <input type="text" v-model="transaction.total_payment" placeholder="xxx" @keypress="[number($event)]" @input="addDots($event, transaction, 'total_payment')" name="total-price-input" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="total-amount-input" class="block text-sm font-medium text-gray-700">Total Bayar</label>
                            <input type="text" v-model="transaction.total_price" placeholder="xxx" @keypress="[number($event)]" @input="addDots($event, transaction, 'total_price')" name="total-amount-input" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div v-if="$page.props.auth.user" class="mb-4">
                            <PrimaryButton :loading="state.loading">Simpan</PrimaryButton>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end row -->
        </form><!-- end form -->
    </AuthenticatedLayout>
</template>

<script setup>
import { reactive, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

let state = reactive({
    loading: false
})
let transaction = useForm({
    name: '',
    total_payment: 0,
    total_price: 0,
    orders: []
})

onMounted(() => {
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
})

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
    transaction.post(route('transactions.create'), {
        // onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template> -->
        <div class="mt-24">
            <div class="flex justify-center">
                <form @submit.prevent="submit">
                    <div class="flex w-full max-w-screen-lg">
                        <!-- Left Column -->
                        <div class="w-4/5 p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4">
                                <!-- Card -->
                                <div v-for="(item, i) in transaction.orders" :key="i" class="bg-white rounded-lg shadow-md h-fit-content">
                                    <div class="p-4">
                                        <div>
                                            <p class="flex fr mb-4">
                                                <label v-if="$page.props.auth.user" class="inline-flex items-center cursor-pointer mr-4">
                                                    <input type="checkbox" @change="changeDetail(item)" class="sr-only peer">
                                                    <div :class="item.temp.is_detail ? 'peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white peer-checked:bg-blue-600' : 'bg-gray-200'"class="relative w-11 h-6 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                                </label>
                                                <span @click="deleteTransaction(i)" class="mdi mdi-close"></span>
                                            </p>
                                            <p class="text-center mb-4">
                                                <input type="text" v-model="item.total_price" :disabled="item.temp.is_detail" @keypress="[number($event)]" @input="addDots($event, item, 'total_price')" :class="item.temp.is_detail ? 'disabled' : ''" class="price-input mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm border-gray-300 rounded-md" placeholder="xxx">
                                            </p>
                                        </div>
                                        <div>
                                            <p>Diskon Voucher</p>
                                            <div class="flex w-full h-1.5 bg-gray-200 rounded-full overflow-hidden dark:bg-neutral-700" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                <div class="flex flex-col justify-center rounded-full overflow-hidden text-xs text-white text-center whitespace-nowrap transition duration-500" :class="percentDiscount(item) <= 100 ? 'bg-blue-600 dark:bg-blue-500' : 'bg-red-600 dark:bg-red-500'" :style="`width: ${percentDiscount(item)}%`"></div>
                                            </div>
                                            <div class="text-right">
                                                <span>{{ percentDiscount(item) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="item.temp.is_detail">
                                        <div class="result">
                                            <div v-for="(detail, d) in item.detail" :key="d" class="detail-item">
                                                <div class="flex">
                                                    <div class="mb-4 mr-4">
                                                        <label for="total-price-input" class="block text-sm font-medium text-gray-700">Nama</label>
                                                        <input type="text" v-model="detail.name" placeholder="Kasih nama / judul dong" name="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mb-4">
                                                        <span @click="deleteDetailTransaction(item, d)" class="mdi mdi-close"></span>
                                                    </div>
                                                </div>
                                                <div class="flex">
                                                    <div class="mb-4 mr-4">
                                                        <label for="total-amount-input" class="block text-sm font-medium text-gray-700">Qty</label>
                                                        <input type="text" v-model="detail.qty" placeholder="xxx" @keypress="[number($event)]" @input="addDots($event, detail, 'qty')" name="total-amount-input" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="total-price-input" class="block text-sm font-medium text-gray-700">Harga</label>
                                                        <input type="text" v-model="detail.price" placeholder="xxx" @keypress="[number($event)]" @input="[addDots($event, detail, 'price'), sumPrice(item)]" name="total-price-input" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="result p-4 text-center">
                                            <p @click="addDetailTransaction(item)" class="cursor-pointer"><span class="mdi mdi-plus text-center"></span> Tambah List</p>
                                        </div>
                                    </div>
                                    <div class="result">
                                        <div class="p-4 flex space-between">
                                            <p>Harga hasil: </p>
                                            <span class="result-span">{{ discount(item)  }}</span>
                                        </div>
                                    </div>
                                </div>
        
                                <!-- Add more cards as needed -->
                                <div class="bg-white rounded-lg shadow-md p-4 h-fit-content">
                                    <div class="add-more">
                                        <p @click="addTransaction"><span class="mdi mdi-plus text-center"></span> Tambah List</p>
                                    </div>
                                </div>
                            </div>
                        </div>
        
                        <!-- Right Column -->
                        <div class="w-1/4 p-4 bg-white max-h-fit m-16">
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
                                <PrimaryButton>Simpan</PrimaryButton>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

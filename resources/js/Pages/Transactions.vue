<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="mt-24">
            <div class="container mx-auto">
                <div class="flex justify-between items-center mb-4">
                    <!-- Search Input -->
                    <div class="w-3/4">
                        <input type="text" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Search...">
                    </div>
                    <!-- Create Button -->
                    <div>
                        <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Create</button>
                    </div>
                </div>
    
                <!-- Table -->
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">TRX Code</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Bayar</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu dibuat</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">MVS/001/01/04/2004</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp 150.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp 50.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">01 May 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">Bagikan</button>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">Edit</button>
                                <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">MVS/001/01/04/2004</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp 150.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp 50.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">01 May 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">Bagikan</button>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">Edit</button>
                                <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">MVS/001/01/04/2004</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp 150.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">Rp 50.000</td>
                            <td class="px-6 py-4 whitespace-nowrap">01 May 2024</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">Bagikan</button>
                                <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mr-2">Edit</button>
                                <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
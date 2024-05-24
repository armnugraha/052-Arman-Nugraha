<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div id="layout-wrapper">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user" :href="route('transactions')" :active="route().current('transactions')">
                                    Transactions
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <div class="ms-3 relative">
                                <Link
                                    v-if="!$page.props.auth.user"
                                    :href="route('login')"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:focus-visible:ring-white"
                                >
                                    Log in
                                </Link>

                                <Dropdown v-else align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('transactions')" :active="route().current('transactions')">
                            Transactions
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props?.auth?.user?.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props?.auth?.user?.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('login')"> Login </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('register')"> Register </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <slot />

                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <!-- Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="font-size-xs text-uppercase">Total Revenue</h6>
                                                <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                                                    $46.34k
                                                </h4>
                                                <div class="text-muted">Earning this month</div>
                                            </div>
                                            <div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle btn btn-light btn-sm" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"><span class="text-muted">Monthly<i
                                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                                    </a>

                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Monthly</a>
                                                        <a class="dropdown-item" href="#">Yearly</a>
                                                        <a class="dropdown-item" href="#">Weekly</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="apex-charts mt-3" id="sparkline-chart-1"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <!-- Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="font-size-xs text-uppercase">Total Refunds</h6>
                                                <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                                                    $895.02
                                                </h4>
                                                <div class="text-muted">Refunds this month</div>
                                            </div>
                                            <div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle btn btn-light btn-sm" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"><span class="text-muted">Monthly<i
                                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                                    </a>

                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Monthly</a>
                                                        <a class="dropdown-item" href="#">Yearly</a>
                                                        <a class="dropdown-item" href="#">Weekly</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="apex-charts mt-3" id="sparkline-chart-2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <!-- Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="font-size-xs text-uppercase">Active Users</h6>
                                                <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                                                    6,985
                                                </h4>
                                                <div class="text-muted">Users this Week</div>
                                            </div>
                                            <div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle btn btn-light btn-sm" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"><span class="text-muted">Weekly<i
                                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                                    </a>

                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Monthly</a>
                                                        <a class="dropdown-item" href="#">Yearly</a>
                                                        <a class="dropdown-item" href="#">Weekly</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="apex-charts mt-3" id="sparkline-chart-3"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <!-- Card -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h6 class="font-size-xs text-uppercase">All Time Orders</h6>
                                                <h4 class="mt-4 font-weight-bold mb-2 d-flex align-items-center">
                                                    12,584
                                                </h4>
                                                <div class="text-muted">Total Number of Orders</div>
                                            </div>
                                            <div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle btn btn-light btn-sm" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false"><span class="text-muted">Yearly<i
                                                                class="mdi mdi-chevron-down ms-1"></i></span>
                                                    </a>

                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Monthly</a>
                                                        <a class="dropdown-item" href="#">Yearly</a>
                                                        <a class="dropdown-item" href="#">Weekly</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="apex-charts mt-3" id="sparkline-chart-4"></div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row-->

                        <div class="row">
                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="alert alert-warning border-0 d-flex align-items-center" role="alert">
                                            <i class="uil uil-exclamation-triangle font-size-16 text-warning me-2"></i>
                                            <div class="flex-grow-1 text-truncate">
                                                Your free trial expired in <b>21</b> days. 
                                            </div>
                                            <div class="flex-shrink-0">
                                                <a href="pricing-basic.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col-sm-7">
                                                <p class="font-size-18">Upgrade your plan from a <span class="fw-semibold">Free
                                                        trial</span>, to ‘Premium Plan’ <i class="mdi mdi-arrow-right"></i></p>
                                                <div class="mt-4">
                                                    <a href="pricing-basic.html" class="btn btn-primary">Upgrade Account!</a>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <img src="assets/images/illustrator/2.png" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div>
                                <!-- end card -->

                                <div class="card">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-reset" href="#"
                                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="fw-semibold">Report By:</span> <span
                                                        class="text-muted">Monthly<i
                                                            class="mdi mdi-chevron-down ms-1"></i></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Yearly</a>
                                                    <a class="dropdown-item" href="#">Monthly</a>
                                                    <a class="dropdown-item" href="#">Weekly</a>
                                                    <a class="dropdown-item" href="#">Today</a>
                                                </div>
                                            </div>
                                        </div>

                                        <h4 class="card-title mb-4">Earning Reports</h4>

                                        <div class="row align-items-center">
                                            <div class="col-sm-7">
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <p class="text-muted mb-2">This Month</p>
                                                        <h5>$12,582<small
                                                                class="badge badge-soft-success font-13 ms-2">+15%</small></h5>
                                                    </div>

                                                    <div class="col-6">
                                                        <p class="text-muted mb-2">Last Month</p>
                                                        <h5>$98,741</h5>
                                                    </div>
                                                </div>
                                                <p class="text-muted"><span class="text-success me-1"> 25.2%<i
                                                            class="mdi mdi-arrow-up"></i></span>From previous period</p>

                                                <div class="mt-4">
                                                    <a href="" class="btn btn-soft-secondary btn-sm">Generate Reports <i
                                                            class="mdi mdi-arrow-right ms-1"></i></a>
                                                </div>
                                            </div> <!-- end col-->
                                            <div class="col-sm-5">
                                                <div class="mt-4 mt-0">
                                                    <div id="donut_chart" class="apex-charts" dir="ltr"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end card -->
                            </div> <!-- end col-->

                            <div class="col-xl-8">
                                <div class="card card-h-100">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle text-reset" href="#" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <span class="fw-semibold">Sort By:</span> <span class="text-muted">Yearly<i
                                                            class="mdi mdi-chevron-down ms-1"></i></span>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Yearly</a>
                                                    <a class="dropdown-item" href="#">Monthly</a>
                                                    <a class="dropdown-item" href="#">Weekly</a>
                                                    <a class="dropdown-item" href="#">Today</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="card-title mb-4">Sales Analytics</h4>

                                        <div class="mt-1">
                                            <ul class="list-inline main-chart mb-0 text-center">
                                                <li class="list-inline-item chart-border-left me-0 border-0">
                                                    <h3 class="text-primary">$<span data-plugin="counterup">3.85k</span><span
                                                            class="text-muted d-inline-block fw-normal font-size-15 ms-2">Income</span>
                                                    </h3>
                                                </li>
                                                <li class="list-inline-item chart-border-left me-0">
                                                    <h3><span data-plugin="counterup">258</span><span
                                                            class="text-muted d-inline-block fw-normal font-size-15 ms-2">Sales</span>
                                                    </h3>
                                                </li>
                                                <li class="list-inline-item chart-border-left me-0">
                                                    <h3><span data-plugin="counterup">52</span>k<span
                                                            class="text-muted d-inline-block fw-normal font-size-15 ms-2">Users</span>
                                                    </h3>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mt-3">
                                            <div id="sales-analytics-chart" class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                &copy; MVS.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Crafted with <i class="mdi mdi-heart text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

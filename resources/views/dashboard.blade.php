@php
    $orderStatuses = array_map(function ($status) {
        return ucfirst($status);
    }, config('order.statuses'));
    $paymentMethods = ['cash' => 'Cash', 'card' => 'Card'];
@endphp

@extends('layouts.admin.master')

@section('main')
    {{-- Tiles --}}
    <div class="grid w-full grid-cols-1 gap-4 xl:grid-cols-2 2xl:grid-cols-4 mb-8">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">Total revenue</h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">£{{ $totalRevenue }}</p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-money-bill"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">Total orders</h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    {{ $totalOrders }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">Total customers</h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    {{ $totalCustomers }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-users"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">Active coupons</h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    {{ $activeCoupons }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-ticket"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">Tody's orders</h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    {{ $ordersToday }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">Orders (Last 7 days)</h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    {{ $ordersLast7Days }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">
                Orders (Last 30 days)
            </h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    {{ $ordersLast30Days }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">
                Sales (Today)
            </h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    £{{ $salesToday }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-money-bill"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">
                Sales (Last 7 days)
            </h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    £{{ $salesLast7Days }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-money-bill"></i>
                </p>
            </div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">
                Sales (Last 30 days)
            </h3>
            <div class="flex items-end justify-between">
                <p class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">
                    £{{ $salesLast30Days }}
                </p>
                <p class="text-gray-500 dark:text-gray-400 text-3xl">
                    <i class="fa-solid fa-money-bill"></i>
                </p>
            </div>
        </div>
    </div>

    {{-- Tables --}}
    @if (auth()->user()->type == 2)
        <div class="mb-2 grid grid-cols-3 gap-4">
            <div class="col-span-2">
                <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">Recent Orders</h3>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="text-base">
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    No of items
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Payable
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    method
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Last update
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentOrders as $order)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        <a class="text-blue-600 dark:text-blue-400 underline"
                                            href="{{ route('orders.show', $order->id) }}">#{{ $order->id }}</a>
                                    </th>
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ count($order->items) }}
                                    </th>
                                    <td class="px-6 py-4">
                                        @if ($order->coupon)
                                            £{{ $order->amount - $order->coupon->discount }}
                                        @else
                                            £{{ $order->amount }}
                                        @endif
                                    </td>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ ucfirst($order->payment_method) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $order->updated_at ? $order->updated_at->setTimezone('GMT')->format('d M Y, H:i:s') : $order->created_at->setTimezone('GMT')->format('d M Y, H:i:s') }}
                                        GMT
                                    </td>
                                    <td class="px-6 py-4">
                                        @include('orders.partials.status-badge', [
                                            'status' => $order->status,
                                        ])
                                    </td>
                                    <td class="px-6 py-4">
                                        @include('orders.partials.status-update', [
                                            'status' => $order->status,
                                            'paymentMethod' => $order->payment_method,
                                        ])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-span-1">
                <h3 class="text-xl font-normal text-gray-500 dark:text-gray-400 mb-2">Top selling Items</h3>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="text-base">
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Quantity
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($topSellingItems as $item)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">

                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $item['name'] }}
                                    </th>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $item['quantity'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

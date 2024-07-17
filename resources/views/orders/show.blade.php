@php
    $orderStatuses = array_map(function ($status) {
        return ucfirst($status);
    }, config('order.statuses'));
    $paymentMethods = ['cash' => 'Cash', 'card' => 'Card'];
@endphp

@extends('layouts.admin.master')
@section('title', 'Order Details')

@section('main')
    <main class="max-w-5xl px-">
        <div class="flex justify-between mb-5">
            <h1 class="text-2xl font-bold text-black dark:text-gray-200">Order #{{ $order->id }}</h1>
            <a href="{{ route('orders') }}" class="text-blue-600 dark:text-blue-400 underline">Back to Orders</a>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200">
                    Order Information
                </h3>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700">
                <dl>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Order ID</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">#{{ $order->id }}
                        </dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Placed at</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            {{ $order->created_at->setTimezone('GMT')->format('d M Y, H:i:s') }} GMT
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Customer Information</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            <div>Name: {{ $order->customer_name }}</div>
                            @if ($order->customer_email)
                                <div>Email: {{ $order->customer_email }}</div>
                            @endif
                            <div>Phone: {{ $order->customer_phone }}</div>
                        </dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm text-gray-500 dark:text-gray-300 mb-2 font-semibold">Order Items</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            <table class="w-full border-collapse border border-gray-200 dark:border-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="text-left border border-gray-200 dark:border-gray-700 px-4 py-2">Item
                                            Name</th>
                                        <th class="text-left border border-gray-200 dark:border-gray-700 px-4 py-2">Unit
                                            Price</th>
                                        <th class="text-left border border-gray-200 dark:border-gray-700 px-4 py-2">Quantity
                                        </th>
                                        <th class="text-left border border-gray-200 dark:border-gray-700 px-4 py-2">Total
                                            Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="border border-gray-200 dark:border-gray-700 px-4 py-2">
                                                {{ $item['name'] }}</td>
                                            <td class="border border-gray-200 dark:border-gray-700 px-4 py-2">
                                                £{{ $item['price'] }}</td>
                                            <td class="border border-gray-200 dark:border-gray-700 px-4 py-2">
                                                {{ $item['quantity'] }}</td>
                                            <td class="border border-gray-200 dark:border-gray-700 px-4 py-2">
                                                £{{ $item['price'] * $item['quantity'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Total Amount</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            £{{ $order->amount }}</dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Discount</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            @if ($order->coupon)
                                {{ $order->coupon->coupon_type == 0
                                    ? "{$order->coupon->valu}%, £{$order->coupon->discount}"
                                    : "flat £{$order->coupon->value}" }}
                            @else
                                None
                            @endif
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Amount after Discount</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            @if ($order->coupon)
                                £{{ $order->amount - $order->coupon->discount }}
                            @else
                                £{{ $order->amount }}
                            @endif
                        </dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Payment Method</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            {{ ucfirst($order->payment_method) }}
                        </dd>
                    </div>
                    @if ($order->payment_method != 'cash')
                        <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Payment ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                                #{{ $order->payment->id }}
                            </dd>
                        </div>
                    @endif
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Last Update</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            {{ $order->updated_at ? $order->updated_at->setTimezone('GMT')->format('d M Y, H:i:s') : $order->created_at->setTimezone('GMT')->format('d M Y, H:i:s') }}
                            GMT
                        </dd>
                    </div>
                    <div class="bg-white dark:bg-gray-800 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            @include('orders.partials.status-badge', ['status' => $order->status])
                        </dd>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-900 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-300">Actions</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 sm:mt-0 sm:col-span-2">
                            @include('orders.partials.status-update', [
                                'status' => $order->status,
                                'paymentMethod' => $order->payment_method,
                            ])
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </main>
@endsection

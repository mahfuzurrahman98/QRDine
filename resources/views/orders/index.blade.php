@php
    $orderStatuses = array_map(function ($status) {
        return ucfirst($status);
    }, config('order.statuses'));
    $paymentMethods = ['cash' => 'Cash', 'card' => 'Card'];
@endphp

@extends('layouts.admin.master')
@section('title', 'Orders')

@section('main')
    <main>
        <div class="flex justify-between mb-5">
            <h1 class="text-2xl font-bold text-black dark:text-gray-200">Orders</h1>
        </div>

        <div class="mb-4">
            <form action="{{ route('orders') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <x-form.input label="Date from" type="date" name="date_from" id="date_from"
                        value="{{ Request::input('date_from') }}" placeholder="Enter date" required="0"
                        class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

                    <x-form.input label="Date to" type="date" name="date_to" id="date_to"
                        value="{{ Request::input('date_to') }}" placeholder="Enter date" required="0"
                        class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

                    <x-form.select label="Order status" name="status" id="status" value="{{ Request::input('status') }}"
                        placeholder="Select status" required="0" :options="$orderStatuses"
                        class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

                    <x-form.select label="Payment status" name="payment_method" id="payment_method"
                        value="{{ Request::input('payment_method') }}" placeholder="Select payment method" required="0"
                        :options="$paymentMethods" class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

                    <div class="md:mt-7">
                        <x-button type="submit" id="edit-restaurant-btn" usage="update"
                            class="bg-blue-600 dark:bg-blue-800 text-white dark:text-white rounded px-4 py-2 transition duration-300 hover:bg-blue-700 dark:hover:bg-blue-900">
                            Search
                        </x-button>
                    </div>
                </div>
            </form>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-base">
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Placed at
                        </th>
                        <th scope="col" class="px-6 py-3">
                            No of items
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Price
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Discount
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Payable
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Payment method
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Last update
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Last status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a class="text-blue-600 dark:text-blue-400 underline"
                                    href="{{ route('orders.show', $order->id) }}">#{{ $order->id }}</a>
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $order->created_at->setTimezone('GMT')->format('d M Y, H:i:s') }} GMT
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ count($order->items) }}
                            </th>
                            <td class="px-6 py-4">
                                £{{ $order->amount }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($order->coupon)
                                    £{{ $order->coupon->discount }}
                                    ({{ $order->coupon->coupon_type == 0 ? "{$order->coupon->value} %" : 'flat' }})
                                @else
                                    None
                                @endif
                            </td>
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
                                @include('orders.partials.status-badge', ['status' => $order->status])
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
        <div class="mt-4 mb-2">
            {{ $orders->links() }}
        </div>
    </main>
@endsection

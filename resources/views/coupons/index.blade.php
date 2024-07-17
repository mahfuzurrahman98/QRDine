@extends('layouts.admin.master')

@section('main')
    <div class="flex justify-between mb-5">
        <h1 class="text-2xl font-bold text-black dark:text-gray-200">Coupons</h1>
        <a href="{{ route('coupons.create') }}"
            class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            Add new coupon
        </a>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="text-base">
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Code</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Value</th>
                    <th scope="col" class="px-6 py-3">Valid From</th>
                    <th scope="col" class="px-6 py-3">Valid To</th>
                    <th scope="col" class="px-6 py-3">Limit</th>
                    <th scope="col" class="px-6 py-3">Used</th>
                    <th scope="col" class="px-6 py-3">Active</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coupons as $coupon)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">{{ $coupon->name }}</td>
                        <td class="px-6 py-4">{{ $coupon->code }}</td>
                        <td class="px-6 py-4">{{ $coupon->type }}</td>
                        <td class="px-6 py-4">{{ $coupon->value }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($coupon->valid_from)->format('M d, Y') }}</td>
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($coupon->valid_to)->format('M d, Y') }}</td>
                        <td class="px-6 py-4">{{ $coupon->limit }}</td>
                        <td class="px-6 py-4">{{ $coupon->used }}</td>

                        <td class="px-6 py-4">{{ $coupon->active ? 'Yes' : 'No' }}</td>
                        <td class="px-6 py-4 flex gap-x-3 text-right">
                            <a href="{{ route('coupons.edit', $coupon->id) }}"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <i class="fas fa-edit" aria-hidden="true"></i>
                            </a>
                            <button
                                class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1 text-center dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-700"
                                type="button" onclick="confirmDelete('{{ $coupon->id }}')">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Delete modal -->
    <button id="delete-coupon-modal-btn" data-modal-target="delete-coupon-modal" data-modal-toggle="delete-coupon-modal"
        class="hidden" type="button">
    </button>
    <div id="delete-coupon-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <i class="fas fa-circle-info text-6xl mx-auto mb-4 text-gray-600 w-12 h-12 dark:text-gray-200"></i>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Are you sure you want to delete this coupon?
                    </h3>
                    <button data-modal-hide="delete-coupon-modal" type="button" onclick="deleteCoupon()"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button data-modal-hide="delete-coupon-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-600 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let couponId;

        // define iziToast options
        // open from the right
        iziToast.settings({
            position: 'topRight',
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight'
        });

        function confirmDelete(id) {
            couponId = id;
            const el = document.getElementById('delete-coupon-modal-btn');
            el.click();
        }

        async function deleteCoupon() {
            const response = await fetch(`/coupons/${couponId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            if (response.ok) {
                console.log(response);
                iziToast.success({
                    title: 'Success',
                    message: 'Coupon deleted successfully'
                });
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                console.error(error);
                iziToast.error({
                    title: 'Error',
                    message: error.response.data.message
                });
            }
        }
    </script>
@endsection

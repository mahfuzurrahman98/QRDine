@extends('layouts.admin.master')

@section('main')
    <main>
        <div class="flex justify-between mb-5">
            <h1 class="text-2xl font-bold text-black dark:text-gray-200">Restaurants</h1>
        </div>

        <div class="mb-4">
            <form action="{{ route('restaurants') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <x-form.input label="Date from" type="date" name="date_from" id="date_from"
                        value="{{ Request::input('date_from') }}" placeholder="Enter date" required="0"
                        class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

                    <x-form.input label="Date to" type="date" name="date_to" id="date_to"
                        value="{{ Request::input('date_to') }}" placeholder="Enter date" required="0"
                        class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

                    <x-form.input label="Name/Slug" type="text" name="name" id="name"
                        value="{{ Request::input('name') }}" placeholder="Enter name/slug" required="0"
                        class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

                    <x-form.input label="Email" type="text" name="email" id="email"
                        value="{{ Request::input('email') }}" placeholder="Enter email" required="0"
                        class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

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
                <thead class="text-xs text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class=" text-sm">
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Slug
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created at
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Edit</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurants as $restaurant)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $restaurant->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $restaurant->slug }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $restaurant->address }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $restaurant->user->email }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $restaurant->phone }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $restaurant->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('restaurants.login_as', ['restaurant' => $restaurant->id]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Login
                                        as</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        const phoneInput = document.getElementById('phone');
        const enableWANotification = document.getElementById('enable_wa_notification');

        // only contain numbers and + sign, not more than 15 characters, not less than 10 characters
        phoneInput.addEventListener('input', function() {
            phoneInput.value = phoneInput.value.replace(/[^0-9+]/g, '');
            if (phoneInput.value.length == 0) {
                enableWANotification.checked = false;
                enableWANotification.setAttribute('disabled', 'disabled');
            } else {
                // if no + sign, set error
                if (!phoneInput.value.includes('+')) {
                    phoneInput.setCustomValidity('Must contain + sign at the beginning');
                    enableWANotification.checked = false;
                    enableWANotification.setAttribute('disabled', 'disabled');
                    return;
                }
                if (phoneInput.value.length > 15) {
                    phoneInput.setCustomValidity('Must be at most 15 characters including + sign');
                    phoneInput.value = phoneInput.value.slice(0, 15);
                    return;
                }
                if (phoneInput.value.length < 10) {
                    phoneInput.setCustomValidity('Must be at least 10 characters including + sign');
                    return;
                }
                phoneInput.setCustomValidity('');
            }
        });
    </script>
@endpush

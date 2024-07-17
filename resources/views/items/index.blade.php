@extends('layouts.admin.master')

@push('styles')
    <link href="https://cdn.datatables.net/v/dt/dt-2.0.0/datatables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.0.0/css/dataTables.tailwindcss.css" rel="stylesheet">
@endpush

@section('main')
    <!-- Delete modal -->
    <button id="delete-item-modal-btn" data-modal-target="delete-item-modal" data-modal-toggle="delete-item-modal"
        class="hidden" type="button">
    </button>
    <div id="delete-item-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <i class="fas fa-circle-info text-6xl mx-auto mb-4 text-gray-600 w-12 h-12 dark:text-gray-200"></i>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete
                        this item?</h3>
                    <button data-modal-hide="delete-item-modal" type="button" onclick="deleteItem()"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button data-modal-hide="delete-item-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                        cancel</button>
                </div>
            </div>
        </div>
    </div>


    <main>
        <div class="flex justify-between mb-5">
            <h1 class="text-2xl font-bold text-black dark:text-gray-200">Items</h1>
            <x-button type="link" name="create-item-link" id="create-item-link" size="small"
                href="{{ route('items.create') }}" usage="create">
                Create new item
            </x-button>
        </div>

        <table class="display" style="width:100%" id="items-table">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        Active
                    </th>
                    <th>
                        Created at
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <th>
                            {{ $item->name }}
                        </th>
                        <td>
                            {{ $item->category->name }}
                        </td>
                        <td>
                            {{ $item->price }}
                        </td>
                        <td>
                            {{ $item->active ? 'Yes' : 'No' }}
                        </td>
                        <td>
                            {{ $item->created_at->setTimezone('GMT')->format('d M Y, H:i:s') }} GMT
                        </td>
                        <td class="flex gap-x-2">
                            <x-button type="link" name="update-item-link" id="update-item-link" size="small"
                                href="{{ route('items.edit', $item->id) }}" usage="update">
                                <i class="fas fa-edit" aria-hidden="true"></i>
                            </x-button>
                            <button
                                class="text-white
                                bg-red-600 hover:bg-red-700 
                                font-medium rounded-lg text-sm px-3 py-1 text-center dark:bg-red-500
                                dark:hover:bg-red-600"
                                type="button" onclick="itemToDelete('{{ $item->id }}')">
                                <i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.tailwindcss.js"></script>
    <script>
        let table = new DataTable('#items-table');

        const appBase = '{{ env('APP_BASE') }}';
        let deleteItemId = null;

        // define iziToast options
        // open from the right
        iziToast.settings({
            position: 'topRight',
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight'
        });

        const itemToDelete = (id) => {
            deleteItemId = id;
            document.getElementById('delete-item-modal-btn').click();
        }

        const deleteItem = () => {
            const action = appBase + '/items/' + deleteItemId;
            axios.delete(action)
                .then(response => {
                    console.log(response);
                    iziToast.success({
                        title: 'Success',
                        message: 'Item deleted successfully'
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                })
                .catch(error => {
                    console.error(error);
                    iziToast.error({
                        title: 'Error',
                        message: error.response.data.message
                    });
                });
        }
    </script>
@endpush

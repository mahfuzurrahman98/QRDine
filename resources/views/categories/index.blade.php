@extends('layouts.admin.master')

@section('title', 'Categories')

@section('main')
    <!-- Add modal -->
    <div id="add-category-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-3 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between px-4 py-2 md:px-5 md:py-3 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add new category
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-category-modal">
                        <i class="fas fa-times text-lg" aria-hidden="true"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-4 pb-3 md:px-5 md:pb-4">
                    <form class="space-y-4" action="{{ route('categories.store') }}" method="POST" id="add-category-form">
                        @csrf
                        <x-form.input label="Category Name" type="text" name="name" id="name"
                            placeholder="Enter category name" required="true" />

                        <x-form.input-checkbox label="Active" name="active" id="active" checked="false"
                            required="false" />

                        <x-button type="submit" id="add-category-btn" usage="create">
                            Save
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update modal -->
    <button data-modal-target="update-category-modal" data-modal-toggle="update-category-modal"
        id="update-category-modal-btn" class="hidden" type="button">
    </button>
    <div id="update-category-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between px-4 py-2 md:px-5 md:py-3 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Update category
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="update-category-modal">
                        <i class="fas fa-times text-lg" aria-hidden="true"></i>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-4 pb-3 md:px-5 md:pb-4">
                    <form class="space-y-4" action="" method="POST" id="update-category-form">
                        @csrf
                        @method('PUT')
                        <x-form.input label="Category Name" type="text" name="name" id="update-name"
                            placeholder="Enter category name" required="true" />

                        <x-form.input-checkbox label="Active" name="active" id="update-active" checked="false"
                            required="false" />

                        <x-button type="submit" id="update-category-btn" usage="update">
                            Save
                        </x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete modal -->
    <button id="delete-category-modal-btn" data-modal-target="delete-category-modal"
        data-modal-toggle="delete-category-modal" class="hidden" type="button">
    </button>
    <div id="delete-category-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <i class="fas fa-circle-info text-6xl mx-auto mb-4 text-gray-600 w-12 h-12 dark:text-gray-200"></i>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Are you sure you want to delete this category?
                    </h3>
                    <button data-modal-hide="delete-category-modal" type="button" onclick="deleteCategory()"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button data-modal-hide="delete-category-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                        cancel</button>
                </div>
            </div>
        </div>
    </div>


    <main>
        <div class="flex justify-between mb-5">
            <h1 class="text-2xl font-bold text-black dark:text-gray-200">Categories</h1>
            <button data-modal-target="add-category-modal" data-modal-toggle="add-category-modal"
                id="add-category-modal-btn"
                class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-3 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                type="button">
                Add new category
            </button>
        </div>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr class="text-base">
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Active
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created at
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $category->name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $category->active ? 'Yes' : 'No' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $category->created_at->setTimezone('GMT')->format('d M Y, H:i:s') }} GMT
                            </td>
                            <td class="px-6 py-4 flex gap-x-3 text-right">
                                <button data-modal-target="update-category-modal"
                                    data-modal-toggle="update-category-modal" id="update-category-modal-btn"
                                    class="text-white
                                    bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300
                                    font-medium rounded-lg text-sm px-2 py-1 text-center dark:bg-blue-600
                                    dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                    type="button"
                                    onclick="editCategory('{{ $category->id }}', '{{ $category->name }}', '{{ $category->active }}', '{{ route('categories.update', ['category' => $category->id]) }}')">
                                    <i class="fas fa-edit" aria-hidden="true"></i>
                                </button>
                                <button
                                    class="text-white
                                bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300
                                font-medium rounded-lg text-sm px-2 py-1 text-center dark:bg-red-500
                                dark:hover:bg-red-600 dark:focus:ring-red-700"
                                    type="button" onclick="categoryToDelete('{{ $category->id }}')">
                                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                                </button>
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
        const appBase = '{{ env('APP_BASE') }}';
        const addCategoryForm = document.getElementById('add-category-form');
        const updateCategoryForm = document.getElementById('update-category-form');
        let deleteCategoryId = null;

        // define iziToast options
        iziToast.settings({
            position: 'topRight',
            transitionIn: 'fadeInLeft',
            transitionOut: 'fadeOutRight'
        });

        const editCategory = (id, name, active, action) => {
            document.getElementById('update-category-form').action = `categories/${id}`;
            document.getElementById('update-name').value = name;
            document.getElementById('update-active').checked = active == 1 ? true : false;
        }

        const categoryToDelete = (id) => {
            deleteCategoryId = id;
            document.getElementById('delete-category-modal-btn').click();
        }

        addCategoryForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(addCategoryForm);
            console.log(Object.fromEntries(formData));
            axios.post(addCategoryForm.action, Object.fromEntries(formData))
                .then(response => {
                    console.log(response);
                    iziToast.success({
                        title: 'Success',
                        message: 'Category added successfully'
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
        });

        updateCategoryForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(updateCategoryForm);
            console.log(Object.fromEntries(formData));
            axios.put(updateCategoryForm.action, Object.fromEntries(formData))
                .then(response => {
                    console.log(response);
                    iziToast.success({
                        title: 'Success',
                        message: 'Category updated successfully'
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
        });

        const deleteCategory = () => {
            const action = appBase + '/categories/' + deleteCategoryId;
            axios.delete(action)
                .then(response => {
                    console.log(response);
                    iziToast.success({
                        title: 'Success',
                        message: 'Category deleted successfully'
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

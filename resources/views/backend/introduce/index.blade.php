<x-app-layout>
    @section('title', config('apps.introduce.titleLabel'))
    <div class="p-4 max-h-full block sm:flex items-center justify-between   dark:bg-gray-800 ">
        <div class="w-full mb-1">
            <div class="mb-4">

                <div class="flex items-center content-center">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mr-2 ">@yield('title')
                    </h1>
                    <x-badges label="Hướng dẫn" type="primary" icon="{{ @svg('css-info', 'w-4 h-4') }}" />
                </div>
            </div>
        </div>


    </div>
    <div>
        <form method="POST" action="{{ route('setting_module.introduce.store') }}">
            @csrf
            <div class="grid grid-cols-12 ">
                <div class="col-span-4 ">
                    <div class="my-0 m-4">
                        <h5 class="mb-1 text-lg font-bold tracking-tight text-green-900 dark:text-white">Thông tin cơ
                            bản
                        </h5>
                        <p class="mb-3 text-xs text-green-700">Dưới đây là các thông tin chi tiết về mục giới thiệu.
                        </p>
                    </div>
                </div>

                <div class="col-span-8 ">
                    <x-card class="my-0">

                        <div class="col-span-6 sm:col-span-3 ">
                            <x-input-label for="content" required>Nhập nội dung</x-input-label>
                            <textarea id="content" rows="10" name="content"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 "
                                placeholder="Nhập nội dung tại đây...">{{ $getData->content??'' }}</textarea>
                        </div>



                    </x-card>
                </div>
            </div>

            <div class="grid grid-cols-12 mt-4">

                <div class="col-span-12 sm:col-span-12">
                    <div class="flex justify-end mt-3">
                        <button type="submit"
                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            <span class="saveBtn">Xác nhận</span>
                            <span class="loadingBtn" style="display: none">
                                <svg aria-hidden="true" role="status"
                                    class="inline w-4 h-4 me-3 text-gray-200 animate-spin dark:text-gray-600"
                                    viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="#1C64F2" />
                                </svg>
                                Loading...
                            </span>
                        </button>
                        <a href="{{ route('ecommerce_module.groupProduct.index') }}"
                            class="text-white bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </form>

    </div>
    @push('js')
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
        <script>
            tinymce.init({
                selector: '#content',
                plugins: 'image',
                toolbar: 'ai_assistant | undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | image | quickbars',
                height: 700,
                quickbars_insert_toolbar: true,
                images_upload_url: '/admin/introduce/upload-image', // URL sẽ xử lý việc tải ảnh lên
                automatic_uploads: true,
                images_upload_handler: function(blobInfo, success, failure) {
                    let formData = new FormData();

                    formData.append('file', blobInfo.blob(), blobInfo.filename());

                    $.ajax({
                        url: '/admin/introduce/upload-image',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            success(response.location); // Trả về đường dẫn ảnh
                        },
                        error: function(error) {
                            failure('Image upload failed: ' + error.message);
                        }
                    });
                },

            });
        </script>
    @endpush
</x-app-layout>

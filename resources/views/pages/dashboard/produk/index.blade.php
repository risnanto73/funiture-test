<x-app-layout>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Produk') }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            var i = 1;
            var datatable = $('#crudTable').DataTable({
                ajax: {
                    url: '{!! url()->current() !!}'
                },
                columns: [{
                        "render": function() {
                            return i++;
                        },
                        className: 'dt-left', targets: '_all'
                    },
                    {
                        data: 'name',
                        name: 'name',
                        className: 'dt-center', targets: '_all'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        className: 'dt-center', targets: '_all'                        
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderlable: false,
                        searchable: false,
                        width: '20%'
                    }
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-10">
                <a href="{{ route('dashboard.produk.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg">+ Create
                    Produk</a>
            </div>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

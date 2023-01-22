<x-app-layout>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transaksi') }}
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
                        data: 'phone',
                        name: 'phone',
                        className: 'dt-center', targets: '_all'
                    },
                    {
                        data: 'courier',
                        name: 'courier',
                        className: 'dt-center', targets: '_all'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        className: 'dt-center', targets: '_all'                        
                    },
                    {
                        data: 'status',
                        name: 'status',
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
            
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Telepon</th>
                                <th>Kurir</th>
                                <th>Total Harga</th>
                                <th>Status</th>
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

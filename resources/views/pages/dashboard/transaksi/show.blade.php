<x-app-layout>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaksi &raquo; #{{ $transaksi->id }} {{ $transaksi->name }}
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
                        className: 'dt-left',
                        targets: '_all'
                    },
                    {
                        data: 'produk.name',
                        name: 'produk.name',
                        className: 'dt-center',
                        targets: '_all'
                    },
                    {
                        data: 'produk.price',
                        name: 'produk.price',
                        className: 'dt-center',
                        targets: '_all'
                    }
                ]
            })
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-lg text-gray-700 leading-thight mb-5">Transaksi Detail</h2>

            <div class="bg-white overflow-hidden shadow sm-rounded-lg mb-10">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <th class="border px-6 py-5 text-right">Name</th>
                                <td class="border px-6 py-5">{{ $transaksi->name }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-5 text-right">Email</th>
                                <td class="border px-6 py-5">{{ $transaksi->email }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-5 text-right">Alamat</th>
                                <td class="border px-6 py-5">{{ $transaksi->address }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-5 text-right">Phome</th>
                                <td class="border px-6 py-5">{{ $transaksi->phone }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-5 text-right">Kurir</th>
                                <td class="border px-6 py-5">{{ $transaksi->courier }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-5 text-right">Payment</th>
                                <td class="border px-6 py-5">{{ $transaksi->payment }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-5 text-right">Payment URL</th>
                                <td class="border px-6 py-5">{{ $transaksi->payment_url }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-5 text-right">Total Price</th>
                                <td class="border px-6 py-5">{{ number_format($transaksi->total_price) }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-5 text-right">Status</th>
                                <td class="border px-6 py-5">{{ $transaksi->status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <h2 class="font-semibold text-lg text-gray-700 leading-thight mb-5">Transaksi Item</h2>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Total Harga</th>

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

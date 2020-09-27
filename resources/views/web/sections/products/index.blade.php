<x-app-layout>
        <table class="ui celled table">
            <thead>
                <tr>
                    <th>Sıra</th>
                    <th>Ürün Adı</th>
                    <th>Kod</th>
                    <th>Barkod</th>
                    <th>Raf Ömrü</th>
                    <th>Min Stok</th>
                    <th>Aktif</th>
                    <th>Üretilebilirlik</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $key => $value)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->code }}</td>
                    <td>{{ $value->barcode }}</td>
                    <td>{{ $value->shelf_life }}</td>
                    <td>{{ $value->min_threshold }}</td>
                    <td>{{ $value->is_active }}</td>
                    <td>{{ $value->producible }}</td>
                </tr>
                @endforeach
            </tbody>
           
        </table>

</x-app-layout>
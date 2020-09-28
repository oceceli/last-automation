<x-app-layout>
        <table class="ui celled green table" id="example">
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
                    <th>İşlemler</th>
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
                    <td><div>test</div></td>
                </tr>
                @endforeach
            </tbody>
           
        </table>

</x-app-layout>

<script>
//    $(document).ready(function() {
//     var table = $('#example').DataTable( {
//         lengthChange: false,
//         buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
//     } );
 
//     table.buttons().container()
//         .appendTo( $('div.eight.column:eq(0)', table.table().container()) );
//     });
$(document).ready( function () {
    $('#example').DataTable({
        paging: false,
        // scrollY: 40
        // scrollX: 500
        "autoWidth": true,
        "info":true
    });
} );
</script>
<table {{ $attributes->merge(['class' => 'ui celled sortable table tablet stackable very compact'])}}>
    {{ $slot }}
    {{-- <thead>
        <tr>
            <th>Sıra</th>
            <th>test</th>
            <th>İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <td>test</td>
            <td><div>Düzenle sil falan</div></td>
        </tr>
    </tbody> --}}
</table>
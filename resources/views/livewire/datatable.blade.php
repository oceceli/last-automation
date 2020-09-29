<div>
    
    <div class="bg-red-100 shadow p-4 flex justify-between items-center">
        <div>asdfj</div>
        <div class="ui icon input" wire:model.debounce.120ms="searchQuery">
            <i class="search icon"></i>
            <input type="text" placeholder="Search...">
        </div>
    </div>
    <div class="pt-2">
        <table class="ui celled green table">
            <thead>
                <tr>
                    <th>Sıra</th>
                    @foreach ($attributes as $attribute)
                        <th>{{ __($attribute) }}</th>
                    @endforeach
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                <tr>
                    <td>{{ $key+1 }}</td>
                    @foreach ($attributes as $attribute)
                        <td>{{ $value->$attribute }}</td>
                    @endforeach
                    <td><div>Düzenle sil falan</div></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

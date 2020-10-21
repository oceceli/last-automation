
<select {{ $attributes }} wire:model.lazy="{{ $model }}">
    <option class="item" selected value="{{ false }}">{{ ucfirst(__($placeholder)) }}</option>
    @foreach ($collection as $item)
        @if ($value !== null)
            @if (strpos($value, '->')) @php $values = explode('->', $value) @endphp
                <option class="item" value="{{ $item->{$values[0]}->{$values[1]} }}">
            @else
                <option class="item" value="{{ $item[$value] }}">
            @endif
                @foreach ($array = explode(',', $text) as $display)
                    {{ $item[$display] }} 
                    @if ($display != end($array)) - @endif
                @endforeach
            </option>
        @else
            <option class="item" value="{{ $item }}"> {{ $item }} </option>
        @endif
    @endforeach  
</select>

<script>
    $('.ui.dropdown').each(function () {
        $(this).dropdown({
            preserveHTML: false,
            ignoreDiacritics: true,
            sortSelect: true,
            transition: '{{ $transition }}',
            ignoreCase: false,
            match: 'text', // text içinde ara
            forceSelection: false, // select açılıp seçim yapmadan blur edildiğinde
            clearable: "{{ $clearable }}",
            // allowCategorySelection: true,
            // on: 'hover',
            fullTextSearch:'exact',

        });
        // document.addEventListener("livewire:load", () => {
	    //     Livewire.hook('message.processed', (message, component) => {
		//         $('.ui .dropdown').dropdown();
    
        //     }); 
        // });

    })
</script>
    
{{-- <div {{ $attributes }}>
    <input type="hidden">
    <i class="dropdown icon focus:outline-none"></i>
    <div class="default text">{{ __($placeholder) }}</div>
    <div class="menu">
        @foreach ($collection as $item)
            <div class="item" data-value="{{ $item[$value] }}">
                @foreach ($array = explode(',', $text) as $display)
                    {{ $item[$display] }} 
                    @if ($display != end($array)) - @endif
                @endforeach
            </div>
        @endforeach
    </div>
</div> --}}

<select {{ $attributes }} wire:model="{{ $model }}">
    <option class="item" selected value="{{ false }}">{{ ucfirst(__($placeholder)) }}</option>
    @foreach ($collection as $item)
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
    @endforeach  
</select>

 
{{-- @prepend('scripts') --}}
<script>
    // $(document).ready(function () {
        // let select = $('.ui .dropdown');
        // select.dropdown();

    // });

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
{{-- @endpush --}}
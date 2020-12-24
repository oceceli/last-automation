
<div {{ $attributes->merge(['class' => 'field'])}} wire:ignore>
    <label>{{ __($label) }}</label>
    <select class="ui selection dropdown {{ $sClass }}" wire:model.lazy="{{ $model }}">
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
    @error($model)
        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
    @enderror
</div>



{{-- @push('scripts') --}}
<script>
    
    $(document).ready(function() {    
        $('.ui.selection.dropdown').dropdown({
            preserveHTML: false,
            ignoreDiacritics: true,
            sortSelect: true,
            // placeholder: '{{ __($placeholder) }}',
            transition: '{{ $transition }}',
            ignoreCase: false,
            match: 'text', // text içinde ara
            forceSelection: false, // select açılıp seçim yapmadan blur edildiğinde
            clearable: "{{ $clearable }}",
            fullTextSearch:'exact',
            // allowCategorySelection: true,
            // on: 'hover',
            // onChange(value, text, $choice) {
            //     // @this.set('unit_id', value);
            // },
            message: {
                addResult     : '<b>{term}</b> ekle',
                count         : '{count} adet seçildi',
                maxSelections : 'En fazla {maxCount} seçilebilir',
                noResults     : '{{ __('common.no_results') }}',
            },
        });
    });
</script>
{{-- @endpush --}}


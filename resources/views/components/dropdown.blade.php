
<div {{ $attributes->merge(['class' => 'field']) }} wire:ignore>
    <label>{{ __($label)}}</label>

    @if ($iModel)
    <div class="ui right labeled input">
        <input type="{{ $iType }}" placeholder="{{ __($iPlaceholder) }}" wire:model.lazy="{{ $iModel }}">
        <div class="ui label {{ $sClass }} scrolling dropdown" id="{{ $sId }}"> 
    @else
    <div>
        <div class="ui selection {{ $sClass }} scrolling dropdown" id="{{ $sId }}"> 
    @endif
            <input type="hidden" name="{{ $model }}" wire:model.lazy="{{ $model }}">            
            <div class="text default">{{ __($placeholder) }}</div>
            <i class="dropdown icon"></i>
            <div class="menu">
                {{-- options handling by javascript --}}
            </div>
        </div>
    </div>
</div>


{{-- @push('scripts') --}}
<script>
    $(document).ready(function() {
        
        var values = [];

        @if ($triggerOn) 
            $("{{ $triggerOn }}").on('change', function (){
                values = []; // empty values before update
                setValues();
            });
        @else
            setValues();
        @endif


        function setValues() {
            let data = @this.get('{{ $dataSource }}');
            console.log(data);
            
            if(data != null) {
                data.forEach(data => {
                    values.push({
                        name: data.{{ $text }},
                        value: data.{{ $value }},
                        selected :  @this.get('{{ $model }}') == data.{{ $value }},
                    });
                });
            } else {
                console.log('dataSource yanlış!');
            }
            // console.log(values);
            setDropdown(values);
        }



        function setDropdown(values = null) {
            $('#{{ $sId }}').dropdown({
                values: values, // {name: test, value: 1} gibi
                preserveHTML: false,
                ignoreDiacritics: true,
                sortSelect: true,
                placeholder: '{{ __($placeholder) }}',
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
                    noResults     : '{{ __('common.there_is_nothing_here') }}',
                },
            });
        }
        
    });
</script>
{{-- @endpush --}}
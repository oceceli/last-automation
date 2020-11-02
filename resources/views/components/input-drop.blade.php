
<div {{ $attributes }}>
    <label>{{ __($label)}}</label>

    @if ($iModel)
    <div class="ui right labeled input">
        <input type="{{ $iType }}" placeholder="{{ __($iPlaceholder) }}" wire:model.lazy="{{ $iModel }}">
        <div class="ui label {{ $sClass }} scrolling dropdown" id="{{ $sId }}" wire:ignore> 
    @else
    <div class="ui right labeled input">
        <div class="ui label {{ $sClass }} scrolling dropdown" id="{{ $sId }}" wire:ignore> 
    @endif
            <input type="hidden" name="{{ $sModel }}" wire:model.lazy="{{ $sModel }}">            
            <div class="text default">{{ __($sPlaceholder) }}</div>
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

        @if ($sTriggerOn) 
            $("{{ $sTriggerOn }}").on('change', function (){
                values = []; // empty values before update
                setValues();
            });
        @else
            setValues();
        @endif


        function setValues() {
            let data = @this.get('{{ $sData }}');

            data.forEach(data => {
                values.push({
                    name: data.{{ $sText }},
                    value: data.{{ $sValue }},
                    selected :  @this.get('{{ $sModel }}') == data.{{ $sValue }},
                });
            });
            console.log(values);
            setDropdown(values);
        }



        function setDropdown(values = null) {
            $('#{{ $sId }}').dropdown({
                values: values, // {name: test, value: 1} gibi
                preserveHTML: false,
                ignoreDiacritics: true,
                sortSelect: true,
                placeholder: '{{ __($sPlaceholder) }}',
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
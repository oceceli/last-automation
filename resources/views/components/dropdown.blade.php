
<div {{ $attributes->merge(['class' => 'field']) }} wire:ignore>

    <label>{{ __($label)}}</label>

    @if ($iModel)
    <div class="ui right labeled small input">
        <input type="{{ $iType }}" placeholder="{{ __($iPlaceholder) }}" wire:model.lazy="{{ $iModel }}">
        <div class="ui label {{ $sClass }} scrolling dropdown" id="{{ $sId }}"> 
            <input type="hidden" name="{{ $model }}" wire:model.lazy="{{ $model }}">            
            <div class="text default">{{ __($placeholder) }}</div>
            <i class="dropdown icon"></i>
            <div class="menu">
                {{-- options handling by javascript --}}
            </div>
        </div>
    </div>
    @else
    <div class="ui selection {{ $sClass }} scrolling dropdown" id="{{ $sId }}"> 
        <input type="hidden" name="{{ $model }}" wire:model.lazy="{{ $model }}">            
        <div class="text default">{{ __($placeholder) }}</div>
        <i class="dropdown icon"></i>
        <div class="menu">
            {{-- options handling by javascript --}}
        </div>
    </div>
    @endif
    @error($model)
        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
    @enderror
    {{ $slot }}

</div>


{{-- @push('scripts') --}}
<script>
    $(document).ready(function() {
        
        var values = [];

        // pupulate the options initially
        fetchValues();

    
        /**
         * if an event specified, populate the select with new options
         */
        @if ($triggerOnEvent)
            Livewire.on('{{ $triggerOnEvent }}', function(){
                console.log("{{ $triggerOnEvent }} event triggered!");
                values = []; // empty values before update
                fetchValues();
            });
        @endif


        /**
         * Populate select options on any dom update. class or id
         */
         @if ($triggerOn) 
            $("{{ $triggerOn }}").on('change', function (){
                values = []; // empty values before update
                fetchValues();
            });
        @endif
        

        
        /**
         * 
         */
        function fetchValues() {
            @if($dataSource)
                let data = @this.get('{{ $dataSource }}');
                setValues(data);
            @else 
                @this.call('{{ $dataSourceFunction }}').then(data => {
                    console.log('{{ $dataSourceFunction }} function populating the {{ $sId }} dropdown');
                    setValues(data);
                });
            @endif
        }

        function setValues(data) {
            console.log(data);
            if(data != null) {
                data.forEach(data => {
                    values.push({
                        name: data.{{ $text }},
                        value: data.{{ $value }},
                        selected :  @this.get('{{ $model }}') == data.{{ $value }},
                    });
                });
                populate(values);
            } else {
                const style = 'font-size: 10px; color: orange;';
                console.log('%c {{ $sId }} dataSource yanlış ya da tetik bekleniyor', style);
            }
        }


        function populate(values = null) {
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
            const style = 'font-size: 10px; color: green;';
            console.log('%c {{ $sId }} population completed!', style);
        }
        
    });
</script>
{{-- @endpush --}}
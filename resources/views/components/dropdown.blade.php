
<div class="field">
    <div {{ $attributes->merge(['class' => 'field']) }} >

        
        <label>{{ __($label)}}</label>
       
    
        @if ($iModel)
        <div class="ui right labeled input" wire:loading.class="disabler">
            <input type="{{ $iType }}" step="any" placeholder="{{ $iPlaceholder }}" wire:model.debounce.500ms="{{ $iModel }}">
            <div wire:ignore class="{{ $sClass }} ui @if( ! $basic) label scrolling @endif dropdown" id="{{ $sId }}"> 
                <input type="hidden" name="{{ $model }}" wire:model.lazy="{{ $model }}">            
                <div class="text default">{{ $placeholder }}</div>
                <i class="dropdown icon"></i>
                <div class="menu">
                    {{-- options handling by javascript --}}
                </div>
            </div>
        </div>
        @else
        <div class="{{ $sClass }} ui @if( ! $basic) selection scrolling @endif dropdown" id="{{ $sId }}" wire:ignore wire:loading.class="double loading disabled" wire:target="{{ $triggerOn }}, {{ $triggerOnEvent }}"> 
            <input type="hidden" name="{{ $model }}" wire:model.lazy="{{ $model }}">            
            <div class="text default">{{ $placeholder }}</div>
            <i class="dropdown icon"></i>
            <div class="menu">
                {{-- options handling by javascript --}}
            </div>
        </div>
        @endif
    </div>

    <div>{{ $right }}</div>



    {{-- @if (!$noErrors) 
        @error($iModel)
            <span class="text-red-500">{{ucfirst($message)}}</span>
        @enderror
        @error($model)
            <span class="text-red-500">{{ucfirst($message)}}</span>
        @enderror
    @endif --}}

</div>


{{-- @push('scripts') --}}
<script>
    $(document).ready(function() {
        
        var values = [];
        var sId = '#{{ $sId }}';

        
        // pupulate the options initially
        @if( ! $initnone)
            fetchValues();
        @endif
        



        /**
         * if an event specified, populate the select with new options
         */
        @if ($triggerOnEvent)
            livewire.on('{{ $triggerOnEvent }}', function(){
                console.log("{{ $triggerOnEvent }} event triggered for {{ $sId }}!");
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
            
            
            @if($collection)
                var data = @json($collection);
                // var data =  {!! json_encode($collection) !!};
                // var data = <?php echo json_encode($collection) ?>;
                setValues(data);
            @elseif($dataSource)
                let data = @this.get('{{ $dataSource }}');
                setValues(data);
            @else 
                @this.call('{{ $dataSourceFunction }}').then(data => {
                    console.log('{{ $dataSourceFunction }} function populating the ' + sId + ' dropdown');
                    setValues(data);
                });
            @endif
        }
        

        function setValues(data) {
            console.log(data);
            if(data != null) {
                data.forEach(data => {
                    let text = "{{ $text }}";
                    let textToShowUser = [];

                    // dropdownda tire(-) ile aralayarak çoklu gösterim yapılmak istenebilir 
                    // kullanıcı virgül ile text attribute'ine geçmeli 
                    text = text.split(',');
                    text.forEach(function(txt){
                        textToShowUser.push(data[txt]);
                    });

                    @if($prefix)
                        textToShowUser.unshift("{{ $prefix }}");
                    @endif

                    values.push({
                        name: textToShowUser.join(' - '),
                        value: data.{{ $value }},
                        selected: @this.get('{{ $model }}') == data.{{ $value }},
                    });
                });
                populate(values);
            } else {
                const style = 'font-size: 10px; color: red;';
                console.log('%c' + sId + ' data source yanlış!', style);
            }
        }


        function populate(values = null) {
            $(sId).dropdown({
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
                    noResults     : '{{ __('common.no_results') }}',
                },
            });
            const style = 'font-size: 10px; color: green;';
            console.log('%c' + sId + ' population completed!', style);
        }
        
    });
</script>
{{-- @endpush --}}


<style>
    .disabler {
        pointer-events:none;
    }
</style>
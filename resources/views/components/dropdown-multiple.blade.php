{{-- <div {{ $attributes->merge(['class' => 'ui multiple search selection fluid dropdown'])}} id="{{ $sId }}">
    <input type="hidden" name="{{ $model }}" wire:model.lazy="{{ $model }}">
    <i class="dropdown icon"></i>
    <div class="default text">Select Country</div>
    <div class="menu">
        {{ $slot }}
    </div>
</div> --}}


<select name="" id="{{ $sId }}" multiple="" {{ $attributes->merge(['class' => 'ui search fluid dropdown'])}}>
    {{ $slot }}
</select>



<script>
    $(document).ready(function(){
        var a = [];
        $('#{{ $sId }}').dropdown({
            maxSelections: "{{ $maxSelections }}",
            // sortSelect: false,
            fullTextSearch: true,
            onAdd: function(addedValue, addedText, $addedChoice) {
                a.push(addedValue);
                @this.set("{{ $model }}", a);
            },
            onRemove: function(removedValue, removedText, $removedChoice) {
                let index = a.indexOf(removedValue);
                @this.set("{{ $model }}", a.splice(a,1));
            }
        });
    })
</script>
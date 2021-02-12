{{-- <div {{ $attributes->merge(['class' => 'ui multiple search selection fluid dropdown'])}} id="{{ $sId }}">
    <input type="hidden" name="{{ $model }}" wire:model.lazy="{{ $model }}">
    <i class="dropdown icon"></i>
    <div class="default text">Select Country</div>
    <div class="menu">
        {{ $slot }}
    </div>
</div> --}}


<div wire:ignore>
    <label class="font-bold pb-2" for="">{{ $label }}</label>
    <select name="" id="{{ $sId }}" multiple="" {{ $attributes->merge(['class' => 'ui search fluid dropdown'])}} wire:model="{{ $model }}">
        {{ $slot }}
    </select>
</div>



<script>
    $(document).ready(function(){
        var a = [];
        $('#{{ $sId }}').dropdown({
            maxSelections: "{{ $maxSelections }}",
            // sortSelect: false,
            fullTextSearch: true,
            // onAdd: function(addedValue, addedText, $addedChoice) {
            //     a.push(addedValue);
            //     @this.set("{{ $model }}", a);
            // },
            // onRemove: function(removedValue, removedText, $removedChoice) {
            //     let index = a.indexOf(removedValue);
            //     a.splice(index,1);
            //     @this.set("{{ $model }}", a);
            // }
        });
    })
</script>
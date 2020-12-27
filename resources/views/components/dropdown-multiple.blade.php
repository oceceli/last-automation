{{-- <div {{ $attributes->merge(['class' => 'ui multiple search selection fluid dropdown'])}} id="{{ $sId }}">
    <input type="hidden" name="{{ $model }}" wire:model.lazy="{{ $model }}">
    <i class="dropdown icon"></i>
    <div class="default text">Select Country</div>
    <div class="menu">
        {{ $slot }}
    </div>
</div> --}}


<select name="{{ $sId}}" id="{{ $sId }}" multiple="" {{ $attributes->merge(['class' => 'ui search fluid dropdown'])}} wire:model="{{ $model }}">
    {{ $slot }}
</select>



<script>
    $(document).ready(function(){
        $('#{{ $sId }}').dropdown({
            maxSelections: "{{ $maxSelections }}",
        });
    })
</script>
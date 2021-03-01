<div {{ $attributes }}>
    {{-- <div class="ui checkbox {{ $type }}"> --}}
        <input type="checkbox" wire:model="{{ $model }}" >
        <label>{{ $label }}</label>
        {{-- <input type="checkbox" class="hidden" wire:model="{{ $model }}" > --}}
    {{-- </div> --}}
    @error($model)
        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
    @enderror
</div>

{{-- <script>
    $('.ui .checkbox').checkbox();
</script> --}}
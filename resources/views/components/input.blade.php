<div {{ $attributes }}>
    <label>{{ ucfirst(__($label)) }}</label>
    <input wire:model.lazy="{{ $model }}" type="{{ $type }}" placeholder="{{ ucfirst(__($placeholder)) }}">
    @if ($showErrors)
        @error($model)
        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
        @enderror
    @endif
</div>
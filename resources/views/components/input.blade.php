<div {{ $attributes->merge(['class' => 'field']) }}>
    <label>{{ ucfirst(__($label)) }}</label>
    @if ($action)
        <div class="ui action input">
            <input wire:model.lazy="{{ $model }}" type="{{ $type }}" placeholder="{{ __($placeholder) }}">
            {{ $button }}
        </div>
    @else
        <input wire:model.lazy="{{ $model }}" type="{{ $type }}" placeholder="{{ ucfirst(__($placeholder)) }}">
    @endif


    @if ($showErrors)
        @error($model)
        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
        @enderror
    @endif



</div>
<div {{ $attributes->merge(['class' => 'field']) }}>
    <label>{{ ucfirst(__($label)) }}</label>
    @if ($action)
        <div class="ui action input flex-1 {{ $iClass }}">
            <input @if($defer) wire:model.defer="{{ $model }}" @else wire:model.lazy="{{ $model }}" @endif type="{{ $type }}" placeholder="{{ ucfirst(__($placeholder)) }}">
            {{ $action }}
        </div>
    @elseif($innerLabel)
        <div class="ui right labeled input flex-1 {{ $iClass }}">
            <input @if($defer) wire:model.defer="{{ $model }}" @else wire:model.lazy="{{ $model }}" @endif type="{{ $type }}" placeholder="{{ ucfirst(__($placeholder)) }}">
            <div class="ui basic label">
                {{ $innerLabel }}
            </div>
        </div>
    @else
        <input @if($defer) wire:model.defer="{{ $model }}" @else wire:model.lazy="{{ $model }}" @endif type="{{ $type }}" placeholder="{{ ucfirst(__($placeholder)) }}">
    @endif


    @if (!$noErrors)
        @error($model)
        <p class="text-red-500 py-2">{{ucfirst($message)}}</p>
        @enderror
    @endif

</div>
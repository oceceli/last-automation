<select {{ $attributes->merge(['class' => 'field focus:outline-none text-sm form-select']) }} wire:model="{{ $model }}">
    <option selected>{{ __('common.dropdown_placeholder')}}</option>
    @if (isset($collection[$collectionKey]))
        @foreach($collection[$collectionKey] as $item)
            <option value="{{ $item }}">{{ $item }}</option>
        @endforeach
    @endif
</select>
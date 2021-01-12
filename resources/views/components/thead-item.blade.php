{{-- <div> --}}
    @if ($sortBy)
        <th {{ $attributes }} wire:click="sortBy('{{ $sortBy }}')">
            {{ $slot }}
            <i class="{{ $this->getDirectionClass($sortBy) }} icon"></i>
        </th>
    @else 
        <th {{ $attributes }}>{{ $slot }}</th>
    @endif
{{-- </div> --}}
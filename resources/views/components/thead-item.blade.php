{{-- <div> --}}
    @if ($sortBy)
        <th wire:click="sortBy('{{ $sortBy }}')">
            {{ $slot }}
            <i class="{{ $this->getDirectionClass($sortBy) }} icon"></i>
        </th>
    @else 
        <th>{{ $slot }}</th>
    @endif
{{-- </div> --}}
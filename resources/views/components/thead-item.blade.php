<th wire:click="sortBy('{{ $sortBy }}')">
    @if ($sortBy)
        {{ $slot }}
        <i class="{{ $this->getDirectionClass($sortBy) }} icon"></i>
    @else 
        {{ $slot }}
    @endif
</th>
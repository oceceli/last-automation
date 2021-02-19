<div class="ui mini {{ $color }} buttons">
    <div wire:click.prevent="{{ $action }}" class="ui button">
        <i class="{{ $icon }}"></i>
        {{ $main }}
    </div>
    <div class="ui floating dropdown icon button">
        <i class="dropdown icon"></i>
        <div class="menu">
            {{ $slot }}
            {{-- <div class="item"><i class="edit icon"></i> Edit Post</div>
            <div class="item"><i class="delete icon"></i> Remove Post</div>
            <div class="item"><i class="hide icon"></i> Hide Post</div> --}}
        </div>
    </div>
</div>




@push('scripts')
    <script>
        $('.ui.dropdown').dropdown();
    </script>
@endpush
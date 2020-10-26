<div {{ $attributes->merge(['class' => 'ui modal']) }}>
    @if ($header)
        <div class="header">{{ $header }}</div>
    @endif

    <div class="{{ $contentClass }} content">
        {{ $slot }}
    </div>

    @if ($buttons)
        <div class="actions">
            {{ $buttons }}
        </div>
    @endif
</div>


<script>
    $('.ui.modal')
    .modal({
        blurring: '{{ $blurring }}',
        inverted: '{{ $inverted }}',
        centered: true,
        closable: true,

        // animation
        transition: '{{ $transition }}',
        duration: 500,
    })
    .modal('show');
</script>
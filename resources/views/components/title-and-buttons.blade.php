
<div {{ $attributes->merge(['class' => 'flex items-center justify-between']) }}>
    <div class="flex-1">
        <h4 class="ui horizontal left aligned divider header">
            <div class="p-3 rounded bg-white shadow border border-teal-100">
                <i class="large {{ $icon }} icon"></i>
                {{ $title }}
            </div>
        </h4>
    </div>
    <div class="pl-3 flex">
        {{-- MALZEMELER BARINI AÇAN BUTON --}}
        <div class="p-2 bg-white shadow-md border rounded-lg">
            <div class="ui buttons">
                {{ $buttons }}
            </div>
        </div>
    </div>
</div>
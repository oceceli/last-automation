<div {{ $attributes->merge(['class' => 'shadow p-3 bg-' . $theme . '-100 border md:border-teal-200 md:rounded'])}}>
    {{ $slot }}
</div>
<div {{ $attributes }} wire:ignore>
    <label>{{ __($label)}}</label>
    <div class="ui right labeled input">

        <input type="{{ $inputType }}" placeholder="{{ __($placeholder) }}" wire:model.lazy="{{ $inputModel }}">

        <div class="ui label basic scrolling dropdown">
            <input type="hidden" name="{{ $selectModel }}" wire:model.lazy="{{ $selectModel }}">
            <div class=" text">{{ __($selectPlaceholder) }}</div>
            <i class="dropdown icon"></i>
            <div class="menu">
                @foreach ($selectData as $data)
                    <div data-value="{{ $data[$selectValue] }}" class="item">{{ $data[$selectText] }}</div>
                @endforeach
            </div>
        </div>
        
    </div>
</div>

<script>
    $('.ui.dropdown').each(function () {
        $(this).dropdown({
            preserveHTML: false,
            ignoreDiacritics: true,
            sortSelect: true,
            transition: '{{ $transition }}',
            ignoreCase: false,
            match: 'text', // text içinde ara
            forceSelection: false, // select açılıp seçim yapmadan blur edildiğinde
            clearable: "{{ $clearable }}",
            // allowCategorySelection: true,
            // on: 'hover',
            fullTextSearch:'exact',

        });
    })
</script>
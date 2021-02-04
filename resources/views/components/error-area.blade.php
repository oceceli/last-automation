@if($errors->any())
    <div {{ $attributes->merge(['class' => 'shadow-md mb-4 md:mb-0 mt-4 mx-5']) }}>
        <div class="ui error message">    
            <div class="header">
                <i class="exclamation triangle icon"></i>
                {{ __('common.please_correct_specified_errors') }}
            </div>
            <ul class="list">
                @foreach ($errors->all() as $error)
                    <li class="text-ease-red text-sm">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
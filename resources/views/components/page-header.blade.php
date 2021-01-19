<div {{ $attributes->merge(['class' => 'flex items-center justify-between px-2 pt-2 pb-4']) }}>

  <div class="flex-1">
      <h4 class="ui horizontal left aligned divider header">
        @if ($header || $icon)
            @if ($icon)
                <i class="{{ $icon }} icon"></i>
            @endif
            <div class="content">
                {{ __($header) }}
                <div class="sub header">{{ __($subheader) }}</div>
            </div>
        @else
            {{ $customHeader }}
        @endif
      </h4>
  </div>

  @if ($buttons)
      <div class="pl-4 flex">
          <div class="shadow rounded-md">
              {{-- <div class="ui buttons"> --}}
                  {{ $buttons }}
              {{-- </div> --}}
          </div>
      </div>
  @endif
  
</div>
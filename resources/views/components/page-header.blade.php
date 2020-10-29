<div {{ $attributes->merge(['class' => 'flex items-center justify-between px-2 pt-1 pb-4']) }}>

  <div class="flex-1">
      <h4 class="ui horizontal left aligned divider header">
          <i class="{{ $icon }} icon"></i>
          <div class="content">
              {{ __($header) }}
              <div class="sub header">{{ __($subheader) }}</div>
          </div>
      </h4>
  </div>

  @if ($buttons)
      <div class="pl-4 flex">
          <div class="p-2 bg-white shadow-md border rounded-lg">
              <div class="ui buttons">
                  {{ $buttons }}
              </div>
          </div>
      </div>
  @endif
  
</div>
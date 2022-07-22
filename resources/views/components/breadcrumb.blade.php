<div class="flex items-center gap-5 py-2">
    <div>
        
    </div>
    <div class="ui breadcrumb">
        @if($currentPath == '/')
            <div class="active section">{{ ucfirst(__('home')) }}</div>
        @else
            <a href="{{ url('/') }}" class="section">{{ ucfirst(__('common.'.'home')) }}</a>
            <i class="right angle icon divider"></i>
            @foreach ($crumbs as $key => $crumb)
                @if($key === $crumbsCount)
                    <div class="active section">{{ ucfirst(__('common.'.$crumb)) }}</div>
                @else
                    <a href="{{ url($crumb) }}" class="section">{{ ucfirst(__('common.'.$crumb)) }}</a>
                    <i class="right angle icon divider"></i>
                @endif
            @endforeach
        @endif
    </div>
</div>
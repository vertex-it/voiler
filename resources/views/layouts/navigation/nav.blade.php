@props([
    'navigation' => config('navigation._pages'),
])

<ul>
    @foreach($navigation as $name => $navigationGroup)
        @if(isset($navigationGroup['label']))
            <li class="nav-label">
                {{ $navigationGroup['label'] }}
            </li>
        @else
            <li>
                @if($name === 'can')
                    @continue
                @endif
                
                @include('voiler::layouts.navigation.collapse-item', [
                    'name' => $name,
                    'navigationGroup' => $navigationGroup,
                    'id' => Str::random(6),
                ])
            </li>
        @endif
    @endforeach
</ul>
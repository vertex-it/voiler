@props([
    'name' => '',
    'navigationGroup' => [],
    'active' => str_contains(print_r($navigationGroup, true), Route::currentRouteName()),
    'id' => '',
])

@if(! isset($navigationGroup['can']) || Auth::user()->can($navigationGroup['can']))
    @if(isset($navigationGroup['route']))
        {{-- Single page --}}
        <a class="nav-item {{ Route::currentRouteName() === $navigationGroup['route'] ? 'active' : '' }}" href="{{ route($navigationGroup['route']) }}">
            {{ $name }}
        </a>
    @else
        <a
            href="#{{ $id }}"
            role="button"
            aria-controls="{{ $id }}"
            aria-expanded="{{ $active ? 'true' : 'false' }}"
            data-bs-toggle="collapse"
            class="nav-item justify-between"
        >
            <span>
                {{ $name }}
            </span>
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 w-3" viewBox="0 0 20 20" fill="currentColor">
                <path
                    fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd"
                />
            </svg>
        </a>
        @if(isset($navigationGroup[0]['route']))
            {{-- Single dropdown --}}
            <div class="collapse {{ str_contains(print_r($navigationGroup, true), Route::currentRouteName()) ? 'show' : '' }}" id="{{ $id }}">
                @foreach(Arr::except($navigationGroup, 'can') as $item)
                    @if(! isset($item['can']) || Auth::user()->can($item['can']))
                        <a href="{{ route($item['route']) }}" class="nav-item {{ Route::currentRouteName() === $item['route'] ? 'active' : '' }}">
                            {{ $item['name'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        @else
            {{-- Recursive dropdown --}}
            <div class="collapse {{ $active ? 'show' : '' }}" id="{{ $id }}">
                @include('voiler::layouts.navigation.nav', [
                    'navigation' => $navigationGroup,
                ])
            </div>
        @endif
    @endif
@endif

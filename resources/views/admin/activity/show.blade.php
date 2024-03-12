@extends('voiler::layouts.master')

@section('title', __('voiler::interface.activities'))

@section('breadcrumbs')
    <x-breadcrumb />
@endsection

@section('content')

    <div class="section w-full">
            <div class="card">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left">{{ __('voiler::interface.column') }}</th>
                            @if(isset($activity['old']))
                                <th class="text-left">{{ __('voiler::interface.old_value') }}</th>
                            @endif
                            <th class="text-left">{{ __('voiler::interface.new_value') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activity['attributes'] as $column => $value)
                            <tr>
                                <td>{{ $column }}</td>
                                @if(isset($activity['old']))
                                    <td>
                                        @if($column === 'updated_at')
                                            {{ Carbon::rawParse($activity['old'][$column])->format('d-m-Y H:i:s') }}
                                        @else
                                            {{ json_encode($activity['old'][$column]) }}
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    @if($column === 'updated_at')
                                        {{ Carbon::rawParse($value)->format('d-m-Y H:i:s') }}
                                    @else
                                        {{ json_encode($value) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div>

@endsection

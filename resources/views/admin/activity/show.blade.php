@extends('voiler::layouts.master')

@section('content')

    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.activities.index') }}">
                {{ __('voiler::interface.activities') }}
            </a>
        </li>
    </ul>
    <div class="content-i">
        <div class="content-box">
            <div class="element-wrapper">
                <h6 class="element-header">
                    {{ __('voiler::interface.activity') }}
                </h6>
                <div class="element-box">
                    <div class="table-responsive">
                        <div class="row">
                            <table class="table" style="word-break: break-all; width: 100%;">
                                <thead>
                                    <tr>
                                        <th width="150">{{ __('voiler::interface.column') }}</th>
                                        @if(isset($activity['old']))
                                            <th>{{ __('voiler::interface.old_value') }}</th>
                                        @endif
                                        <th>{{ __('voiler::interface.new_value') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($activity['attributes'] as $column => $value)
                                        <tr>
                                            <td>{{ $column }}</td>
                                            @if(isset($activity['old']))
                                                <td>
                                                    @if($column === 'updated_at')
                                                        {{ \Carbon\Carbon::rawParse($activity['old'][$column])->format('d-m-Y H:i:s') }}
                                                    @else
                                                        {{ json_encode($activity['old'][$column]) }}
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                @if($column === 'updated_at')
                                                    {{ \Carbon\Carbon::rawParse($value)->format('d-m-Y H:i:s') }}
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
                </div>
            </div>
        </div>
    </div>

@endsection
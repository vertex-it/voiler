@extends('voiler::layouts.base-index')

@section('scripts')
    <script>
        var additionalConfig = {
            columns: [
                { title: 'Name', data: 'name' },
                { title: 'Email', data: 'email' },
                { title: 'Registered at', data: 'created_at' },
            ],
            order: [3, 'desc']
        };
    </script>
@endsection

{{-- FIX: Use simple base index because there is no soft delete, etc. --}}
@extends('voiler::layouts.base-index')

@section('aditional-content')
    <x-modal id="permissions-modal" title="Dozvole" />
    <x-modal id="users-modal" title="Korisnici" />
@endsection

@section('aditional-scripts')
    <script>
        var aditionalConfig = {
            columns: [
                { data: "name", responsivePriority: 0 },
                { data: "description" },
                { data: "permissions" },
                { data: "users" },
                { data: "action", orderable: false,  width: "80px", responsivePriority: 1, searchable: false },
            ],
            select: {
                style: 'multi',
                selector: 'td:not(:nth-child(3), :nth-child(4), :last-child)'
            }
        };
    </script>
@endsection
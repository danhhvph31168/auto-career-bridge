@extends('admin.layouts.master')
@section('content')
    @if ($page == 'list')
        @livewire('admin-university-component')
    @elseif($page == 'detail')
        @include('admin.universities.users.partials.detail')
    @endif
@endsection

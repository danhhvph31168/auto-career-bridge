@extends('admin.layouts.master')
@section('content')
    @if ($page == 'list')
        @livewire('admin-workshop-component')
    @elseif($page == 'detail')
        @include('admin.universities.workshops.partials.detail')
    @endif
@endsection

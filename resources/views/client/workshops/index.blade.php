@php
    $segmentParent = request()->segment(1);
    $segmentChild = request()->segment(2);
@endphp

@extends('client.layouts.master')

@section('content')
    @if ($segmentChild == '' && $segmentParent == 'workshops')
        @include('client.workshops.components.breadcrumb', ['title' => $config['list']])
        @livewire('client-workshop-component')
        @section('script')
            <script src="{{ asset('assets/client/js/job.js') }}"></script>
        @endsection
    @elseif ($segmentChild === 'detail' && $segmentParent == 'workshops')
        @include('client.workshops.components.breadcrumb', ['title' => $config['detail']])
        @include('client.workshops.components.detail')
    @endif
@endsection

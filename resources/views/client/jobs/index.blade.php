@php
    $segmentParent = request()->segment(1);
    $segmentChild = request()->segment(2);
@endphp

@extends('client.layouts.master')

@section('content')
    @if ($segmentChild == '' && $segmentParent == 'jobs')
        @include('client.jobs.components.breadcrumb', ['title' => $config['jobs']['list']])
        @include('client.jobs.components.list')
        @section('script')
            <script src="{{ asset('assets/client/js/job.js') }}"></script>
        @endsection
    @elseif ($segmentChild === 'detail' && $segmentParent == 'jobs')
        @include('client.jobs.components.breadcrumb', ['title' => $config['jobs']['detail']])
        @include('client.jobs.components.detail')
    @endif
@endsection

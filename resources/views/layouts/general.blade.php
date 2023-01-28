@extends('layouts.base')
@section('body')
    @include('layouts.parts.header')
    @include('layouts.parts.navbar')
    @yield('main')
    @include('layouts.parts.footer')
@endsection

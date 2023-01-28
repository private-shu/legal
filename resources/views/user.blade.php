@extends('layouts.general')
@section('main')
<main>
    <div class="container-fluid border rounded mt-1">
        <div class="row">
            <div class="col-md-2 border-right">
                @include('layouts.parts.sidebar')
            </div>
            <div class="col-md-9">
                @if (Request::routeIs('user.create'))
                    @include('layouts.parts.contents.user.create')
                @elseif (Request::routeIs('user.detail'))
                    @include('layouts.parts.contents.user.detail')
                @else
                    @include('layouts.parts.contents.user.list')
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
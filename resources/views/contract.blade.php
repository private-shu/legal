@extends('layouts.general')
@section('main')
<main>
    <div class="container-fluid border rounded mt-1">
        <div class="row">
            <div class="col-md-2 border-right">
                @include('layouts.parts.sidebar')
            </div>
            <div class="col-md-10">
                @if (Request::routeIs('contract.create'))
                    @include('layouts.parts.contents.contract.create')
                @elseif (Request::routeIs('contract.detail'))
                    @include('layouts.parts.contents.contract.detail')
                @elseif (Request::routeIs('contract.summary'))
                    @include('layouts.parts.contents.contract.summary')
                @else
                    @include('layouts.parts.contents.contract.search')
                    @include('layouts.parts.contents.contract.list')
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
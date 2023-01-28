@extends('layouts.general')
@section('main')
<main>
    <div class="container-fluid border rounded mt-4">
        <div class="row">
            <div class="col-md-2 border-right">
                @include('layouts.parts.sidebar')
            </div>
            <div class="col-md-10">
                @include('layouts.parts.contents.case.list')
            </div>
        </div>
    </div>
</main>
@endsection
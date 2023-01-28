@extends('layouts.general')
@section('main')
<main>
    <div class="container-fluid border rounded mt-1">
        <div class="row">
            <div class="col-md-2 border-right">
                @include('layouts.parts.sidebar')
            </div>
            <div class="col-md-9">
                @include('layouts.parts.contents.member.detail')
            </div>
        </div>
    </div>
</main>
@endsection
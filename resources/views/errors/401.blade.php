@extends('layout.main')

@section('content')
    <x-http-error code="401" :exception="$exception" />
@endsection

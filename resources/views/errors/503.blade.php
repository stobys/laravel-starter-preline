@extends('layout.main')

@section('content')
    <x-http-error code="503" :exception="$exception" />
@endsection

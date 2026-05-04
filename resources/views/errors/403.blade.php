@extends('layout.main')

@section('content')
    <x-http-error code="403" :exception="$exception" />
@endsection

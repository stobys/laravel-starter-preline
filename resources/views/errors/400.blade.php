@extends('layout.main')

@section('content')
    <x-http-error code="400" :exception="$exception" />
@endsection

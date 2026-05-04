@extends('layout.main')

@section('content')
    <x-http-error code="408" :exception="$exception" />
@endsection

@extends('layout.main')

@section('content')
    <x-http-error code="402" :exception="$exception" />
@endsection

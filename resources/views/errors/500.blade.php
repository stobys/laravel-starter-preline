@extends('layout.main')

@section('content')
    <x-http-error code="500" :exception="$exception" />
@endsection

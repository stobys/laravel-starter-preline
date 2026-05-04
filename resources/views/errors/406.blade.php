@extends('layout.main')

@section('content')
    <x-http-error code="406" :exception="$exception" />
@endsection

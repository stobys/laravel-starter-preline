@extends('layout.main')

@section('content')
    <x-http-error code="418" :exception="$exception" />
@endsection

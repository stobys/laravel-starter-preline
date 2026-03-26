@extends('layout.main')

@section('content')
    <x-http-error code="419" :exception="$exception" />
@endsection

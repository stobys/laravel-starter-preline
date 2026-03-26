@extends('layout.main')

@section('content')
    <x-http-error code="404" :exception="$exception" />
@endsection

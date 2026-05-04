@extends('layout.main')

@section('content')
    <x-http-error code="501" :exception="$exception" />
@endsection

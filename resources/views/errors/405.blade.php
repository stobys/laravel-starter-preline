@extends('layout.main')

@section('content')
    <x-http-error code="405" :exception="$exception" />
@endsection

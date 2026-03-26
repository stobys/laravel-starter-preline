@extends('layout.main')

@section('content')
    <x-http-error code="429" :exception="$exception" />
@endsection

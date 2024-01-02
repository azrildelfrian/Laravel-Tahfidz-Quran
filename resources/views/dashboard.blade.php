@extends('template.page')
@section('content')
Assalamualaikum, {{ Auth::user()->name }}
@endsection
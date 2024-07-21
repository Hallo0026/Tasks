@extends('layouts.app')

@section('content')

    <register-component csrf-token="{{ csrf_token() }}"></register-component>

@endsection

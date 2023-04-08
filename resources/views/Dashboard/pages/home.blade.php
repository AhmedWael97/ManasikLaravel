@extends('Dashboard.Layout.app')
@section('content')
    Welcome {{ Auth::user()->name_ar }}
@endsection

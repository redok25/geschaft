@extends('layouts.app')
@section('web-title', 'Dashboard')
@section('title', 'Dashboard')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="p-6 text-gray-900">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
@endsection

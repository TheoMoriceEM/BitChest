@extends('layouts.layout')

@section('title', 'Cours du Bitcoin')

@section('content')
    <h1 class="text-center mb-5">Historique du Bitcoin</h1>
    <div class="d-flex justify-content-center">
        <a class="btn btn-sm btn-outline-secondary" href="{{ route('currencies.index') }}" role="button">Retour</a>
        <a class="btn btn-sm btn-primary ml-3" href="#" role="button">Acheter</a>
    </div>
@endsection

@extends('layouts.layout')

@section('title', "Création d'utilisateur")

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Ajouter un utilisateur</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('users.index') }}" role="button">Annuler</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

        </div>
    </div>
@endsection

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
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="last_name" class="col-12 col-sm-2 col-form-label">Nom :</label>
                    <div class="col-12 col-sm-10">
                        <input type="text" class="form-control" name="last_name" id="last_name" maxlength="100" value="{{ old('last_name') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="first_name" class="col-12 col-sm-2 col-form-label">Prénom :</label>
                    <div class="col-12 col-sm-10">
                        <input type="text" class="form-control" name="first_name" id="first_name" maxlength="100" value="{{ old('first_name') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-12 col-sm-2 col-form-label">Statut :</label>
                    <div class="col-12 col-sm-10 d-flex">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="client" value="client" @if(old('status') == 'client') checked @endif required>
                            <label class="form-check-label" for="client">Client</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="admin" value="admin" @if(old('status') == 'admin') checked @endif required>
                            <label class="form-check-label" for="admin">Administrateur</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-12 col-sm-2 col-form-label">Adresse e-mail :</label>
                    <div class="col-12 col-sm-10">
                        <input type="email" class="form-control" name="email" id="email" maxlength="255" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-12 col-sm-2 col-form-label">Mot de passe :</label>
                    <div class="col-12 col-sm-10">
                        <input type="password" class="form-control" name="password" id="password" minlength="8" maxlength="100" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password_confirmation" class="col-12 col-sm-2 col-form-label">Confirmer le mot de passe :</label>
                    <div class="col-12 col-sm-10">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" minlength="8" maxlength="100" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>

            </form>
        </div>
    </div>
@endsection

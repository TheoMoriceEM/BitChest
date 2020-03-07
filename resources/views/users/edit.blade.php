@extends('layouts.layout')

@section('title', "Modification d'utilisateur")

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Modifier un utilisateur</h1>
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
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @method('patch')
                @csrf

                <div class="form-group row">
                    <label for="last_name" class="col-12 col-sm-2 col-form-label">Nom :</label>
                    <div class="col-12 col-sm-10">
                        <input type="text" class="form-control" name="last_name" id="last_name" maxlength="100" value="{{ $user->last_name }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="first_name" class="col-12 col-sm-2 col-form-label">Prénom :</label>
                    <div class="col-12 col-sm-10">
                        <input type="text" class="form-control" name="first_name" id="first_name" maxlength="100" value="{{ $user->first_name }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status" class="col-12 col-sm-2 col-form-label">Statut :</label>
                    <div class="col-12 col-sm-10 d-flex">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="client" value="client" @if($user->status == 'client') checked @endif required>
                            <label class="form-check-label" for="client">Client</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status" id="admin" value="admin" @if($user->status == 'admin') checked @endif required>
                            <label class="form-check-label" for="admin">Administrateur</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-12 col-sm-2 col-form-label">Adresse e-mail :</label>
                    <div class="col-12 col-sm-10">
                        <input type="email" class="form-control" name="email" id="email" maxlength="255" value="{{ $user->email }}" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>

            </form>
        </div>
    </div>
@endsection

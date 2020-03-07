@extends('layouts.layout')

@section('title', "Mon compte")

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Mon compte</h1>
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
            <form action="{{ route('account.update', $user->id) }}" method="POST">
                @method('PATCH')
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
                        <p id="status" class="m-0 d-flex align-items-center">
                            @if ($user->status == 'admin')
                                Administrateur
                            @elseif ($user->status == 'client')
                                Client
                            @endif
                        </p>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-12 col-sm-2 col-form-label">Adresse e-mail :</label>
                    <div class="col-12 col-sm-10">
                        <input type="email" class="form-control" name="email" id="email" maxlength="255" value="{{ $user->email }}" required>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary my-4">Modifier mon mot de passe</button><br>

                <button type="submit" class="btn btn-primary">Valider</button>

            </form>
        </div>
    </div>
@endsection

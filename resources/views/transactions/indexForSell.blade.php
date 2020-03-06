@extends('layouts.layout')

@section('title', 'Vente de Bitcoin')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Vendre du Bitcoin</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('wallet') }}" role="button">Retour au portefeuille</a>
                <a class="btn btn-sm btn-primary ml-3" href="#" role="button">Vendre tout</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

        </div>
    </div>
@endsection

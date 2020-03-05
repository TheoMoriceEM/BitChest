@extends('layouts.layout')

@section('title', 'Mon Portefeuille')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Mon Portefeuille</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-outline-secondary" href="#" role="button">Voir toutes vos transactions</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="datatable">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Identifiant</th>
                        <th>Quantité</th>
                        <th>Cours actuel</th>
                        <th>Plus-value</th>
                        <th data-orderable="false"></th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><img src="{{ asset('storage/bitcoin.png') }}" alt="Logo Bitcoin" class="mr-3">Bitcoin</td>
                        <td>BTC</td>
                        <td>6,65</td>
                        <td class="d-flex align-items-center">
                            7895.64 {{ config('currency')['symbol'] }}
                            <i class="change-caret-up fas fa-2x fa-caret-up ml-2"></i>
                        </td>
                        <td class="text-danger">- 548,69 {{ config('currency')['symbol'] }}</td>
                        <td><a class="btn btn-sm btn-outline-secondary" href="#" role="button">Voir les transactions</a></td>
                        <td><a class="btn btn-sm btn-primary" href="#" role="button">Vendre</a></td>
                    </tr>
                </tbody>
            </table>

            {{-- <span>Vous ne détenez actuellement aucune cryptomonnaie. Pour en acheter, ça se passe ici : </span>
            <a class="btn btn-sm btn-primary" href="{{ route('currencies.index') }}" role="button">Liste des cryptomonnaies</a> --}}
        </div>
    </div>
@endsection

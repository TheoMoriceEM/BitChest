@extends('layouts.layout')

@section('title', 'Mon Portefeuille')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Mon Portefeuille</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('transactions.index') }}" role="button">Voir toutes vos transactions</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if ($currencies->isNotEmpty())
                <table class="datatable">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Identifiant</th>
                            <th>Quantité</th>
                            <th>Cours actuel</th>
                            <th>Plus/Moins-value</th>
                            <th data-orderable="false"></th>
                            <th data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($currencies as $currency)
                            <tr>
                                <td><img src="{{ asset($currency['currency']->logo) }}" alt="Logo {{ $currency['currency']->name }}" class="mr-3">{{ $currency['currency']->name }}</td>
                                <td>{{ $currency['currency']->api_id }}</td>
                                <td>{{ $currency['total_quantity'] }}</td>
                                <td class="d-flex align-items-center">
                                    {{ $currency['current_rate'] }} {{ config('currency')['symbol'] }}
                                    @if ($currency['change'] == '+')
                                        <i class="change-caret-up fas fa-2x fa-caret-up ml-2"></i>
                                    @else
                                        <i class="change-caret-down fas fa-2x fa-caret-down ml-2"></i>
                                    @endif
                                </td>
                                @if ($currency['increase'] > 0)
                                    <td class="text-success">
                                @else
                                    <td class="text-danger">
                                @endif
                                    {{ $currency['increase'] }} {{ config('currency')['symbol'] }}</td>
                                <td><a class="btn btn-sm btn-outline-secondary" href="{{ route('transactions.index', $currency['currency']->id) }}" role="button">Voir les transactions</a></td>
                                <td><a class="btn btn-sm btn-primary" href="#" role="button">Vendre</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="text-center">
                    Vous ne détenez actuellement aucune cryptomonnaie.<br>Pour en acheter, ça se passe ici :
                    <a class="btn btn-sm btn-primary" href="{{ route('currencies.index') }}" role="button">Liste des cryptomonnaies</a>
                </div>
            @endif
        </div>
    </div>
@endsection

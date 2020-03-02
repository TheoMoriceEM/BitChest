@extends('layouts.layout')

@section('title', 'Cours des cryptomonnaies')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Liste des cryptomonnaies</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="datatable">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Identifiant</th>
                        <th>Cours actuel</th>
                        <th data-orderable="false"></th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($currencies as $currency)
                        <tr>
                            <td><img src="{{ asset($currency->logo) }}" alt="Logo {{ $currency->name }}" class="mr-3">{{ $currency->name }}</td>
                            <td>{{ $currency->api_id }}</td>
                            <td class="d-flex align-items-center">
                                {{ $currency->current_rate }} {{ config('currency')['symbol'] }}
                                @if ($currency->change == '+')
                                    <i class="change-caret-up fas fa-2x fa-caret-up ml-2"></i>
                                @else
                                    <i class="change-caret-down fas fa-2x fa-caret-down ml-2"></i>
                                @endif
                            </td>
                            <td><a class="btn btn-sm btn-outline-secondary" href="{{ route('currencies.show', $currency->id) }}" role="button">Historique</a></td>
                            <td><a class="btn btn-sm btn-primary" href="{{ route('transactions.create', $currency->id) }}" role="button">Acheter</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

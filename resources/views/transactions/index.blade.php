@extends('layouts.layout')

@section('title', 'Vos transactions')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Liste des transactions</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('wallet') }}" role="button">Retour au portefeuille</a>
                {{-- <a class="btn btn-sm btn-primary ml-3" href="#" role="button">Vendre</a> --}}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <ul class="nav nav-tabs" id="transactionsTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-tab" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">Toutes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="unsold-tab" data-toggle="tab" href="#unsold" role="tab" aria-controls="unsold" aria-selected="false">Non vendues</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="sold-tab" data-toggle="tab" href="#sold" role="tab" aria-controls="sold" aria-selected="false">Vendues</a>
                </li>
            </ul>

            <div class="tab-content mt-4">
                <div class="tab-pane active" id="all" role="tabpanel" aria-labelledby="all-tab">
                    <table class="datatable custom">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Identifiant</th>
                                <th>Quantité</th>
                                <th>Cours à l'achat</th>
                                <th>Total dépensé</th>
                                <th>Date d'achat</th>
                                <th data-orderable="false">Statut</th>
                                <th>Cours à la vente</th>
                                <th>Montant de la vente</th>
                                <th>Plus/Moins-value</th>
                                <th>Date de vente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td><img src="{{ asset($transaction->currency->logo) }}" alt="Logo {{ $transaction->currency->name }}" class="mr-3">{{ $transaction->currency->name }}</td>
                                    <td>{{ $transaction->currency->api_id }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->purchase_price }} {{ config('currency')['symbol'] }}</td>
                                    <td>{{ $transaction->amount }} {{ config('currency')['symbol'] }}</td>
                                    <td>{{ $transaction->purchase_date }}</td>
                                    @if ($transaction->sold)
                                        <td><span class="badge badge-success">Vendu</span></td>
                                        <td>{{ $transaction->selling_price }} {{ config('currency')['symbol'] }}</td>
                                        <td>{{ $transaction->selling_amount }} {{ config('currency')['symbol'] }}</td>
                                        @if ($transaction->selling_amount - $transaction->amount >= 0)
                                            <td class="text-success">
                                                {{ $transaction->selling_amount - $transaction->amount }} {{ config('currency')['symbol'] }}
                                            </td>
                                        @else
                                            <td class="text-danger">
                                                {{ $transaction->selling_amount - $transaction->amount }} {{ config('currency')['symbol'] }}
                                            </td>
                                        @endif
                                        <td>{{ $transaction->selling_date }}</td>
                                    @else
                                        <td><span class="badge badge-danger">Non vendu</span></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td>-</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="unsold" role="tabpanel" aria-labelledby="unsold-tab">
                    <table class="datatable custom">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Identifiant</th>
                                <th>Quantité</th>
                                <th>Cours à l'achat</th>
                                <th>Total dépensé</th>
                                <th>Date d'achat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions->where('sold', false) as $transaction)
                                <tr>
                                    <td><img src="{{ asset($transaction->currency->logo) }}" alt="Logo {{ $transaction->currency->name }}" class="mr-3">{{ $transaction->currency->name }}</td>
                                    <td>{{ $transaction->currency->api_id }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->purchase_price }} {{ config('currency')['symbol'] }}</td>
                                    <td>{{ $transaction->amount }} {{ config('currency')['symbol'] }}</td>
                                    <td>{{ $transaction->purchase_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="sold" role="tabpanel" aria-labelledby="sold-tab">
                    <table class="datatable custom">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Identifiant</th>
                                <th>Quantité</th>
                                <th>Cours à l'achat</th>
                                <th>Total dépensé</th>
                                <th>Date d'achat</th>
                                <th>Cours à la vente</th>
                                <th>Montant de la vente</th>
                                <th>Plus/Moins-value</th>
                                <th>Date de vente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions->where('sold', true) as $transaction)
                                <tr>
                                    <td><img src="{{ asset($transaction->currency->logo) }}" alt="Logo {{ $transaction->currency->name }}" class="mr-3">{{ $transaction->currency->name }}</td>
                                    <td>{{ $transaction->currency->api_id }}</td>
                                    <td>{{ $transaction->quantity }}</td>
                                    <td>{{ $transaction->purchase_price }} {{ config('currency')['symbol'] }}</td>
                                    <td>{{ $transaction->amount }} {{ config('currency')['symbol'] }}</td>
                                    <td>{{ $transaction->purchase_date }}</td>
                                    <td>{{ $transaction->selling_price }} {{ config('currency')['symbol'] }}</td>
                                    <td>{{ $transaction->selling_amount }} {{ config('currency')['symbol'] }}</td>
                                    @if ($transaction->selling_amount - $transaction->amount >= 0)
                                        <td class="text-success">
                                            {{ $transaction->selling_amount - $transaction->amount }} {{ config('currency')['symbol'] }}
                                        </td>
                                    @else
                                        <td class="text-danger">
                                            {{ $transaction->selling_amount - $transaction->amount }} {{ config('currency')['symbol'] }}
                                        </td>
                                    @endif
                                    <td>{{ $transaction->selling_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('JS')
    <script>
        $(function() {
            $('.datatable.custom').DataTable({
                order: [[5, "desc"]]
            });
        });
    </script>
@endsection

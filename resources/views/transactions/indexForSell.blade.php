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
            <div class="alert alert-warning" role="alert">
                <span class="font-weight-bold">Attention :</span> toutes les informations de paiement sont calculées par rapport au cours de la monnaie au moment où vous êtes arrivé(e) sur cette page. Pour actualiser ces informations en fonction du cours le plus récent, cliquez sur le bouton <span class="font-weight-bold">"Rafraîchir le cours actuel"</span> ci-dessous.
            </div>
            <div class="alert alert-info" role="alert">
                Cours actuel du Bitcoin :
                <span class="font-weight-bold">
                    <span id="currentRate">7896.25</span> €
                </span>
                <button type="button" id="refreshRate" class="btn btn-info text-white ml-2" data-toggle="tooltip" data-placement="top" title="Rafraîchir le cours actuel">
                    <i class="fas fa-sync"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="datatable custom">
                <thead>
                    <tr>
                        <th>Quantité</th>
                        <th>Cours à l'achat</th>
                        <th>Total dépensé</th>
                        <th>Total de vente potentiel</th>
                        <th>Plus/Moins-value</th>
                        <th>Date d'achat</th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->quantity }}</td>
                            <td>{{ $transaction->purchase_price }} €</td>
                            <td>{{ $transaction->amount }} €</td>
                            <td>3325.14 €</td>
                            <td class="text-danger">-755.69 €</td>
                            <td>{{ $transaction->purchase_date }}</td>
                            <td><a class="btn btn-sm btn-primary" href="#" role="button">Vendre</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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

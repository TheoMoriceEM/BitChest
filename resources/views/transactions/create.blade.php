@extends('layouts.layout')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Achat {{ $currency->name }}</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('currencies.index') }}" role="button">Retour liste</a>
                <a class="btn btn-sm btn-primary ml-3" href="{{ route('currencies.show', $currency->id) }}" role="button">Historique</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info" role="alert">
                Cours actuel du {{ $currency->name }} :
                <span class="font-weight-bold">
                    <span id="currentRate"></span> €
                </span>
                <button type="button" id="refreshRate" class="btn btn-info text-white ml-2" data-toggle="tooltip" data-placement="top" title="Rafraîchir le cours actuel">
                    <i class="fas fa-sync"></i>
                </button>
            </div>
        </div>
        <div class="col-12">
            <form action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="buying_option">Choisissez une méthode d'achat :</label>
                    <div class="form-check">
                        <input class="form-check-input buying_options" type="radio" name="buying_option" id="buy_by_amount" value="amountBuyingInput">
                        <label class="form-check-label" for="buy_by_amount">Investir une certaine somme</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input buying_options" type="radio" name="buying_option" id="buy_by_quantity" value="quantityBuyingInput">
                        <label class="form-check-label" for="buy_by_quantity">Acheter une certaine quantité</label>
                    </div>
                </div>
                <div class="form-group buying-inputs" id="amountBuyingInput">
                    <label for="amount">Somme à investir</label>
                    <input type="number" class="form-control" id="amount" name="amount" aria-describedby="amountTotal">
                    <small id="amountTotal" class="form-text text-muted">Total de {{ $currency->name }} acquis : 0.235689</small>
                </div>
                <div class="form-group buying-inputs" id="quantityBuyingInput">
                    <label for="quantity">Quantité à acheter</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" step="0.001" aria-describedby="quantityTotal">
                    <small id="quantityTotal" class="form-text text-muted">Total à payer : 524.89 €</small>
                </div>
                <input type="hidden" name="fk_currency" value="{{ $currency->id }}">
                <input type="hidden" name="currency_api_id" value="{{ $currency->api_id }}">
                <button type="submit" class="btn btn-primary">Confirmer l'achat</button>
            </form>
        </div>
    </div>
@endsection

@section('JS')
    <script>
        const refreshIcon = $('#refreshRate .fa-sync');

        function displayCurrentRate() {
            $.get({
                url: 'https://min-api.cryptocompare.com/data/price',
                data: {
                    fsym: 'BTC',
                    tsyms: 'EUR'
                },
                success: function(data) {
                    refreshIcon.removeClass('fa-spin');
                    $('#currentRate').text(data.EUR);
                }
            })
            .fail(function(error) {
                console.log(error);
            });
        }

        $(function() {
            displayCurrentRate();
        });

        $('#refreshRate').click(function() {
            refreshIcon.addClass('fa-spin');
            displayCurrentRate();
        });
    </script>
@endsection

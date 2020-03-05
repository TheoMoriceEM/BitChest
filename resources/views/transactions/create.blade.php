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
            <div class="alert alert-warning" role="alert">
                <span class="font-weight-bold">Attention :</span> toutes les informations de paiement sont calculées par rapport au cours de la monnaie au moment où vous êtes arrivé(e) sur cette page. Pour actualiser ces informations en fonction du cours le plus récent, cliquez sur le bouton <span class="font-weight-bold">"Rafraîchir le cours actuel"</span> ci-dessous.
            </div>
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
            <form id="buyingForm" action="{{ route('transactions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="buying_option">Choisissez une méthode d'achat :</label>
                    <div class="form-check">
                        <input class="form-check-input buying_options" type="radio" name="buying_option" id="buy_by_amount" value="amountBuyingInput" required>
                        <label class="form-check-label" for="buy_by_amount">Investir une certaine somme</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input buying_options" type="radio" name="buying_option" id="buy_by_quantity" value="quantityBuyingInput" required>
                        <label class="form-check-label" for="buy_by_quantity">Acheter une certaine quantité</label>
                    </div>
                </div>
                <div class="form-group buying-inputs" id="amountBuyingInput">
                    <label for="amount">Somme à investir</label>
                    <input type="number" class="form-control" id="amount" name="amount" max="999999" aria-describedby="amountTotal">
                    <small class="form-text text-muted">
                        Total de {{ $currency->name }} acquis :
                        <span id="quantityTotal" class="font-weight-bold"></span>
                    </small>
                </div>
                <div class="form-group buying-inputs" id="quantityBuyingInput">
                    <label for="quantity">Quantité à acheter</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" step="0.001" aria-describedby="quantityTotal">
                    <small class="form-text text-muted">
                        Total à payer :
                        <span class="font-weight-bold">
                            <span id="amountTotal"></span> €
                        </span>
                    </small>
                </div>
                <input type="hidden" name="currency_id" value="{{ $currency->id }}">
                <input type="hidden" name="currency_api_id" value="{{ $currency->api_id }}">
                <button type="submit" class="btn btn-primary">Confirmer l'achat</button>
            </form>
        </div>
    </div>
@endsection

@section('JS')
    <script>
        let currentRate;
        const refreshIcon = $('#refreshRate .fa-sync');

        function calcAndDisplayQuantity() {
            const quantityTotal = $('#amount').val() / currentRate;
            $('#quantityTotal').text(quantityTotal.toFixed(4));
        }

        function calcAndDisplayAmount() {
            const amountTotal = $('#quantity').val() * currentRate;
            $('#amountTotal').text(amountTotal.toFixed(2));
        }

        function getAndDisplayCurrentRate() {
            // Get current rate from the API
            $.get({
                url: 'https://min-api.cryptocompare.com/data/price',
                data: {
                    fsym: '{{ $currency->api_id }}',
                    tsyms: '{{ config('currency')['api_id'] }}'
                },
                success: function(data) {
                    currentRate = data.EUR;

                    // Refresh payment infos
                    calcAndDisplayQuantity();
                    calcAndDisplayAmount();

                    $('#currentRate').text(currentRate); // Refresh rate display

                    // Calculate max value for quantity input (total amount mustn't exceed 999999)
                    const qtyMax = 999999 / currentRate;
                    $('#quantity').attr('max', qtyMax);

                    refreshIcon.removeClass('fa-spin'); // Stop icon spinning
                }
            })
            .fail(function(error) {
                console.log(error);
            });
        }

        // On page load
        $(function() {
            getAndDisplayCurrentRate();
        });

        // On click on refresh button
        $('#refreshRate').click(function() {
            refreshIcon.addClass('fa-spin'); // Make the icon spin during the request
            getAndDisplayCurrentRate(); // Refresh payment info
        });

        // When the user types in an input
        $('input[type="number"]').on('input', function() {
            if ($(this).is('#amount')) {
                calcAndDisplayQuantity();
            } else if ($(this).is('#quantity')) {
                calcAndDisplayAmount();
            }
        });

        // Confirm before form submitting
        $("#buyingForm").on("submit", function () {
            return confirm("Confimer l'achat ?");
        });
    </script>
@endsection

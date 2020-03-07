@extends('layouts.layout')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Vendre du {{ $transactions->first()->currency->name }}</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('wallet') }}" role="button">Retour au portefeuille</a>
                <form class="selling-form" action="{{ route('transactions.update', $transactions->first()->currency->id) }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <input class="btn btn-sm btn-primary ml-3" role="button" type="submit" value="Vendre tout">
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="alert alert-warning" role="alert">
                <span class="font-weight-bold">Attention :</span> toutes les informations de paiement sont calculées par rapport au cours de la monnaie au moment où vous êtes arrivé(e) sur cette page. Pour actualiser ces informations en fonction du cours le plus récent, cliquez sur le bouton <span class="font-weight-bold">"Rafraîchir le cours actuel"</span> ci-dessous.
            </div>
            <div class="alert alert-info" role="alert">
                Cours actuel du {{ $transactions->first()->currency->name }} :
                <span class="font-weight-bold">
                    <span id="currentRate"></span> {{ config('currency')['symbol'] }}
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
                        <tr class="transaction">
                            <td class="quantity">{{ $transaction->quantity + 0 }}</td>
                            <td>{{ $transaction->purchase_price }} {{ config('currency')['symbol'] }}</td>
                            <td class="amount">{{ $transaction->amount }} {{ config('currency')['symbol'] }}</td>
                            <td><span class="selling-amount"></span> {{ config('currency')['symbol'] }}</td>
                            <td class="increase-col"><span class="increase"></span> {{ config('currency')['symbol'] }}</td>
                            <td>{{ $transaction->purchase_date }}</td>
                            <td>
                                <form class="selling-form" action="{{ route('transactions.update', [$transactions->first()->currency->id, $transaction->id]) }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <input type="hidden" name="selling_amount" value="">
                                    <input type="hidden" name="selling_price" value="">
                                    <input class="btn btn-sm btn-primary" role="button" type="submit" value="Vendre">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('JS')
    <script>
        let currentRate;
        const refreshIcon = $('#refreshRate .fa-sync');
        const transactions = $('.transaction');

        function refreshTransactionInfo() {
            // Loop through transactions to make calculations for all of them
            $.each(transactions, function (i, transaction) {
                const sellingAmount = $(transaction).find('.quantity').text() * currentRate;
                const increase = sellingAmount - parseInt($(transaction).find('.amount').text());

                $(transaction).find('.selling-amount').text(sellingAmount.toFixed(2));
                $(transaction).find('.increase').text(increase.toFixed(2));

                if (increase > 0) {
                    $(transaction).find('.increase-col').addClass('text-success');
                } else {
                    $(transaction).find('.increase-col').addClass('text-danger');
                }

                // Set hidden inputs values for having these values when we sell
                $('input[name="selling_amount"]').val(sellingAmount);
                $('input[name="selling_price"]').val(currentRate);
            });
        }

        function getAndDisplayCurrentRate() {
            // Get current rate from the API
            $.get({
                url: '{{ route('api.get-price', $transactions->first()->currency->api_id) }}',
                success: function(data) {
                    currentRate = data;
                    refreshTransactionInfo(); // Refresh payment infos
                    $('#currentRate').text(currentRate); // Refresh rate display
                    refreshIcon.removeClass('fa-spin'); // Stop icon spinning
                }
            })
            .fail(function(error) {
                console.log(error);
            });
        }

        $(function() {
            $('.datatable.custom').DataTable({
                order: [[4, "desc"]],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                }
            });

            getAndDisplayCurrentRate(); // On page load

            // On click on refresh button
            $('#refreshRate').click(function() {
                refreshIcon.addClass('fa-spin'); // Make the icon spin during the request
                getAndDisplayCurrentRate(); // Refresh payment info
            });

            // Confirm before form submitting
            $(".selling-form").submit(function () {
                return confirm("Confimer la vente ?");
            });
        });
    </script>
@endsection

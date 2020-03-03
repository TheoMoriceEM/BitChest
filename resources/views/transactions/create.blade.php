@extends('layouts.layout')

@section('title', 'Acheter du Bitcoin')

@section('content')
    <h1 class="text-center">Achat Bitcoin</h1>
    <div class="d-flex justify-content-center my-4">
        <a class="btn btn-sm btn-outline-secondary" href="#" role="button">Retour liste</a>
        <a class="btn btn-sm btn-primary ml-3" href="#" role="button">Historique</a>
    </div>
    <form action="" method="POST">
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
            <input type="number" class="form-control" id="amount" aria-describedby="amountTotal">
            <small id="amountTotal" class="form-text text-muted">Total de Bitcoin acquis : 0.235689</small>
        </div>
        <div class="form-group buying-inputs" id="quantityBuyingInput">
            <label for="quantity">Quantité à acheter</label>
            <input type="number" class="form-control" id="quantity" step="0.001" aria-describedby="quantityTotal">
            <small id="quantityTotal" class="form-text text-muted">Total à payer : 524.89 €</small>
        </div>
        <button type="submit" class="btn btn-primary">Confirmer l'achat</button>
    </form>
@endsection

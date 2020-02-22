@extends('layouts.layout')

@section('title', 'Cours des cryptomonnaies')

@section('content')
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
            <tr>
                <td>Bitcoin</td>
                <td>BTC</td>
                <td>3056,87 €</td>
                <td><a class="btn btn-sm btn-outline-secondary" href="#" role="button">Historique</a></td>
                <td><a class="btn btn-sm btn-primary" href="#" role="button">Acheter</a></td>
            </tr>
            <tr>
                <td>Ethereum</td>
                <td>ETH</td>
                <td>826,24 €</td>
                <td><a class="btn btn-sm btn-outline-secondary" href="#" role="button">Historique</a></td>
                <td><a class="btn btn-sm btn-primary" href="#" role="button">Acheter</a></td>
            </tr>
            <tr>
                <td>Ripple</td>
                <td>XRP</td>
                <td>214,07 €</td>
                <td><a class="btn btn-sm btn-outline-secondary" href="#" role="button">Historique</a></td>
                <td><a class="btn btn-sm btn-primary" href="#" role="button">Acheter</a></td>
            </tr>
        </tbody>
    </table>
@endsection

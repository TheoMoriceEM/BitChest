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
            <table class="datatable custom">
                <thead>
                    <tr>
                        <th>Quantité</th>
                        <th>Cours à l'achat</th>
                        <th>Total dépensé</th>
                        <th>Cours actuel</th>
                        <th>Total de vente potentiel</th>
                        <th>Plus/Moins-value</th>
                        <th>Date d'achat</th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0.42</td>
                        <td>8796.31 €</td>
                        <td>4000 €</td>
                        <td>7458.39 €</td>
                        <td>3325.14 €</td>
                        <td class="text-danger">-755.69 €</td>
                        <td>20/11/2019 15:46</td>
                        <td><a class="btn btn-sm btn-primary" href="#" role="button">Vendre</a></td>
                    </tr>
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

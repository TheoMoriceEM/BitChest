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
            @foreach ($currencies as $currency)
                <tr>
                    <td>{{ $currency->name }}</td>
                    <td>{{ $currency->api_id }}</td>
                    <td class="d-flex align-items-center">
                        {{ $currency->current_rate }} {{ config('currency')['symbol'] }}
                        @if ($currency->change == '+')
                            <i class="change-caret-up fas fa-2x fa-caret-up ml-2"></i>
                        @else
                            <i class="change-caret-down fas fa-2x fa-caret-down ml-2"></i>
                        @endif
                    </td>
                    <td><a class="btn btn-sm btn-outline-secondary" href="#" role="button">Historique</a></td>
                    <td><a class="btn btn-sm btn-primary" href="#" role="button">Acheter</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

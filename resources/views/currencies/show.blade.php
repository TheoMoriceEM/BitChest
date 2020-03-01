@extends('layouts.layout')

@section('title', 'Cours du Bitcoin')

@section('content')
    <h1 class="text-center">Historique du Bitcoin</h1>
    <div class="d-flex justify-content-center my-4">
        <a class="btn btn-sm btn-outline-secondary" href="{{ route('currencies.index') }}" role="button">Retour</a>
        <a class="btn btn-sm btn-primary ml-3" href="#" role="button">Acheter</a>
    </div>
    <canvas id="historyChart"></canvas>
@endsection

@section('JS')
    <script>
        new Chart($('#historyChart'), {
            type: 'line',
            data: {
                labels: [
                    '01/02', '', '', '', '',
                    '06/02', '', '', '', '',
                    '11/02', '', '', '', '',
                    '16/02', '', '', '', '',
                    '21/02', '', '', '', '',
                    '26/02', '', '', '', '01/03'
                ],
                datasets: [{
                    label: 'Cours du Bitcoin',
                    data: [
                        65, 59, 80, 81, 56,
                        55, 40, 28, 36, 64,
                        65, 59, 80, 81, 56,
                        55, 40, 28, 36, 64,
                        65, 59, 80, 81, 56,
                        55, 40, 28, 36, 64
                    ],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgb(75, 192, 192, .1)',
                    lineTension: 0.1
                }]
            }
        });
    </script>
@endsection

@extends('layouts.layout')

@section('title', $title)

@section('content')
    <h1 class="text-center">Historique du {{ $currency }}</h1>
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
                    @foreach ($days as $day)
                        @if ($loop->first || $loop->iteration % 5 === 0)
                            '{{ $day['date'] }}',
                        @else
                            '',
                        @endif
                    @endforeach
                ],
                datasets: [{
                    label: 'Cours du {{ $currency }}',
                    data: [
                        @foreach ($days as $day)
                            {{ $day['rate'] }},
                        @endforeach
                    ],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgb(75, 192, 192, .1)',
                    lineTension: 0.1
                }]
            }
        });
    </script>
@endsection

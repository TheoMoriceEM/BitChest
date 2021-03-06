@extends('layouts.layout')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Historique du {{ $currency->name }}</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('currencies.index') }}" role="button">Retour liste</a>
                <a class="btn btn-sm btn-primary ml-3" href="{{ route('transactions.create', $currency->id) }}" role="button">Acheter</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <canvas id="historyChart"></canvas>
        </div>
    </div>
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
                    label: 'Cours du {{ $currency->name }}',
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

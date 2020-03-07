@extends('layouts.layout')

@section('title', 'Les utilisateurs')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Liste des utilisateurs</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-primary ml-3" href="{{ route('users.create') }}" role="button">Ajouter un utilisateur</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="datatable custom">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Adresse email</th>
                        <th>Date d'inscription</th>
                        <th>Statut</th>
                        <th data-orderable="false"></th>
                        <th data-orderable="false"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->subscription_date }}</td>
                            <td>
                                @if ($user->status == 'admin')
                                    <span class="badge badge-primary">Administrateur</span>
                                @elseif ($user->status == 'client')
                                    <span class="badge badge-secondary">Client</span>
                                @endif
                            </td>
                            <td><a type="button" class="btn btn-sm btn-primary" href="{{ route('users.edit', $user->id) }}">Modifier</a></td>
                            <td>
                                <form class="delete-form" action="{{ route('users.destroy', $user->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <input class="btn btn-sm btn-danger ml-3" role="button" type="submit" value="Supprimer">
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
        $(function() {
            $('.datatable.custom').DataTable({
                order: [[3, "desc"]],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                }
            });

            // Confirm before form submitting
            $(".delete-form").submit(function () {
                return confirm("Confimer la suppression ?");
            });
        });
    </script>
@endsection

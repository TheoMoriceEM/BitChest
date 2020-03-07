@extends('layouts.layout')

@section('title', 'Les utilisateurs')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Liste des utilisateurs</h1>
            <div class="d-flex justify-content-center my-4">
                <a class="btn btn-sm btn-primary ml-3" href="#" role="button">Ajouter un utilisateur</a>
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
                    <tr>
                        <td>Morice</td>
                        <td>Théo</td>
                        <td>theo.morice5@gmail.com</td>
                        <td>27/12/2018</td>
                        <td><span class="badge badge-primary">Administrateur</span></td>
                        <td><a type="button" class="btn btn-primary" href="#">Modifier</a></td>
                        <td><a type="button" class="btn btn-danger" href="#">Supprimer</a></td>
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
                order: [[3, "asc"]],
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.20/i18n/French.json"
                }
            });
        });
    </script>
@endsection

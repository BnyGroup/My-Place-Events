@extends('AdminTheme.master')

@section('title', 'Newsletter abonnes')

@section('content-header')
    <h1>Liste des utilisateurs</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li><a href="#"> Liste des abonnés à la newsletter</a></li>
    </ol>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Liste des abonnés à la newsletter</h3>
        </div>
        <div class="box-body">
            <table id="AllempTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newsletterAbonnes as $newsletterAbonne)
                        <tr>
                            <td>{{ $newsletterAbonne->id }}</td>
                            <td>{{ $newsletterAbonne->email }}</td>
                            <td class="text-center">Action</td> <!-- Placeholder for action buttons -->
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

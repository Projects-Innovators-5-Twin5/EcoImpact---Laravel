@extends('back.layout')
<title>EcoImpact - Liste des Produits</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

@section('content')
<div class="container">
    <h1>Liste des Produits</h1>
    <a href="{{ route('produits.create') }}" class="btn btn-primary mb-3">Ajouter un Produit</a>

    <!-- Champ de recherche avec un style amélioré -->
    <div class="input-group mb-3">
        <div class="input-group-append">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>

    <table id="produitsTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produits as $produit)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="img-thumbnail" style="width: 100px; height: auto;">
                    </td>
                    <td>{{ $produit->nom }}</td>
                    <td>{{ Str::limit($produit->description, 50) }}</td>
                    <td>{{ $produit->prix }} DT</td>
                    <td>{{ $produit->quantite }}</td>
                    <td>
                        <a href="{{ route('produits.edit', $produit) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('produits.destroy', $produit) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            // Initialise DataTable
            var table = $('#produitsTable').DataTable();

            // Filtrer le tableau en fonction de la recherche
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });
        });
    </script>
</div>
@endsection

@extends('back.layout')

@section('content')
    <h1>Liste des Produits</h1>
    <a href="{{ route('produits.create') }}" class="btn btn-primary mb-3">Ajouter un Produit</a>

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
                    <td>{{ $produit->description }}</td>
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
            $('#produitsTable').DataTable();
        });
    </script>
@endsection

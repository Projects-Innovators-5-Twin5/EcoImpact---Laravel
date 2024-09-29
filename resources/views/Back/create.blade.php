@extends('back.layout')

@section('content')
    <h1>Créer un Nouveau Produit</h1>
    <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="nom">Nom:</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div>
            <label for="prix">Prix:</label>
            <input type="number" name="prix" id="prix" required>
        </div>
        <div>
            <label for="quantite">Quantité:</label>
            <input type="number" name="quantite" id="quantite" required>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" accept="image/*">
        </div>
        <button type="submit">Créer Produit</button>
    </form>
@endsection

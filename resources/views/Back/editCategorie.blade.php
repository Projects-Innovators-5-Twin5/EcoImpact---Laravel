@extends('back.layout')

@section('content')
    <div class="container">
        <h1>Modifier la catégorie : {{ $categorie->nom }}</h1>

        <form action="{{ route('categories.update', $categorie->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $categorie->nom) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description', $categorie->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="produits">Produits</label>
                <select name="produits[]" id="produits" class="form-control" multiple>
                    @foreach($produits as $produit)
                        <option value="{{ $produit->id }}" {{ in_array($produit->id, $categorie->produits->pluck('id')->toArray()) ? 'selected' : '' }}>
                            {{ $produit->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
@endsection

@extends('back.layout')

@section('content')
    <div class="container">
        <h1>Modifier la catégorie : {{ $categorie->nom }}</h1>

        <form action="{{ route('categories.update', $categorie->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $categorie->nom) }}" required minlength="3" maxlength="100">
                @error('nom')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" required minlength="10" maxlength="500">{{ old('description', $categorie->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="produits">Produits</label>
                <select name="produits[]" id="produits" class="form-control @error('produits') is-invalid @enderror" multiple>
                    @foreach($produits as $produit)
                        <option value="{{ $produit->id }}" {{ in_array($produit->id, old('produits', $categorie->produits->pluck('id')->toArray())) ? 'selected' : '' }}>
                            {{ $produit->nom }}
                        </option>
                    @endforeach
                </select>
                @error('produits')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
@endsection

@extends('back.layout')

@section('content')
    <div class="py-4">
        <h1 class="h4">Modifier le Produit</h1>
        <p class="mb-0">Mettez à jour les détails ci-dessous pour modifier le produit.</p>
        <div class="button-group">
            <a href="{{ route('produits.backproduit') }}" class="btn btn-secondary back-btn">Retour à la Liste des Produits</a>
        </div>
    </div>

    <form action="{{ route('produits.update', $produit->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $produit->nom) }}" required minlength="3" maxlength="100">
                    @error('nom')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" required minlength="10" maxlength="500">{{ old('description', $produit->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prix" class="form-label">Prix</label>
                    <input type="number" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $produit->prix) }}" required min="0.01" step="0.01">
                    @error('prix')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" class="form-control @error('quantite') is-invalid @enderror" id="quantite" name="quantite" value="{{ old('quantite', $produit->quantite) }}" required min="1">
                    @error('quantite')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    @if ($produit->image)
                        <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="img-thumbnail mt-2" style="width: 100px; height: auto;">
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Mettre à jour</button>
                <a href="{{ route('produits.index') }}" class="btn btn-secondary">Annuler</a>
            </div>
        </div>
    </form>
@endsection

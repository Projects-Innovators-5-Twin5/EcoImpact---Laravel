@extends('back.layout')

@section('content')
    <div class="py-4">
        <h1 class="h4">Créer un Nouveau Produit</h1>
        <p class="mb-0">Remplissez les détails ci-dessous pour créer un nouveau produit.</p>
    </div>
    <form action="{{ route('produits.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Entrez le nom du produit" required minlength="3" maxlength="100">
                        @error('nom')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-lg-6 mb-3">
                        <label for="prix" class="form-label">Prix</label>
                        <input type="number" name="prix" id="prix" class="form-control @error('prix') is-invalid @enderror" value="{{ old('prix') }}" placeholder="Entrez le prix" required min="0.01" step="0.01">
                        @error('prix')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Décrivez le produit..." required minlength="10" maxlength="500">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="quantite" class="form-label">Quantité</label>
                    <input type="number" name="quantite" id="quantite" class="form-control @error('quantite') is-invalid @enderror" value="{{ old('quantite') }}" required min="1">
                    @error('quantite')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image du Produit</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Créer Produit</button>
            </div>
        </div>
    </form>
@endsection

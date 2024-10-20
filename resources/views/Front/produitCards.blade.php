@extends('front.layout')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">Produits par Catégorie: {{ $categorie->nom ?? 'Tous les produits' }}</h1>

        <div class="row mb-4">
            <div class="col-md-4 offset-md-4">
                <select id="categorieSelect" class="form-select" onchange="location = this.value;">
                    <option value="{{ route('produits.backproduit') }}">Tous les produits</option>
                    @foreach ($categories as $category)
                        <option value="{{ route('categorie.produits', $category->id) }}" {{ $category->id === ($categorie->id ?? null) ? 'selected' : '' }}>
                            {{ $category->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            @if(isset($produits) && $produits->isEmpty())
                <div class="col-12">
                    <div class="alert alert-warning text-center">Aucun produit disponible dans cette catégorie.</div>
                </div>
            @else
                @foreach ($produits ?? [] as $produit)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-light">
                            @if ($produit->image)
                                <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top" style="height: 200px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                    <span class="text-muted">Aucune image disponible</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $produit->nom }}</h5>
                                <p class="card-text">{{ Str::limit($produit->description, 70) }}</p>
                                <p class="card-text"><strong>Prix:</strong> {{ $produit->prix }} DT</p>
                                <p class="card-text"><strong>Quantité:</strong> {{ $produit->quantite }}</p>
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('produits.show', $produit->id) }}" class="btn btn-info btn-sm">Voir Détails</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

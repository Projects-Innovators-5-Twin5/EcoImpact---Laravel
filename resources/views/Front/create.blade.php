@extends('front.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">{{ $produit->nom }}</h1>

        <div class="row">
            <div class="col-md-6">
                @if ($produit->image)
                    <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="img-fluid rounded shadow" style="height: 300px; object-fit: cover;">
                @else
                    <div class="card-img-top rounded shadow" style="height: 300px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                        <span class="text-muted">Aucune image disponible</span>
                    </div>
                @endif
            </div>

            <div class="col-md-6">
                <div class="product-details border p-3 rounded shadow-sm">
                    <h3 class="mb-3">Détails du produit</h3>
                    <p><strong>Description:</strong> {{ $produit->description }}</p>
                    <p><strong>Prix:</strong> <span class="text-success">{{ $produit->prix }} DT</span></p>
                    <p><strong>Quantité disponible:</strong> {{ $produit->quantite }}</p>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('produits.index') }}" class="btn btn-secondary">Retour à la liste</a>
                        <form action="{{ route('commandes.store') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="produit_id" value="{{ $produit->id }}">
                            <input type="hidden" name="client_id" value="{{ auth()->user()->id }}">
                            <button type="submit" class="btn btn-primary">Commander maintenant</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
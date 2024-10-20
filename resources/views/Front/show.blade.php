
<script src="{{ asset('js/landing.js') }}"></script>

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
                        <span class="text-muted">No image available</span>
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
                        <a href="{{ route('produitCards.front') }}" class="btn btn-secondary">Retour à la liste</a>

                        <form action="{{ route('panier.ajouter', $produit->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

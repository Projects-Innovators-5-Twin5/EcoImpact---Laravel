<script src="{{ asset('js/landing.js') }}"></script>

@extends('front.layout')

@section('content')
    <h1 class="text-center mb-4">Products</h1>
    <div class="card">
    <div class="container  p-3">
        <div class="row">
            @foreach ($produits as $produit)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-light">
                        @if ($produit->image)
                            <img src="{{ asset('storage/' . $produit->image) }}" alt="{{ $produit->nom }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top" style="height: 200px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                <span class="text-muted">No image available</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $produit->nom }}</h5>
                            <p class="card-text">{{ Str::limit($produit->description, 70) }}</p>
                            <p class="card-text"><strong>Price:</strong> {{ $produit->prix }} DT</p>
                            <p class="card-text"><strong>Quantity:</strong> {{ $produit->quantite }}</p>
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('produits.show', $produit->id) }}" class="btn btn-primary btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

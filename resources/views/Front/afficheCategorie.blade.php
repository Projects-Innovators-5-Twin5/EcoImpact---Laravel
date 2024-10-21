@extends('front.layout')

@section('content')
    <h1 class="text-center mb-4">Catégories et Produits</h1>
    <div class="container">
        <div class="row">
            @foreach ($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-light">
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->nom }}</h5>
                            <p class="card-text">{{ Str::limit($category->description, 70) }}</p>

                            <h6>Produits:</h6>
                            <ul class="list-unstyled">
                                @if($category->produits->isEmpty())
                                    <li><em>Aucun produit disponible</em></li>
                                @else
                                    @foreach ($category->produits as $produit)
                                        <li>
                                            <strong>{{ $produit->nom }}</strong> - {{ $produit->prix }} DT
                                            <a href="{{ route('produits.show', $produit->id) }}" class="btn btn-info btn-sm">Voir Détails</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                            <!-- Lien vers la page des produits de cette catégorie -->
                            <a href="{{ route('categories.produits', $category->id) }}" class="btn btn-primary">Voir tous les produits</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

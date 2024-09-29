@extends('front.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Votre panier</h1>

        @if(session('panier'))
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('panier') as $id => $details)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(isset($details['image']))
                                            <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['nom'] }}" class="img-thumbnail mr-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>{{ $details['nom'] }}</div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    {{ $details['quantite'] }}
                                </td>
                                <td class="align-middle">{{ $details['prix'] }} DT</td>
                                <td class="align-middle">{{ $details['prix'] * $details['quantite'] }} DT</td>
                                <td class="align-middle">
                                    <a href="{{ route('panier.supprimer', $id) }}" class="btn btn-danger btn-sm">Retirer</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Affichage du total et du bouton "Passer à la caisse" -->
            <div class="d-flex justify-content-between mt-4">
                <h3 class="text-primary">Total :
                    {{ array_sum(array_map(function($produit) {
                        return $produit['prix'] * $produit['quantite'];
                    }, session('panier'))) }} DT
                </h3>
            </div>

            <!-- Bouton Passer à la caisse -->
            <div class="text-center mt-4">
                <a href="{{ route('checkout') }}" class="btn btn-success">Passer à la caisse</a>
            </div>
        @else
            <div class="alert alert-warning text-center">
                <p>Votre panier est vide !</p>
            </div>
        @endif
    </div>
@endsection

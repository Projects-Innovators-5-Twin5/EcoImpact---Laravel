@extends('front.layout')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4" style="color: #FF6F20; font-weight: bold;">Votre Panier</h1>

        @if($commandes->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                Votre panier est vide.
            </div>
        @else
            <form action="{{ route('panier.update') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead class="thead-light" style="background-color: #FF6F20; color: white;">
                            <tr>
                                <th>Produit(s)</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                @foreach($commande->produits as $produit)
                                    <tr>
                                        <td>{{ $produit->nom }}</td>
                                        <td>
                                            <input type="number" name="quantites[{{ $produit->id }}]" value="{{ $produit->pivot->quantite }}" min="1" class="form-control text-center" style="width: 70px; display: inline;">
                                        </td>
                                        <td>{{ $produit->prix * $produit->pivot->quantite }} €</td> <!-- Total par produit -->
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-right">
                    <h5 style="color: #FF6F20; font-weight: bold;">Total Général : {{ $commandes->sum('total') }} €</h5> <!-- Total général -->
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-warning" style="background-color: #FF6F20; border: none;">Mettre à jour le panier</button>
                </div>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('checkout') }}" class="btn btn-success" style="background-color: #28a745; border: none;">Passer à la caisse</a>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('produits.index') }}" class="btn btn-warning" style="background-color: #FF6F20; border: none;">Retour à la liste des produits</a>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .table {
            border: 1px solid #FF6F20;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f9f9f9;
        }
        .table-striped tbody tr:hover {
            background-color: #ffe6cc;
        }
        .alert {
            font-weight: bold;
            font-size: 1.1em;
        }
        .btn-warning, .btn-success {
            background-color: #FF6F20;
            border: none;
        }
    </style>
@endsection

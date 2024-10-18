<script src="{{ asset('js/landing.js') }}"></script>

@extends('front.layout')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Votre panier</h1>

    @if(session('panier'))
        <form action="{{ route('commande.passer') }}" method="POST">
            @csrf
            <div class="row">
                @foreach(session('panier') as $id => $details)
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-3">
                                <img src="{{ asset('storage/' . $details['image']) }}" class="card-img" alt="{{ $details['nom'] }}" style="height: 150px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $details['nom'] }}</h5>
                                    <p>{{ $details['description'] ?? 'Aucune description disponible' }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="decrementQuantity({{ $id }}, {{ $details['prix'] }})">-</button>
                                            <input type="text" name="quantites[{{ $id }}]" id="quantite-{{ $id }}" value="{{ $details['quantite'] }}" class="form-control mx-2 text-center" style="width: 50px;" readonly>
                                            <button type="button" class="btn btn-secondary btn-sm" onclick="incrementQuantity({{ $id }}, {{ $details['prix'] }})">+</button>
                                        </div>
                                        <div>
                                            <p class="card-text"><strong>Prix: {{ $details['prix'] }} DT</strong></p>
                                            <p class="card-text"><strong>Total: <span id="total-{{ $id }}">{{ $details['prix'] * $details['quantite'] }}</span> DT</strong></p>
                                        </div>
                                        <a href="{{ route('panier.supprimer', $id) }}" class="btn btn-danger btn-sm">Retirer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between mt-4">
                <h3 class="text-primary">Total : <span id="total-price">
                    {{ array_sum(array_map(function($produit) {
                        return $produit['prix'] * $produit['quantite'];
                    }, session('panier'))) }}
                </span> DT</h3>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Enregistrer ma commande et payer</button>
            </div>
        </form>
    @else
        <div class="alert alert-warning text-center">
            <p>Votre panier est vide !</p>
        </div>
    @endif
</div>

<script>
    function incrementQuantity(id, price) {
        var quantityInput = document.getElementById('quantite-' + id);
        var quantity = parseInt(quantityInput.value);
        quantityInput.value = quantity + 1;
        updateTotal(id, price);
    }

    function decrementQuantity(id, price) {
        var quantityInput = document.getElementById('quantite-' + id);
        var quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
            updateTotal(id, price);
        }
    }

    function updateTotal(id, price) {
        var quantity = parseInt(document.getElementById('quantite-' + id).value);
        var totalElement = document.getElementById('total-' + id);
        totalElement.textContent = (price * quantity) + ' DT';
        updateTotalPrice();
    }

    function updateTotalPrice() {
        var totalPrice = 0;
        @foreach(session('panier') as $id => $details)
            var quantity = parseInt(document.getElementById('quantite-{{ $id }}').value);
            totalPrice += quantity * {{ $details['prix'] }};
        @endforeach
        document.getElementById('total-price').textContent = totalPrice + ' DT';
    }
</script>
@endsection

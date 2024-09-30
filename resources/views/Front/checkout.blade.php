@extends('front.layout')

@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://js.stripe.com/v3/"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container mt-5">
    <h1 class="text-center mb-4" style="color: #FF6F20; font-weight: bold;">Paiement</h1>

    <div class="col-md-6 mx-auto">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Détails de Paiement</h5>
            </div>
            <div class="card-body">
                <form id="payment-form">
                    <div class="form-group">
                        <label for="card-element">Informations de Carte</label>
                        <div id="card-element" class="form-control" style="padding: 10px; border: 1px solid #ced4da; border-radius: .25rem;"></div>
                        <small class="form-text text-muted">Nous acceptons les cartes de crédit et de débit.</small>
                    </div>
                    <button id="submit" class="btn btn-success btn-block" style="background-color: #28a745; border: none;">
                        Payer {{ $total }} DT
                    </button>
                    <div id="payment-result" class="mt-3 text-center"></div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        const form = document.getElementById('payment-form');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const { paymentIntent, error } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
                payment_method: {
                    card: cardElement,
                },
            });

            if (error) {
                console.error('Payment error:', error);
                document.getElementById('payment-result').innerText = error.message;
                document.getElementById('payment-result').className = 'text-danger';
                return;
            }

            console.log('Payment successful:', paymentIntent);
            document.getElementById('payment-result').innerText = 'Paiement réussi !';
            document.getElementById('payment-result').className = 'text-success';

            // Envoi des détails de la commande au serveur
            const produits = JSON.parse(sessionStorage.getItem('panier'));

            try {
                const response = await fetch('{{ route('commande.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        total: {{ $total }},
                        produits: produits,
                        statut: 'en attente' // Ajoutez ceci si ce champ est requis
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Erreur lors de l\'enregistrement de la commande.');
                }

                document.getElementById('payment-result').innerText = 'Commande enregistrée avec succès !';
                document.getElementById('payment-result').className = 'text-success';

            } catch (error) {
                console.error('Fetch error:', error);
                document.getElementById('payment-result').innerText = error.message;
                document.getElementById('payment-result').className = 'text-danger';
            }
        });
    });
</script>

@endsection

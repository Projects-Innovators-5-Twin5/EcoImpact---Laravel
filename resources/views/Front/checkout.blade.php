@extends('front.layout')

@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://js.stripe.com/v3/"></script>

<div class="container mt-5">
    <h1 class="text-center mb-4" style="color: #FF6F20; font-weight: bold;">Paiement</h1>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Détails de Paiement</h5>
        </div>
        <div class="card-body">
            <form id="payment-form">
                <div class="form-group">
                    <label for="name">Nom</label>
                    <input type="text" id="name" class="form-control" placeholder="Votre nom" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" class="form-control" placeholder="Votre email" required>
                </div>
                <div class="form-group">
                    <label for="card-element">Informations de carte</label>
                    <div id="card-element" class="form-control" style="padding: 10px; border: 1px solid #ced4da; border-radius: .25rem;"></div>
                </div>
                <button id="submit" class="btn btn-success btn-block" style="background-color: #28a745; border: none;">
                    Payer {{ $total }} €
                </button>
                <div id="payment-result" class="mt-3"></div>
            </form>
        </div>
    </div>
</div>

<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}'); // Votre clé publique Stripe
    const elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#card-element');

    const form = document.getElementById('payment-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { paymentIntent, error } = await stripe.confirmCardPayment('{{ $clientSecret }}', {
            payment_method: {
                card: cardElement,
                billing_details: {
                    name: document.getElementById('name').value,
                    email: document.getElementById('email').value,
                },
            },
        });

        if (error) {
            // Affichez l'erreur à l'utilisateur
            document.getElementById('payment-result').innerText = error.message;
        } else {
            // Le paiement a réussi, redirigez l'utilisateur ou affichez un message de succès
            document.getElementById('payment-result').innerText = 'Paiement réussi !';
        }
    });
</script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Checkout</h1>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <h3>Total: ${{ number_format($total, 2) }}</h3>

    <form id="payment-form" method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div id="card-element">
            <!-- Stripe Elements will insert a card input field here -->
        </div>
        <div id="card-errors" class="text-danger mt-2"></div>

        <button id="submit-pay" class="btn btn-primary mt-4">Pay ${{ number_format($total, 2) }}</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const stripe = Stripe('{{ env('STRIPE_KEY') }}'); // Ensure this is your correct Stripe publishable key
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        
        cardElement.mount('#card-element');
        
        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-pay');

        submitButton.disabled = true;
        
        form.addEventListener('submit', async function (event) {
            event.preventDefault();

            submitButton.disabled = true;

            // Create a token using the card element
            const {token, error} = await stripe.createToken(cardElement);
    
            try {
            // Create the Stripe token for the card
            const {token, error} = await stripe.createToken(cardElement);

            if (error) {
                // Display any errors in the card-errors div
                document.getElementById('card-errors').textContent = error.message;
                submitButton.disabled = false; // Re-enable button if there's an error
            } else {
                // Create a hidden input field for the token and append it to the form
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'stripeToken';
                hiddenInput.value = token.id;
                form.appendChild(hiddenInput);

                console.log(form, 'this is the form');
                // Submit the form after adding the token
                form.submit();
            }
        } catch (err) {
            // Catch any errors in the asynchronous process
            console.error('Error creating token: ', err);
            document.getElementById('card-errors').textContent = "An error occurred. Please try again.";
            submitButton.disabled = false; // Re-enable button in case of error
        }
        });
        cardElement.on('change', function (event) {
        if (event.complete) {
            submitButton.disabled = false; // Enable button if form is ready for submission
        }
    });

    });
</script>
@endsection

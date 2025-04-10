@extends('layouts.app')

@section('title', 'Paiement - CinéHall')

@section('content')
<div class="bg-gray-100 min-h-screen py-8">
    <div class="container mx-auto px-4">
        <!-- Reservation progress bar -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center text-green-600">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-600 text-white">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="ml-2 font-medium">Sélection des sièges</span>
                </div>
                <div class="flex-1 h-1 mx-4 bg-green-200">
                    <div class="h-1 bg-green-600" style="width: 100%"></div>
                </div>
                <div class="flex items-center text-indigo-600">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-indigo-600 text-white">
                        2
                    </div>
                    <span class="ml-2 font-medium">Paiement</span>
                </div>
                <div class="flex-1 h-1 mx-4 bg-gray-300">
                    <div class="h-1 bg-indigo-600" style="width: 0%"></div>
                </div>
                <div class="flex items-center text-gray-400">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300">
                        3
                    </div>
                    <span class="ml-2 font-medium">Confirmation</span>
                </div>
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Payment form section -->
            <div class="lg:w-2/3">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Informations de paiement</h2>
                    
                    <div id="payment-element">
                        <!-- Payment form -->
                        <form id="payment-form" class="space-y-6">
                            <!-- Card information -->
                            <div>
                                <label for="card-number" class="block text-sm font-medium text-gray-700 mb-1">Numéro de carte</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="far fa-credit-card text-gray-400"></i>
                                    </div>
                                    <input type="text" id="card-number" class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="4242 4242 4242 4242" maxlength="19">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <img src="https://cdn.jsdelivr.net/gh/thatanjan/MERN-job-tracking-app@0.0.16-b/client/public/favicon.ico" alt="Visa" class="h-6 w-8 object-contain">
                                    </div>
                                </div>
                                <div id="card-number-error" class="text-red-600 text-sm mt-1 hidden">
                                    Veuillez entrer un numéro de carte valide.
                                </div>
                            </div>
                            
                            <!-- Card holder -->
                            <div>
                                <label for="card-holder" class="block text-sm font-medium text-gray-700 mb-1">Nom du titulaire</label>
                                <input type="text" id="card-holder" class="block w-full py-3 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Prénom Nom">
                                <div id="card-holder-error" class="text-red-600 text-sm mt-1 hidden">
                                    Veuillez entrer le nom du titulaire de la carte.
                                </div>
                            </div>
                            
                            <div class="flex space-x-4">
                                <!-- Expiration date -->
                                <div class="w-1/2">
                                    <label for="card-expiry" class="block text-sm font-medium text-gray-700 mb-1">Date d'expiration</label>
                                    <input type="text" id="card-expiry" class="block w-full py-3 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="MM/AA" maxlength="5">
                                    <div id="card-expiry-error" class="text-red-600 text-sm mt-1 hidden">
                                        Veuillez entrer une date d'expiration valide.
                                    </div>
                                </div>
                                
                                <!-- CVC -->
                                <div class="w-1/2">
                                    <label for="card-cvc" class="block text-sm font-medium text-gray-700 mb-1">Code de sécurité (CVC)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="text" id="card-cvc" class="block w-full py-3 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="123" maxlength="3">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-question-circle text-gray-400"></i>
                                        </div>
                                    </div>
                                    <div id="card-cvc-error" class="text-red-600 text-sm mt-1 hidden">
                                        Veuillez entrer un code CVC valide.
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Billing address -->
                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Adresse de facturation</h3>
                                
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6">
                                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                                        <input type="text" id="address" class="block w-full py-3 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="postal-code" class="block text-sm font-medium text-gray-700 mb-1">Code postal</label>
                                        <input type="text" id="postal-code" class="block w-full py-3 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                    
                                    <div class="col-span-6 sm:col-span-4">
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville</label>
                                        <input type="text" id="city" class="block w-full py-3 px-4 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-6">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="save-card" name="save-card" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="save-card" class="font-medium text-gray-700">Sauvegarder cette carte pour mes prochains achats</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" id="submit-payment" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Payer {{ $reservation->total_price }} €
                                </button>
                            </div>
                            
                            <div class="flex items-center justify-center space-x-3 mt-4">
                                <i class="fas fa-lock text-gray-500"></i>
                                <span class="text-sm text-gray-500">Paiement sécurisé par Stripe</span>
                            </div>
                        </form>
                        
                        <!-- Payment processing state -->
                        <div id="payment-processing" class="hidden text-center py-10">
                            <div class="animate-spin inline-block w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full mb-4"></div>
                            <p class="text-lg font-medium text-gray-700">Traitement du paiement en cours...</p>
                            <p class="text-gray-600 mt-2">Veuillez ne pas fermer cette page.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('reservations.create', $reservation->showtime_id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Retourner à la sélection
                        </a>
                        
                        <div class="flex items-center">
                            <img src="https://cdn.jsdelivr.net/gh/thatanjan/MERN-job-tracking-app@0.0.16-b/client/public/favicon.ico" alt="Visa" class="h-8">
                            <img src="https://cdn.jsdelivr.net/gh/thatanjan/MERN-job-tracking-app@0.0.16-b/client/public/favicon.ico" alt="Mastercard" class="h-8 ml-2">
                            <img src="https://cdn.jsdelivr.net/gh/thatanjan/MERN-job-tracking-app@0.0.16-b/client/public/favicon.ico" alt="American Express" class="h-8 ml-2">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order summary section -->
            <div class="lg:w-1/3">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Résumé de la commande</h2>
                    
                    <div class="border-t border-gray-200 py-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Film:</span>
                            <span class="font-medium">{{ $reservation->showtime->movie->title }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Séance:</span>
                            <span class="font-medium">{{ \Carbon\Carbon::parse($reservation->showtime->start_time)->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Salle:</span>
                            <span class="font-medium">{{ $reservation->showtime->theater->name }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Type:</span>
                            <span class="font-medium">{{ $reservation->showtime->type }}</span>
                        </div>
                    </div>
                    
                    <!-- Selected seats section -->
                    <div class="border-t border-gray-200 py-4">
                        <h3 class="font-medium text-gray-800 mb-2">Places sélectionnées ({{ count($reservation->seats) }})</h3>
                        
                        <div class="space-y-1 pl-2">
                            @foreach($reservation->seats as $seat)
                                <div class="flex justify-between text-sm">
                                    <span>Rangée {{ $seat->row }}, Siège {{ $seat->number }} {{ $seat->type === 'Couple' ? '(Couple)' : '' }}</span>
                                    <span>
                                        @if($seat->type === 'Regular')
                                            {{ $reservation->showtime->type === 'VIP' ? '15,00 €' : '10,00 €' }}
                                        @else
                                            {{ $reservation->showtime->type === 'VIP' ? '25,00 €' : '18,00 €' }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Totals section -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Total:</span>
                            <span>{{ number_format($reservation->total_price, 2, ',', ' ') }} €</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">TVA incluse</p>
                    </div>
                    
                    <!-- Expiration notice -->
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Attention</h3>
                                <div class="text-sm text-yellow-700">
                                    <p>Votre réservation expirera dans <span id="expiry-timer" class="font-medium">10:00</span> minutes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format credit card number with spaces
    const cardNumberInput = document.getElementById('card-number');
    cardNumberInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s+/g, '');
        if (value.length > 0) {
            value = value.match(new RegExp('.{1,4}', 'g')).join(' ');
        }
        e.target.value = value;
    });
    
    // Format expiry date with slash
    const cardExpiryInput = document.getElementById('card-expiry');
    cardExpiryInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });
    
    // Only allow numbers for CVC
    const cardCvcInput = document.getElementById('card-cvc');
    cardCvcInput.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
    
    // Timer for reservation expiration (10 minutes)
    let timeLeft = 10 * 60; // 10 minutes in seconds
    const timerElement = document.getElementById('expiry-timer');
    
    function startTimer() {
        const timer = setInterval(function() {
            timeLeft--;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                // Redirect to reservations page with expiration message
                window.location.href = "{{ route('reservations.index') }}?expired=true";
            }
            
            // Format time as mm:ss
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Change color when time is running out
            if (timeLeft < 60) {
                timerElement.classList.add('text-red-600');
            }
        }, 1000);
    }
    
    // Start the timer
    startTimer();
    
    // Handle form submission
    const paymentForm = document.getElementById('payment-form');
    const paymentElement = document.getElementById('payment-element');
    const processingElement = document.getElementById('payment-processing');
    const submitButton = document.getElementById('submit-payment');
    
    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        let isValid = true;
        
        // Card number validation (simple check for length)
        const cardNumber = cardNumberInput.value.replace(/\s+/g, '');
        if (cardNumber.length !== 16) {
            document.getElementById('card-number-error').classList.remove('hidden');
            isValid = false;
        } else {
            document.getElementById('card-number-error').classList.add('hidden');
        }
        
        // Card holder validation
        if (document.getElementById('card-holder').value.trim() === '') {
            document.getElementById('card-holder-error').classList.remove('hidden');
            isValid = false;
        } else {
            document.getElementById('card-holder-error').classList.add('hidden');
        }
        
        // Expiry validation (simple MM/YY format)
        const expiry = cardExpiryInput.value;
        if (!/^\d{2}\/\d{2}$/.test(expiry)) {
            document.getElementById('card-expiry-error').classList.remove('hidden');
            isValid = false;
        } else {
            document.getElementById('card-expiry-error').classList.add('hidden');
        }
        
        // CVC validation
        if (cardCvcInput.value.length !== 3) {
            document.getElementById('card-cvc-error').classList.remove('hidden');
            isValid = false;
        } else {
            document.getElementById('card-cvc-error').classList.add('hidden');
        }
        
        if (isValid) {
            // Show processing state
            paymentForm.classList.add('hidden');
            processingElement.classList.remove('hidden');
            
            // Submit payment to server
            // Note: In a real application, you would use a payment gateway like Stripe
            submitPayment();
        }
    });
    
    function submitPayment() {
        // Simulate payment processing
        setTimeout(function() {
            // Send payment intent to server
            fetch('{{ route("payment.process") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    reservation_id: '{{ $reservation->id }}',
                    // In a real application, you would send tokenized card data
                    payment_method: 'card'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to confirmation page
                    window.location.href = `{{ route('reservations.show', $reservation->id) }}?status=paid`;
                } else {
                    // Show error message
                    alert('Une erreur est survenue lors du paiement. Veuillez réessayer.');
                    paymentForm.classList.remove('hidden');
                    processingElement.classList.add('hidden');
                }
            })
            .catch(error => {
                console.error('Payment error:', error);
                alert('Une erreur est survenue lors du paiement. Veuillez réessayer.');
                paymentForm.classList.remove('hidden');
                processingElement.classList.add('hidden');
            });
        }, 2000); // Simulate 2 second payment processing
    }
});
</script>
@endpush
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paystack Payment</title>
</head>
<body>
    <h2>Pay with Paystack</h2>

    <form id="paymentForm" onsubmit="event.preventDefault(); payWithPaystack();">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email-address" required />
        </div>
        <div>
            <label for="amount">Amount (NGN)</label>
            <input type="number" id="amount" required />
        </div>
        <div>
            <button type="submit">Pay</button>
        </div>
    </form>

    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        function payWithPaystack() {
            const handler = PaystackPop.setup({
                key: 'pk_live_63277ccf3a8eac8ccb7d287b7d93859da12198d7', // Replace with your public key
                email: document.getElementById('email-address').value,
                amount: document.getElementById('amount').value * 100, // Paystack works in kobo
                currency: 'NGN', // Currency
                callback: function(response) {
                    // Payment completed successfully
                    alert('Payment successful! Reference: ' + response.reference);
                    // Redirect to verify payment
                    window.location.href = 'verify_payment.php?reference=' + response.reference;
                },
                onClose: function() {
                    alert('Payment was not completed.');
                }
            });
            handler.openIframe(); // Open the Paystack payment modal
        }
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Razorpay Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>

<h1>Processing Payment...</h1>

<script>
    var options = {
        "key": "{{ $key }}",
        "amount": "{{ $amount }}",
        "currency": "{{ $currency }}",
        "name": "{{ $name }}",
        "description": "{{ $description }}",
        "order_id": "{{ $order_id }}",
        "handler": function (response){
            alert("Payment Successful! Payment ID: " + response.razorpay_payment_id);
            window.location.href = "{{ url('/payment-success') }}";
        },
        "prefill": {
            "name": "Test User",
            "email": "test@example.com"
        },
        "theme": {
            "color": "#528FF0"
        }
    };

    var rzp1 = new Razorpay(options);
    rzp1.open();
</script>

</body>
</html>

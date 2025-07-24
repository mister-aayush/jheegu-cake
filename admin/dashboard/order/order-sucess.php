<?php
$order_no = $_GET['order'] ?? '';
if (empty($order_no)) {
    header('Location: ../../frontend/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful - Jheegu Cake</title>
    <link rel="stylesheet" href="../src/output.css">
</head>
<body class="bg-pink-50 min-h-screen flex items-center justify-center px-4">
    
    <div class="bg-white w-full max-w-md p-8 rounded-lg shadow-md text-center">
        
        <!-- Success Icon -->
        <div class="mb-6">
            <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Success Message -->
        <h1 class="text-2xl font-bold text-green-600 mb-4">🎉 Order Placed Successfully!</h1>
        
        <p class="text-gray-600 mb-6">Thank you for your order! Your delicious cake is being prepared with love.</p>
        
        <!-- Order Details -->
        <div class="bg-pink-50 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold text-pink-700 mb-2">Order Details</h2>
            <p class="text-gray-700">
                <strong>Order Number:</strong><br>
                <span class="text-pink-600 font-mono text-lg"><?php echo htmlspecialchars($order_no); ?></span>
            </p>
        </div>

        <!-- Instructions -->
        <div class="text-sm text-gray-600 mb-6 text-left bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold mb-2">What's Next?</h3>
            <ul class="space-y-1">
                <li>• We'll call you within 30 minutes to confirm your order</li>
                <li>• Your cake will be prepared fresh on the delivery date</li>
                <li>• Keep your order number for reference</li>
                <li>• For any queries, call us at +977 9808823698</li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="../../frontend/index.php" 
               class="w-full inline-block bg-pink-600 text-white py-3 px-6 rounded-md hover:bg-pink-700 transition duration-200">
                Continue Shopping
            </a>
            
            <button onclick="window.print()" 
                    class="w-full bg-gray-200 text-gray-700 py-2 px-6 rounded-md hover:bg-gray-300 transition duration-200">
                Print Order Details
            </button>
        </div>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-500">
                <strong>Jheegu Cake</strong><br>
                Gurjudhara, Kathmandu<br>
                📞 +977 9808823698
            </p>
        </div>
    </div>

    <script>
        // Auto-redirect after 5 minutes (optional)
        setTimeout(function() {
            if (confirm('Would you like to return to the homepage?')) {
                window.location.href = '../../frontend/index.php';
            }
        }, 300000); // 5 minutes
    </script>

</body>
</html>
<?php
$is_LoggedIn = $_SESSION['is_loggedin'] ?? false;

if (!$is_LoggedIn) {
    header('Location: ../../auth/login.php ');
    exit();
}

$conn = mysqli_connect("localhost", "root", "", "jheegu-cake");

if($conn == false){
    echo "Connection Failed";
} 


// Handle status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_no = $_POST['order_no'];
    $new_status = $_POST['status'];
    
    $update_query = "UPDATE order_status SET status = ?, updated_at = NOW() WHERE order_no = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, 'ss', $new_status, $order_no);
    mysqli_stmt_execute($update_stmt);
    
    echo "<script>alert('Order status updated successfully!'); window.location.reload();</script>";
}

// Fetch all orders from order_status table
$query = "SELECT * FROM order_status ORDER BY created_at DESC";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$orders = [];

while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

// Fetch customer details for hover tooltip
$customer_query = "SELECT customer_no, full_name, location, contact, payment_method FROM customerdetails";
$customer_stmt = mysqli_prepare($conn, $customer_query);
mysqli_stmt_execute($customer_stmt);
$customer_result = mysqli_stmt_get_result($customer_stmt);
$customers = [];

while ($row = mysqli_fetch_assoc($customer_result)) {
    $customers[$row['customer_no']] = $row;
}
?>

<div class="bg-white p-4 sm:p-6 rounded-lg shadow-md">
    <h2 class="text-xl sm:text-2xl font-bold text-pink-700 mb-4 sm:mb-6">Order Management</h2>
    
    <?php if (empty($orders)): ?>
        <div class="text-center py-8">
            <p class="text-gray-500 text-lg">No orders found.</p>
        </div>
    <?php else: ?>
        <!-- Desktop Table -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-pink-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-pink-700 border-b">Order No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-pink-700 border-b">Customer</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-pink-700 border-b">Cake</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-pink-700 border-b">Pound</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-pink-700 border-b">Egg Option</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-pink-700 border-b">Delivery</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-pink-700 border-b">Message</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-pink-700 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-3 text-sm">
                                <span class="font-medium text-pink-600"><?php echo htmlspecialchars($order['order_no']); ?></span>
                                <br>
                                <span class="text-xs text-gray-500">
                                    <?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?>
                                </span>
                            </td>
                            
                            <td class="px-4 py-3 text-sm relative">
                                <div class="customer-hover cursor-pointer font-medium text-blue-600 hover:underline"
                                     data-order="<?php echo htmlspecialchars($order['order_no']); ?>">
                                    <?php echo htmlspecialchars($order['customer_name']); ?>
                                </div>
                                
                                <!-- Tooltip -->
                                <div class="customer-tooltip hidden absolute z-10 bg-gray-800 text-white p-3 rounded-lg shadow-lg left-0 top-full mt-1 w-64">
                                    <?php if (isset($customers[$order['order_no']])): ?>
                                        <div class="text-sm space-y-1">
                                            <div><strong>Name:</strong> <?php echo htmlspecialchars($customers[$order['order_no']]['full_name']); ?></div>
                                            <div><strong>Location:</strong> <?php echo htmlspecialchars($customers[$order['order_no']]['location']); ?></div>
                                            <div><strong>Contact:</strong> <?php echo htmlspecialchars($customers[$order['order_no']]['contact']); ?></div>
                                            <div><strong>Payment:</strong> <?php echo htmlspecialchars($customers[$order['order_no']]['payment_method']); ?></div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>
                            
                            <td class="px-4 py-3 text-sm font-medium"><?php echo htmlspecialchars($order['cake_name']); ?></td>
                            <td class="px-4 py-3 text-sm"><?php echo $order['pound']; ?> lb</td>
                            <td class="px-4 py-3 text-sm"><?php echo htmlspecialchars($order['egg_option']); ?></td>
                            <td class="px-4 py-3 text-sm">
                                <div class="font-medium">
                                    <?php echo date('M d, Y', strtotime($order['delivery_date'])); ?>
                                </div>
                                <div class="text-gray-500 text-xs">
                                    <?php echo date('H:i A', strtotime($order['delivery_date'])); ?>
                                </div>
                            </td>
                            
                            <td class="px-4 py-3 text-sm">
                                <?php if (!empty($order['cake_message'])): ?>
                                    <span class="text-blue-600 italic text-xs">"<?php echo htmlspecialchars($order['cake_message']); ?>"</span>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">No message</span>
                                <?php endif; ?>
                            </td>
                            
                            <td class="px-4 py-3 text-sm">
                                <form method="POST" class="inline-block">
                                    <input type="hidden" name="order_no" value="<?php echo htmlspecialchars($order['order_no']); ?>">
                                    <select name="status" class="text-xs border rounded px-2 py-1 bg-white
                                        <?php 
                                        echo $order['status'] === 'done' ? 'text-green-700 border-green-300' : 
                                             ($order['status'] === 'pending' ? 'text-yellow-700 border-yellow-300' : 'text-blue-700 border-blue-300');
                                        ?>" 
                                        onchange="this.form.submit()">
                                        <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                        <option value="done" <?php echo $order['status'] === 'done' ? 'selected' : ''; ?>>Done</option>
                                        <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                    </select>
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Cards -->
        <div class="lg:hidden space-y-4">
            <?php foreach ($orders as $order): ?>
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="font-medium text-pink-600 text-sm"><?php echo htmlspecialchars($order['order_no']); ?></span>
                            <br>
                            <span class="text-xs text-gray-500">
                                <?php echo date('M d, Y H:i', strtotime($order['created_at'])); ?>
                            </span>
                        </div>
                        
                        <form method="POST" class="inline-block">
                            <input type="hidden" name="order_no" value="<?php echo htmlspecialchars($order['order_no']); ?>">
                            <select name="status" class="text-xs border rounded px-2 py-1 bg-white
                                <?php 
                                echo $order['status'] === 'done' ? 'text-green-700 border-green-300' : 
                                     ($order['status'] === 'pending' ? 'text-yellow-700 border-yellow-300' : 'text-blue-700 border-blue-300');
                                ?>" 
                                onchange="this.form.submit()">
                                <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
                                <option value="done" <?php echo $order['status'] === 'done' ? 'selected' : ''; ?>>Done</option>
                                <option value="cancelled" <?php echo $order['status'] === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <input type="hidden" name="update_status" value="1">
                        </form>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="font-medium">Customer:</span>
                            <span class="customer-hover cursor-pointer text-blue-600 hover:underline"
                                  data-order="<?php echo htmlspecialchars($order['order_no']); ?>">
                                <?php echo htmlspecialchars($order['customer_name']); ?>
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium">Cake:</span>
                            <span><?php echo htmlspecialchars($order['cake_name']); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium">Size:</span>
                            <span><?php echo $order['pound']; ?> lb - <?php echo htmlspecialchars($order['egg_option']); ?></span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="font-medium">Delivery:</span>
                            <span><?php echo date('M d, Y H:i A', strtotime($order['delivery_date'])); ?></span>
                        </div>
                        
                        <?php if (!empty($order['cake_message'])): ?>
                            <div class="flex justify-between">
                                <span class="font-medium">Message:</span>
                                <span class="text-blue-600 italic text-xs">"<?php echo htmlspecialchars($order['cake_message']); ?>"</span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Mobile Tooltip -->
                    <div class="customer-tooltip hidden mt-3 p-3 bg-gray-100 rounded-lg border">
                        <?php if (isset($customers[$order['order_no']])): ?>
                            <div class="text-sm space-y-1">
                                <div><strong>Name:</strong> <?php echo htmlspecialchars($customers[$order['order_no']]['full_name']); ?></div>
                                <div><strong>Location:</strong> <?php echo htmlspecialchars($customers[$order['order_no']]['location']); ?></div>
                                <div><strong>Contact:</strong> <?php echo htmlspecialchars($customers[$order['order_no']]['contact']); ?></div>
                                <div><strong>Payment:</strong> <?php echo htmlspecialchars($customers[$order['order_no']]['payment_method']); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Summary Stats -->
        <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php
            $total_orders = count($orders);
            $pending_orders = count(array_filter($orders, function($order) { return $order['status'] === 'pending'; }));
            $done_orders = count(array_filter($orders, function($order) { return $order['status'] === 'done'; }));
            $processing_orders = count(array_filter($orders, function($order) { return $order['status'] === 'processing'; }));
            ?>
            
            <div class="bg-blue-50 p-3 sm:p-4 rounded-lg text-center">
                <div class="text-xl sm:text-2xl font-bold text-blue-600"><?php echo $total_orders; ?></div>
                <div class="text-xs sm:text-sm text-blue-600">Total Orders</div>
            </div>
            
            <div class="bg-yellow-50 p-3 sm:p-4 rounded-lg text-center">
                <div class="text-xl sm:text-2xl font-bold text-yellow-600"><?php echo $pending_orders; ?></div>
                <div class="text-xs sm:text-sm text-yellow-600">Pending</div>
            </div>
            
            <div class="bg-blue-50 p-3 sm:p-4 rounded-lg text-center">
                <div class="text-xl sm:text-2xl font-bold text-blue-600"><?php echo $processing_orders; ?></div>
                <div class="text-xs sm:text-sm text-blue-600">Processing</div>
            </div>
            
            <div class="bg-green-50 p-3 sm:p-4 rounded-lg text-center">
                <div class="text-xl sm:text-2xl font-bold text-green-600"><?php echo $done_orders; ?></div>
                <div class="text-xs sm:text-sm text-green-600">Done</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
// Customer hover tooltip functionality
document.addEventListener('DOMContentLoaded', function() {
    const customerHovers = document.querySelectorAll('.customer-hover');
    
    customerHovers.forEach(hover => {
        const tooltip = hover.parentElement.querySelector('.customer-tooltip') || 
                       hover.closest('.bg-white').querySelector('.customer-tooltip');
        
        if (tooltip) {
            hover.addEventListener('mouseenter', function() {
                tooltip.classList.remove('hidden');
            });
            
            hover.addEventListener('mouseleave', function() {
                tooltip.classList.add('hidden');
            });
            
            // For mobile - toggle on click
            hover.addEventListener('click', function(e) {
                e.preventDefault();
                tooltip.classList.toggle('hidden');
            });
        }
    });
    
    // Hide tooltips when clicking elsewhere
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.customer-hover')) {
            document.querySelectorAll('.customer-tooltip').forEach(tooltip => {
                tooltip.classList.add('hidden');
            });
        }
    });
});
</script>
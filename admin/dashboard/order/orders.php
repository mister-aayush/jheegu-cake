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
    
    $update_query = "UPDATE order_status SET status = ? WHERE order_no = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, 'ss', $new_status, $order_no);
    mysqli_stmt_execute($update_stmt);
    
    echo "<script>alert('Order status updated successfully!'); window.location.reload();</script>";
}

// Fetch all orders from order_status table - removed ORDER BY created_at since column doesn't exist
$query = "SELECT * FROM order_status ORDER BY order_no DESC";
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
    
    <?php if (isset($_GET['success']) && $_GET['success'] == '1'): ?>
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-md">
            <p class="text-sm">Order status updated successfully!</p>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['bulk_deleted'])): ?>
        <div class="mb-4 p-3 bg-blue-100 border border-blue-400 text-blue-700 rounded-md">
            <p class="text-sm"><?php echo $_GET['bulk_deleted']; ?> completed orders deleted successfully!</p>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-md">
            <p class="text-sm"><?php echo htmlspecialchars($error_message); ?></p>
        </div>
    <?php endif; ?>
    
    <?php if (empty($orders)): ?>
        <div class="text-center py-8">
            <p class="text-gray-500 text-lg">No orders found.</p>
        </div>
    <?php else: ?>
        <!-- Desktop Table -->
        <div class="overflow-x-auto">
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
                                <form method="POST" class="inline-block" onsubmit="return confirmStatusChange(this)">
                                    <input type="hidden" name="order_no" value="<?php echo htmlspecialchars($order['order_no']); ?>">
                                    <select name="status" class="text-xs border rounded px-2 py-1 bg-white
                                        <?php 
                                        echo $order['status'] === 'done' ? 'text-green-700 border-green-300' : 
                                             ($order['status'] === 'pending' ? 'text-yellow-700 border-yellow-300' : 
                                             ($order['status'] === 'cancelled' ? 'text-red-700 border-red-300' : 'text-blue-700 border-blue-300'));
                                        ?>" 
                                        onchange="this.form.submit()" data-original="<?php echo $order['status']; ?>">
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
                    
                    <!-- Totals Row -->
                    <?php
                    $total_orders = count($orders);
                    $pending_orders = count(array_filter($orders, function($order) { return $order['status'] === 'pending'; }));
                    $processing_orders = count(array_filter($orders, function($order) { return $order['status'] === 'processing'; }));
                    $done_orders = count(array_filter($orders, function($order) { return $order['status'] === 'done'; }));
                    $cancelled_orders = count(array_filter($orders, function($order) { return $order['status'] === 'cancelled'; }));
                    ?>
                    <tr class="bg-pink-50 border-t-2 border-pink-200 font-semibold">
                        <td class="px-4 py-3 text-sm font-bold text-pink-800">TOTALS</td>
                        <td class="px-4 py-3 text-sm text-blue-600"><?php echo $total_orders; ?> Total</td>
                        <td class="px-4 py-3 text-sm text-gray-600">-</td>
                        <td class="px-4 py-3 text-sm text-gray-600">-</td>
                        <td class="px-4 py-3 text-sm text-gray-600">-</td>
                        <td class="px-4 py-3 text-sm text-gray-600">-</td>
                        <td class="px-4 py-3 text-sm text-gray-600">-</td>
                        <td class="px-4 py-3 text-sm">
                            <div class="flex flex-wrap gap-1 text-xs">
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded"><?php echo $pending_orders; ?> Pending</span>
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded"><?php echo $processing_orders; ?> Processing</span>
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded"><?php echo $done_orders; ?> Done</span>
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded"><?php echo $cancelled_orders; ?> Cancelled</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    
    <?php endif; ?>
</div>

<script>
// Confirmation function for status changes
function confirmStatusChange(form) {
    const select = form.querySelector('select[name="status"]');
    const newStatus = select.value;
    const originalStatus = select.getAttribute('data-original');
    
    if (newStatus === 'cancelled' && originalStatus !== 'cancelled') {
        return confirm('Are you sure you want to cancel this order? This action should be carefully considered.');
    }
    
    if (newStatus === 'done' && originalStatus !== 'done') {
        return confirm('Mark this order as completed?');
    }
    
    return true;
}

// Confirmation function for order deletion
function confirmDelete(form) {
    const orderNo = form.querySelector('input[name="order_no"]').value;
    return confirm(`Are you sure you want to permanently delete order ${orderNo}?\n\nThis will remove the order from all tables and cannot be undone!`);
}

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
    
    // Auto-hide success messages after 3 seconds
    const successMessages = document.querySelectorAll('.bg-green-100, .bg-blue-100');
    successMessages.forEach(message => {
        setTimeout(function() {
            message.style.transition = 'opacity 0.5s';
            message.style.opacity = '0';
            setTimeout(function() {
                message.remove();
            }, 500);
        }, 3000);
    });
});
</script>
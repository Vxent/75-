<?php
session_start(); // Start the session

include 'db_connection.php'; // Database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: index.php'); // Redirect to homepage
    exit();
}

// Fetch customization orders with user names
$query = "
    SELECT co.*, u.username 
    FROM customization_orders co
    JOIN users u ON co.user_id = u.id
    LIMIT 10"; // Adjust LIMIT based on your needs
$result = $db->query($query);

// Begin HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kween P Sports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="images/headlogo.png" type="image/x-icon">
    <!-- Other styles and links -->
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Karla:400,700&display=swap');
    .font-family-karla { font-family: karla; }
    .bg-sidebar { background: orange; }
    .cta-btn { color: black; }
    .upgrade-btn { background: black; }
    .upgrade-btn:hover { background: black; }
    .active-nav-link { background: grey; }
    .nav-item:hover { background: grey; }
</style>

<body class="bg-gray-100 font-family-karla flex">

<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-6">
        <img src="images/logo1.png" alt="">
    </div>
    <nav class="text-white text-base font-semibold pt-3">
        <a href="adminDashboard.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>
        <a href="userOrder.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fas fa-sticky-note mr-3"></i>
            User Orders
        </a>
        <a href="myProducts.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fas fa-table mr-3"></i>
            My Products
        </a>
        <a href="customizationOrder.php" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
            <i class="fa-solid fa-shirt mr-2"></i>
            Customized Order
        </a>
        <a href="adminChangePassword.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-4 pl-6 nav-item">
            <i class="fa fa-cog mr-3"></i> 
            Change Password
        </a>
    </nav>
</aside>
<div class="relative w-full flex flex-col h-screen overflow-y-hidden">
    <!-- Desktop Header -->
    <header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
        <div class="w-1/2"></div>
        <div x-data="{ isOpen: false }" class="relative w-1/2 flex justify-end">
            <button @click="isOpen = !isOpen" class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-4 border-gray-400 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
                <img src="https://tse1.mm.bing.net/th?id=OIP.V0NH3fa-mZ4AJ94SEQTy_wHaHa&pid=Api&P=0&h=220">
            </button>
            <button x-show="isOpen" @click="isOpen = false" class="h-full w-full fixed inset-0 cursor-default"></button>
            <div x-show="isOpen" class="absolute w-32 bg-white rounded-lg shadow-lg py-2 mt-16">
                <a href="logout.php" class="block px-4 py-2 account-link hover:text-white">Log out</a>
            </div>
        </div>
    </header>

    <!-- Mobile Header & Nav -->
    <header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
        <div class="flex items-center justify-between">
            <img src="images/logo1.png" alt="" class="text-center">
            <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
                <i x-show="!isOpen" class="fas fa-bars"></i>
                <i x-show="isOpen" class="fas fa-times"></i>
            </button>
        </div>

        <!-- Dropdown Nav -->
        <nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
            <a href="adminDashboard.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fas fa-tachometer-alt mr-3"></i>
                Dashboard
            </a>
            <a href="userOrder.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fas fa-sticky-note mr-3"></i>
                User Orders
            </a>
            <a href="myProducts.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fas fa-table mr-3"></i>
                My Products
            </a>
            <a href="customizationOrder.php" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
                <i class="fa-solid fa-shirt mr-2"></i>
                Customized Order
            </a>
            <a href="adminChangePassword.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fa fa-cog mr-3"></i>
               Change Password
            </a>
            <a href="logout.php" class="flex items-center text-white opacity-75 hover:opacity-100 py-2 pl-4 nav-item">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Log Out
            </a>
        </nav>
    </header>

    <div class="container mx-auto p-3 ">
        <div class="text-center p-5"><h1 class="text-4xl font-bold mb-4">Customization Orders</h1></div>

        <?php
        if ($result->num_rows > 0) {
            echo "<table class='min-w-full bg-white border border-gray-800'>";
            // Table header
            echo "<thead><tr class='bg-gray-800 text-white'>";
            echo "<th class='py-2 px-4 border-b'>ID</th>";
            echo "<th class='py-2 px-4 border-b'>Username</th>"; // Changed to Username
            echo "<th class='py-2 px-4 border-b'>Product Name</th>";
            echo "<th class='py-2 px-4 border-b'>Size</th>";
            echo "<th class='py-2 px-4 border-b'>Front Text</th>";
            echo "<th class='py-2 px-4 border-b'>Back Text</th>";
            echo "<th class='py-2 px-4 border-b'>File Path</th>";
            echo "<th class='py-2 px-4 border-b'>Order Date</th>";
            echo "<th class='py-2 px-4 border-b'>Status</th>";
            echo "<th class='py-2 px-4 border-b'>Action</th>"; // New column for action
            echo "</tr></thead>";
            
            // Table body
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr class='hover:bg-gray-100'>";
                echo "<td class='border-b px-4 py-2'>{$row['id']}</td>";
                echo "<td class='border-b px-4 py-2'>" . htmlspecialchars($row['username']) . "</td>"; // Display Username
                echo "<td class='border-b px-4 py-2'>{$row['product_name']}</td>";
                echo "<td class='border-b px-4 py-2'>{$row['size']}</td>";
                echo "<td class='border-b px-4 py-2'>" . htmlspecialchars($row['front_text']) . "</td>";
                echo "<td class='border-b px-4 py-2'>" . htmlspecialchars($row['back_text']) . "</td>";
                echo "<td class='border-b px-4 py-2'>" . htmlspecialchars($row['file_path']) . "</td>";
                echo "<td class='border-b px-4 py-2'>{$row['order_date']}</td>";

                
                // Add status dropdown
                echo "<td class='border-b px-4 py-2'>
                        <form action='updateCustomizationOrderStatus.php' method='POST' class='inline'>
                            <input type='hidden' name='order_id' value='{$row['id']}'>
                            <select name='status' class='border rounded p-1' onchange='this.form.submit()'>";
                
                // Status options
                $statuses = ['Pending', 'Processing', 'Delivery', 'Completed', 'Cancelled'];
                foreach ($statuses as $status) {
                    $selected = ($status === $row['status']) ? 'selected' : '';
                    echo "<option value='$status' $selected>$status</option>";
                }

                echo "      </select>
                        </form>
                      </td>";
                
                // Add a download link
                echo "<td class='border-b px-4 py-2'>
                        <a href='" . htmlspecialchars($row['file_path']) . "' download class='text-blue-500 hover:underline'>Download</a>
                      </td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p class='text-gray-700'>No customization orders found.</p>";
        }

        $db->close(); // Close the database connection
        ?>
    </div>

</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- AlpineJS -->
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@2.x.x/dist/alpine.min.js" defer></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>

</body>
</html>

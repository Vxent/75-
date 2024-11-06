<?php
session_start();
include 'db_connection.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$username = null; // Initialize the username variable

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $query = "SELECT username FROM users WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kween P Sports</title>
    <!-- tailwind css cdn -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="images/headlogo.png"  type="image/x-icon">
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Red+Hat+Display:wght@500;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Dots&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<style>
    h1 {
        font-family: 'Zen Dots', cursive;
    }

    .drop {
        font-family: 'Zen Dots', cursive;
    }

    .your {
        font-family: 'Zen Dots', cursive;
    }
    h2 {
        font-family: 'Zen Dots', cursive;
    }

</style>

<body>

<nav class="bg-black shadow-md top-0 left-0 w-full z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-2">
            <div class="flex-1 flex justify-start">
                <div class="hidden md:flex space-x-4 p-2">

                    <a href="#Main" class="font-abhaya-libre uppercase text-white tracking-wider px-4 xl:px-8 py-2 text-lg hover:underline">Home</a>
                    <a href="#about" class="text-gray-700 px-2 py-1 font-abhaya-libre uppercase text-white tracking-wider px-4 xl:px-8 py-2 text-lg hover:underline">About</a>
                    <a href="#services" class="text-gray-700 px-2 py-1 font-abhaya-libre uppercase text-white tracking-wider px-4 xl:px-8 py-2 text-lg hover:underline">Services</a>
                 
                 
                 
                </div>
            </div>
            <div class="flex-1 flex justify-center">
                <div class="text-center">
                    <img src="images/logo1.png" alt="Ricehub Logo" width="200px" class="h-20">
                </div>
            </div>
            <div class="flex-1 flex justify-end">
                <div class="hidden md:flex space-x-4 p-2">
                <a href="apparelShop.php" class="text-gray-700 px-2 py-1 font-abhaya-libre uppercase text-white tracking-wider px-4 xl:px-8 py-2 text-lg hover:underline">SHOP</a>
                
                    <a href="order_history.php" class="text-gray-700 px-2 py-1 font-abhaya-libre uppercase text-white tracking-wider px-4 xl:px-8 py-2 text-sm hover:underline">Order History</a>
                    <?php if ($isLoggedIn): ?>
                        <form action="logout.php" method="POST" style="display:inline;">
                            <button type="submit" class="border-2 border-white bg-black text-white py-2 px-4 rounded">Logout</button>
                        </form>
                    <?php else: ?>
                        <a href="login.php" class="border-2 border-white bg-black text-white py-3 px-4 rounded">Login</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Hamburger Icon for Mobile View -->
            <div class="md:hidden flex items-center">
                <button id="navbar-toggle" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="navbar-menu" class="navbar-menu md:hidden hidden">
            <a href="#Main" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Home</a>
           
            <a href="#about" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">About</a>
            <a href="#contacts" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Contacts</a>
            <a href="order_history.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Order History</a>
            <?php if ($isLoggedIn): ?>
                <form action="logout.php" method="POST" style="display:inline;">
                    <button type="submit" class="block font-bold bg-orange-400 text-white py-2 px-6 rounded hover:bg-orange-300 transition">Logout</button>
                </form>
            <?php else: ?>
                <a href="login.php" class="block font-bold bg-orange-400 text-white py-2 px-6 rounded hover:bg-orange-300 transition">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<!-- JavaScript for Toggling Navbar -->
<script>
    document.getElementById('navbar-toggle').addEventListener('click', function() {
        var menu = document.getElementById('navbar-menu');
        menu.classList.toggle('hidden'); // Toggles the hidden class
    });
</script>

<!-- Success Message -->
<?php if (isset($_SESSION['register_success'])): ?>
    <div class="bg-green-500 text-white p-4 text-center">
        <p><?php echo $_SESSION['register_success']; ?></p>
        <?php unset($_SESSION['register_success']); ?>
    </div>
<?php endif; ?>



    <!-- 3D Section or Headers -->
    <section id="home" class="bg-cover bg-no-repeat" style="background-image: url(images/bg.png);">
    <div class="max-w-7xl h-full mx-auto px-4 py-20 md:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Text Section -->
            <div class="text-center lg:text-left">
                <h1 class="text-3xl md:text-4xl lg:text-3xl text-white pb-5">
                    WELCOME TO KWEEN P, <span class="text-yellow-500">
        <?php echo isset($username) && $username ? htmlspecialchars($username) : 'Guest'; ?>
    </span>
                </h1>
                <main class="container">
                    <h2 class="text-4xl md:text-5xl lg:text-6xl text-white">Customize Your:</h2>
                    <div class="animation pt-4">
                        <div class="first text-yellow-500 text-3xl md:text-4xl">
                            <div>APPAREL</div>
                        </div>
                        <div class="second text-yellow-500 text-3xl md:text-4xl">
                            <div>STYLE</div>
                        </div>
                        <div class="third text-yellow-500 text-3xl md:text-4xl">
                            <div>LOOK</div>
                        </div>
                    </div>
                    <div class="pt-14">
                        <a href="customization.php" class="inline-block bg-black text-white py-2 px-4 rounded hover:bg-orange-300 transition">
                            3D Customization &rarr;
                        </a>
                    </div>
                </main>
            </div>

            <!-- Image Section -->
            <div class="flex justify-center lg:justify-end">
                <img src="images/header.gif" alt="Sportswear" class="w-full h-96 object-cover md:h-80 lg:h-full">
            </div>
        </div>
    </div>
</section>


  <!-- Quality Section -->
<section class="bg-black px-4 py-10">
    <div class="container mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 text-center shadow-lg pb-2">
            <div class="transform transition-transform hover:scale-105">
                <div class="flex justify-center mb-4">
                    <div>
                        <i class="fas fa-check fa-2x"></i>
                    </div>
                </div>
                <h2 class="text-2xl mb-2">Quality Measure</h2>
                <p class="text-2xl font-bold">100%</p><br>
            </div>
            <div class="transform transition-transform hover:scale-105">
                <div class="flex justify-center mb-4">
                    <div>
                        <i class="fas fa-heart fa-2x"></i>
                    </div>
                </div>
                <h2 class="text-2xl mb-2">Product Quality</h2>
                <p class="text-2xl font-bold">100%</p>
            </div>
            <div class="transform transition-transform hover:scale-105">
                <div class="flex justify-center mb-4">
                    <div>
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                </div>
                <h2 class="text-2xl mb-2">Excellent Service</h2>
                <p class="text-2xl font-bold">100%</p>
            </div>
        </div>
    </div>
</section>

    <!-- Size Guide -->      

    <div class="flex flex-col sm:flex-row mx-auto bg-white shadow-lg rounded-lg p-5 bg-black" style="background-image: url">
    <div class="w-full sm:w-1/2 p-4 ">
    <h3 class="text-4xl font-bold text-center text-gray-800 mb-4">SIZE GUIDE CHART</h3>
        <img src="images/sizeshirt.png" alt="Description" class="w-full h-auto rounded-lg">
    </div>
    <div class="w-full sm:w-1/2 p-4">

        <table class="min-w-full border-collapse text-orange-600 font-bold bg-white">
            <thead>
                <tr class="bg-black">
                    <th class="border px-4 py-6 text-white">Size</th>
                    <th class="border px-4 py-6 text-white">Chest Width (inches)</th>
                    <th class="border px-4 py-6 text-white">Height (inches)</th>
                    <th class="border px-4 py-6 text-white">Sleeve Length (inches)</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-100">
                    <td class="border px-4 py-6 text-center">S</td>
                    <td class="border px-4 py-6 text-center">34-36</td>
                    <td class="border px-4 py-6 text-center">5'2" - 5'6"</td>
                    <td class="border px-4 py-6 text-center">32</td>
                </tr>
                <tr class="border-b hover:bg-gray-100">
                    <td class="border px-4 py-6 text-center">M</td>
                    <td class="border px-4 py-6 text-center">38-40</td>
                    <td class="border px-4 py-6 text-center">5'6" - 5'10"</td>
                    <td class="border px-4 py-6 text-center">33</td>
                </tr>
                <tr class="border-b hover:bg-gray-100">
                    <td class="border px-4 py-6 text-center">L</td>
                    <td class="border px-4 py-6 text-center">42-44</td>
                    <td class="border px-4 py-6 text-center">5'10" - 6'0"</td>
                    <td class="border px-4 py-6 text-center">34</td>
                </tr>
                <tr class="border-b hover:bg-gray-100">
                    <td class="border px-4 py-6 text-center">XL</td>
                    <td class="border px-4 py-6 text-center">46-48</td>
                    <td class="border px-4 py-6 text-center">6'0" - 6'2"</td>
                    <td class="border px-4 py-6 text-center">35</td>
                </tr>
                <tr class="border-b hover:bg-gray-100">
                    <td class="border px-4 py-6 text-center">XXL</td>
                    <td class="border px-4 py-6 text-center">50-52</td>
                    <td class="border px-4 py-6 text-center">6'2" - 6'4"</td>
                    <td class="border px-4 py-6 text-center">36</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    <!-- SHOP -->
    <section id="shop">
        <div class="py-16 bg-white">
            <div class="container m-auto px-6 text-gray-600 md:px-12 xl:px-6">
                <div class="space-y-6 md:space-y-0 md:flex md:gap-6 lg:items-center lg:gap-12">
                    <div class="md:5/12 lg:w-5/12">
                        <img src="https://img.ws.mms.shopee.ph/9d19fa579abc8ce4be3d0d24fba33a1f" alt="image" loading="lazy" width="" height="">
                    </div>
                    <div class="md:7/12 lg:w-6/12">
                        <h2 class="text-2xl text-gray-900 font-bold md:text-4xl">Nuxt development is carried out by passionate developers</h2>
                        <p class="mt-6 text-gray-600 pb-5">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Eum omnis voluptatem accusantium nemo perspiciatis delectus atque autem! Voluptatum tenetur beatae unde aperiam, repellat expedita consequatur! Officiis id consequatur atque doloremque!</p>
                          <a href="apparelShop.php" class="inline-block bg-black text-white py-2 px-4 rounded hover:bg-orange-300 transition">SHOP NOW</a>
                    </div>
                </div>
                <div class="pt-14">
                 
                </div>
            </div>
        </div>
    </section>
    <!-- component -->
<div id="services" class="section relative pt-20 pb-8 md:pt-16 md:pb-0 bg-white ">
    <div class="container xl:max-w-6xl mx-auto px-4">
        <!-- Heading start -->
        <header class="text-center mx-auto mb-12 lg:px-20">
            <h2 class="text-2xl leading-normal mb-2 font-bold text-black">Services</h2>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 60" style="margin: 0 auto;height: 35px;" xml:space="preserve">
                <circle cx="50.1" cy="30.4" r="5" class="stroke-primary" style="fill: transparent;stroke-width: 2;stroke-miterlimit: 10;"></circle>
                <line x1="55.1" y1="30.4" x2="100" y2="30.4" class="stroke-primary" style="stroke-width: 2;stroke-miterlimit: 10;"></line>
                <line x1="45.1" y1="30.4" x2="0" y2="30.4" class="stroke-primary" style="stroke-width: 2;stroke-miterlimit: 10;"></line>
            </svg>
            <p class="text-gray-500 leading-relaxed font-light text-xl mx-auto pb-2">Save time managing advertising &amp; Content for your business.</p>
        </header>
        <!-- End heading -->
        <!-- row -->
        <div class="flex flex-wrap flex-row -mx-4 text-center">
            <div class="flex-shrink px-4 max-w-full w-full sm:w-1/2 lg:w-1/3 lg:px-6 wow fadeInUp" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeInUp;">
                <!-- service block -->
                <div class="py-8 px-12 mb-12 bg-gray-50 border-b border-gray-100 transform transition duration-300 ease-in-out hover:-translate-y-2">
                    <div class="inline-block text-gray-900 mb-4">
                        <!-- icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-normal mb-2 font-semibold text-black">SEO Services</h3>
                    <p class="text-gray-500">This is a wider card with supporting text below as a natural content.</p>
                </div>
                <!-- end service block -->
            </div>
            <div class="flex-shrink px-4 max-w-full w-full sm:w-1/2 lg:w-1/3 lg:px-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".1s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: fadeInUp;">
                <!-- service block -->
                <div class="py-8 px-12 mb-12 bg-gray-50 border-b border-gray-100 transform transition duration-300 ease-in-out hover:-translate-y-2">
                    <div class="inline-block text-gray-900 mb-4">
                        <!-- icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" class="bi bi-chat-square-dots" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                            <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-normal mb-2 font-semibold text-black">Social Content</h3>
                    <p class="text-gray-500">This is a wider card with supporting text below as a natural content.</p>
                </div>
                <!-- end service block -->
            </div>
            <div class="flex-shrink px-4 max-w-full w-full sm:w-1/2 lg:w-1/3 lg:px-6 wow fadeInUp" data-wow-duration="1s" data-wow-delay=".3s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.3s; animation-name: fadeInUp;">
                <!-- service block -->
                <div class="py-8 px-12 mb-12 bg-gray-50 border-b border-gray-100 transform transition duration-300 ease-in-out hover:-translate-y-2">
                    <div class="inline-block text-gray-900 mb-4">
                        <!-- icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" class="bi bi-badge-ad" viewBox="0 0 16 16">
                            <path d="M3.7 11l.47-1.542h2.004L6.644 11h1.261L5.901 5.001H4.513L2.5 11h1.2zm1.503-4.852l.734 2.426H4.416l.734-2.426h.053zm4.759.128c-1.059 0-1.753.765-1.753 2.043v.695c0 1.279.685 2.043 1.74 2.043.677 0 1.222-.33 1.367-.804h.057V11h1.138V4.685h-1.16v2.36h-.053c-.18-.475-.68-.77-1.336-.77zm.387.923c.58 0 1.002.44 1.002 1.138v.602c0 .76-.396 1.2-.984 1.2-.598 0-.972-.449-.972-1.248v-.453c0-.795.37-1.24.954-1.24z"></path>
                            <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-normal mb-2 font-semibold text-black">Creative ads</h3>
                    <p class="text-gray-500">This is a wider card with supporting text below as a natural content.</p>
                </div>
                <!-- end service block -->

                <!-- end service block -->
            </div>
        </div>
        <!-- end row -->
    </div>
</div>

    <!-- ABOUT US -->
     <!-- component -->


    <!-- Footer Section -->
    <footer class="bg-black text-white p-8">
    <div class="container mx-auto">
        <div class="flex justify-between">
            <div>
                <h2 class="text-lg font-bold">Services</h2>
                <ul>
                    <li><a href="#" class="hover:underline">Web Development</a></li>
                    <li><a href="#" class="hover:underline">Graphic Design</a></li>
                    <li><a href="#" class="hover:underline">SEO Services</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-lg font-bold">Contact</h2>
                <p>Email: <a href="mailto:info@example.com" class="hover:underline">info@example.com</a></p>
            </div>
            <div>
                <h2 class="text-lg font-bold">Follow Us</h2>
                <div class="flex space-x-4">
                    <a href="https://facebook.com" target="_blank" class="hover:text-blue-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35C.6 0 0 .6 0 1.325v21.35C0 23.4.6 24 1.325 24h21.35C23.4 24 24 23.4 24 22.675V1.325C24 .6 23.4 0 22.675 0zM12 3c2.2 0 3.59 1.36 3.59 3.48v2.82H18l-1.32 3.89h-3.68V24H9.32V10.2H7V6.31h2.32V4.5c0-2.13 1.16-3.5 3.7-3.5z"/></svg>
                    </a>
                    <a href="https://instagram.com" target="_blank" class="hover:text-purple-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.736 0 5.5.007 5.5 0c-2.644.008-5.5 2.72-5.5 5.5C0 8.736 0 12 0 12s0 3.264 0 6.5C0 22.28 2.72 24 5.5 24c3.264 0 6.5-.007 6.5-.007s3.264 0 6.5 0c2.78 0 5.5-2.72 5.5-5.5C24 15.264 24 12 24 12s0-3.264 0-6.5c0-2.78-2.72-5.5-5.5-5.5C15.264 0 12 0 12 0zm0 2.25c3.964 0 7.25 3.29 7.25 7.25S15.964 16.75 12 16.75 4.75 13.46 4.75 10.5 8.036 2.25 12 2.25zm0 2.75a4.5 4.5 0 1 0 0 9 4.5 4.5 0 0 0 0-9zm7.125-.375c0 .414-.336.75-.75.75s-.75-.336-.75-.75.336-.75.75-.75.75.336.75.75z"/></svg>
                    </a>
                    <a href="https://twitter.com" target="_blank" class="hover:text-blue-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M23.954 4.569c-.885.392-1.83.655-2.825.775 1.014-.609 1.794-1.572 2.163-2.724-.951.566-2.005.977-3.127 1.195-.894-.952-2.167-1.54-3.583-1.54-2.71 0-4.913 2.199-4.913 4.913 0 .385.045.761.127 1.124-4.083-.205-7.703-2.161-10.125-5.144-.423.725-.666 1.562-.666 2.465 0 1.699.865 3.191 2.179 4.066-.805-.026-1.564-.247-2.228-.616v.062c0 2.38 1.69 4.372 3.938 4.831-.412.111-.844.171-1.287.171-.315 0-.621-.031-.922-.086.623 1.946 2.433 3.365 4.575 3.405-1.677 1.314-3.785 2.095-6.075 2.095-.394 0-.782-.023-1.164-.067 2.167 1.386 4.748 2.194 7.508 2.194 9.005 0 13.905-7.459 13.905-13.903 0-.211-.005-.422-.014-.632.954-.688 1.775-1.55 2.425-2.53z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>

</html>
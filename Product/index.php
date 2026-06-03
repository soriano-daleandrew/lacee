<?php
session_start();
include_once('../Database/lacee_db.php');
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='icon' href='../Images/lacee/lacee dark.png'>
    <title>lacee</title>

    <style>
        @font-face {
            font-family: Poppins;
            src: url(../Fonts/Poppins.ttf);
        }

        @font-face {
            font-family: Monainn;
            src: url(../Fonts/Monainn.otf);
        }

        :root {
            --platinum: #E5E4E2;
            --nightshadow: #1C1C1C;
            --neonred: #FF1515;
            --malachite: #0BDA51;
        }

        * {
            margin: 0;
        }

        .nav-bar {
            background-color: black;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        .ecommerce {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ecommerce img {
            width: 75px;
            height: 75px;
        }

        .ecommerce p {
            color: white;
            font-size: 50px;
            font-family: Monainn;
        }

        .account {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            margin-right: 20px;
        }

        /* ----------------- */

        .manager {
            display: flex;
            align-items: center;
            justify-content: end;
            gap: 15px;
        }
        
        .manager a {
            text-decoration: none;
        }
        
        .manager p {
            color: white;
            font-size: 12px;
            font-family: Poppins;
        }

        #signed-profile,
        #unsigned-profile {
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #signed-profile::before,
        #unsigned-profile::before {
            content: '';
            position: absolute;
            top: 45px;
            transform: translateX(1px);
            border-width: 10px;
            border-style: solid;
            border-color: transparent transparent white transparent;
            pointer-events: none;
            transition-duration: 0.1s;
        }

        #signed-profile::before {
            opacity: var(--signedProfileBeforeOpacity, 0);
        }

        #unsigned-profile::before {
            opacity: var(--unsignedProfileBeforeOpacity, 0);
        }

        #options {
            position: absolute;
            top: 65px;
            right: -20px;
            display: flex;
            flex-direction: column;
            background-color: white;
            opacity: 0;
            visibility: hidden;
            transition-duration: 0.1s;
            z-index: 1;
        }

        #options a,
        #options button {
            border: none;
            background-color: transparent;
            font-family: Poppins;
            font-size: 15px;
            text-decoration: none;
            color: black;
            width: 150px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition-duration: 0.1s;
        }

        #options a:hover,
        #options button:hover {
            background-color: var(--neonred);
            color: white;
        }

        /* --------------------- */

        .manager img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            aspect-ratio: 1/1;
            object-fit: cover;
        }

        .container {
            background-color: var(--platinum);
            display: flex;
            padding: 5% 0;
            justify-content: center;
            gap: 12.5%;
        }

        .brand-image {
            width: 25%;
        }

        #transac-form {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        #transac-form input {
            font-family: Poppins;
        }

        #transac-form h2 {
            font-family: Poppins;
        }

        .price {
            font-family: Poppins;
            font-weight: bold;
            font-size: 30px;
            color: var(--neonred);
            background-color: silver;
            margin: 10px 0;
            padding: 0 5%;
        }

        .rate {
            display: flex;
            font-size: 15px;
            gap: 15px;
        }

        .rate .star img {
            width: 15px;
        }

        .rate p {
            font-family: Poppins;
        }

        .star {
            display: flex;
        }

        .star p {
            margin-right: 5px;
        }

        .details .label {
            width: 100px;
            color: dimgrey;
        }

        .details td {
            font-family: Poppins;
            font-size: 15px;
            padding: 5px 0;
        }

        .details button {
            width: 29px;
            height: 29px;
            background-color: transparent;
            border: 1px solid dimgrey;
            color: dimgrey;
            cursor: pointer;
            font-family: Poppins;
        } 

        .details input {
            width: 50px;
            height: 25px;
            text-align: center;
            border: 1px solid dimgrey;
            outline: none;
            background-color: transparent;
            font-family: Poppins;
        } 

        .details input::-webkit-inner-spin-button,
        .details input::-webkit-outer-spin-button {
            -webkit-appearance: none;
        } 

        .submitter {
            display: flex;
            gap: 2px;
        }

        .submitter button {
            font-family: Poppins;
            font-weight: bold;
            width: 250px;
            height: 45px;
            border-radius: 2px;
            cursor: pointer;
        }

        .submitter button:first-child {
            background-color: var(--neonred);
            border: none;
            outline: none;
            color: white;
        }

        .submitter button:last-child {
            background-color: white;
            border: 1px solid var(--neonred);
            outline: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--neonred);
        }

        .submitter button img {
            width: 35px;
        }

        .company-details {
            display: flex;
            justify-content: center;
            gap: 10%;
            font-family: Poppins;
            padding: 50px 0;
        }

        .company-details a {
            text-decoration: none;
            font-size: 15px;
        }

        .company-info {
            display: flex;
            flex-direction: column;
        }

        .company-info a {
            color: black;
        }

        .follow-us {
            text-align: center;
        }

        .follow-us a img {
            width: 35px;
        }

        .credits {
            height: 50px;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-family: Poppins;
            gap: 15px;
            color: white;
        }

        #cart {
            position: relative;
        }

        #cart::before {
            content: 'Added to Cart!';
            position: absolute;
            top: 45px;
            right: -150%;
            background-color: var(--malachite);
            width: 150px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-family: Poppins;
            font-size: 15px;
            cursor: default;
            pointer-events: none;
            opacity: var(--cartBeforeOpacity, 0);
            transition: 0.1s;
        }

        #cart::after {
            content: '';
            position: absolute;
            top: 25px;
            left: 21.5%;
            border-width: 10px;
            border-style: solid;
            border-color: transparent transparent var(--malachite) transparent;
            cursor: default;
            pointer-events: none;
            opacity: var(--cartAfterOpacity, 0);
            transition: 0.1s;
        }
    </style>
</head>
<body>
    <section>
        <div class='nav-bar'>
            <div class='ecommerce'>
                <img src='../Images/lacee/lacee dark.png'>
                <p>lacee</p>
            </div>
            <div class='account'>
                <div class='manager'>
                    <?php
                    if (isset($_SESSION['user'])) {
                        if (is_numeric($_SESSION['user'])) {
                            $SQL_SELECT_customers = "SELECT id, `profile` FROM customers WHERE phone = '$_SESSION[user]'";
                            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);
                    
                            if (!$QUERY_SELECT_customers) die;
            
                            $TABLE_customers = mysqli_fetch_array($QUERY_SELECT_customers);
                        } else {
                            $SQL_SELECT_customers = "SELECT id, `profile` FROM customers WHERE email = '$_SESSION[user]'";
                            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);
                    
                            if (!$QUERY_SELECT_customers) die;
            
                            $TABLE_customers = mysqli_fetch_array($QUERY_SELECT_customers);
                        }
                        echo "
                            <a href='../Order/'>
                                <img src='../Icons/Order.svg'>
                            </a>
                            <a href='../Cart/' id='cart'>
                                <img src='../Icons/Cart.svg'>
                            </a>
                            <div id='signed-profile' onclick='showOptions(true)'>
                        ";
                            if ($TABLE_customers['profile']) {
                                echo "
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_customers['profile']) . "'>
                                ";
                            } else {
                                echo "
                                    <img src='../Icons/User.svg'>
                                ";
                            }
                        echo "
                                <div id='options'>
                                    <a href='../Profile/'>Profile</a>
                                    <form action='./' method='POST'>
                                        <button type='submit' name='log-out'>Log out</button>
                                    </form>
                                </div>
                                <p>$_SESSION[name]</p>
                            </div>
                        ";
                    } else {
                        echo "
                            <a href='../Account/'>
                                <img src='../Icons/Order.svg'>
                            </a>
                            <a href='../Account/'>
                                <img src='../Icons/Cart.svg'>
                            </a>
                            <div id='unsigned-profile' onclick='showOptions(false)'>
                                <img src='../Icons/User.svg'>
                                <div id='options'>
                                    <a href='../Account/'>Sign In</a>
                                    <a href='../Account/?sign=up'>Sign Up</a>
                                </div>
                                <p>Guest</p>
                            </div>
                        ";
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <main>
        <div class='container'>
            <?php
            if (isset($_POST['id'])) {
                $product_id = $_POST['id'];

                $SQL_SELECT_products = "SELECT brand_name, price, stock, brand_image FROM products WHERE id = $product_id";
                $QUERY_SELECT_products = mysqli_query($connect, $SQL_SELECT_products);

                if (!$QUERY_SELECT_products) die;

                $TABLE_products = mysqli_fetch_array($QUERY_SELECT_products);
                
                echo "
                    <img src='data:image/png; base64, " . base64_encode($TABLE_products['brand_image']) . "' class='brand-image'>
                    <form action='./' method='POST' id='transac-form'>
                        <div class='product-info'>
                            <input type='hidden' name='buy-now-product-id' value='$product_id'>
                            <input type='hidden' name='id' value='$product_id'>
                            <h2>$TABLE_products[brand_name]</h2>
                            <div class='rate'>
                                <div class='star'>
                                    <p>3.4</p>
                                    <img src='../Icons/Star Filled.svg'>
                                    <img src='../Icons/Star Filled.svg'>
                                    <img src='../Icons/Star Filled.svg'>
                                    <img src='../Icons/Star Empty.svg'>
                                    <img src='../Icons/Star Empty.svg'>
                                </div>
                                <p>|</p>
                                <p>1k Ratings</p>
                                <p>|</p>
                                <p>3k Solds</p>
                            </div>
                            <p class='price'>P $TABLE_products[price]</p>
                        </div>
                        <table class='details'>
                            <tr>
                                <td class='label'>Stock</td>
                                <td>$TABLE_products[stock] pcs</td>
                            </tr>
                            <tr>
                                <td class='label'>Quantity</td>
                                <td>
                                    <button type='button' onclick='subQuantity()'> - </button>
                                    <input type='number' name='quantity' id='quantity' value='1'>
                                    <button type='button' onclick='addQuantity()'> + </button>
                                </td>
                            </tr>
                        </table>
                        <div class='submitter'>
                            <button type='button' name='buy-now' onclick='handleTransacForm()'>Buy Now</button>
                            <button type='submit' name='add-to-cart'>
                                <img src='../Icons/Cart Plus.svg'>Add to Cart
                            </button>
                        </div>
                    </form>
                ";
            };
            ?>
        </div>
    </main>

    <section>
        <div class='company-details'>
            <div class='company-info'>
                <h3>Company Info</h3>
                <a href=''>About Us</a>
            </div>
            <div class='follow-us'>
                <h3>Follow Us</h3>
                <a href=''>
                    <img src='../Icons/Facebook.svg'>
                </a>
                <a href=''>
                    <img src='../Icons/Instagram.svg'>
                </a>
            </div>
        </div>
        <div class='credits'>
            <p>Dale Soriano</p>
            <p>|</p>
            <p>For Educational Purposes Only</p>
            <p>|</p>
            <p>© 2024 lacee Philippines Inc.</p>
        </div>
    </section>

    <script>
        let hide = false;
        function showOptions(account) {
            const options = document.getElementById('options');

            if (account) {
                const signedProfile = document.getElementById('signed-profile');
    
                if (!hide) {
                    options.style.opacity = 1;
                    options.style.visibility = 'visible';
                    signedProfile.style.setProperty('--signedProfileBeforeOpacity', 1);
                    hide = true;
                } else {
                    options.style.opacity = 0;
                    options.style.visibility = '';
                    signedProfile.style.setProperty('--signedProfileBeforeOpacity', 0);
                    hide = false;
                }
            } else {
                const unsignedProfile = document.getElementById('unsigned-profile');
    
                if (!hide) {
                    options.style.opacity = 1;
                    options.style.visibility = 'visible';
                    unsignedProfile.style.setProperty('--unsignedProfileBeforeOpacity', 1);
                    hide = true;
                } else {
                    options.style.opacity = 0;
                    options.style.visibility = '';
                    unsignedProfile.style.setProperty('--unsignedProfileBeforeOpacity', 0);
                    hide = false;
                }
            }
        }

        const product_stock = <?php echo $TABLE_products['stock'] ?>;
        const quantity = document.getElementById('quantity');

        function subQuantity() {
            if (quantity.value != 1) quantity.value--;
        }
        
        function addQuantity() {
            if (product_stock > quantity.value) quantity.value++;
        }
    </script>

    <?php
    echo "
        <script>
            const transacForm = document.getElementById('transac-form');
    
            function handleTransacForm() {
                if ('$_SESSION[user]') {
                    transacForm.action = '../Cart/';
                    transacForm.submit();
                } else {
                    window.open('../Account/', '_self');
                }
            }
        </script>
    ";

    if (isset($_POST['add-to-cart'])) {
        if ($_SESSION['user']) {
            $SQL_SELECT_carts = "SELECT product_id, quantity FROM carts WHERE customer_id = $TABLE_customers[id]";
            $QUERY_SELECT_carts = mysqli_query($connect, $SQL_SELECT_carts);

            if (!$QUERY_SELECT_carts) die;

            $existing = false;
            while ($TABLE_carts = mysqli_fetch_array($QUERY_SELECT_carts)) {
                if ($TABLE_carts['product_id'] == $product_id) {
                    $SQL_UPDATE_carts = "UPDATE carts SET quantity = $TABLE_carts[quantity] + $_POST[quantity] WHERE customer_id = $TABLE_customers[id] AND product_id = $product_id";
                    $QUERY_UPDATE_carts = mysqli_query($connect, $SQL_UPDATE_carts);
            
                    if (!$QUERY_UPDATE_carts) die;

                    $existing = true;
                }
            }

            if (!$existing) {
                $SQL_INSERT_carts = "INSERT INTO carts(customer_id, product_id, quantity) VALUES ($TABLE_customers[id], $product_id, $_POST[quantity])";
                $QUERY_INSERT_carts = mysqli_query($connect, $SQL_INSERT_carts);
        
                if (!$QUERY_INSERT_carts) die;
            }

            echo "
                <script>        
                    quantity.value = $_POST[quantity];
                    
                    const cart = document.getElementById('cart');
                    
                    cart.style.setProperty('--cartBeforeOpacity', 1);
                    cart.style.setProperty('--cartAfterOpacity', 1);
        
                    setTimeout(() => {
                        cart.style.setProperty('--cartBeforeOpacity', 0);
                        cart.style.setProperty('--cartAfterOpacity', 0);
                    }, 5000);
                </script>
            ";
        } else {
            echo "
                <script>
                    window.open('../Account/', '_self');
                </script>
            ";
        }
    }

    if (isset($_POST['log-out'])) {
        session_destroy();
        
        echo "
            <script>
                window.open('../Account/', '_self');
            </script>
        ";
    };
    ?>
</body>
</html>
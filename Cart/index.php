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
        
        .manager {
            display: flex;
            align-items: center;
            justify-content: end;
            gap: 15px;
        }
        
        .manager a {
            text-decoration: none;
        }
        
        .manager img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            aspect-ratio: 1/1;
            object-fit: cover;
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

        .container {
            background-color: var(--platinum);
            min-height: 100vh;
        }

        .empty-cart {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .empty-cart img {
            width: 25%;
        }

        .empty-cart p {
            font-size: 40px;
            font-family: Poppins;
            color: dimgrey;
        }

        .filled-cart {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 15px 0;
        }

        .product {
            display: flex;
            background-color: white;
            width: 70%;
            gap: 5%;
            box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.2);
        }

        .product img {
            width: 25%;
            margin-left: 5%;
        }

        .clip {
            position: absolute;
            min-width: 55px;
            height: 55px;
            border-bottom-right-radius: 100%;
            background-color: var(--nightshadow);
        }

        .item {
            min-width: 25px;
            min-height: 25px;
            accent-color: var(--nightshadow);
            margin: 10px 0 0 10px;
            cursor: pointer;
        }

        .details {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .product-name {
            font-family: Poppins;
            font-size: 30px;
            font-weight: bold;
            line-height: 30px;
        }

        .company-name {
            font-family: Poppins;
            font-size: 20px;
        }

        .stock {
            font-family: Poppins;
            font-size: 15px;
            color: dimgrey;
            padding: 5px 0;
        }

        .price {
            font-family: Poppins;
            font-size: 25px;
            font-weight: bold;
            color: var(--neonred);
            padding-top: 10px;
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

        .delete-form {
            min-width: 45px;
        }

        .delete {
            width: 100%;
            height: 100%;
            background-color: var(--nightshadow);
            color: white;
            font-family: Poppins;
            font-weight: bold;
            border: none;
            outline: none;
            cursor: pointer;
        }

        .delete img {
            width: 25px;
            height: 25px;
        }

        .sticky-container {
            display: flex;
            justify-content: center;
            background-color: var(--platinum);
            position: sticky;
            bottom: 0;
        }

        .checked-list {
            width: 70%;
            display: flex;
            align-items: center;
            background-color: black;
            color: white;
            font-family: Poppins;
        }

        .checked-list label {
            min-width: fit-content;
            cursor: pointer;
        }

        #items {
            min-width: 25px;
            min-height: 25px;
            accent-color: var(--nightshadow);
            cursor: pointer;
            margin: 10px;
        }

        .total-items {
            width: 100%;
            margin: 0 5%;
        }

        #total {
            color: var(--neonred);
            min-width: fit-content;
            margin: 0 15px 0 10px;
            font-size: 25px;
            font-weight: bold;
        }

        .checkout {
            min-width: 250px;
            min-height: 45px;
            background-color: var(--neonred);
            color: white;
            font-family: Poppins;
            font-weight: bold;
            outline: none;
            border: none;
            border-radius: 2px;
            outline: none;
            cursor: pointer;
            margin: 10px 10px 10px 0;
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
                        } else {
                            $SQL_SELECT_customers = "SELECT id, `profile` FROM customers WHERE email = '$_SESSION[user]'";
                            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);
                        }
        
                        if (!$QUERY_SELECT_customers) die;
        
                        $TABLE_customers = mysqli_fetch_array($QUERY_SELECT_customers);

                        echo "
                            <a href='../Order/'>
                                <img src='../Icons/Order.svg'>
                            </a>
                            <a href='../Cart/'>
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
            if (isset($_POST['delete'])) {
                $SQL_DELETE_carts = "DELETE FROM carts WHERE id = '$_POST[id]'";
                $QUERY_DELETE_carts = mysqli_query($connect, $SQL_DELETE_carts);

                if (!$QUERY_DELETE_carts) die;
            }

            if (isset($_POST['buy-now-product-id'])) {
                $buy_now_product_id = $_POST['buy-now-product-id'];

                $SQL_SELECT_carts = "SELECT product_id, quantity FROM carts WHERE customer_id = $TABLE_customers[id]";
                $QUERY_SELECT_carts = mysqli_query($connect, $SQL_SELECT_carts);

                if (!$QUERY_SELECT_carts) die;

                $existing = false;
                while ($TABLE_carts = mysqli_fetch_array($QUERY_SELECT_carts)) {
                    if ($TABLE_carts['product_id'] == $buy_now_product_id) {
                        $SQL_UPDATE_carts = "UPDATE carts SET quantity = $TABLE_carts[quantity] + $_POST[quantity] WHERE customer_id = $TABLE_customers[id] AND product_id = $buy_now_product_id";
                        $QUERY_UPDATE_carts = mysqli_query($connect, $SQL_UPDATE_carts);
                
                        if (!$QUERY_UPDATE_carts) die;

                        $existing = true;
                    }
                }

                if (!$existing) {
                    $SQL_INSERT_carts = "INSERT INTO carts(customer_id, product_id, quantity) VALUES ($TABLE_customers[id], $buy_now_product_id, $_POST[quantity])";
                    $QUERY_INSERT_carts = mysqli_query($connect, $SQL_INSERT_carts);
            
                    if (!$QUERY_INSERT_carts) die;
                }
            }

            $SQL_SELECT_carts = "SELECT carts.id, carts.product_id, companies.company, products.brand_name, products.price, products.stock, products.brand_image, carts.quantity FROM carts INNER JOIN products ON carts.product_id = products.id INNER JOIN companies ON products.company_id = companies.id WHERE customer_id = $TABLE_customers[id] ORDER BY carts.id DESC";
            $QUERY_SELECT_carts = mysqli_query($connect, $SQL_SELECT_carts);

            if (!$QUERY_SELECT_carts) die;

            $filled = false;
            while ($TABLE_carts = mysqli_fetch_array($QUERY_SELECT_carts)) {
                if ($TABLE_carts['id']) $filled = true;

                $price = $TABLE_carts['price'] * $TABLE_carts['quantity'];

                echo "
                    <div class='filled-cart'>
                        <div class='product'>
                            <div class='clip'>
                                <input type='checkbox' class='item' id='item" . $TABLE_carts['id'] . "' onclick='itemize()'>
                            </div>
                            <img src='data:image/png; base64, " . base64_encode($TABLE_carts['brand_image']) . "'>
                            <div class='details'>
                                <p class='product-name'>$TABLE_carts[brand_name]</p>
                                <p class='company-name'>$TABLE_carts[company]</p>
                                <p class='stock'>$TABLE_carts[stock] pcs left</p>
                                <div>
                                    <button type='button' onclick='subQuantity($TABLE_carts[id], $TABLE_carts[price], $TABLE_carts[stock])'> - </button>
                                    <input type='number' name='quantity' class='quantity' id='quantity" . $TABLE_carts['id'] . "' value='$TABLE_carts[quantity]'>
                                    <button type='button' onclick='addQuantity($TABLE_carts[id], $TABLE_carts[price], $TABLE_carts[stock])'> + </button>
                                </div>
                                <p class='price' id='price" . $TABLE_carts['id'] . "'>P " . number_format($price, 2, '.', '') . "</p>
                            </div>
                            <form action='./' method='POST' class='delete-form'>
                                <input type='hidden' name='id' value='$TABLE_carts[id]'>
                                <button type='submit' name='delete' class='delete'>
                                    <img src='../Icons/Trash.svg'>
                                </button>
                            </form>
                        </div>
                    </div>
                ";

                if (isset($_POST['buy-now-product-id']) && $_POST['buy-now-product-id'] == $TABLE_carts['product_id']) {
                    echo "
                        <script>
                            const buyNowItemId = document.getElementById('item" . $TABLE_carts['id'] . "');
                            buyNowItemId.checked = true;
                        </script>
                    ";
                }
            }

            if (!$filled) {
                echo "
                    <div class='empty-cart'>
                        <img src='../Images/lacee/Empty Cart.png'>
                        <p>Your cart is empty.</p>
                    </div>
                ";
            }   
            ?>
        </div>
    </main>

    <section class='sticky-container'>
        <div class='checked-list'>
            <input type='checkbox' id='items' onclick='selectAll()'>
            <label for='items'>Select All</label>
            <div class='total-items'>
                <p id='item-count'>0 item</p>
            </div>
            <p>TOTAL</p>
            <p id='total'>P 0</p>
            <form action='../Checkout/' method='POST' onsubmit='return handleCheckoutForm()'>
                <input type='hidden' name='order-list' id='order-list' value=''>
                <input type='hidden' name='quantity-list' id='quantity-list' value=''>
                <button type='submit' class='checkout'>Checkout</button>
            </form>
        </div>
    </section>

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

        const items = document.getElementById('items');
        const total = document.getElementById('total');
        const itemCount = document.getElementById('item-count');
        
        const item = document.getElementsByClassName('item');
        const price = document.getElementsByClassName('price');
        const quantity = document.getElementsByClassName('quantity');
        
        function itemize() {
            let count = 0;
            let grandTotal = 0;
            for (let i = 0; item.length > i; i++) {
                const itemId = document.getElementById(item[i].id);
                const priceId = document.getElementById(price[i].id);
                const regexTotal = priceId.textContent.replace(/^\D+/g, '');
                
                if (itemId.checked == true) {
                    grandTotal += parseFloat(regexTotal);
                    total.textContent = 'P ' + grandTotal.toFixed(2);
                    count++;
                } 

                if (!count) total.textContent = 'P 0';
            }

            if (count <= 1) itemCount.textContent = count + ' item';
            else itemCount.textContent = count + ' items';
        }

        itemize();
        
        function subQuantity(productId, productPrice, productStock) {
            for (let i = 0; quantity.length > i; i++) {
                const quantityId = document.getElementById(quantity[i].id);
                const priceId = document.getElementById(price[i].id);
                if ('quantity' + productId == quantity[i].id && 
                    'price' + productId == price[i].id &&
                    quantityId.value != 1) {
                    quantityId.value--;
                    priceId.textContent = 'P ' + (productPrice * quantityId.value).toFixed(2);
                    itemize();
                };
            }
        }
        
        function addQuantity(productId, productPrice, productStock) {
            for (let i = 0; quantity.length > i; i++) {
                const quantityId = document.getElementById(quantity[i].id);
                const priceId = document.getElementById(price[i].id);
                if ('quantity' + productId == quantity[i].id &&
                    'price' + productId == price[i].id &&
                    productStock > quantityId.value) {
                    quantityId.value++;
                    priceId.textContent = 'P ' + (productPrice * quantityId.value).toFixed(2);
                    itemize();
                };
            }
        }

        function selectAll() {
            if (items.checked == true) {
                for (let i = 0; item.length > i; i++) {
                    const itemId = document.getElementById(item[i].id);
                    const regexItem = item[i].id.replace(/^\D+/g, '');
                    itemId.checked = true;
                    itemize();
                }
            } else {
                for (let i = 0; item.length > i; i++) {
                    const itemId = document.getElementById(item[i].id);
                    const regexItem = item[i].id.replace(/^\D+/g, '');
                    itemId.checked = false;
                    itemize();
                }
            }
        }

        const orderList = document.getElementById('order-list');
        const quantityList = document.getElementById('quantity-list');

        function handleCheckoutForm() {
            let productIdList = [];
            let orderQuantityList = [];

            if (itemCount.textContent == '0 item') return false;

            for (let i = 0; item.length > i; i++) {
                const itemId = document.getElementById(item[i].id);
                const quantityId = document.getElementById(quantity[i].id);
                const regexItem = item[i].id.replace(/^\D+/g, '');
                
                if (itemId.checked == true) {
                    productIdList.push(parseInt(regexItem, 10));
                    orderQuantityList.push(quantityId.value);
                }
            }

            orderList.value = productIdList;
            quantityList.value = orderQuantityList;
        }
    </script>

    <?php
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
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
        /* ------------------------- */
        .ordered-product {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding: 15px 0;
        }

        .product {
            width: 70%;
            background-color: white;
            box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.2);
        }

        .delivery-address {
            background-color: var(--nightshadow);
            width: 100%;
            position: relative;
        }

        .delivery-address div {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 5px 0 5px;
        }

        .delivery-address div img {
            width: 35px;
        }

        .delivery-address div p {
            font-family: Poppins;
            font-size: 20px;
            color: white;
        }

        .delivery-address button {
            position: absolute;
            top: 50%;
            right: 10px;
            width: 40px;
            height: 40px;
            outline: none;
            border: none;
            background-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .delivery-address button img {
            width: 30px;
        }
        
        .address {
            font-family: Poppins;
            font-size: 15px;
            color: white;
            padding: 0 45px 5px 45px;
        }

        .company {
            border-bottom: 1px solid dimgrey;
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 5px 3.5%;
        }

        .company img {
            width: 25px;
        }

        .company p {
            font-family: Poppins;
            font-size: 15px;
        }

        .details {
            display: flex;
            align-items: center;
            gap: 2.5%;
        }

        .details img {
            width: 100px;
            margin-left: 2.5%;
        }

        .details p {
            width: 100%;
            font-family: Poppins;
            font-size: 20px;
            font-weight: bold;
        }
        
        .details table {
            font-family: Poppins;
            font-size: 15px;
            text-align: center;
            margin-right: 2.5%;
        }
        
        .label td {
            min-width: 125px;
            color: dimgrey;
        }

        .sticky-container {
            display: flex;
            justify-content: center;
            background-color: var(--platinum);
            position: sticky;
            bottom: 0;
        }

        .order-list {
            width: 70%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            background-color: black;
            color: white;
            font-family: Poppins;
        }

        #grandtotal {
            color: var(--neonred);
            min-width: fit-content;
            margin: 0 15px 0 10px;
            font-size: 25px;
            font-weight: bold;
        }

        .order {
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
        /* ------------------------- */
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
                            $SQL_SELECT_customers = "SELECT customers.profile, customers.residence, barangays.barangay, municipalities.municipality, provinces.province, zip_codes.zip_code FROM customers INNER JOIN barangays ON customers.barangay_id = barangays.id INNER JOIN municipalities ON customers.municipality_id = municipalities.id INNER JOIN provinces ON customers.province_id = provinces.id INNER JOIN zip_codes ON customers.zip_code_id = zip_codes.id WHERE phone = '$_SESSION[user]'";
                            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);
                        } else {
                            $SQL_SELECT_customers = "SELECT customers.profile, customers.residence, barangays.barangay, municipalities.municipality, provinces.province, zip_codes.zip_code FROM customers INNER JOIN barangays ON customers.barangay_id = barangays.id INNER JOIN municipalities ON customers.municipality_id = municipalities.id INNER JOIN provinces ON customers.province_id = provinces.id INNER JOIN zip_codes ON customers.zip_code_id = zip_codes.id WHERE email = '$_SESSION[user]'";
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
                                        <input type='hidden' name='order-list' value='" . $_POST['order-list'] . "'> <!-- might be temporary for me to be able to log out -->
                                        <input type='hidden' name='quantity-list' value='" . $_POST['quantity-list'] . "'> <!-- might be temporary for me to be able to log out -->
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
            if (isset($_POST['order-list'])) {
                $order_list = explode(',', $_POST['order-list']);
                $quantity_list = explode(',', $_POST['quantity-list']);

                for ($i = 0; count($order_list) > $i; $i++) {
                    $SQL_SELECT_carts = "SELECT carts.id, products.brand_name, products.price, products.brand_image, companies.company, companies.logo FROM carts INNER JOIN products ON carts.product_id = products.id INNER JOIN companies ON products.company_id = companies.id WHERE carts.id = '$order_list[$i]'";
                    $QUERY_SELECT_carts = mysqli_query($connect, $SQL_SELECT_carts);

                    if (!$QUERY_SELECT_carts) die;
        
                    $TABLE_carts = mysqli_fetch_array($QUERY_SELECT_carts);

                    $subtotal = $quantity_list[$i] * $TABLE_carts['price'];

                    echo "
                        <div class='ordered-product'>
                            <div class='product'>
                                <div class='delivery-address'>
                                    <div>
                                        <img src='../Icons/Position.svg'>
                                        <p>Delivery Address</p>
                                    </div>
                    ";
                                    if (!$TABLE_customers['residence']) {
                                        echo "
                                            <p class='address'>none</p>
                                        ";
                                    } else {
                                        $address = $TABLE_customers['residence'] . ', ' . $TABLE_customers['barangay'] . ', ' . $TABLE_customers['municipality'] . ', ' . $TABLE_customers['province'] . ', ' . $TABLE_customers['zip_code'];
                                        if (strlen($address) > 99) {
                                            echo "
                                                <p class='address'>" . substr($address, 0, 99) . '...' . "</p>
                                            ";
                                        } else {
                                            echo "
                                                <p class='address'>$address</p>
                                            ";
                                        }
                                    }
                    echo "
                                    <button type='button'>
                                        <img src='../Icons/Edit.svg'>
                                    </button>
                                </div>
                                <div class='company'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_carts['logo']) . "'>
                                    <p>$TABLE_carts[company]</p>
                                </div>
                                <div class='details'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_carts['brand_image']) . "'>
                    ";
                                    if (strlen($TABLE_carts['brand_name']) > 30) {
                                        echo "
                                            <p>" . substr($TABLE_carts['brand_name'], 0, 30) . '...' . "</p>
                                        ";
                                    } else {
                                        echo "
                                            <p>$TABLE_carts[brand_name]</p>
                                        ";
                                    }
                    echo "
                                    <table>
                                        <tr class='label'>
                                            <td>Quantity</td>
                                            <td>Price</td>
                                            <td>Subtotal</td>
                                        </tr>
                                        <tr>
                                            <td>$quantity_list[$i]</td>
                                            <td>P $TABLE_carts[price]</td>
                                            <td class='subtotal' id='subtotal" . $TABLE_carts['id'] . "'>P " . number_format($subtotal, 2, '.', '') . "</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    ";
                }
            }
            ?>
        </div>
    </main>

    <section class='sticky-container'>
        <div class='order-list'>
            <p>GRANDTOTAL</p>
            <p id='grandtotal'>P 0</p>
            <form action='../Order/' method='POST' onsubmit='return handleOrderForm()'>
                <input type='hidden' name='order-list' id='order-list' value=''>
                <input type='hidden' name='quantity-list' id='quantity-list' value=''>
                <button type='submit' class='order'>Order</button>
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

        const subtotal = document.getElementsByClassName('subtotal');

        let total = 0;
        (() => {
            for (let i = 0; subtotal.length > i; i++) {
                const subtotalId = document.getElementById(subtotal[i].id);
                total += parseFloat(subtotalId.textContent.replace(/^\D+/g, ''));
            }
            
            const grandtotal = document.getElementById('grandtotal');
            grandtotal.textContent = 'P ' + total.toFixed(2);
        })();
        

        const orderList = document.getElementById('order-list');
        const quantityList = document.getElementById('quantity-list');
        const address = document.getElementsByClassName('address');

        function handleOrderForm() {
            let productIdList = [];
            let orderQuantityList = [];

            <?php
            for ($i = 0; count($order_list) > $i; $i++) {
                echo "
                    productIdList.push($order_list[$i]);
                    orderQuantityList.push($quantity_list[$i]);
                ";
            }
            ?>

            for (let i = 0; address.length > i; i++) {
                if (address[i].textContent == 'none') {
                    alert('Delivery Address not set.\nPlease set Delivery Address to continue.');
                    return false
                } else {
                    orderList.value = productIdList;
                    quantityList.value = orderQuantityList;
                }
            }
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
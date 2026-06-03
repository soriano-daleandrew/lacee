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

        /* -------------------------- */
        .sticky-container {
            display: flex;
            justify-content: center;
            background-color: var(--platinum);
            position: sticky;
            top: 0;
        }

        .order-states {
            width: 70%;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            color: white;
            background-color: black;
            font-family: Poppins;
            gap: 2px;
        }

        #to-pay,
        #to-ship,
        #to-receive,
        #completed {
            display: none;
        }

        #to-pay:checked + label,
        #to-ship:checked + label,
        #to-receive:checked + label,
        #completed:checked + label {
            color: black;
            background-color: white;
            border-bottom: 2px solid var(--neonred);
        }

        .tab {
            height: 45px;
            border-bottom: 2px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition-duration: 0.1s;
        }
        
        .container {
            background-color: var(--platinum);
            min-height: 100vh;
        }
        /* ------------------------- */
        .delivery-address {
            background-color: var(--nightshadow);
            /* width: 100%; */
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

        .address {
            font-family: Poppins;
            font-size: 15px;
            color: white;
            padding: 0 45px 5px 45px;
        }
        #content-to-ship,
        #content-to-receive,
        #content-completed {
            display: none;
        }
        
        .empty {
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .empty img {
            width: 25%;
        }
        
        .empty p {
            font-size: 40px;
            font-family: Poppins;
            color: dimgrey;
        }
        
        .filled {
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
        /* -------------------------- */

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
                            $SQL_SELECT_customers = "SELECT customers.id, customers.profile, customers.residence, barangays.barangay, municipalities.municipality, provinces.province, zip_codes.zip_code FROM customers INNER JOIN barangays ON customers.barangay_id = barangays.id INNER JOIN municipalities ON customers.municipality_id = municipalities.id INNER JOIN provinces ON customers.province_id = provinces.id INNER JOIN zip_codes ON customers.zip_code_id = zip_codes.id WHERE phone = '$_SESSION[user]'";
                            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);
                        } else {
                            $SQL_SELECT_customers = "SELECT customers.id, customers.profile, customers.residence, barangays.barangay, municipalities.municipality, provinces.province, zip_codes.zip_code FROM customers INNER JOIN barangays ON customers.barangay_id = barangays.id INNER JOIN municipalities ON customers.municipality_id = municipalities.id INNER JOIN provinces ON customers.province_id = provinces.id INNER JOIN zip_codes ON customers.zip_code_id = zip_codes.id WHERE email = '$_SESSION[user]'";
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

    <section class="sticky-container">
        <div class="order-states">
            <input type="radio" name='tab' id="to-pay" checked>
            <label for="to-pay" class="tab" onclick="showContent('pay')">To Pay</label>
            <input type="radio" name='tab' id="to-ship">
            <label for="to-ship" class="tab" onclick="showContent('ship')">To Ship</label>
            <input type="radio" name='tab' id="to-receive">
            <label for="to-receive" class="tab" onclick="showContent('receive')">To Receive</label>
            <input type="radio" name='tab' id="completed">
            <label for="completed" class="tab" onclick="showContent('completed')">Completed</label>
        </div>
    </section>

    <main>
        <div class='container'>
            <?php
            if (isset($_POST['order-list'])) {
                $order_list = explode(',', $_POST['order-list']);
                $quantity_list = explode(',', $_POST['quantity-list']);
                
                for ($i = 0; count($order_list) > $i; $i++) {
                    $SQL_SELECT_carts = "SELECT product_id FROM carts WHERE id = $order_list[$i] AND customer_id = $TABLE_customers[id]";
                    $QUERY_SELECT_carts = mysqli_query($connect, $SQL_SELECT_carts);

                    if (!$QUERY_SELECT_carts) die;

                    $TABLE_carts = mysqli_fetch_array($QUERY_SELECT_carts);

                    $SQL_INSERT_orders = "INSERT INTO orders(customer_id, product_id, quantity, order_state_id) VALUES ($TABLE_customers[id], $TABLE_carts[product_id], $quantity_list[$i], 1)";
                    $QUERY_INSERT_orders = mysqli_query($connect, $SQL_INSERT_orders);

                    if (!$QUERY_INSERT_orders) die;

                    $SQL_SELECT_products = "SELECT stock FROM products WHERE id = $TABLE_carts[product_id]";
                    $QUERY_SELECT_products = mysqli_query($connect, $SQL_SELECT_products);

                    if (!$QUERY_SELECT_products) die;

                    $TABLE_products = mysqli_fetch_array($QUERY_SELECT_products);

                    $stock = $TABLE_products['stock'] - $quantity_list[$i];
                    $SQL_UPDATE_products = "UPDATE products SET stock = $stock WHERE id = $TABLE_carts[product_id]";
                    $QUERY_UPDATE_products = mysqli_query($connect, $SQL_UPDATE_products);

                    if (!$QUERY_UPDATE_products) die;
                }
            }
            ?>
            <div id="content-to-pay">
                <?php
                $SQL_SELECT_orders = "SELECT orders.id, companies.company, companies.logo, products.brand_name, products.price, products.brand_image, orders.quantity FROM orders INNER JOIN products ON orders.product_id = products.id INNER JOIN companies ON products.company_id = companies.id INNER JOIN order_states ON orders.order_state_id = order_states.id WHERE customer_id = $TABLE_customers[id] AND order_state = 'to pay' ORDER BY orders.id DESC";
                $QUERY_SELECT_orders = mysqli_query($connect, $SQL_SELECT_orders);

                if (!$QUERY_SELECT_orders) die;

                $filled = false;
                while ($TABLE_orders = mysqli_fetch_array($QUERY_SELECT_orders)) {
                    if ($TABLE_orders['id']) $filled = true;

                    $subtotal = $TABLE_orders['quantity'] * $TABLE_orders['price'];

                    echo "
                        <div class='filled to-pay'>
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
                                </div>
                                <div class='company'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_orders['logo']) . "'>
                                    <p>$TABLE_orders[company]</p>
                                </div>
                                <div class='details'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_orders['brand_image']) . "'>
                    ";
                                    if (strlen($TABLE_orders['brand_name']) > 30) {
                                        echo "
                                            <p>" . substr($TABLE_orders['brand_name'], 0, 30) . '...' . "</p>
                                        ";
                                    } else {
                                        echo "
                                            <p>$TABLE_orders[brand_name]</p>
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
                                            <td>$TABLE_orders[quantity]</td>
                                            <td>P $TABLE_orders[price]</td>
                                            <td class='subtotal'>P " . number_format($subtotal, 2, '.', '') . "</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    ";
                }

                if (!$filled) {
                    echo "
                        <div class='empty to-pay'>
                            <img src='../Images/lacee/Empty Box.png'>
                            <p>No orders yet.</p>
                        </div>
                    ";
                }   
                ?>
            </div>

            <div id="content-to-ship">
                <?php
                $SQL_SELECT_orders = "SELECT orders.id, companies.company, companies.logo, products.brand_name, products.price, products.brand_image, orders.quantity FROM orders INNER JOIN products ON orders.product_id = products.id INNER JOIN companies ON products.company_id = companies.id INNER JOIN order_states ON orders.order_state_id = order_states.id WHERE customer_id = $TABLE_customers[id] AND order_state = 'to ship' ORDER BY orders.id DESC";
                $QUERY_SELECT_orders = mysqli_query($connect, $SQL_SELECT_orders);

                if (!$QUERY_SELECT_orders) die;

                $filled = false;
                while ($TABLE_orders = mysqli_fetch_array($QUERY_SELECT_orders)) {
                    if ($TABLE_orders['id']) $filled = true;

                    $subtotal = $TABLE_orders['quantity'] * $TABLE_orders['price'];

                    echo "
                        <div class='filled to-ship'>
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
                                </div>
                                <div class='company'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_orders['logo']) . "'>
                                    <p>$TABLE_orders[company]</p>
                                </div>
                                <div class='details'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_orders['brand_image']) . "'>
                    ";
                                    if (strlen($TABLE_orders['brand_name']) > 30) {
                                        echo "
                                            <p>" . substr($TABLE_orders['brand_name'], 0, 30) . '...' . "</p>
                                        ";
                                    } else {
                                        echo "
                                            <p>$TABLE_orders[brand_name]</p>
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
                                            <td>$TABLE_orders[quantity]</td>
                                            <td>P $TABLE_orders[price]</td>
                                            <td class='subtotal'>P " . number_format($subtotal, 2, '.', '') . "</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    ";
                }

                if (!$filled) {
                    echo "
                        <div class='empty to-ship'>
                            <img src='../Images/lacee/Empty Box.png'>
                            <p>No orders yet.</p>
                        </div>
                    ";
                }   
                ?>
            </div>

            <div id="content-to-receive">
                <?php
                $SQL_SELECT_orders = "SELECT orders.id, companies.company, companies.logo, products.brand_name, products.price, products.brand_image, orders.quantity FROM orders INNER JOIN products ON orders.product_id = products.id INNER JOIN companies ON products.company_id = companies.id INNER JOIN order_states ON orders.order_state_id = order_states.id WHERE customer_id = $TABLE_customers[id] AND order_state = 'to receive' ORDER BY orders.id DESC";
                $QUERY_SELECT_orders = mysqli_query($connect, $SQL_SELECT_orders);

                if (!$QUERY_SELECT_orders) die;

                $filled = false;
                while ($TABLE_orders = mysqli_fetch_array($QUERY_SELECT_orders)) {
                    if ($TABLE_orders['id']) $filled = true;

                    $subtotal = $TABLE_orders['quantity'] * $TABLE_orders['price'];

                    echo "
                        <div class='filled to-receive'>
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
                                </div>
                                <div class='company'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_orders['logo']) . "'>
                                    <p>$TABLE_orders[company]</p>
                                </div>
                                <div class='details'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_orders['brand_image']) . "'>
                    ";
                                    if (strlen($TABLE_orders['brand_name']) > 30) {
                                        echo "
                                            <p>" . substr($TABLE_orders['brand_name'], 0, 30) . '...' . "</p>
                                        ";
                                    } else {
                                        echo "
                                            <p>$TABLE_orders[brand_name]</p>
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
                                            <td>$TABLE_orders[quantity]</td>
                                            <td>P $TABLE_orders[price]</td>
                                            <td class='subtotal'>P " . number_format($subtotal, 2, '.', '') . "</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    ";
                }

                if (!$filled) {
                    echo "
                        <div class='empty to-receive'>
                            <img src='../Images/lacee/Empty Box.png'>
                            <p>No orders yet.</p>
                        </div>
                    ";
                }   
                ?>
            </div>

            <div id="content-completed">
                <?php
                $SQL_SELECT_orders = "SELECT orders.id, companies.company, companies.logo, products.brand_name, products.price, products.brand_image, orders.quantity FROM orders INNER JOIN products ON orders.product_id = products.id INNER JOIN companies ON products.company_id = companies.id INNER JOIN order_states ON orders.order_state_id = order_states.id WHERE customer_id = $TABLE_customers[id] AND order_state = 'completed' ORDER BY orders.id DESC";
                $QUERY_SELECT_orders = mysqli_query($connect, $SQL_SELECT_orders);

                if (!$QUERY_SELECT_orders) die;

                $filled = false;
                while ($TABLE_orders = mysqli_fetch_array($QUERY_SELECT_orders)) {
                    if ($TABLE_orders['id']) $filled = true;

                    $subtotal = $TABLE_orders['quantity'] * $TABLE_orders['price'];

                    echo "
                        <div class='filled completed'>
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
                                </div>
                                <div class='company'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_orders['logo']) . "'>
                                    <p>$TABLE_orders[company]</p>
                                </div>
                                <div class='details'>
                                    <img src='data:image/png; base64, " . base64_encode($TABLE_orders['brand_image']) . "'>
                    ";
                                    if (strlen($TABLE_orders['brand_name']) > 30) {
                                        echo "
                                            <p>" . substr($TABLE_orders['brand_name'], 0, 30) . '...' . "</p>
                                        ";
                                    } else {
                                        echo "
                                            <p>$TABLE_orders[brand_name]</p>
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
                                            <td>$TABLE_orders[quantity]</td>
                                            <td>P $TABLE_orders[price]</td>
                                            <td class='subtotal'>P " . number_format($subtotal, 2, '.', '') . "</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    ";
                }

                if (!$filled) {
                    echo "
                        <div class='empty completed'>
                            <img src='../Images/lacee/Empty Box.png'>
                            <p>No orders yet.</p>
                        </div>
                    ";
                }   
                ?>
            </div>
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

        const toPay = document.getElementById('to-pay');
        const toShip = document.getElementById('to-ship');
        const toReceive = document.getElementById('to-receive');
        const completed = document.getElementById('completed');

        const contentToPay = document.getElementById('content-to-pay');
        const contentToShip = document.getElementById('content-to-ship');
        const contentToReceive = document.getElementById('content-to-receive');
        const contentCompleted = document.getElementById('content-completed');

        function showContent(state) {
            if (state == 'pay') {
                toPay.checked = true;
            } else if (state == 'ship') {
                toShip.checked = true;
            } else if (state == 'receive') {
                toReceive.checked = true;
            } else if (state == 'completed') {
                completed.checked = true;
            }

            if (toPay.checked == true) {
                contentToPay.style.display = '';
                contentToShip.style.display = '';
                contentToReceive.style.display = '';
                contentCompleted.style.display = '';
            } else if (toShip.checked == true) {
                contentToPay.style.display = 'none';
                contentToShip.style.display = 'block';
                contentToReceive.style.display = '';
                contentCompleted.style.display = '';
            } else if (toReceive.checked == true) {
                contentToPay.style.display = 'none';
                contentToShip.style.display = '';
                contentToReceive.style.display = 'block';
                contentCompleted.style.display = '';
            } else if (completed.checked == true) {
                contentToPay.style.display = 'none';
                contentToShip.style.display = '';
                contentToReceive.style.display = '';
                contentCompleted.style.display = 'block';
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
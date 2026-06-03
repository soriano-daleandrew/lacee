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
        /* ----------------------- */
        .container {
            background-color: var(--platinum);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            padding: 15px 0;
        }

        .product {
            width: 70%;
            background-color: white;
            display: flex;
            gap: 2.5%;
            box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.2); 
        }

        .product table {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product table:first-child {
            margin-left: 2.5%;
        }
        
        .product table:nth-child(3) {
            width: 100%;
        }

        .product table td {
            font-size: 15px;
            font-family: Poppins;
            text-align: center;
        }

        .product button img {
            width: 25px;
        }
        
        .brand-image {
            width: 100px;
        }
        
        .label-id {
            color: dimgrey;
            min-width: 50px;
        }

        .label-price,
        .label-stock {
            color: dimgrey;
            min-width: 125px;
        }

        .label-brand {
            color: dimgrey;
            min-width: 375px;
        }

        #manipulate {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .stock {
            width: 50px;
            height: 25px;
            text-align: center;
            border: 1px solid dimgrey;
            outline: none;
            background-color: transparent;
            font-family: Poppins;
        } 

        .stock::-webkit-inner-spin-button,
        .stock::-webkit-outer-spin-button {
            -webkit-appearance: none;
        } 

        .edit,
        .delete {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            height: 100%;
            background-color: var(--nightshadow);
            color: white;
            font-family: Poppins;
            font-weight: bold;
            border: none;
            outline: none;
            cursor: pointer;
        }

        .edit img,
        .delete img {
            width: 25px;
            height: 25px;
        }
        /* ----------------------- */
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
                            $SQL_SELECT_customers = "SELECT `profile` FROM customers WHERE phone = '$_SESSION[user]'";
                            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);
                        } else {
                            $SQL_SELECT_customers = "SELECT `profile` FROM customers WHERE email = '$_SESSION[user]'";
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
            if (isset($_POST['edit'])) {
                $SQL_UPDATE_products = "UPDATE products SET stock = '$_POST[stock]' WHERE id = $_POST[id]";
                $QUERY_UPDATE_products = mysqli_query($connect, $SQL_UPDATE_products);
        
                if (!$QUERY_UPDATE_products) die;
            }

            if (isset($_POST['delete'])) {
                $SQL_DELETE_products = "DELETE FROM products WHERE id = $_POST[id]";
                $QUERY_DELETE_products = mysqli_query($connect, $SQL_DELETE_products);
        
                if (!$QUERY_DELETE_products) die;
            }
            
            $SQL_SELECT_products = "SELECT id, brand_name, price, stock, brand_image FROM products";
            $QUERY_SELECT_products = mysqli_query($connect, $SQL_SELECT_products);

            if (!$QUERY_SELECT_products) die;

            while ($TABLE_products = mysqli_fetch_array($QUERY_SELECT_products)) {
                echo "
                    <div class='product'>
                        <table>
                            <tr>
                                <td class='label-id'>ID</td>
                            </tr>
                            <tr>
                                <td>$TABLE_products[id]</td>
                            </tr>
                        </table>
                        <img src='data:image/png; base64, " . base64_encode($TABLE_products['brand_image']) . "' class='brand-image'>
                        <table>
                            <tr>
                                <td class='label-brand'>Brand Name</td>
                                <td class='label-price'>Price</td>
                                <td class='label-stock'>Stock</td>
                            </tr>
                            <tr>
                                <td>$TABLE_products[brand_name]</td>
                                <td>P $TABLE_products[price]</td>
                                <td><input type='number' value='$TABLE_products[stock]' class='stock' id='stock" . $TABLE_products['id'] . "'></td>
                            </tr>
                        </table>
                        <form action='./' method='POST' id='manipulate' onsubmit='handleManipulateForm($TABLE_products[id])'>
                            <input type='hidden' name='id' value='$TABLE_products[id]'>
                            <input type='hidden' name='stock' id='hidden-stock" . $TABLE_products['id'] . "' value=''>
                            <button type='submit' name='edit' class='edit'>
                                <img src='../Icons/Plus.svg'>
                            </button>
                            <button type='submit' name='delete' class='delete'>
                                <img src='../Icons/Trash.svg'>
                            </button>
                        </form>
                    </div>
                ";
            }
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

        const stock = document.getElementsByClassName('stock');

        function handleManipulateForm(id) {
            for (let i = 0; stock.length > i; i++) {
                const stockId = document.getElementById(stock[i].id);
                console.log(stock[i].id);
                console.log('stock' + id);
                
                if (stock[i].id == 'stock' + id) {
                    document.getElementById('hidden-stock' + id).value = stockId.value;
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
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

        /* ------------------------- */
        
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

        /* ------------------------- */

        .container {
            background-color: var(--platinum);
            display: grid;
            gap: 2px;
            grid-template-columns: repeat(3, 1fr);
            grid-auto-rows: 200px;
            padding: 5%;
            overflow: hidden;
        }

        .product {
            position: relative;
            cursor: pointer;
        }

        .highlight {
            width: 100%;
            height: 100%;
            border-radius: 16px;
            position: absolute;
            overflow: hidden;
        }

        .highlight::before {
            content: '';
            background-color: silver;
            width: 100%;
            height: 100%;
            position: absolute;
            clip-path: circle(25% at center);
            transition: 0.5s;
        }

        .product:hover .highlight::before {
            background-color: var(--nightshadow);
            clip-path: circle(100% at center);
        }

        .content {
            font-family: Poppins;
            width: 45%;
            height: 79.5%;
            display: flex;
            flex-direction: column;
            justify-content: end;
            position: relative;
            left: 25%;
            padding: 5%;
            opacity: 0;
            transition-duration: 0.25s;
        }

        .content h2 {
            color: white;
            line-height: 25px;
        }

        .content p {
            color: var(--neonred);
            font-weight: bold;
        }

        .product:hover .content {
            left: 0;
            opacity: 1;
            transition-duration: 0.5s;
            transition-delay: 0.25s;
        }

        .product img {
            width: 55%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            transition: 0.5s;
        }

        .product:hover img {
            width: 80%;
            left: 85%;
            filter: drop-shadow(0 0 5px white);
            transform: translate(-50%, -50%) rotate(45deg);
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
            $SQL_SELECT_products = 'SELECT id, brand_name, price, brand_image FROM products ORDER BY brand_name';
            $QUERY_SELECT_products = mysqli_query($connect, $SQL_SELECT_products);

            if (!$QUERY_SELECT_products) die;

            while ($TABLE_products = mysqli_fetch_array($QUERY_SELECT_products)) {
                echo "
                    <form action='../Product/' method='POST' class='product' id='product-id" . $TABLE_products['id'] . "' onclick='submitForm($TABLE_products[id])'>
                        <input type='hidden' name='id' value='$TABLE_products[id]'>
                        <div class='highlight'></div>
                        <div class='content'>
                            <h2>$TABLE_products[brand_name]</h2>
                            <p>P $TABLE_products[price]</p>
                        </div>
                        <img src='data:image/png; base64, " . base64_encode($TABLE_products['brand_image']) . "'>
                    </form>
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
        function submitForm(id) {
            const productId = document.getElementById('product-id' + id);
            productId.submit();
        }

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
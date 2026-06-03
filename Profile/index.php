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
        
        /* ------------------------- */
        .manager img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            aspect-ratio: 1/1;
            object-fit: cover;
        }
        /* ------------------------- */
        
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
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .user,
        .guest {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px 0;
        }

        .user img,
        .guest img {
            width: 15%;
            aspect-ratio: 1/1;
            object-fit: cover;
            background-color: var(--nightshadow);
            border-radius: 50%;
        }

        .name,
        .guest p {
            font-size: 40px;
            font-family: Poppins;
        }

        .info {
            width: 50%;
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 15px;
        }

        .info div {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .info-label {
            font-size: 20px;
            font-family: Poppins;
            font-weight: bold;
        }

        .info-value {
            font-size: 20px;
            font-family: Poppins;
            border: 1px solid transparent;
            text-align: center;
            padding: 2px 12px;
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
                            $SQL_SELECT_customers = "SELECT customers.phone, customers.email, customers.residence, barangays.barangay, municipalities.municipality, provinces.province, zip_codes.zip_code, customers.profile FROM customers INNER JOIN barangays ON customers.barangay_id = barangays.id INNER JOIN municipalities ON customers.municipality_id = municipalities.id INNER JOIN provinces ON customers.province_id = provinces.id INNER JOIN zip_codes ON customers.zip_code_id = zip_codes.id WHERE phone = '$_SESSION[user]'";
                            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);
                        } else {
                            $SQL_SELECT_customers = "SELECT customers.phone, customers.email, customers.residence, barangays.barangay, municipalities.municipality, provinces.province, zip_codes.zip_code, customers.profile FROM customers INNER JOIN barangays ON customers.barangay_id = barangays.id INNER JOIN municipalities ON customers.municipality_id = municipalities.id INNER JOIN provinces ON customers.province_id = provinces.id INNER JOIN zip_codes ON customers.zip_code_id = zip_codes.id WHERE email = '$_SESSION[user]'";
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
            if (isset($_SESSION['user'])) {
                echo "
                    <div class='user'>
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
                        <p class='name'>$_SESSION[name]</p>
                        <div class='info'>
                            <div>
                                <p class='info-label'>Phone</p>
                                <p class='info-value'>$TABLE_customers[phone]</p>
                            </div>
                            <div>
                                <p class='info-label'>Email</p>
                                <p class='info-value'>
                ";                  
                                    if ($TABLE_customers['email']) {
                                        echo "
                                            $TABLE_customers[email]
                                        ";
                                    } else {
                                        echo "none";
                                    }
                echo "
                                </p>
                            </div>
                            <div>
                                <p class='info-label'>Address</p>
                                <p class='info-value'>
                ";
                                    if (!$TABLE_customers['residence']) {
                                        echo "none";
                                    } else {
                                        echo "
                                            $TABLE_customers[residence], $TABLE_customers[barangay], $TABLE_customers[municipality], $TABLE_customers[province], $TABLE_customers[zip_code]
                                        ";
                                    }
                echo "
                                </p>
                            </div>
                        </div>
                    </div>
                ";
            } else {
                echo "
                    <div class='guest'>
                        <img src='../Icons/User.svg'>
                        <p>You're in guest mode.</p>
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
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

        html {
            overflow: hidden;
        }

        .container {
            width: 100%;
            height: 100vh;
            background-color: var(--platinum);
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        #ecommerce {
            background-color: black;
            width: 50%;
            height: 150vh;
            position: absolute;
            top: -25vh;
            z-index: 1;
            transition: 0.5s;
        }

        #ecommerce img {
            position: absolute;
            top: 50%;
            left: 50%;
            translate: -50% -50%;
        }

        #sign-up-form,
        #sign-in-form {
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: auto;
            gap: 15px;
        }

        #sign-up-form p,
        #sign-in-form p {
            font-family: Monainn;
            font-size: 50px;
        }

        #sign-up-form input,
        #sign-in-form input {
            width: 50%;
            height: 30px;
            outline: none;
            border: 1px solid;
            border-radius: 32px;
            padding: 2px 12px;
            font-family: Poppins;
            text-align: center;
        }

        #sign-up,
        #sign-in {
            width: 150px;
            height: 35px;
            font-family: Poppins;
            background-color: var(--nightshadow);
            color: white;
            border: none;
            border-radius: 4px;
            outline: none;
            cursor: pointer;
        }
        
        #login-instead,
        #create-account {
            font-family: Poppins;
            font-size: 15px;
            border: none;
            outline: none;
            background-color: transparent;
            cursor: pointer;
            color: dimgrey;
            text-decoration: underline;
        }

        #sign-up-account-notif,
        #sign-up-weak-pass-notif,
        #sign-up-pass-notif,
        #sign-in-account-notif,
        #sign-in-pass-notif {
            display: none;
            font-size: 12px;
            font-family: Poppins;
            color: var(--neonred);
        }
    </style>
</head>
<body>
    <main>
        <div id='ecommerce'>
            <img src='../Images/lacee/lacee dark.png'>
        </div>
        <div class='container'>
            <form action='./?sign=up' method='POST' id='sign-up-form'>
                <p>lacee</p>
                <input type='text' name='firstname' placeholder='First Name' id='firstname' required>
                <input type='text' name='lastname' placeholder='Last Name' id='lastname' required>
                <input type='text' name='sign-up-phone-or-email' placeholder='Phone or Email'   id='sign-up-phone-or-email' required>
                <input type='password' name='sign-up-password' placeholder='Password' id='sign-up-password' required>
                <input type='password' name='confirm-password' placeholder='Confirm Password' id='confirm-password' required>
                <span id='sign-up-account-notif'>Account already exists.</span>
                <span id='sign-up-weak-pass-notif'>Password must be at least 8 characters.</span>
                <span id='sign-up-pass-notif'>Password don't match.</span>
                <button type='submit' name='sign-up' id='sign-up'>SIGN UP</button>
                <button type='button' id='login-instead'>Login Instead?</button>
            </form>

            <form action='./' method='POST' id='sign-in-form'>
                <p>lacee</p>
                <input type='text' name='sign-in-phone-or-email' placeholder='Phone or Email' id='sign-in-phone-or-email' required>
                <input type='password' name='sign-in-password' placeholder='Password' id='sign-in-password' required>
                <span id='sign-in-account-notif'>Account doesn't exists.</span>
                <span id='sign-in-pass-notif'>Password is incorrect.</span>
                <button type='submit' name='sign-in' id='sign-in'>SIGN IN</button>
                <button type='button' id='create-account'>Create Account</button>
            </form>
        </div>
    </main>
    
    <script>
        const ecommerce = document.getElementById('ecommerce');
        const signUpForm = document.getElementById('sign-up-form');
        const signInForm = document.getElementById('sign-in-form');
        const loginInstead = document.getElementById('login-instead');
        const createAccount = document.getElementById('create-account');

        loginInstead.addEventListener('click', () => {
            ecommerce.style.width = '100%';
            ecommerce.style.left = 0;
            ecommerce.style.borderRadius = 0;
            signInForm.style.zIndex = 0;
            setTimeout(() => {
                ecommerce.style.width = '50%';
                ecommerce.style.borderRadius = '0 50% 50% 0';
                signUpForm.style.zIndex = -1;
            }, 500)
        })

        createAccount.addEventListener('click', () => {
            ecommerce.style.width = '100%';
            ecommerce.style.borderRadius = 0;
            signUpForm.style.zIndex = 0;
            setTimeout(() => {
                ecommerce.style.width = '50%';
                ecommerce.style.left = '50%';
                ecommerce.style.borderRadius = '50% 0 0 50%';
                signInForm.style.zIndex = -1; 
            }, 500)
        })

        const queryString = location.search;
        const params = new URLSearchParams(queryString);
        
        if (params.get('sign') == 'up') {
            ecommerce.style.left = '50%';
            ecommerce.style.borderRadius = '50% 0 0 50%';
            signInForm.style.zIndex = -1;
        } else {
            ecommerce.style.left = 0;
            ecommerce.style.borderRadius = '0 50% 50% 0';
            signUpForm.style.zIndex = -1; 
        }
    </script>

    <?php
    include_once('../Database/ecom_db.php');

    if (isset($_POST['sign-up'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $phone_or_email = $_POST['sign-up-phone-or-email'];
        $password = $_POST['sign-up-password'];
        $confirm_password = $_POST['confirm-password'];

        echo "
            <script>
                const firstname = document.getElementById('firstname');
                const lastname = document.getElementById('lastname');
                const signUpPhoneOrEmail = document.getElementById('sign-up-phone-or-email');
                const signUpPassword = document.getElementById('sign-up-password');
                const confirmPassword = document.getElementById('confirm-password');
            </script>
        ";
    
        if (is_numeric($phone_or_email)) {
            $SQL_SELECT_customers = "SELECT phone FROM customers WHERE phone = '$phone_or_email'";
            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);

            if (!$QUERY_SELECT_customers) die;

            $TABLE_customers = mysqli_fetch_array($QUERY_SELECT_customers);

            if (!$TABLE_customers['phone']) {
                if ($password != $confirm_password) {
                    echo "
                        <script>
                            firstname.value = '$firstname';
                            lastname.value = '$lastname';
                            signUpPhoneOrEmail.value = '$phone_or_email';
                            signUpPassword.value = '$password';
                            confirmPassword.value = '$confirm_password';

                            const signUpPassNotif = document.getElementById('sign-up-pass-notif');
                            signUpPassNotif.style.display = 'block';
                        </script>
                    ";                
                } elseif (strlen($password) < 8) {
                    echo "
                        <script>
                            firstname.value = '$firstname';
                            lastname.value = '$lastname';
                            signUpPhoneOrEmail.value = '$phone_or_email';
                            signUpPassword.value = '$password';
                            confirmPassword.value = '$confirm_password';

                            const signUpWeakPassNotif = document.getElementById('sign-up-weak-pass-notif');
                            signUpWeakPassNotif.style.display = 'block';
                        </script>
                    ";
                } elseif ($password == $confirm_password && strlen($password) >= 8) {
                    $options = [
                        'cost' => 10,
                    ];
    
                    $hashed_pass = password_hash($password, PASSWORD_BCRYPT, $options);
    
                    $SQL_INSERT_customers = "INSERT INTO customers(firstname, lastname, phone, `password`) VALUES ('$firstname', '$lastname', '$phone_or_email', '$hashed_pass')";
                    $QUERY_INSERT_customers = mysqli_query($connect, $SQL_INSERT_customers);
    
                    if (!$QUERY_INSERT_customers) die;
                    $_SESSION['name'] = $firstname . ' ' . $lastname;
                    $_SESSION['user'] = $phone_or_email;
    
                    echo "
                        <script>
                            window.open('../Home/', '_self'); 
                        </script>
                    ";
                }
            } else {
                echo "
                    <script>
                        firstname.value = '$firstname';
                        lastname.value = '$lastname';
                        signUpPhoneOrEmail.value = '$phone_or_email';
                        signUpPassword.value = '$password';
                        confirmPassword.value = '$confirm_password';
                        
                        const signUpAccountNotif = document.getElementById('sign-up-account-notif');
                        signUpAccountNotif.style.display = 'block';
                    </script>
                ";
            }
        } else {
            $SQL_SELECT_customers = "SELECT email FROM customers WHERE email = '$phone_or_email'";
            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);

            if (!$QUERY_SELECT_customers) die;

            $TABLE_customers = mysqli_fetch_array($QUERY_SELECT_customers);

            if (!$TABLE_customers['email']) {
                if ($password != $confirm_password) {
                    echo "
                        <script>
                            firstname.value = '$firstname';
                            lastname.value = '$lastname';
                            signUpPhoneOrEmail.value = '$phone_or_email';
                            signUpPassword.value = '$password';
                            confirmPassword.value = '$confirm_password';

                            const signUpPassNotif = document.getElementById('sign-up-pass-notif');
                            signUpPassNotif.style.display = 'block';
                        </script>
                    ";                
                } elseif (strlen($password) < 8) {
                    echo "
                        <script>
                            firstname.value = '$firstname';
                            lastname.value = '$lastname';
                            signUpPhoneOrEmail.value = '$phone_or_email';
                            signUpPassword.value = '$password';
                            confirmPassword.value = '$confirm_password';

                            const signUpWeakPassNotif = document.getElementById('sign-up-weak-pass-notif');
                            signUpWeakPassNotif.style.display = 'block';
                        </script>
                    ";
                } elseif ($password == $confirm_password && strlen($password) >= 8) {
                    $options = [
                        'cost' => 10,
                    ];
    
                    $hashed_pass = password_hash($password, PASSWORD_BCRYPT, $options);
    
                    $SQL_INSERT_customers = "INSERT INTO customers(firstname, lastname, email, `password`) VALUES ('$firstname', '$lastname', '$phone_or_email', '$hashed_pass')";
                    $QUERY_INSERT_customers = mysqli_query($connect, $SQL_INSERT_customers);
    
                    if (!$QUERY_INSERT_customers) die;
                    $_SESSION['name'] = $firstname . ' ' . $lastname;
                    $_SESSION['user'] = $phone_or_email;
    
                    echo "
                        <script>
                            window.open('../Home/', '_self'); 
                        </script>
                    ";
                }
            } else {
                echo "
                    <script>
                        firstname.value = '$firstname';
                        lastname.value = '$lastname';
                        signUpPhoneOrEmail.value = '$phone_or_email';
                        signUpPassword.value = '$password';
                        confirmPassword.value = '$confirm_password';
                        
                        const signUpAccountNotif = document.getElementById('sign-up-account-notif');
                        signUpAccountNotif.style.display = 'block';
                    </script>
                ";
            }
        }
    }

    if (isset($_POST['sign-in'])) {
        $phone_or_email = $_POST['sign-in-phone-or-email'];
        $password = $_POST['sign-in-password'];

        echo "
            <script>
                const signInPhoneOrEmail = document.getElementById('sign-in-phone-or-email');
                const signInPassword = document.getElementById('sign-in-password');
            </script>
        ";

        if (is_numeric($phone_or_email)) {
            $SQL_SELECT_customers = "SELECT firstname, lastname, phone, `password` FROM customers WHERE phone = '$phone_or_email'";
            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);

            if (!$QUERY_SELECT_customers) die;

            $TABLE_customers = mysqli_fetch_array($QUERY_SELECT_customers);

            if (!$TABLE_customers['phone']) {
                echo "
                    <script>
                        signInPhoneOrEmail.value = '$phone_or_email';

                        const signInAccountNotif = document.getElementById('sign-in-account-notif');
                        signInAccountNotif.style.display = 'block';
                    </script>
                ";
            } else {
                if (password_verify($password, $TABLE_customers['password'])) {
                    $_SESSION['name'] = $TABLE_customers['firstname'] . ' ' . $TABLE_customers['lastname'];
                    $_SESSION['user'] = $phone_or_email;

                    echo "
                        <script>
                            window.open('../Home/', '_self');
                        </script>
                    ";
                } else {
                    echo "
                        <script>
                            signInPhoneOrEmail.value = '$phone_or_email';

                            const signInPassNotif = document.getElementById('sign-in-pass-notif');
                            signInPassNotif.style.display = 'block';
                        </script>
                    ";
                }
            }
        } else {
            $SQL_SELECT_customers = "SELECT firstname, lastname, email, `password` FROM customers WHERE email = '$phone_or_email'";
            $QUERY_SELECT_customers = mysqli_query($connect, $SQL_SELECT_customers);

            if (!$QUERY_SELECT_customers) die;

            $TABLE_customers = mysqli_fetch_array($QUERY_SELECT_customers);

            if (!$TABLE_customers['email']) {
                echo "
                    <script>
                        signInPhoneOrEmail.value = '$phone_or_email';

                        const signInAccountNotif = document.getElementById('sign-in-account-notif');
                        signInAccountNotif.style.display = 'block';
                    </script>
                ";
            } else {
                echo "
                    <script>
                        const signInPhoneOrEmail = document.getElementById('sign-in-phone-or-email');
                        const signInPassword = document.getElementById('sign-in-password');
                    </script>
                ";
                if (password_verify($password, $TABLE_customers['password'])) {
                    $_SESSION['name'] = $TABLE_customers['firstname'] . ' ' . $TABLE_customers['lastname'];
                    $_SESSION['user'] = $phone_or_email;

                    echo "
                        <script>
                            window.open('../Home/', '_self');
                        </script>
                    ";
                } else {
                    echo "
                        <script>
                            signInPhoneOrEmail.value = '$phone_or_email';
                            
                            const signInPassNotif = document.getElementById('sign-in-pass-notif');
                            signInPassNotif.style.display = 'block';
                        </script>
                    ";
                }
            }
        }
    }
    ?>
</body>
</html>
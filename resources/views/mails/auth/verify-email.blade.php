<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Email Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">
        /* styles.css */
        .container {
            background-color: #FAF8F4;
            padding: 20px;
        }

        .inner-container {
            margin: 0 auto;
            max-width: 500px;
        }

        .card {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .text-big {
            font-family: Arial, sans-serif;
            font-size: 18px;
            color: #333333;
        }

        .text-medium {
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333333;
        }

        a.text-link {
            color: #520100;
            text-decoration: none;
            position: relative;
        }

        a.text-link::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 2px;
            background-color: #ffcc00;
            bottom: -4px;
            left: 0;
        }



        .text-small {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #520100;
            margin-bottom: 10px;
        }

    </style>

</head>
<body>
  <div class="container">
      <div class="inner-container">
          <div class="card">
              <p class="text-big">Greetings, {{ $user->name }}!</p>
              <p class="text-medium">Welcome to our platform. To get started, please verify your email address by clicking the link below:</p>
              <a href="#" class="text-link">Verify Email</a>
          </div>
      </div>
      <div style="margin-top: 20px;">
          <p class="text-small">HRIS</p>
          <p class="text-small">Ilocos Sur Polytechnic State College</p>
      </div>
  </div>

</body>
</html>

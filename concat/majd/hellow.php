<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello Page</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        h1 {
            font-size: 2.5rem;
            color: #333;
        }

        p {
            font-size: 1rem;
            color: #555;
            width: 60%;
            line-height: 1.6;
            text-align: center;
            padding: 10px;
         
        }

        .container {
            width: 50%; 
            max-width: 600px; 
            margin-bottom: 20px;
        }

        img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .button-container {
            width: 50%;
            max-width: 600px;
        }

        #one {
            width: 100%;
            background-color: #007BFF; 
            color: white;
            font-size: 1.2rem;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background 0.3s ease-in-out, transform 0.2s;
            display: block;
        }

        #one:hover {
            background-color: #0056b3; 
            transform: scale(1.02);
        }

        #tow {
            width: 100%;
            background-color: #DC3545; 
            color: white;
            font-size: 1.2rem;
            padding: 15px;
            margin: 10px 0;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background 0.3s ease-in-out, transform 0.2s;
            display: block;
        }
        #tow:hover {
            background-color: #a71d2a; 
            transform: scale(1.02);
        }
    </style>
</head>
<body>

    <h1>Hello There!</h1>
    <p>Automative identity verification which enables you to verify your identity.</p>

    <div class="container">
        <img src="images/new.webp" alt="images">
    </div>

    <div class="button-container">
        <a href="Login.php"><button id="one">Login</button></a>
        <a href="signUp.php"><button id="tow">Sign up</button></a>
    </div>
</body>
</html>

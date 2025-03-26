<?php

require_once 'vendor/autoload.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #f9f9f9;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        input[type="file"] {
            display: block;
            margin: 10px auto;
        }
        button,a {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            transition: background-color 0.3s;
        }
        button:hover, a:hover {
            background-color: #0056b3;
        }
        a {

            text-decoration: none;
        }
        .hidden {
            display: none;
        }
    </style>

    <title>LateX to PDF conversion</title>
</head>
<body>

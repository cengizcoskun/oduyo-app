<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
</head>
<body>
<div id="app">
    <payment-component></payment-component>
</div>
</body>
</html>

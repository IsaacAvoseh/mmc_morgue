<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
</head>

<body style="background: #5DC560">
    <center style="margin-top: 200px; color:white">Error: 419 <h1>Redirecting.....</h1>
    </center>
    <script>
        setTimeout(() => {
            window.location.href = "{{ url('/login') }}";
        }, 1000);
    </script>
</body>

</html>

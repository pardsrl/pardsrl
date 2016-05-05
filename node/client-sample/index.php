<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Socket.IO Chat Example</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
</head>
<body>

<pre id="json-output">

</pre>


<script>
    $(function () {
        var socket = io('10.0.0.2:1337');
        socket.on('csvOutput', function (data) {

            console.log('Actualizamos', data);

        });
    });
</script>

</body>
</html>

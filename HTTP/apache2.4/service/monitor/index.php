<html lang="pt-br">
<head>

    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">

    <style>
        body {
            background-color: #000;
            color: #FFF;
            font-family: Candara, serif;
            font-size: 12px
        }

        table {
            border: 1px solid red;
        }

        td {
            border: 0.1px dotted #8d8d8d;
            color: #FFF;
            font-size: 12px
        }
    </style>

    <title>Apache Status</title>
</head>
<body>
<code>
    <div id="status"></div>
</code>

<script>

    let xhttp = new XMLHttpRequest()

    setInterval(function () {

        xhttp.open("GET", "http://localhost:8888/server-status", false)
        xhttp.send()

        document.getElementById("status").innerHTML = xhttp.responseText;

    }, 1000)

</script>

</body>
</html>
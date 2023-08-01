<html lang="pt-br">
    <head>
		<!-- Define a formatacao da pagina -->
        <style>
            body {
				background-color: #000;
				color: #FFF;
                font-family: Candara, serif;
				font-size: 12px
			}
        </style>
		
        <!-- Carrega a biblioteca Jquery e executa o LOAD conforme o temporatizador -->
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript">
            setInterval(function () {
                $('#js').load('http://localhost:83/basic_status');
            }, 1000);
        </script>
        <title></title>
    </head>
    <body>
    <code>
        <div id="js"></div>
    </code>
    </body>
</html>
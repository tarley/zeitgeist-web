<!DOCTYPE html>
<html lang="pt-br">
    <head>
    
    <meta charset="utf-8">
    <title>ZeitGeist - CONTATO</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="assets/materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="assets/css/style.css">
    
    </head>
    <div align="justify" class="content" ng-controller="MainCtrl as main">
    		<h3>Formulário de Contato</h3>
        
        <!-- Formulário de contato -->
		<form method="POST" action="envioEmail/processa.php">
			<label>Nome</label>
			<input type="text" name="nome" placeholder="Nome completo" required="required"><br><br>
			
			<label>Assunto</label>
            <input type="text" name="assunto" placeholder="Qual assunto?" required="required"><br><br>

            <label>Email</label>
			<input type="email" name="email" placeholder="Seu melhor e-mail" required="required"><br><br>
			
			<label>Mensagem</label>
			<textarea name="mensagem" rows="4" cols="50" required="required"></textarea><br><br>
			
			<input type="submit" class="btn btn-blue" value="Enviar"><br><br>
		</form>
    </body>
</html>
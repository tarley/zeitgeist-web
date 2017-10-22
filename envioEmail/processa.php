<!DOCTYPE html>
<!-- Processa o formulário do contato e envia! -->
<html lang="pt-br">
    <head>
        
    <meta charset="utf-8">
    <title></title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="../assets/materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="../assets/css/style.css">
    
    </head>
    
    <div class="content" ng-controller="MainCtrl as main">    
        <!-- Referencia as label do contato.php -->
        <?php
		$nome = $_POST['nome'];
        $assunto = $_POST['assunto'];
		$email = $_POST['email'];
		$mensagem = $_POST['mensagem'];
		
		//Função utilizada pelo PHPMailer
        include("PHPMailer-master/class.phpmailer.php");
        $mail = new PHPMailer();

        //Conexão com e-mail externo - Se utilizar email no próprio registro não necessita
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->Username = 'jornalzeitgeist@gmail.com';
        $mail->Password = 'JornalZeit.';

        //Email igual ao do site
        $mail->From = 'jornalzeitgeist@gmail.com';
        $mail->FromName = "$nome";
        
        //Cópia do email será enviada para quem
        $mail->AddAddress($email, $nome);
        $mail->AddCC('cari.roriz@gmail.com');

        //e-mail pode ser HRML
        $mail->IsHTML(true);

    //Assunto da mensagem
    $mail->Subject = $assunto;
    
    //Corpo da Mensagem
    $mail->Body = $mensagem;

        $enviado = $mail->Send();

        //script em alerta impossibilando duplicidade em F5
        if ($enviado){
            echo '
                    <script type="text/JavaScript">
                        alert("Seu e-mail foi enviado com sucesso. Obrigado");
                        location.href="../home"
                    </script>
                 ';
        } else {
            echo "Não foi possível enviar o e-mail";
        }

        ?>
    </div>
    </body>
</html>


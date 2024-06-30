<?php

require_once '../req/conex.php';

$_SUCCESS = false;
$_error_ = false;
$_error_msg_ = '';



// Função para verificar se um whatsapp já está cadastrado
function ckNumWhatsapp($mysqli,$value): bool 
{
    // Prepara a consulta SQL para verificar o CNPJ
    $sql = "SELECT numero_whatsapp FROM usuario WHERE numero_whatsapp = ?";
    $stmt = $mysqli->prepare($sql);
    // Vincula o parâmetro à consulta preparada
    $stmt->bind_param("s", $value);
    // Executa a consulta
    $stmt->execute();
    // Armazena o resultado
    $stmt->store_result();
    // Verifica se o CNPJ já está cadastrado
    $_existente = $stmt->num_rows > 0;
    // Fecha a consulta e a conexão
    $stmt->close();
    return $_existente;
} 

if(isset($_POST['btProximo'])){
    if(strlen($_POST['value']) == 0) 
    {
        $_error_ = true;
        $_error_msg_ = 'Preencha seu numero';
    }else{

        $numWhatsapp = $mysqli->real_escape_string($_POST['value']);
        $numWhatsapp = preg_replace('/\D/', '', $numWhatsapp);

        // verifica se o email ja esta cadastrado para este usuario
        if( $_error_ != true)
        {
            if (ckNumWhatsapp($mysqli,$numWhatsapp)) {
                $_error_ = true;
                $_error_msg_ = 'Whatsapp já cadastrado';
            } 
        }         

        if( $_error_ != true)
        {
            setcookie('register_whatsapp',$numWhatsapp, time() + (86400 * 30), "/");
            $_SUCCESS = true; 
        }
    } 
}
if($_error_ == True){$show_alert = 'True';}else{$show_alert = 'False';}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Criar conta | One</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel='stylesheet' type='text/css' media='screen' href='../assets/css/main.css'>
    <!--boxicon-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>    
    <style>
        *{
            background-color: #a8ff03;
        }
        .logo{
            height: 45%;
            position: relative;
            float: left;
            top: 20px; left: 15px;
        }
        p{
            position: relative; float: left;
            left: 25px;
            color: #6ca304;
        }
        .input{
            height: 100%; width: 100%;
            border: none;
            border-bottom: 1px solid #a3e030;
            font-size: 22px;
            font-weight: 600;
        }
        label{
            position: relative;
            left: 25px; 
            font-weight: 600;
        }        
        button{
            width: 100%;
            height: 100%;
            border: 0px none;
            background-color: #c4ff53;
            font-size: 18px;
            font-family: "Roboto", sans-serif;
            font-weight: 600;           
        }
        button i{
            font-size: 25px;
            position: relative; top: 5px;
            background-color: #c4ff53;
        }        
    </style>
</head>
<body>
    <form action="#" method="POST">
        <div style="height:100px; width: 100%;">
            <img class="logo" src="../assets/img/logo.png" />
        </div>
        <div style="height:20px; width: 100%;">
            <label>Criar conta</label>
        </div>          
        <div style="height:80px; width: 100%;"></div>
        <div style="height:20px; width: 100%;">
            <p>Numero whatsapp:</p>
        </div>
        <div style="height:10px; width: 100%;"></div>
        <div style="height:50px; width: 100%; padding-left: 25px; padding-right: 25px;">
            <input class="input" type="text" name="value" id="value">
        </div>
        <div style="height: 70px; border: none;" class="b-main-container-footer">
            <button name="btProximo" type="submit">Proximo<i class='bx bx-chevron-right'></i></button>
        </div>
    </form>
    <?php 
        if($_SUCCESS == true){
            //echo('<label class="roboto-light">✅ Sucesso os dados foram salvo na base de dados</label>');
        }
        if($_error_ == true){
            echo('<label class="roboto-light">⚠️ '.$_error_msg_.'</label>');
        }     
        
        if (($_error_ == false) and ($_SUCCESS == true)){
            $redirect_url = urldecode($_GET['redirect']);
            echo "<script type='text/javascript'>
                window.parent.location.href = 'user.mobile.senha.php?redirect=".$redirect_url."';
            </script>";         
        }         
    ?>     
</body>
<script>
        // Função para aplicar a máscara de telefone
        function aplicarMascaraTelefone(event) {
            // Obtém o valor atual do campo de entrada
            let input = event.target;
            let valor = input.value;
            
            // Remove tudo exceto números
            valor = valor.replace(/\D/g, '');
            
            // Aplica a máscara
            if (valor.length > 0) {
                valor = "(" + valor.substring(0, 2) + ") " + valor.substring(2, 3) + " " + valor.substring(3, 7) + "-" + valor.substring(7, 11);
            }
            
            // Atualiza o valor do campo de entrada
            input.value = valor;
        }
        
        // Seleciona o campo de entrada
        let campoTelefone = document.getElementById("value");
        
        // Adiciona um ouvinte de evento para detectar mudanças no campo de entrada
        campoTelefone.addEventListener("input", aplicarMascaraTelefone);
    </script>
</html>
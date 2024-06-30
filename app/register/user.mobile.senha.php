<?php
require_once '../req/conex.php';

$_SUCCESS = false;
$_error_ = false;
$_error_msg_ = '';
// zera variaveis
$numWhatsapp = '';
$nome        = '';
$email       = '';

if(isset($_POST['btProximo']))
{

    $numWhatsapp = $mysqli->real_escape_string($_COOKIE['register_whatsapp']);
    $nome        = $mysqli->real_escape_string($_COOKIE['register_nome']);
    $email       = $mysqli->real_escape_string($_COOKIE['register_email']);
    $senha       = $mysqli->real_escape_string($_POST['value']);
    $senha = md5($senha);
    $numWhatsapp = preg_replace('/\D/', '', $numWhatsapp);

    if(strlen($email) == 0) {
        $_error_ = true;
        $_error_msg_ = 'Preencha seu e-mail';
    } else if(strlen($senha) == 0) {
        $_error_ = true;
        $_error_msg_ = 'Preencha sua senha';
    } else if(strlen($numWhatsapp) == 0){
        $_error_ = true;
        $_error_msg_ = 'Não foi informado o numero do whatsapp';
    } else if(strlen($nome) == 0){
        $_error_ = true;
        $_error_msg_ = 'Não foi informado o nome';
    }  

    // Função para verificar se um CNPJ já está cadastrado
    function ckNumWhatsapp($mysqli,$value): bool {
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
    // Função para verificar se um email está cadastrado
    function ckEmail($mysqli,$value): bool {
        // Prepara a consulta SQL para verificar o CNPJ
        $sql = "SELECT email FROM usuario WHERE email = ?";
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

    // verifica se o email ja esta cadastrado para este usuario
    if( $_error_ != true){
        if (ckEmail($mysqli,$email)) {
            $_error_ = true;
            $_error_msg_ = 'Email já cadastrado';
        } 
    }    
    // verifica se o email ja esta cadastrado para este usuario
    if( $_error_ != true){
        if (ckNumWhatsapp($mysqli,$numWhatsapp)) {
            $_error_ = true;
            $_error_msg_ = 'Numero de whatsapp já esta cadastrado';
        }  
    }   
    
    if( $_error_ != true){
        // Prepara a consulta SQL para inserção dos dados
        $sql = "INSERT INTO usuario (nome, numero_whatsapp, email, status,cod_validate_whatsapp,senha,cidade_id)  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        if (!$stmt) {
            echo "Erro na preparação da consulta: " . $conn->error;
            return -1;
        }
        // Vincula os parâmetros à consulta preparada
        $status = 'pending_validate_whatsApp';
        $idCidade = 1;
        $codigo = mt_rand(100000, 999999);
        $stmt->bind_param("sssssss", $nome, $numWhatsapp, $email, $status, $codigo, $senha, $idCidade);
        // Executa a consulta
        if ($stmt->execute()) {
            $id_user = $mysqli->insert_id; // Obtém o ID do registro inserido
            $_SUCCESS = true;
            setcookie('authorization_type','user', time() + (86400 * 30), "/");
            setcookie('authorization_id',$id_user, time() + (86400 * 30), "/");

            if(!isset($_GET['redirect'])){$redirect='null';}
            else{$redirect=$_GET['redirect'];}

        } else {
            echo "Erro na inserção de dados: " . $stmt->error;
        }
        $stmt->close();  
    } 


}
if($_error_ == true){$show_alert = 'True';}else{$show_alert = 'False';}
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
            <p>Senha:</p>
        </div>
        <div style="height:10px; width: 100%;"></div>
        <div style="height:50px; width: 100%; padding-left: 25px; padding-right: 25px;">
            <input class="input" type="password" name="value">
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
            echo "<script type='text/javascript'>
                window.parent.location.href = 'validate_whatsapp.php?redirect=".urlencode($redirect)."';
            </script>";
        }         
    ?>    
</body>
</html>
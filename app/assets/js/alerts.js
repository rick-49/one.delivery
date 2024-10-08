function publicar(){
    Swal.fire({
        html: `
            <br>
            <iframe src="login.php?type=company" class="janela-publicar" title="Crie ou acesse sua conta"></iframe>
        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        title:'Acesse sua conta',
        width: 400
    });     
}
function produtoDetalhe(id,loja){
    Swal.fire({
        html: `
            <br>
            <iframe src="./venda/produto.php?id=`+id+`&loja=`+loja+`" class="janela-produto-detalhe" title="Crie ou acesse sua conta"></iframe>
        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        width: 500
    });      
}
function addProduto(id){
    Swal.fire({
        html: `
            <br>
            <iframe src="produto_add.php?id=`+id+`" class="janela-produto-detalhe" title="Crie ou acesse sua conta"></iframe>
        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        width: 500
    });      
}
function trocarEnd(id,loja){
    Swal.fire({
        html: `
            <br>
            <iframe src="select_endereco_venda.php?id_venda=`+id+`" class="janela-produto-detalhe" title="Crie ou acesse sua conta"></iframe>
        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        width: 500
    });      
}
// na pagina de vendas esse alert abre o detalhe do pedido
function pedido_detalhe(id, token){
    Swal.fire({
        html: `
            <br>
            <iframe src="pedido.php?cod=`+id+`&token=`+token+`" class="janela-produto-detalhe" title="Crie ou acesse sua conta"></iframe>
        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        width: 500
    });      
}
// 
function logoEmpresa(){
    Swal.fire({
        html: `
            <br>
            <iframe src="logo.php" class="janela-logo" title="Crie ou acesse sua conta"></iframe>
        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        width: 500
    });  
    $('.drop-down').toggleClass('drop-down--active');    
}
// troca status do pedido
function pedido_status(id){
    Swal.fire({
        html: `
            <br>
            <iframe src="pedido_status.php?cod=`+id+`" class="janela-pedido_status" title="Crie ou acesse sua conta"></iframe>
        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        width: 500
    });      
}

// menu do produto
function produto_menu(id){
    Swal.fire({
        html: `
            <br>
            <iframe src="produto_menu.php?id=`+id+`" class="janela-produto-menu" title="Crie ou acesse sua conta"></iframe>
        `,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        showConfirmButton: false,
        width: 500
    });      
}
function isMobile() {
    // Expressão regular para identificar dispositivos móveis
    const mobileRegex = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i;
    
    // Verifica o userAgent do navegador
    return mobileRegex.test(navigator.userAgent);
}


// abrir janela de cadastro de usuario apartir do menu
function criar_usuario_menu(url){
    if (isMobile()) {
        window.location.href = 'register/user.mobile.nome.php?'+url;
    }else{
        Swal.fire({
            html: `
                <br>
                <iframe src="register/user.mobile.nome.php?`+url+`" class="janela-criar-usuario-menu" title="Criar conta de usuario"></iframe>
            `,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            showConfirmButton: false,
            width: 500
        }); 
    }
    $('.drop-down').toggleClass('drop-down--active');     
}

// abrir janela de log-in usuario a apartir do menu
function entrar_usuario_menu(url){
    if (isMobile()) {
        window.location.href = 'register/login.mobile.phone.php?'+url;
    }else{
        Swal.fire({
            html: `
                <br>
                <iframe src="login.php?type=user&`+url+`" class="janela-publicar" title="Log-in usuario"></iframe>
            `,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            showConfirmButton: false,
            width: 400
        }); 
    }
    $('.drop-down').toggleClass('drop-down--active');     
}

function open_login(url){
    if (isMobile()) {
        window.parent.location.href = '../login.php?type=user&redirect='+url;
        
    }else{
        window.location.href = '../login.php?type=user&redirect='+url;
    }
}
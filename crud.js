$(document).ready('load', function(e){
    var h,w;
    h = $(document).height() - $('#myTab').height() -1;
    w = $(document).width();
    $('#fundo').css('height', h).css('width', w);
});

$('#repete_senha').on('blur', 
    function() {
        let senha = $('#senha').val();
        let senha2 = $('#repete_senha').val()        
        if ((senha != senha2) && (senha != "" || senha2 != "")) {
            alert('As senhas não conferem!');
            $('#repete_senha').val("");
            $('#senha').val("");
        }
    }
);

  setTimeout(()=> $('#mensagem_cadastro').hide(1000), 3000);
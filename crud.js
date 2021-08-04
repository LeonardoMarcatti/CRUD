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
        };
    }
);

setTimeout(() => {
   $('#mensagem').fadeOut(500);
   $('#flash').hide(500);
}, 1000);

jQuery("input.telefone")
        .mask("(99) 9999-9999?9")
        .focusout(function (event) {  
            var target, phone, element;  
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;  
            phone = target.value.replace(/\D/g, '');
            element = $(target);  
            element.unmask();  
            if(phone.length > 10) {  
                element.mask("(99) 99999-999?9");  
            } else {  
                element.mask("(99) 9999-9999?9");  
            }  
        });

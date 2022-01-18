$(document).ready('load', function(e){
    var h,w;
    h = $(document).height() - $('#myTab').height() -1;
    w = $(document).width();
    $('#fundo').css('height', h).css('width', w);
});

$('#pass2').on('blur', 
    function() {
        let pass = $('#pass').val();
        let pass2 = $('#pass2').val()        
        if ((pass != pass2) && (pass != "" || pass2 != "")) {
            alert('As senhas não conferem!');
            $('#pass2').val("");
            $('#pass').val("");
        };
    }
);

$(document).ready(function () { 
    setInterval(() => {
        $('#flashBarra').fadeOut(500);
    }, 2000);
});


$('#telefone').mask('0000-0000');
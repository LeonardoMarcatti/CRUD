$(document).ready(function () {
    $.ajax({
        type: "post",
        url: "../Controller/clientsTable.php",
        success: function (response) {
            let list = JSON.parse(response);
            $.each(list, function (i, v) {
                $('tbody').append(
                    `<tr><th scope="row"><a href="details.php?id=${v.id}">${v.id}</a></th><td><a href="details.php?id=${v.id}">${v.name}</a></td><td><a href="exclude.php?del=${v.id}"><i class="fas fa-trash-alt"></i></a></</td></tr>`
                );
            });
        }
    });
});

$('#consulta_clientes_form').on('submit', function(p){
    p.preventDefault();
    $.ajax({
        type: "post",
        url: "../Controller/clientsTable.php",
        data: $(this).serialize(),
        beforeSend: () => { 
            console.log($(this).serialize());
         },
        success: function (response) {
            let list = JSON.parse(response);
            console.log(list);
            $('tbody').html('');
            $.each(list, function (i, v) {
                $('tbody').append(
                    `<tr><th scope="row"><a href="details.php?id=${v.id}">${v.id}</a></th><td><a href="details.php?id=${v.id}">${v.name}</a></td><td><a href="exclude.php?del=${v.id}"><i class="fas fa-trash-alt"></i></a></</td></tr>`
                );
            });
        }
    });
});
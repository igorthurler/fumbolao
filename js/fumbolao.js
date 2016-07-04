
window.onload = function() {
    /*document.getElementById('aceitaTermos').checked = false;
    document.getElementById('enviar').disabled = true;
    var segmentos = document.getElementsByName('segmento');
    segmentos[0].checked = true;
    carregarSerieAno('1');*/
};

$(document).ready( function() {
    $("#frmPalpite").validate({
        rules:{            
            emailParticipante:{
                required: true,
                email: true
            }            
        },        
        show: {when: {event: 'none'}, ready: true},
        hide: {when: {event: 'keydown'}},
        messages:{
            emailParticipante:{
                required: "Campo obrigatório",
                email: "Informe um e-mail válido"
            }
        }
    });
    
    $("#partidas").on("keypress", "input:text", function(e){
        
        var target = $(e.target).attr('id');

        $("#partidas").find("input:text").each(function(i, item){
            
            var obj = $(item).attr('id');
			
            if (target != obj) {
				$(item).val('');
            };
        });
    });    
});
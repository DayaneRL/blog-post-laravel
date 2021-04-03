/*
*Função para impedir bug nos níveis do usuario
*/
$(document).ready(function(){
    if($('#roles')){
        first = '';
        
        if($('#user_id').val()){
            $('#roles').find('input').each(function(){
                if($(this).prop('checked')==false && first==''){ //se nao encontrou o primeiro checkbox checked, desabilita botao
                    $(this).addClass('dis-able')
                }
                if($(this).prop('checked')==true && first==''){ //define o primeiro checkbox checked
                    first=$(this);
                }
                if(first !='' && $(this).attr('id') > first.attr('id')){ //definem todos os seguintes como desabilitados
                    if($(this).prop('checked')==true){
                        $(this).addClass('dis-able')
                    }
                }
            })
        }
    }
})

/*
* Função que manipula os níveis quando clicado
*/
$('.icheck').click(function(){
    this_id = $(this).attr('id');
    clicked = this;
    $(this).parents('#roles').find('input').each(function(){
        if($(this).attr('id') > this_id){
            $(this).prop('checked', !$(this).prop("checked"));

            if($(this).prop('checked')==true){
                $(this).addClass('dis-able')
            }
            else{
                if($(this).hasClass('dis-able')) $(this).removeClass('dis-able');
            }
            
        }else if($(this).attr('id') < this_id){
            if($(clicked).prop('checked')==true){
                
                $(this).parents('.chb').hide();
            }else{
                $(this).parents('.chb').show();
                if($(this).hasClass('dis-able')) $(this).removeClass('dis-able');
            }
        }
    })
})

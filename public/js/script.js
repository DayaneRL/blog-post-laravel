$(document).ready(function(){
    if($('#send-comment')){
        $('#send-comment').attr('disabled', true);
    }
})
$(document).on('keyup', '#comment', function(e, element){
    if($(e.target).val().length >= 5){
        $('#send-comment').attr('disabled', false);
    }else{
        $('#send-comment').attr('disabled', true);
    }
})

$(document).on('click', '#send-comment', function(e){
    $('#send-comment').attr('disabled', true);
    addComment()
})

$(document).on('click', '.comment-btn', function(e){
    if($(e.target).find('.icon-btn').hasClass('fa-angle-right')){
        $(e.target).find('.icon-btn').attr('class', 'fas fa-angle-down float-right icon-btn')
    }else if($(e.target).find('.icon-btn').hasClass('fa-angle-down')){
        $(e.target).find('.icon-btn').attr('class', 'fas fa-angle-right float-right icon-btn')
    }
})

function addComment(){
    var txtcomment = $('#comment').val();
    var idpost = $('#post_id').val();
    let token =  $('.fazer-comentario').find("[name=_token]").val();
    if(txtcomment.length>0){
        $.ajax({
            url: window.location.origin+'/comentario/store/'+txtcomment+'/'+idpost,
            type: 'POST', 
            data: {'_token': token}, 
            dataType: 'json',
            success: function(response){
                if(response.deucerto){
                    
                    if($('#comentarios').find('.comment-btn').length==0){
                        $('#comentarios').prepend('<a class="btn btn-secondary text-center comment-btn" data-toggle="collapse" href="#collapseComment" role="button" aria-expanded="false" style="width:100%">Comentários<i class="fas fa-angle-down float-right icon-btn"></i></a><div class="collapse show" id="collapseComment"></div>');
                    }
                    if(!$('#collapseComment').hasClass('show')){
                        $('.comment-btn').click();
                    }

                    $('#collapseComment').append(
                        '<div class="comentario col-md-12 offset-md-0"><div class="row" style="padding: 8px"><div class="col-12 col-md-2 mt-1 text-center pl-5"><i class="fas fa-user-circle fa-3x m-2"></i></div><div class="card col-12 col-md-9 comentario-area"><div class="card-header align-items-center justify-content-between small"><div><a href="'+window.location.origin+'/user/'+response.autorid+'" class="mr-1">'+response.autornome+'</a>&middot;<i class="far fa-calendar-alt mr-1 ml-1"></i>'+response.created_at+'<input type="hidden" value="'+response.idcriado+'" id="comment_id"/><button class="btn btn-default float-right pb-0 pt-0" id="del-comment"><i class="fas fa-trash"></i></button></div> </div> <div class="card-body row-comment"><p>'+txtcomment+'</p></div></div></div></div>');
                    $('#comment').val('');

                    $(".alert-success-box").remove();
                    $('#collapseComment').append('<div class="alert-success alert-success-box col-md-9 offset-md-2">'+response.deucerto+'</div>')
                    $('.alert-success-box').fadeTo(2000, 500).slideUp(500);

                } else{
                    $(".alert-danger-box").remove();
                    $('#comentarios').append('<div class="alert-danger alert-danger-box  col-md-10 offset-md-1" >'+response.erro+'</div>')
                    $('.alert-danger-box').fadeTo(2000, 500).slideUp(500);
                    console.log(response.erro);
                }
            }
        });
    }
}


$(document).on('click', '#del-comment', function(e){
    $.confirm({
        title: 'Atenção !',
        content: 'Você tem certeza que deseja realizar esta ação ?',
        buttons: {
            confirmar: function () {
                id = $(e.target).parents('.card-header').find('#comment_id').val()
                apagarComentario(id, e.target);
            },
            cancelar: function () {
                //
            },
        }
    });
  
})

function apagarComentario(id, element){
    let token =  $("[name=_token]").val()

    $.ajax({
        url: window.location.origin+'/comentario/destroy/'+id,
        type: 'DELETE',
        data: {'_token': token, 'id': id}, //isso que vai para o php
        dataType: 'json',
        success: function(response){
            if(response.deucerto){
                $(element).parents('.comentario').fadeOut('slow');

                if(response.count_comments == 0){
                    $('.commen-btn').fadeOut('slow');
                    $('.comment-btn').remove();
                }

            } else{
                $(".alert-danger-box").remove();
                $('#comentarios').append('<div class="alert-danger alert-danger-box col-md-10 offset-md-1" >'+response.erro+'</div>')
                $('.alert-danger-box').fadeTo(2000, 500).slideUp(500);
                console.log(response.erro);
            }
            
        }
    });
}

// ----------------------------------------------------------------------

$(document).on('click', '.input-img-edit', function(){
    $('.div-imagem').find('.input-group').remove();
    $('.div-imagem').append('<div class="input-group"><input type="file" class="form-control p-1" id="imagem" name="image" ><div class="input-group-append"><div class="input-group-text p-0" style="background-color: #fff;"><button type="button" class="btn btn-default input-img-del float-right pt-1"><i class="far fa-trash-alt p-0"></i></button></div></div></div>');
})

$(document).on('click', '.input-img-del', function(){
    $('.div-imagem').find('.input-group').remove();
    $('.div-imagem').append('<input type="text" class="form-control p-1" id="imagem" readonly  value=" " name="image">');
})

// -----------------------------------------------------------------

//Função para para destroys
$(document).on('click', '#post-del', function(){
    botao = this;
    $.confirm({
        title: 'Atenção !',
        content: 'Você tem certeza que deseja realizar esta ação ?',
        buttons: {
            confirmar: function () {
                form = $(botao).parents('#form-delete');
                form.submit();
            },
            cancelar: function () {
                //
            },
        }
    });
})


/*
function editarComentario(id){
    console.log(id)
    $('div[data-id-comentario='+id+'] .textocomentario p').attr('contenteditable', 'true')
    $('div[data-id-comentario='+id+'] .textocomentario p.texto').after('<p class="bteditar"><a href="javascript:;" onclick="salvarEdicao('+id+')">Salvar</a> <span onclick="cancelarEdicao('+id+')">Cancelar</span></p>')
    $('div[data-id-comentario='+id+'] .textocomentario p.texto').addClass('editavel')
}

function salvarEdicao(id){
    var texto = $('div[data-id-comentario='+id+'] .textocomentario p.texto').text();
    console.log(texto)
    $.ajax({
        url: 'ajax/editarcomentario.php',
        type: 'POST',
        data: {'id': id, 'texto': texto}, //isso que vai para o php
        dataType: 'json',
        success: function(response){
            if(response.deucerto){
                $('div[data-id-comentario='+id+'] .textocomentario p.bteditar').remove();
                $('div[data-id-comentario='+id+'] .textocomentario p.texto').removeClass('editavel')
                $('div[data-id-comentario='+id+'] .textocomentario p.texto').removeAttr('contenteditable')
                meualerta('success',response.mensagem);
                
            } else{
                meualerta('error',response.mensagem);
                console.log(response.erro);
            }	
        }
    });
}

function cancelarEdicao(id){
    $('div[data-id-comentario='+id+'] .textocomentario p.bteditar').remove();
    $('div[data-id-comentario='+id+'] .textocomentario p.texto').removeClass('editavel')
    $('div[data-id-comentario='+id+'] .textocomentario p.texto').removeAttr('contenteditable')
}
*/
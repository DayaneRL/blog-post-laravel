$(document).ready(function(){
    loadCroppie();
})

function loadCroppie(){
    $uploadCrop = $('#upload-image').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary: {
            width: 230,
            height: 230
        }
    });
}


$(document).on('change','#imagem', function () { 
	var reader = new FileReader();
    reader.onload = function (e) {
    	$uploadCrop.croppie('bind', {
    		url: e.target.result
        })
        .then(function(){
            console.log('imagem carregada');
    	});
    }
   
    reader.readAsDataURL(this.files[0]);
});


$(document).on('click','.upload', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {

        let id= $('#id_user').val();
        let token =  $("[name=_token]").val();
        let imagem = $('#imagem');
        $.ajax({
            url: window.location.origin+"/user/"+id+"/imagem/upload",
            type: "PATCH",
            data: {'_token': token,'file': resp},
            success: function (data) {
                console.log(data.deucerto)
                $('#modal_image').find('.close').click();
                $('.profile-user-img').attr('src', window.location.origin+'/storage/categories/'+data.nomeCriado);

                $('.card').before('<div class="alert-success alert-success-box mb-3">'+data.deucerto+'</div>')
                $('.alert-success-box').fadeTo(1500, 500).slideUp(400);
            }
        });
    });
});

$('#del-image').on('click', function (ev) {
    $.confirm({
        title: 'Atenção !',
        content: 'Você tem certeza que deseja deletar a imagem ?',
        buttons: {
            confirmar: function () {
                delImage();
               
            },
            cancelar: function () {
                //
            },
        }
    })
});

$('#del-comment').on('click', function(e){
    $.confirm({
        title: 'Atenção !',
        content: 'Você tem certeza que deseja realizar esta ação ?',
        buttons: {
            confirmar: function () {
                form = $(e.target).parents('form');
                form.submit();
            },
            cancelar: function () {
                //
            },
        }
    });
})

function delImage(){
    let id= $('#id_user').val();
    let token =  $("[name=_token]").val();

    $.ajax({
        url: window.location.origin+"/user/"+id+"/imagem/delete",
        type: "DELETE",
        data: {'_token': token,'id': id},
        success: function (data) {
            console.log(data.deucerto)
            $('.col-image').find('p, button').remove()
            $('.col-image').append('<strong>Select Image:</strong><br/><input type="file" id="imagem" name="image"><br/><button type="button" class="btn btn-success upload">Upload Image</button>');
            $('#upload-demo-i').remove()
            $('.col-modal-croppie').append('<div id="upload-image"></div>');
            loadCroppie();
        }
    });
}
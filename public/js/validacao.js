$(document).ready(function(){
    
    var validate = $("#formPOST").validate(
      {
        rules:{
            titulo: {
                required: true,
                minlength: 10,
                maxlength: 200,
            },
            autor: {
                required: true,
                minlength: 5,
                maxlength: 100,
            },
            tipo_post: {
                required: true,
                minlength: 2,
            },
            post: {
                required: true,
                minlength: 20,
                maxlength: 400
            }
        },
        messages:{
            titulo:{
                required:"Esse campo não pode ser vazio",
                minlength: "Obrigatório pelo menos 10 caracteres",
                maxlength: "Apenas até 200 caracteres"
            },
            autor: {
                required: "Esse campo não pode ser vazio",
                minlength:"Obrigatório pelo menos 5 caracteres",
                maxlength: "Apenas até 100 caracteres"
            },
            tipo_post: {
                required: "Esse campo não pode ser vazio",
                minlength:"Obrigatório selecionar alguma opção",
            },
            post: {
                required: "Esse campo não pode ser vazio",
                minlength:"Obrigatório pelo menos 20 caracteres",
                maxlength: "Apenas até 400 caracteres"
            }
        },
  
      }
    );
    console.log(validate.rules)
    //----------------------
    //----user-validation---
    $("#formUser").validate(
        {
            errorElement:"span",
            submitHandler: function(form){
            form.submit();
            },
            rules:{
                name: {
                    required: true,
                    minlength: 5,
                    maxlength: 50,
                    string: true,
                },
                email:{
                    required: true,
                    minlength: 10,
                    maxlength: 50,
                    email: true,
                    unique: true,
                },
                password:{
                    required: true,
                    minlength: 8,
                },
                "password_confirmation":{
                    required: true,
                    minlength: 8,
                },
                "roles[]":{
                    required: true,
                },
            },
            messages:{
                name:{
                    required: "Esse campo não pode ser vazio",
                    minlength:"Obrigatório pelo menos 5 caracteres",
                    maxlength: "Apenas até 50 caracteres",
                    string: "Esse campo deve ser do tipo string"
                },
                email: {
                    required: "Esse campo não pode ser vazio",
                    minlength:"Obrigatório pelo menos 10 caracteres",
                    maxlength: "Apenas até 50 caracteres",
                    email: "Insira um email valido",
                    unique: "Esse email já esta cadastrado"
                },
                password:{
                    required: "Esse campo não pode ser vazio",
                    minlength:"Obrigatório pelo menos 8 caracteres",
                },
                "password_confirmation":{
                    required: "Esse campo não pode ser vazio",
                    minlength: "Obrigatório pelo menos 8 caracteres",
                },
                "roles[]":{
                    required: "Esse campo não pode ser vazio",
                }
            }
        }
    )

    $("#formUserEdit").validate(
        {
            errorElement:"span",
            //submitHandler: function(form){
            //form.submit();
            //console.log(form);
            //},
            rules:{
                name: {
                    required: true,
                    minlength: 5,
                    maxlength: 10,
                },
                email:{
                    required: true,
                    minlength: 10,
                    maxlength: 50,
                    email: true,
                    unique: true,
                },
                "roles[]":{
                    required: true,
                },
                if(password){
                    //$("#password_confirmation").attr('required', true);
                }
            },
            messages:{
                name:{
                    required: "Esse campo não pode ser vazio",
                    minlength:"Obrigatório pelo menos 5 caracteres",
                    maxlength: "Apenas até 50 caracteres",
                },
                email: {
                    required: "Esse campo não pode ser vazio",
                    minlength:"Obrigatório pelo menos 10 caracteres",
                    maxlength: "Apenas até 50 caracteres",
                    email: "Insira um email valido",
                    unique: "Esse email já esta cadastrado"
                },
                "roles[]":{
                    required: "Esse campo não pode ser vazio",
                }
            }
        }
    )
})
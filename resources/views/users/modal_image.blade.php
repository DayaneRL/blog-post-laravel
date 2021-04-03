<div id="modal_image"  class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{(empty($img)) ? 'Adicionar':'Editar'}} imagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times align-text-bottom"></i></span>
                </button>
            </div>
            <div class="modal-body">

                <form action="{{route('user.imagem',Auth::user()->id)}}" id="form-imagem" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <div class="col-md-6 col-12 col-modal-croppie">
                            @if(empty($img))
                                <div id="upload-image"></div>
                            @else 
                                <div id="upload-demo-i">
                                    <img src="{{asset('/storage/categories/'.$img)}}" alt="{{ $img }}">
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 col-12 col-image">
                            <input type="hidden" id="id_user" name="id_user" value="{{Auth::user()->id}}">
                            @if(empty($img))
                                <strong>Select Image:</strong>
                                <br/>
                                <input type="file" id="imagem" name="image">
                                <br/>
                                <button type="button" class="btn btn-success upload">Upload Image</button>
                            @else
                                <p>{{$img}}</p>
                                <button type="button" class="btn btn-danger show-shadow" id="del-image">Deletar</button>
                            @endif
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
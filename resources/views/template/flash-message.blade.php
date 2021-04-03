@if ($message = Session::get('success'))
<div class="alert alert-success alert-block" style="margin: 1em 0;">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block" style="margin: 1em 0;">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        <strong>{{ $message }}</strong>
    </div>
@endif

@if(isset($errors) && count($errors)>0)
    <div class="alert text-center mb-1 p-2 alert-danger alert-error" style="margin: 1em 0;">
    <button type="button" class="close" data-dismiss="alert">×</button>    
        @foreach($errors->all() as $erro)
            {{$erro}}<br>
        @endforeach
    </div>
@endif
   
@if ($message = Session::get('warning') || isset($warning))
<div class="alert alert-warning alert-block" style="margin: 1em 0;">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ (Session::get('warning')) ? Session::get('warning') : (($warning) ? $warning : '' ) }}</strong>
</div>
@endif
   
@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif

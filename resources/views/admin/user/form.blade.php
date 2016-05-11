<div class="par control-group {{ $errors->has('username')?'error':'' }}">
    <label class="control-label">Username <small>(Wajib Diisi)</small></label>
    <div class="field">
        {!! Form::text('username',null,['class' => 'input-xxlarge']) !!}
        {!! $errors->first('username','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('name')?'error':'' }}">
    <label class="control-label">Nama <small>(Wajib Diisi)</small></label>
    <div class="field">
        {!! Form::text('name',null,['class' => 'input-xxlarge']) !!}
        {!! $errors->first('name','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('password')?'error':'' }}">
    <label class="control-label">Password <small>(Wajib Diisi)</small></label>
    <div class="field">
        {!! Form::password('password',null,['class' => 'input-xxlarge']) !!}
        {!! $errors->first('password','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group">
    <label class="control-label">Ulangi Password </label>
    <div class="field">
        {!! Form::password('password2',null,['class' => 'input-xxlarge']) !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('email')?'error':'' }}">
    <label class="control-label">Email </label>
    <div class="field">
        {!! Form::text('email',null,['class' => 'input-xxlarge']) !!}
        {!! $errors->first('email','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('type')?'error':'' }}">
    <label class="control-label">Type <small>(Wajib Diisi)</small></label>
    <div class="field">
        {!! Form::hidden('type',null,['id' => 'type', 'class' => 'input-xxlarge']) !!}
        {!! $errors->first('type','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('modules')?'error':'' }}">
    <label class="control-label">Menu <small>(Wajib Diisi)</small></label>
    <div class="field">
        {!! Form::hidden('modules',null,['id' => 'modules', 'class' => 'input-xxlarge', 'multiple']) !!}
        {!! $errors->first('modules','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<p class="stdformbutton">
    <button class="btn btn-primary">Simpan</button>
    <button type="reset" class="btn">Reset</button>
</p>
<div class="par control-group {{ $errors->has('mesin_nama')?'error':'' }}">
    <label class="control-label">Machine Name <small>(Mandatory)</small></label>
    <div class="field">
        {!! Form::text('mesin_nama',null,['class' => 'input-xxlarge']) !!}
        {!! $errors->first('mesin_nama','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('mesin_nomor')?'error':'' }}">
    <label class="control-label">Machine Number <small>(Mandatory)</small></label>
    <div class="field">
        {!! Form::text('mesin_nomor',null,['class' => 'input-xxlarge']) !!}
        {!! $errors->first('mesin_nomor','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('mesin_spindle')?'error':'' }}">
    <label class="control-label">Spindle <small>(Mandatory)</small></label>
    <div class="field">
        {!! Form::text('mesin_spindle',null,['class' => 'input-xxlarge']) !!}
        {!! $errors->first('mesin_spindle','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<p class="stdformbutton">
    <button class="btn btn-primary">Save</button>
    <button type="reset" class="btn">Reset</button>
</p>
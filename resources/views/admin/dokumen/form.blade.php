<div class="par control-group {{ $errors->has('dokumen_file')?'error':'' }}">
    <label class="control-label">File Dokumen <small>(Wajib Diisi)</small></label>
    <div class="field">
        {!! Form::file('dokumen_file',['class' => 'input-xxlarge', 'id' => 'dokumen_file']) !!}
        {!! $errors->first('dokumen_file','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('dokumen_deskripsi')?'error':'' }}">
    <label class="control-label">Deskripsi <small>(Wajib Diisi)</small></label>
    <div class="field">
        {!! Form::text('dokumen_deskripsi',null,['id' => 'dokumen_deskripsi', 'class' => 'input-xxlarge']) !!}
        {!! $errors->first('dokumen_deskripsi','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group {{ $errors->has('dokumen_author')?'error':'' }}">
    <label class="control-label">Author <small>(Wajib Diisi)</small></label>
    <div class="field">
        {!! Form::hidden('dokumen_author',null,['id' => 'dokumen_author', 'class' => 'input-xxlarge']) !!}
        {!! $errors->first('dokumen_author','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<div class="par control-group">
    <label class="control-label">Komentar</label>
    <div class="field">
        {!! Form::text('dokumen_komentar',null,['id' => 'dokumen_komentar', 'class' => 'input-xxlarge', 'multiple']) !!}
        {!! $errors->first('dokumen_komentar','<span class="help-inline warning">:message</span>') !!}
    </div>                
</div>
<p>
    <label class="control-label">Izin Departemen</label>
    <div class="formwrapper" style="height:250px;overflow-y: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Departemen</th>
                    <th>Tanpa Akses</th>
                    <th>View</th>
                    <th>Download</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departemenlist as $dep)
                    <tr>
                        <td>{{ $dep['departemen_nama'] }}</td>
                        <td>{!! Form::radio('dep['.$dep['id'].']','0') !!}</td>
                        <td>{!! Form::radio('dep['.$dep['id'].']','1') !!}</td>
                        <td>{!! Form::radio('dep['.$dep['id'].']','2') !!}</td>
                        <td>{!! Form::radio('dep['.$dep['id'].']','3') !!}</td>
                        <td>{!! Form::radio('dep['.$dep['id'].']','4') !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>                
</p>
<p>
    <label class="control-label">Izin User</label>
    <div class="formwrapper" style="height:250px;overflow-y: auto;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Tanpa Akses</th>
                    <th>View</th>
                    <th>Download</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($userlist as $usr)
                    <tr>
                        <td>{{ $usr['name'].', '.$usr['type'] }}</td>
                        <td>{!! Form::radio('usr['.$usr['id'].']','0') !!}</td>
                        <td>{!! Form::radio('usr['.$usr['id'].']','1') !!}</td>
                        <td>{!! Form::radio('usr['.$usr['id'].']','2') !!}</td>
                        <td>{!! Form::radio('usr['.$usr['id'].']','3') !!}</td>
                        <td>{!! Form::radio('usr['.$usr['id'].']','4') !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>                
</p>
<p class="stdformbutton">
    <button class="btn btn-primary">Simpan</button>
    <button type="reset" class="btn">Reset</button>
</p>
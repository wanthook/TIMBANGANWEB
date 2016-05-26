<div class="row-fluid">
    <div class="span6">
        <div class="row-fluid {{ $errors->has('snap_tanggal')?'error':'' }}">
            <div class="span4">
                <span class="pull-right"><label>Date <small>(mandatory)</small></label></span>
            </div>
            <div class="span8">
                {!! Form::date('snap_tanggal',null,['class' => 'input-large', 'id' => 'snap_tanggal']) !!}
                {!! $errors->first('snap_tanggal','<span class="help-inline warning">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="row-fluid {{ $errors->has('snap_shift')?'error':'' }}">
            <div class="span3">
                <span class="pull-right"><label>Shift <small>(mandatory)</small></label></span>
            </div>
            <div class="span9">
                {!! Form::text('snap_shift',null,['class' => 'input-large', 'id' => 'snap_shift']) !!}
                {!! $errors->first('snap_shift','<span class="help-inline warning">:message</span>') !!}
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span6">
        <div class="row-fluid {{ $errors->has('mesin_id')?'error':'' }}">
            <div class="span4">
                <span class="pull-right"><label>Machine <small>(mandatory)</small></label></span>
            </div>
            <div class="span8">
                {!! Form::hidden('mesin_id',null,['class' => 'input-large', 'id' => 'mesin_id']) !!}
                {!! $errors->first('mesin_id','<span class="help-inline warning">:message</span>') !!}
            </div>
        </div>
    </div>
    <div class="span6">
    </div>
</div>
<hr>
<div class="headtitle">    
    <div class="btn-group">
        <a class="btn" id="addDetail"><i class="iconfa-plus-sign"></i>&nbsp;Add Snap Detail</a>
    </div>
    <h4 class="widgettitle">Table List Snap Detail</h4>
    
    <table id="tableId" class="table table-bordered responsive">
        {{--*/
        $arrHead = array('&nbsp;',
                        'Time',
                         'Rest',
                         'Left',
                         'L Snap',
                         'Right',
                         'R Snap',
                         'Total Breaks',
                         'Total Snap',
                         'RR Pos',
                         'Speed'
                         )
        /*--}}
        <colgroup>
        {{--*/ $col = 0 /*--}}
        @for ($i = 0; $i < count($arrHead); $i++)
            <col class="con{{$col}}" />
            @if($col==0) 
                {{--*/ $col = 1 /*--}}
            @else
                {{--*/ $col = 0 /*--}}
            @endif
        @endfor   
        </colgroup>
        <thead>
            <tr>
                {{--*/  $col = 0  /*--}}
                @for ($i = 0; $i < count($arrHead); $i++)
                    <th class="head{{$col}}">{{$arrHead[$i]}}</th>
                    @if($col==0) 
                        {{--*/ $col = 1 /*--}}
                    @else
                        {{--*/ $col = 0 /*--}}
                    @endif
                @endfor  
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th colspan="2" style="text-align:right">Average:</th>
                {{--*/  $col = 0  /*--}}
                @for ($i = 2; $i < count($arrHead); $i++)
                    <th></th>
                @endfor  
            </tr>
        </tfoot>
    </table>
    <div class="row-fluid">
        <div class="span6">
        </div>
        <div class="span6">
            <table class="table table-bordered table-invoice">
                <tr>
                    <td class="width30">Average Rest:</td>
                    <td class="width70"><div id="avgRest"></div>
                    </td>
                </tr>
                <tr>
                    <td class="width30">First:</td>
                    <td class="width70"><div id="avgFirst"></div>
                    </td>
                </tr>
                <tr>
                    <td class="width30">Last:</td>
                    <td class="width70"><div id="avgLast"></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<p class="stdformbutton">
    <button class="btn btn-primary">Save</button>
    <button type="reset" class="btn">Reset</button>
</p>
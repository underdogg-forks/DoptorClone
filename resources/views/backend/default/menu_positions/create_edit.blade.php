@section('content')
  <div class="row-fluid">
    <div class="span12">
      <!-- BEGIN FORM widget-->
      <div class="widget box blue tabbable">
        <div class="blue widget-title">
          <h4>
            <i class="icon-user"></i>
            @if (!isset($menu_position))
              <span class="hidden-480">{!! trans('options.create_new') !!} Menu Position</span>
            @else
              <span class="hidden-480">{!! trans('options.edit') !!} Existing Menu Position</span>
            @endif
            &nbsp;
          </h4>
        </div>
        <div class="widget-body form">
          <div class="tabbable widget-tabs">
            <div class="tab-content">
              <div class="tab-pane active" id="widget_tab1">
                <!-- BEGIN FORM-->
                @if (!isset($menu_position))
                  {!! Form::open(array('route'=>$link_type . '.menu-positions.store', 'method'=>'POST', 'class'=>'form-horizontal')) !!}
                @else
                  {!! Form::open(array('route' => array($link_type . '.menu-positions.update', $menu_position->id), 'method'=>'PUT', 'class'=>'form-horizontal')) !!}
                @endif

                @if ($errors->has())
                  <div class="alert alert-error hide" style="display: block;">
                    <button data-dismiss="alert" class="close">×</button>
                    {!! trans('errors.form_errors') !!}
                  </div>
                @endif


                <div class="control-group {!! $errors->has('name') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.name') !!} <span class="red">*</span></label>
                  <div class="controls">
                    {!! Form::text('name', (!isset($menu_position)) ? Input::old('name') : $menu_position->name, array('class' => 'input-xlarge'))!!}
                    {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>
                <div class="control-group {!! $errors->has('alias') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.alias') !!} </label>
                  <div class="controls">
                    {!! Form::text('alias', (!isset($menu_position)) ? Input::old('alias') : $menu_position->alias, array('class' => 'input-xlarge')) !!}
                    <span class="help-inline">{!! trans('form_messages.blank_for_automatic_alias') !!}</span>
                    {!! $errors->first('alias', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>
                <div class="form-actions">
                  <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> {!! trans('options.save') !!}
                  </button>
                </div>
                {!! Form::close() !!}
                  <!-- END FORM-->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- END FORM widget-->
    </div>
  </div>
@stop

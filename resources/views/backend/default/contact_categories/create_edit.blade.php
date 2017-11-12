@section('content')
  <div class="row-fluid">
    <div class="span12">
      <!-- BEGIN FORM widget-->
      <div class="widget box blue tabbable">
        <div class="blue widget-title">
          <h4>
            <i class="icon-user"></i>
            @if (!isset($contact_cat))
              <span
                class="hidden-480">{!! trans('options.create_new') !!} {!! trans('fields.contact') !!} {!! trans('cms.category') !!}</span>
            @else
              <span
                class="hidden-480">{!! trans('options.edit') !!} {!! trans('fields.contact') !!} {!! trans('cms.category') !!}</span>
            @endif
            &nbsp;
          </h4>
        </div>
        <div class="widget-body form">
          <div class="tabbable widget-tabs">
            <div class="tab-content">
              <div class="tab-pane active" id="widget_tab1">
                <!-- BEGIN FORM-->
                @if (!isset($contact_cat))
                  {!! Form::open(array('route'=>$link_type . '.contact-categories.store', 'method'=>'POST', 'class'=>'form-horizontal')) !!}
                @else
                  {!! Form::open(array('route' => array($link_type . '.contact-categories.update', $contact_cat->id), 'method'=>'PUT', 'class'=>'form-horizontal')) !!}
                @endif

                @if ($errors->has())
                  <div class="alert alert-error hide" style="display: block;">
                    <button data-dismiss="alert" class="close">×</button>
                    {!! trans('errors.form_errors') !!}
                  </div>
                @endif

                @if (isset($contact_cat))
                  {!! Form::text('id', $contact_cat->id, array('class' => 'hide')) !!}
                @endif

                <div class="control-group {!! $errors->has('name') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.name') !!} <span class="red">*</span></label>
                  <div class="controls">
                    {!! Form::text('name', (!isset($contact_cat)) ? Input::old('name') : $contact_cat->name, array('class' => 'input-xlarge'))!!}
                    {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                <div class="control-group {!! $errors->has('alias') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.alias') !!}</label>
                  <div class="controls">
                    {!! Form::text('alias', (!isset($contact_cat)) ? Input::old('alias') : $contact_cat->alias, array('class' => 'input-xlarge'))!!}
                    <div class="help-inline">{!! trans('form_messages.blank_for_automatic_alias') !!}</div>
                    {!! $errors->first('alias', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                <div class="control-group {!! $errors->has('status') ? 'error' : '' !!} hide">
                  <label class="control-label">{!! trans('options.status') !!} <span class="red">*</span></label>
                  <div class="controls line">
                    {!! Form::select('status', Post::all_status(), (!isset($contact_cat)) ? Input::old('status') : $contact_cat->status, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px')) !!}
                    {!! $errors->first('status', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                <div class="control-group {!! $errors->has('description') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.description') !!}</label>
                  <div class="controls">
                    {!! Form::textarea('description', (!isset($contact_cat)) ? Input::old('description') : $contact_cat->description, array('class' => 'input-xlarge'))!!}
                    {!! $errors->first('description', '<span class="help-inline">:message</span>') !!}
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

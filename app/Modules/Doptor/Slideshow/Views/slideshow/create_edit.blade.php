@section('styles')
  {!! HTML::style('assets/backend/default/plugins/bootstrap/css/bootstrap-modal.css') !!}
  {!! HTML::style('assets/backend/default/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('content')
  <div class="row-fluid">
    <div class="span12">
      <!-- BEGIN FORM widget-->
      <div class="widget box blue tabbable">
        <div class="blue widget-title">
          <h4>
            <i class="icon-user"></i>
            @if (!isset($slide))
              <span class="hidden-480">Create New Slide</span>
            @else
              <span class="hidden-480">Edit Slide</span>
            @endif
            &nbsp;
          </h4>
        </div>
        <div class="widget-body form">
          <div class="tabbable widget-tabs">
            <div class="tab-content">
              <div class="tab-pane active" id="widget_tab1">
                <!-- BEGIN FORM-->
                @if (!isset($slide))
                  {!! Form::open(array('route'=>$link_type . '.modules.doptor.slideshow.store', 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) !!}
                @else
                  {!! Form::open(array('route' => array($link_type . '.modules.doptor.slideshow.update', $slide->id), 'method'=>'PUT', 'class'=>'form-horizontal', 'files'=>true)) !!}
                @endif

                @if ($errors->has())
                  <div class="alert alert-error hide" style="display: block;">
                    <button data-dismiss="alert" class="close">×</button>
                    {!! trans('errors.form_errors') !!}
                  </div>
                @endif

                @if (isset($slide))
                  {!! Form::hidden('id', $slide->id) !!}
                @endif

                <div class="control-group {{ $errors->has('content') ? 'error' : '' }}">
                  <label class="control-label">Caption <span class="red">*</span></label>
                  <div class="controls line">
                    <textarea class="span12 ckeditor m-wrap" name="caption"
                              rows="6">{!! (!isset($slide)) ? Input::old('caption') : $slide->caption !!}</textarea>
                    {!! $errors->first('caption', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                <div class="control-group {{ $errors->has('image') ? 'error' : '' }}">
                  <label class="control-label">Image <span class="red">*</span></label>
                  <div class="controls">
                    {{-- Form::file('image', array('class' => 'input-xlarge')) --}}
                    {!! Form::hidden('image') !!}
                    <a class="btn btn-primary insert-media" id="insert-main-image" href="#"> Select image</a>
                                            <span class="file-name">
                                                {!! $slide->image or '' !!}
                                            </span>
                    {!! $errors->first('image', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                <div
                  class="control-group {!! $errors->has('link') ? 'error' : '' !!} {!! $errors->has('link') ? 'wrapper_width' : '' !!} {!! $errors->has('wrapper_height') ? 'error' : '' !!}">
                  <label class="control-label">Link</label>
                  <div class="controls">
                    {!! Form::select('link', Menu::menu_lists(true), (!isset($slide)) ? Input::old('link') : $slide->link, array('id'=>'link', 'class' => 'chosen span6 m-wrap', 'style'=>'width:285px')) !!}
                    {!! $errors->first('link', '<span class="help-inline">:message</span>') !!}
                  </div>
                  <div id="manual-link" class="controls">
                    {!! Form::text('link_manual', (!isset($slide)) ? Input::old('link_manual') : $slide->link_manual, array('class' => 'input-xlarge'))!!}
                  </div>
                </div>

                <div class="control-group {!! $errors->has('link_title') ? 'error' : '' !!}">
                  <label class="control-label">Link Title</label>
                  <div class="controls">
                    {!! Form::text('link_title', (!isset($slide)) ? Input::old('link_title') : $slide->link_title, array('class' => 'input-xlarge'))!!}
                    {!! $errors->first('link_title', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                <div class="control-group {{ $errors->has('status') ? 'error' : '' }}">
                  <label class="control-label">Status <span class="red">*</span></label>
                  <div class="controls line">
                    {!! Form::select('status', $all_statuses, (!isset($slide)) ? Input::old('status') : $slide->status, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px')) !!}
                    {!! $errors->first('status', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                <!-- <div class="control-group {{ $errors->has('publish_start') ? 'error' : '' }}">
                                        <label class="control-label">Publish Start</label>
                                        <div class="controls line">
                                            <div id="datetimepicker_start" class="input-append">
                                                {!! Form::text('publish_start', (!isset($slide)) ? '' : $slide->publish_start, array('data-format'=>'yyyy-MM-dd HH:mm:ss')) !!}
                  <span class="add-on">
                      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                      </i>
                  </span>
              </div>
              <span class="help-inline">Leave blank to start publishing immediately.</span>
              {!! $errors->first('publish_start', '<span class="help-inline">:message</span>') !!}
                  </div>
              </div>

              <div class="control-group {{ $errors->has('publish_end') ? 'error' : '' }}">
                                        <label class="control-label">Publish End</label>
                                        <div class="controls line">
                                            <div id="datetimepicker_end" class="input-append">
                                                {!! Form::text('publish_end', (!isset($slide)) ? '' : $slide->publish_end, array('data-format'=>'yyyy-MM-dd HH:mm:ss')) !!}
                  <span class="add-on">
                      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                      </i>
                  </span>
              </div>
              <span class="help-inline">Leave blank to never stop publishing.</span>
              {!! $errors->first('publish_end', '<span class="help-inline">:message</span>') !!}
                  </div>
              </div> -->

                <br>

                <div class="form-actions">
                  <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
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

@section('scripts')
  {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') !!}
  {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modal.js') !!}
  {!! HTML::script("assets/backend/default/plugins/ckeditor/ckeditor.js") !!}
  {!! HTML::script("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") !!}
  {!! HTML::script("assets/backend/default/scripts/media-selection.js") !!}
  @parent
  <script>
    function showOrHideManualLinks() {
      value = $('#link').val();
      if (value == 'manual') {
        $('#manual-link').show();
      } else {
        $('#manual-link').hide();
      }
    }
    jQuery(document).ready(function () {
      showOrHideManualLinks();
      $('#link').on('change', function () {
        showOrHideManualLinks();
      });
    });

    MediaSelection.init('image');
  </script>
@stop

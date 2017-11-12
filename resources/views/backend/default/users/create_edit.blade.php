@section('styles')
  {!! HTML::style('assets/backend/default/plugins/bootstrap/css/bootstrap-modal.css') !!}
  <style>
    span.password-verdict
    {
      display: inline;
      padding: 10px;
    }

    span.password-verdict:before
    {
      content: 'Strength: ';
    }

    .controls .progress
    {
      display: none;
    }
  </style>
@stop

@section('content')
  <div class="row-fluid">
    <div class="span12">
      <!-- BEGIN FORM widget-->
      <div class="widget light-gray box tabbable">
        <div class="blue widget-title">
          <h4>
            <i class="icon-user"></i>
            @if (!isset($user))
              <span class="hidden-480">{!! trans('options.create_new') !!} {!! trans('fields.user') !!}</span>
            @else
              <span class="hidden-480">{!! trans('options.edit') !!} {!! trans('fields.user') !!}</span>
            @endif
            &nbsp;
          </h4>
        </div>

        <div class="widget-body widget-container form">
          <div class="tabbable widget-tabs">
            <div class="tab-content">
              <div class="tab-pane active" id="widget_tab1">
                <!-- BEGIN FORM-->
                @if (!isset($user))
                  {!! Form::open(array('route'=>$link_type.'.users.store', 'method'=>'POST', 'files'=>true, 'class'=>'form-horizontal')) !!}
                @else
                  {!! Form::open(array('route' => array($link_type.'.users.update', $user->id), 'method'=>'PUT', 'files'=>true, 'class'=>'form-horizontal')) !!}
                @endif

                @if ($errors->has())
                  <div class="alert alert-error hide" style="display: block;">
                    <button data-dismiss="alert" class="close">×</button>
                    {!! trans('errors.form_errors') !!}
                  </div>
                @endif


                <div class="control-group {!! $errors->has('username') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.username') !!} <span class="red">*</span></label>
                  <div class="controls">
                    {!! Form::text('username', (!isset($user)) ? Input::old('username') : $user->username, array('id'=>'username', 'class' => 'input-xlarge'))!!}
                    {!! $errors->first('username', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>
                <div class="control-group {!! $errors->has('email') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.email') !!} <span class="red">*</span></label>
                  <div class="controls">
                    {!! Form::text('email', (!isset($user)) ? Input::old('email') : $user->email, array('class' => 'input-xlarge'))!!}
                    {!! $errors->first('email', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>
                <div class="control-group {!! $errors->has('first_name') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.first_name') !!} <span class="red">*</span></label>
                  <div class="controls">
                    {!! Form::text('first_name', (!isset($user)) ? Input::old('first_name') : $user->first_name, array('class' => 'input-xlarge'))!!}
                    {!! $errors->first('first_name', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>
                <div class="control-group {!! $errors->has('last_name') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('fields.last_name') !!} <span class="red">*</span></label>
                  <div class="controls">
                    {!! Form::text('last_name', (!isset($user)) ? Input::old('last_name') : $user->last_name, array('class' => 'input-xlarge'))!!}
                    {!! $errors->first('last_name', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                @if (!isset($user) || (isset($user) && $user->id == $current_user->id))
                  <div class="control-group {!! $errors->has('password') ? 'error' : '' !!}">
                    <label
                      class="control-label">{!! trans('fields.password') !!} {!! (!isset($user)) ? '<span class="red">*</span>' : '' !!}</label>
                    <div class="controls">
                      {!! Form::password('password', array('class' => 'input-xlarge'))!!}
                      {!! $errors->first('password', '<span class="help-inline">:message</span>') !!}
                    </div>
                  </div>
                  <div class="control-group {!! $errors->has('password_confirmation') ? 'error' : '' !!}">
                    <label
                      class="control-label">{!! trans('options.confirm') !!} {!! trans('fields.password') !!} {!! (!isset($user)) ? '<span class="red">*</span>' : '' !!}</label>
                    <div class="controls">
                      {!! Form::password('password_confirmation', array('class' => 'input-xlarge'))!!}
                      {!! $errors->first('password_confirmation', '<span class="help-inline">:message</span>') !!}
                    </div>
                  </div>

                  @if (isset($user))
                    {{--For administrators, no need to input security question/answer while creating an user--}}
                    <div class="control-group {!! $errors->has('security_question') ? 'error' : '' !!}">
                      <label class="control-label">{!! trans('config.security_question') !!} <span class="red">*</span></label>
                      <div class="controls">
                        {!! Form::text('security_question', (!isset($user)) ? Input::old('security_question') : $user->security_question, array('class' => 'input-xlarge'))!!}
                        {!! $errors->first('security_question', '<span class="help-inline">:message</span>') !!}
                      </div>
                    </div>

                    <div class="control-group {!! $errors->has('security_answer') ? 'error' : '' !!}">
                      <label class="control-label">{!! trans('config.security_answer') !!} <span
                          class="red">*</span></label>
                      <div class="controls">
                        {!! Form::text('security_answer', (!isset($user)) ? Input::old('security_answer') : $user->security_answer, array('class' => 'input-xlarge'))!!}
                        {!! $errors->first('security_answer', '<span class="help-inline">:message</span>') !!}
                      </div>
                    </div>
                  @endif
                @else
                  @if (isset($user))
                    <div class="control-group">
                      <div class="controls">
                        {!! HTML::link($link_type . '/users/forgot_password?email=' . urlencode($user->email), trans('password_reset.reset'), array('class'=>'btn')) !!}
                      </div>
                    </div>
                  @endif
                @endif

                <div class="control-group {!! $errors->has('auto_logout_time') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('config.auto_logout_time') !!}</label>
                  <div class="controls">
                    {!! Form::text('auto_logout_time', (!isset($user)) ? Input::old('auto_logout_time') : $user->auto_logout_time, array('class' => 'input-xlarge'))!!}
                    <span class="help-inline">{!! trans('config.time_in_min') !!}</span>
                    {!! $errors->first('auto_logout_time', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                @if (!Request::is('*profile*'))
                  <div class="control-group {!! $errors->has('company_id[]') ? 'error' : '' !!}">
                    <label class="control-label">{!! trans('form_messages.associated_companies') !!}</label>
                    <div class="controls">
                      {!! Form::select('company_id[]', $companies, (!isset($user)) ? Input::old('company_id[]') : $user->company_id, array('multiple', 'class'=>'chosen input-xlarge')) !!}
                      {!! $errors->first('company_id', '<span class="help-inline">:message</span>') !!}
                    </div>
                  </div>
                @endif

                @if (!Request::is('*profile*'))
                  {{-- Don't show {!! trans('options.status') !!} selection while editing profile --}}
                  <div class="control-group">
                    <label class="control-label">{!! trans('options.status') !!}</label>
                    <div class="controls">
                      @if (isset($user))
                        {!! Form::select('status', User::status(), ($user->is_banned)?'0':'1', array('class'=>'chosen input-xlarge')) !!}
                      @else
                        {!! Form::select('status', User::status(), 1, array('class'=>'chosen input-xlarge')) !!}
                      @endif
                    </div>
                  </div>
                  {{-- Don't show user group selection while editing profile --}}
                  <div class="control-group">
                    <label class="control-label">{!! trans('cms.user_group') !!}</label>
                    <div class="controls">
                      @if (isset($user))
                        {!! Form::select('user-group', Group::lists('name', 'id'), User::user_group($user), array('class'=>'chosen input-xlarge')) !!}
                      @else
                        {!! Form::select('user-group', UserGroup::all_groups(), '', array('class'=>'chosen input-xlarge')) !!}
                      @endif

                      {!! HTML::link("$link_type/user-groups/create", trans('options.create_new') . ' ' . trans('cms.user_group'), array('class'=>'btn btn-mini mb-15')) !!}
                    </div>
                  </div>
                @endif

                <div class="control-group {!! $errors->has('photo') ? 'error' : '' !!}">
                  <label class="control-label">{!! trans('cms.profile') !!} {!! trans('fields.image') !!}</label>
                  <div class="controls">
                    {{-- Form::file('photo', array('class' => 'input-xlarge')) --}}
                    {!! Form::hidden('photo') !!}
                    <a class="btn btn-primary insert-media" id="insert-main-image"
                       href="#"> {!! trans('form_messages.select_image') !!}</a>
                                            <span class="file-name">
                                                {!! $user->photo or '' !!}
                                            </span>
                    {!! $errors->first('photo', '<span class="help-inline">:message</span>') !!}
                  </div>
                </div>

                <br>
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

@section('scripts')
  {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') !!}
  {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modal.js') !!}
  {!! HTML::script("assets/backend/default/scripts/media-selection.js") !!}
  {!! HTML::script("assets/backend/default/plugins/pwstrength-bootstrap-1.2.1.min.js") !!}
  @parent
  <script>
    MediaSelection.init('photo');

    jQuery(document).ready(function () {
      var options = {
        minChar: 8,
        bootstrap3: false,
        error{!! trans('fields.message') !!}s: {
          password_too_short: "<font color='red'>{!! trans('errors.short_password') !!}</font>",
          same_as_username: "{!! trans('errors.password_username_same') !!}"
        },
        scores: [17, 26, 40, 50],
        verdicts: ["Weak", "Normal", "Medium", "Strong", "Very Strong"],
        showVerdicts: true,
        showVerdictsInitially: false,
        raisePower: 1.4,
        usernameField: "#username",
      };
      $('[name=password]').pwstrength(options);
    });
  </script>
@stop

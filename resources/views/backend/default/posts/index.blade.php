@section('styles')
  <!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" href="{!! URL::to('assets/backend/default/plugins/data-tables/DT_bootstrap.css') !!}"/>
<!-- END PAGE LEVEL STYLES -->
@stop

@section('content')
  <div class="row-fluid">
    <div class="span12">
      <!-- BEGIN EXAMPLE TABLE widget-->
      <div class="widget light-gray box">
        <div class="blue widget-title">
          <h4><i class="icon-th-list"></i> {!! trans('cms.all_entries') !!}</h4>
          <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#widget-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
          </div>
        </div>
        <div class="widget-body">
          <div class="clearfix margin-bottom-10">
            <div class="btn-group pull-right">
              <div class="actions inline">
                <div class="btn">
                  <i class="icon-cog"> {!! trans('options.actions') !!}</i>
                </div>
                <ul class="btn">
                  @if ($current_user->hasAccess("{$type}.destroy"))
                    <li>
                      {!! Form::open(array('route' => array($link_type . '.' . $type .'s.destroy', 'multiple'), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecords($(this), '{$type}');")) !!}
                      {!! Form::hidden('selected_ids', '', array('id'=>'selected_ids')) !!}
                      <button type="submit" class="danger delete"><i
                          class="icon-trash"></i> {!! trans('options.delete') !!}</button>
                      {!! Form::close() !!}
                    </li>
                  @endif
                </ul>
              </div>
            </div>
            @if ($current_user->hasAccess("{$type}.create"))
              <div class="btn-group pull-right">
                <button data-href="{!! URL::to($link_type . '/' . $type .'s/create') !!}" class="btn btn-success">
                  {!! trans('options.create_new') !!} <i class="icon-plus"></i>
                </button>
              </div>
            @endif
          </div>
          <table class="table table-striped table-hover table-bordered" id="sample_1">
            <thead>
            <tr>
              <th class="span1"><input type="checkbox" class="select_all"/></th>
              <th>Title</th>
              <th>{!! trans('options.status') !!}</th>
              <th>Created by</th>
              <th class="span2"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($posts as $post)
              <tr>
                <td>{!! Form::checkbox($post->id, 'checked', false) !!}</td>
                <td>{!! HTML::link(url($link_type . '/' . $type .'s/'.$post->id), $post->title) !!}</td>
                <td>{!! $post->status() !!}</td>
                <td>{!! $post->author() !!}</td>
                <td>
                  <a href="{!! URL::to($link_type . '/' . $type .'s/' . $post->id . '/edit') !!}"
                     class="btn btn-mini"><i class="icon-edit"></i></a>

                  <div class="actions inline">
                    <div class="btn btn-mini">
                      <i class="icon-cog"> {!! trans('options.actions') !!}</i>
                    </div>
                    <ul class="btn btn-mini">
                      @if ($current_user->hasAccess("{$type}.destroy"))
                        <li>
                          {!! Form::open(array('route' => array($link_type . '.' . $type .'s.destroy', $post->id), 'method' => 'delete', 'class'=>'inline', 'onsubmit'=>"return deleteRecord($(this), '{$type}');")) !!}
                          <button type="submit" class="danger delete"><i
                              class="icon-trash"></i> {!! trans('options.delete') !!}</button>
                          {!! Form::close() !!}
                        </li>
                      @endif
                    </ul>
                  </div>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <!-- END EXAMPLE TABLE widget-->
    </div>
  </div>
  @stop

  @section('scripts')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
  <script type="text/javascript"
          src="{!! URL::to("assets/backend/default/plugins/data-tables/jquery.dataTables.js") !!}"></script>
  <script type="text/javascript"
          src="{!! URL::to("assets/backend/default/plugins/data-tables/DT_bootstrap.js") !!}"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  @parent
  <script src="{!! URL::to("assets/backend/default/scripts/table-managed.js") !!}"></script>
  <script>
    jQuery(document).ready(function () {
      TableManaged.init();
    });
  </script>
  <!-- END PAGE LEVEL SCRIPTS -->
  <script>
    $(function () {
      $('#selected_ids').val('');

      $('.select_all').change(function () {
        var checkboxes = $('#sample_1 tbody').find(':checkbox');

        if ($(this).is(':checked')) {
          checkboxes.attr('checked', 'checked');
          restore_uniformity();
        } else {
          checkboxes.removeAttr('checked');
          restore_uniformity();
        }
      });
    });
    function deleteRecords(th, type) {
      if (type === undefined) type = 'record';

      doDelete = confirm("Are you sure you want to delete the selected " + type + "s ?");
      if (!doDelete) {
        // If cancel is selected, do nothing
        return false;
      }

      $('#sample_1 tbody').find('input:checked').each(function () {
        value = $('#selected_ids').val();
        $('#selected_ids').val(value + ' ' + this.name);
      });
    }
    function restore_uniformity() {
      $.uniform.restore("input[type=checkbox]");
      $('input[type=checkbox]').uniform();
    }
  </script>
@stop

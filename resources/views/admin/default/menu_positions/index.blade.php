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
          <h4><i class="icon-th-list"></i>Menu Positions</h4>
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
              @if ($current_user->hasAccess('menu-positions.create'))
                <button data-href="{!! URL::to($link_type . '/menu-positions/create') !!}" class="btn btn-success">
                  Add New <i class="icon-plus"></i>
                </button>
              @endif
            </div>
          </div>
          <table class="table table-striped table-hover table-bordered" id="sample_1">
            <thead>
            <tr>
              <th>Name</th>
              <th>Alias</th>
              <th class="span3">Created At</th>
              <th class="span2"></th>
            </tr>
            </thead>
            <tbody id="menu-list">
            @foreach ($menu_positions as $menu_position)
              <tr class="">
                <td>{!! $menu_position->name !!}</td>
                <td>{!! $menu_position->alias !!}</td>
                <td>{!! $menu_position->created_at !!}</td>
                <td>
                  @if ($current_user->hasAccess('menu-positions.edit'))
                    <a href="{!! URL::to($link_type . '/menu-positions/' . $menu_position->id . '/edit') !!}"
                       class="btn btn-mini"><i class="icon-edit"></i></a>
                  @endif

                  <div class="actions inline">
                    <div class="btn btn-mini">
                      <i class="icon-cog"> Actions</i>
                    </div>
                    <ul class="btn btn-mini">
                      @if ($current_user->hasAccess('menu-positions.destroy'))
                        <li>
                          {!! Form::open(array('route' => array($link_type . '.menu-positions.destroy', $menu_position->id), 'method' => 'delete', 'class'=>'inline', 'onclick'=>"return deleteRecords($(this), 'menu position');")) !!}
                          <button type="submit" class="danger delete"><i class="icon-trash"></i> Delete</button>
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
  <script src="{!! url("assets/admin/default/js/jquery.dataTables.js") !!}"></script>

  <script src="{!! url("assets/admin/default/js/dataTables.bootstrap.js") !!}"></script>

  <script>
    $(function () {
      $('.table').dataTable({
        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>"
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
  </script>
@stop

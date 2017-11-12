@section('styles')
  <!-- Flexslider -->
{!! HTML::style("assets/public/default/css/flexslider.css") !!}
@stop

@section('scripts')
  <!-- Flexslider -->
{!! HTML::script("assets/public/default/js/jquery.flexslider.js") !!}
@stop


@section('content')
  <section class="indent">
    <div class="container">
      <div class="grid_12">
        @if (isset($page))
          <h2>{!! $page->title !!}</h2>

          {!! $page->content !!}
        @else
          <h2>Welcome</h2>

          <p>The CMS public section can now be viewed at {!! HTML::link(url('/'), url('/')) !!}</p>

          <p>The CMS admin can now be viewed at {!! HTML::link(url('admin'), url('admin')) !!}</p>

          <p>The CMS backend can now be viewed at {!! HTML::link(url('backend'), url('backend')) !!}</p>
        @endif
      </div>
    </div>
  </section>
@stop

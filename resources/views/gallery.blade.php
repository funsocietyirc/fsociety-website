@extends('layout._main')
@section('title','IRC Image Gallery')
@section('content')
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <div id="vue">
        <gallery></gallery>
    </div>
@endsection
@section('head-script')
    <script src="{{elixir('js/vue.js')}}"></script>
@endsection
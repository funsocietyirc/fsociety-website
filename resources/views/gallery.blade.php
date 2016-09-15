@extends('layout._main')
@section('content')
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
    <div id="test">
        <example></example>
    </div>
@endsection
@section('scripts')
    <script src="{{elixir('js/vu.js')}}"></script>
@endsection
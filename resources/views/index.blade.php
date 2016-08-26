@extends('layout/_main')
@section('content')
    <div class="uk-vertical-align uk-text-center full-height">
        <div class="uk-vertical-align-middle">
            <div class="message-container">
                <div class="message"></div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/1.1.4/typed.min.js"></script>
<script type="text/javascript">
    var lines = [
        'Hello friend.',
        "If you've come, you've come for a reason.",
        "but there's a part of you that's exhausted with this world...",
        "You may not be able to explain it yet,",
        "A world that decides where you work, who you see,",
        "and how you empty and fill your depressing bank account.",
        "Even the Internet connection you're using to read this is costing you,",
        "slowly chipping away at your existence.",
        "Soon I will give you a voice. Today your education begins.",
        "<a  href='/chat'>Connect to FreeNode</a>, and join us on <strong>#fsociety</strong>."
    ];
    $(function(){
        $(".message").typed({
            strings: lines,
            typeSpeed: 4,
            contentType: 'html'
        });
    });
</script>
@endsection

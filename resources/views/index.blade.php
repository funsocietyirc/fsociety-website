@section('title','Hello Friend')
@extends('layout/_main', [ 'fullHeight' => true])
@section('head-style')
@endsection
@section('content')
    <div class="uk-vertical-align uk-text-center full-height">
        <div class="uk-vertical-align-middle">
            <div class="message-container">
                <div class="message"></div>
            </div>
            <div class="explanation">
                <a claSS="hvr-bob" href="#explanation" data-uk-modal>?</a>
            </div>
        </div>
    </div>
    <div id="explanation" class="uk-modal">
        <div class="uk-modal-dialog">
            <div class="uk-modal-header">Welcome</div>
            <p>
                This site is a early beta of things to come for season three. Some of the features we hope
                to achieve include but are not limited to.
            </p>
            <ul>
                <li>Theory submissions / Rating / Voting</li>
                <li>Episodic comments and forums</li>
                <li>ARG Link tracking, problem solving, discussions</li>
            </ul>
            <p>
                Currently, I am but one developer, if you care to join me you can find us on <a
                        href="https://github.com/funsocietyirc/fsociety-website">Github</a>.
            </p>
            <div class="uk-modal-footer">
                <a class="uk-button uk-button-danger uk-modal-close">exit<span class="typed-cursor">|</span></a>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        let lines = [
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
        $(function () {
            let p = document.querySelector('.message');
            let t = new Typed(p, {
                strings: lines,
                typeSpeed: 40,
                contentType: 'html'
            });
        });
    </script>
@endsection

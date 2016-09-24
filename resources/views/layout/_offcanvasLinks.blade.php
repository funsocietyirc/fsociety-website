<li class="{{ areActiveRoutes(['episodes','season','episode'])}}">
    <a href="{{route('episodes')}}">Episodes</a>
</li>
<li class="{{ areActiveRoutes(['arg.index','arg.show','arg.create'])}}">
    <a href="{{route('arg.index')}}">ARG</a>
</li>
<li class="{{ isActiveRoute('chat')}}">
    <a href="{{route('chat')}}">Chat</a>
</li>
<li class="{{ isActiveRoute('gallery')}}">
    <a href="{{route('gallery')}}">Gallery</a>
</li>
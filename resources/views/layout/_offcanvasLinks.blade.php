<li class="{{ areActiveRoutes(['episodes','season','episode'])}}">
    <a href="{{route('episodes')}}">Episodes</a>
</li>
<li class="{{ areActiveRoutes(['arg.index','arg.show','arg.create'])}}">
    <a class="uk-navbar-nav-subtitle" href="{{route('arg.index')}}">ARG<div>Links</div></a>
</li>
<li class="{{ isActiveRoute('chat')}}">
    <a class="uk-navbar-nav-subtitle" href="{{route('chat')}}">IRC<div>Chat</div></a>
</li>
<li class="{{ isActiveRoute('gallery')}}">
    <a class="uk-navbar-nav-subtitle" href="{{route('gallery')}}">IRC<div>Gallery</div></a>
</li>
<li class="{{ isActiveRoute('links')}}">
    <a class="uk-navbar-nav-subtitle" href="{{route('links')}}">IRC<div>Links</div></a>
</li>
<li class="{{ isActiveRoute('irc-channels')}}">
    <a class="uk-navbar-nav-subtitle" href="{{route('irc-channels')}}">IRC<div>Channels</div></a>
</li>
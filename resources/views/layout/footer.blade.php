<footer>
    <div class="footer">
        <div class="links">
            <ul>
                <li class="right"><span class="top"><a href="#top">Back to Top</a></span></li>
            </ul>
        </div>
        @if(\Auth::user())<br>
        <div class="links">
            <ul>
                <li class="menu"><a href="/">Home</a></li>
                <li class="menu"><a href="{{Route('timecode')}}">Timecode</a></li>
                <li class="menu"><a href="{{Route('scenes.index')}}">Scenes</a></li>
                <li class="menu"><a href="{{Route('sections.index')}}">Sections</a></li>
                <li class="menu"><a href="{{Route('users')}}">Users</a></li>
            </ul>
        </div>
        @endif
        <div class="footer-text">
            <br>
            <strong>Please note, this is experimental.</strong><br>
            Timecodes might not be accurate and it might use more system
            resources/bandwidth than expected.<br>Use it at your own risk.
        </div>
    </div>
</footer>

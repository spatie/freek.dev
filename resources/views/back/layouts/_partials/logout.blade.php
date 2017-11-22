<ul>
    <li>
        <a href="{{ route('logout') }}" class="py-2 mx-6"
           onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </li>
</ul>
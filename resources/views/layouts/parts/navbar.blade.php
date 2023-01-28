<navbar>
    <!-- Right Side Of Navbar -->
    <p id="loginUserName" class="text-right p-0 m-0"><i class="fa-solid fa-user"></i>
        {{ Auth::user()->name }} さん
    </p>
    <p class="text-right text-muted text-nowrap p-0 m-0"><small>
        @foreach($roles as $role)
            {{ Auth::user()->role_id == $role->id ? $role->name : "" }}</small>
        @endforeach
    </p>
</navbar>
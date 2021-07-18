<navbar nombre_usuario="{{ Auth::check() ? Auth::user()->name : '' }}"></navbar>

<navbar :usuario="{{ Auth::check() ? Auth::user() : "{}" }}"></navbar>

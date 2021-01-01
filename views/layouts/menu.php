<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="/">Task manager</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <div class="form-inline my-2 my-lg-0">
            <?= (\App\Core\Auth::isLogged()) ? '<a href="/logout" class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</a>' : '<a href="/sign_in" class="btn btn-outline-success my-2 my-sm-0" type="submit">Login</a>' ?>

        </div>
    </div>
</nav>

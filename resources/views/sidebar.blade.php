@inject('categories', 'App\Services\Categories')

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ route('home') }}">Товары</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Категории
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @foreach ($categories->list() as $category)
                        @php ($topClass = '')
                        @if ($category->is_top)
                            @php ($topClass = ' h5')
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item{{$topClass}}" href="{{ route('category', ['id' => $category->id]) }}">{{$category->title}}</a>

                    @endforeach
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0" method="get" action="{{ route('search') }}">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="word" value="{{ app('request')->input('word') }}">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Искать</button>
        </form>
    </div>
</nav>

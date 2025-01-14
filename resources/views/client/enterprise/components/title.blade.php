<div class="page-title-area">
    <div class="container">
        <div class="page-title-content">
            <h2>{{ config('apps.clients.enterprises.show.title') }}</h2>
            <ul>
                <li>
                    <a href="{{ route('home') }}">
                        {{ config('apps.clients.enterprises.home') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('enterprises.index') }}">
                        {{ config('apps.clients.enterprises.title') }}
                    </a>
                </li>
                <li class="active">{{ Str::limit($enterprise->name, 40, '...') }}</li>
            </ul>
        </div>
    </div>
</div>

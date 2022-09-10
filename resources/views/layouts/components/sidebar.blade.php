<div class="navbar-logo-left wf-section">
    <div data-animation="over-left" data-collapse="medium" data-duration="400" data-easing="ease" data-easing2="ease"
        role="banner" class="navbar-logo-left-container shadow-three w-nav">
        <div class="container">
            <div class="navbar-wrapper">
                <a href="#" class="navbar-brand w-nav-brand">
                    <div class="text-block-11"> {{ Session::get('name') }}<br></div>
                    <div class="text-block-11">
                        {{ Session::get('access') }}
                    </div>
                </a>
                <nav role="navigation" class="nav-menu-wrapper w-nav-menu">
                    <ul role="list" class="nav-menu-two w-list-unstyled">
                        <li class="list-item">
                            <a href="/" aria-current="page" class="nav-link w--current">Dashboard</a>
                            <link rel="prerender" href="/">
                        </li>
                        <li class="list-item">
                            <a href="{{ route('sections.index') }}" class="nav-link">Sections</a>
                            <link rel="prerender" href="{{ route('sections.index') }}">
                        </li>
                        <li class="list-item">
                            <a href="{{ route('categories.index') }}" class="nav-link">Categories</a>
                            <link rel="prerender" href="{{ route('categories.index') }}">
                        </li>
                        <li class="list-item">
                            <a href="{{ route('authors.index') }}" class="nav-link">Authors</a>
                            <link rel="prerender" href="{{ route('authors.index') }}">
                        </li>

                        <li class="list-item">
                            <a href="{{ route('quotes.index') }}" class="nav-link">Quotes</a>
                            <link rel="prerender" href="{{ route('quotes.index') }}">
                        </li>
                        <li class="list-item">
                            <a href="{{ route('dailyprose.index') }}" class="nav-link">Prose</a>
                            <link rel="prerender" href="{{ route('dailyprose.index') }}">
                        </li>
                        <li class="list-item">
                            <div data-hover="false" data-delay="0" class="nav-dropdown w-dropdown">
                                <div class="nav-dropdown-toggle w-dropdown-toggle">
                                    <div class="nav-dropdown-icon w-icon-dropdown-toggle"></div>
                                    <div class="text-block-12">Moods</div>
                                </div>
                                <nav class="nav-dropdown-list shadow-three mobile-shadow-hide w-dropdown-list">
                                    <a href="{{ route('mood.index') }}" class="nav-dropdown-link w-dropdown-link">Mood</a>
                                    <link rel="prerender" href="{{ route('mood.index') }}">
                                    <a href="{{ route('reason.table') }}" class="nav-dropdown-link w-dropdown-link">Reason</a>
                                    <link rel="prerender" href="{{ route('reason.table') }}">
                                    <a href="{{ route('feeling.table') }}" class="nav-dropdown-link w-dropdown-link">Feeling</a>
                                    <link rel="prerender" href="{{ route('feeling.table') }}">
                                </nav>
                            </div>
                        </li>
                     
                        <li class="list-item">
                            <a href="{{ route('user.index') }}" class="nav-link">Users</a>
                        </li>
                        <li class="list-item">
                            <div data-hover="false" data-delay="0" class="nav-dropdown w-dropdown">
                                <div class="nav-dropdown-toggle w-dropdown-toggle">
                                    <div class="nav-dropdown-icon w-icon-dropdown-toggle"></div>
                                    <div class="text-block-12">Settings</div>
                                </div>
                                <nav class="nav-dropdown-list shadow-three mobile-shadow-hide w-dropdown-list">
                                    <a href="{{ route('social.index') }}"
                                        class="nav-dropdown-link w-dropdown-link">Social Media</a>
                                    <link rel="prerender" href="{{ route('social.index') }}">
                                    <a href="{{ route('setting.index') }}"
                                        class="nav-dropdown-link w-dropdown-link">System Settings</a>
                                    <link rel="prerender" href="{{ route('setting.index') }}">
                                    <a href="{{ route('index_terms') }}"
                                        class="nav-dropdown-link w-dropdown-link">Privacy Policy & Terms <br>And
                                        Condition Settings</a>
                                    <link rel="prerender" href="{{ route('index_terms') }}">
                                    <a href="{{ route('index_password') }}"
                                        class="nav-dropdown-link w-dropdown-link">Change Password</a>
                                    <link rel="prerender" href="{{ route('index_password') }}">

                                </nav>
                            </div>
                        </li>


                        <li class="list-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link link-button">Logout</button>
                            </form>

                        </li>
                    </ul>
                </nav>
                <div class="nav-hamburger w-nav-button">
                    <div class="w-icon-nav-menu"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@extends('layouts.admin')
@section('test')
    {{ session()->get('access') }}
@endsection
@section('title')
    TheGoodQuote-Dashboard
@endsection
@section('content')
    <div class="dashboard-wrapper">
        <section class="features-metrics wf-section">
            <div class="container">
                <div class="features-wrapper">
                    <div class="features-block">
                        <div class="features-title">
                            <div id="section"></div>
                        </div>
                        <div>Sections</div>
                    </div>
                    <div class="features-block">
                        <div class="features-title">
                            <div id="categories"></div>
                        </div>
                        <div>Categories</div>
                    </div>
                    <div class="features-block">
                        <div class="features-title">
                            <div id="author"></div>
                        </div>
                        <div>Authors</div>
                    </div>
                    <div class="features-block">
                        <div class="features-title">
                            <div id="quote"></div> <span class="features-title-small"></span>
                        </div>
                        <div>Quotes</div>
                    </div>
                    <div class="features-block">
                        <div class="features-title">
                            <div id="users"></div> <span class="features-title-small"></span>
                        </div>
                        <div>Users</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
                    function kFormatter(num) {
                        return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) + 'k' : Math.sign(
                                num) * Math
                            .abs(num)
                    };
                    $.get("{{ route('dashboard.index') }}", function(data) {
                        // alert(data.link);
                        $('div#section').text(kFormatter(data.section));
                        $('div#categories').text(kFormatter(data.categories));
                        $('div#author').text(kFormatter(data.author));
                        $('div#quote').text(kFormatter(data.quotes));
                        $('div#users').text(kFormatter(data.users));


                    })
                });
    </script>
@endsection

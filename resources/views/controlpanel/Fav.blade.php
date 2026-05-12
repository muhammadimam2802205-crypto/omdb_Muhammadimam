@include('template.header')
         {{-- main content --}}
<div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('My Favorites') }}</h1>

                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ url('/dashboard') }}">
                            {{ __('Dashboard') }}
                        </a>
                    </div>

                    <div class="breadcrumb-item">
                        {{ __('Favorites') }}
                    </div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('Favorite Movies') }}</h4>
                            </div>

                            <div class="card-body">
                                <div id="favorites-content">
                                    <div class="text-center py-5">
                                        <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>

                                        <h5 class="text-muted">
                                            {{ __('No favorites yet') }}
                                        </h5>

                                        <p class="text-muted">
                                            {{ __('Start adding movies to your favorites list!') }}
                                        </p>

                                        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-search"></i>
                                            {{ __('Search Movies') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('template.footer')
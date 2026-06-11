@include('template.header')
<!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Movie Detail') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}?q={{ str_replace(' ', '+', request('q')) }}">{{ __('Movies') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Movie Detail') }}</div>
                </div>
            </div>

            <div class="section-body">
                @if ($error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @else
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <img src="{{ $movie['Poster'] }}" alt="{{ $movie['Title'] }}" class="img-fluid rounded"
                                        loading="lazy"
                                        onerror="
            this.onerror=null;
            this.src='/assets/img/no-image.jpg';
        ">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h2 class="mb-1">{{ $movie['Title'] }}</h2>
                                            <p class="text-muted mb-3">
                                                {{ $movie['Year'] }} • {{ $movie['Runtime'] }} • {{ $movie['Genre'] }}
                                            </p>
                                        </div>
                                        @if ($isFavorite)
                                            <button type="button" class="btn favorite-btn btn-danger"
                                                data-imdb="{{ $movie['imdbID'] }}"
                                                id="favorite-btn-{{ $movie['imdbID'] }}">
                                                <i class="fa-heart fas"></i>
                                                <span>{{ __('Remove from Favorites') }}</span>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-outline-danger favorite-btn"
                                                data-imdb="{{ $movie['imdbID'] }}"
                                                id="favorite-btn-{{ $movie['imdbID'] }}">
                                                <i class="far fa-heart"></i>
                                                <span>{{ __('Add to Favorites') }}</span>
                                            </button>
                                        @endif

                                    </div>

                                    <div class="mb-4">
                                        @foreach ($movie['Ratings'] as $rating)
                                            <span class="badge badge-info mr-1">{{ $rating['Source'] }}:
                                                {{ $rating['Value'] }}</span>
                                        @endforeach
                                        <span class="badge badge-warning mr-1">IMDb: {{ $movie['imdbRating'] }}</span>
                                    </div>

                                    <h5>{{ __('Plot') }}</h5>
                                    <p class="mb-4">{{ $movie['Plot'] }}</p>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>{{ __('Director') }}</h6>
                                            <p>{{ $movie['Director'] }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Writer</h6>
                                            <p>{{ $movie['Writer'] }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>{{ __('Actors') }}</h6>
                                            <p>{{ $movie['Actors'] }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{ __('Language') }}</h6>
                                            <p>{{ $movie['Language'] }}</p>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <h6>{{ __('Country') }}</h6>
                                            <p>{{ $movie['Country'] }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>{{ __('Box Office') }}</h6>
                                            <p>{{ $movie['BoxOffice'] ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <a href="{{ route('dashboard') }}?q={{ str_replace(' ', '+', request('q')) }}"
                                            class="btn btn-secondary">
                                            <i class="fas fa-arrow-left"></i> {{ __('Back to Movies') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@push('scripts')
    <script>
        const translations = {
            addFavorite: "{{ __('Add to Favorites') }}",
            removeFavorite: "{{ __('Remove from Favorites') }}",
            movieRemovedFromFavorites: "{{ __('Movie removed from favorites') }}",
            movieAddedToFavorites: "{{ __('Movie added to favorites') }}"
        };

        function getCsrfToken() {
            return $('meta[name="csrf-token"]').attr('content') || '';
        }

        let isFavorite = @json($isFavorite);
        const imdbId = @json($movie['imdbID']);

        function updateFavoriteButton() {
            const $btn = $('#favorite-btn-' + imdbId);
            if (isFavorite) {
                $btn.removeClass('btn-outline-danger').addClass('btn-danger');
                $btn.find('i').removeClass('far').addClass('fas');
                $btn.find('span').text(translations.removeFavorite);
            } else {
                $btn.removeClass('btn-danger').addClass('btn-outline-danger');
                $btn.find('i').removeClass('fas').addClass('far');
                $btn.find('span').text(translations.addFavorite);
            }
        }

        $(document).ready(function() {
            $('#favorite-btn-' + imdbId).on('click', function() {
                if (isFavorite) {
                    $.ajax({
                        url: `/favorites/${imdbId}`,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json'
                        },
                        success: function(data) {
                            if (data.success) {
                                isFavorite = false;
                                updateFavoriteButton();
                                Swal.fire({
                                    icon: 'success',
                                    text: translations.movieRemovedFromFavorites,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function(err) {
                            console.error('Error removing favorite:', err);
                        }
                    });
                } else {
                    $.ajax({
                        url: '/favorites/add',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify({
                            imdb_id: imdbId
                        }),
                        success: function(data) {
                            if (data.success) {
                                isFavorite = true;
                                updateFavoriteButton();
                                Swal.fire({
                                    icon: 'success',
                                    text: translations.movieAddedToFavorites,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 2000
                                });
                            }
                        },
                        error: function(err) {
                            console.error('Error adding favorite:', err);
                        }
                    });
                }
            });
        });
    </script>
@endpush

@include('template.footer')

@include('template.header')
<!-- Main Content -->
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
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Poster') }}</th>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Year') }}</th>
                                                <th>{{ __('Genre') }}</th>
                                                <th>{{ __('Rating') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($movies as $movie)
                                                <tr>
                                                    <td class="align-middle">
                                                        <img src="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : asset('img/no-image.jpg') }}"
                                                            alt="{{ $movie['Title'] }}" class="rounded" width="50"
                                                            height="70" style="object-fit:cover">
                                                    </td>
                                                    <td class="align-middle">{{ $movie['Title'] }}</td>
                                                    <td class="align-middle">{{ $movie['Year'] }}</td>
                                                    <td class="align-middle">{{ $movie['Genre'] ?? '-' }}</td>
                                                    <td class="align-middle">
                                                        <span class="badge badge-warning">
                                                            <i class="fas fa-star"></i>
                                                            {{ $movie['imdbRating'] ?? 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">

                                                        <a href="{{ route('movies.detail', ['imdbID' => $movie['imdbID']]) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> {{ __('Detail') }}
                                                        </a>
                                                        <button type="button" data-imdb={{ $movie['imdbID'] }}
                                                            class="btn btn-sm btn-danger remove-favorite">
                                                            <i class="fas fa-trash"></i> {{ __('Remove') }}
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-5">
                                                        <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                                                        <h5 class="text-muted">{{ __('No favorites yet') }}</h5>
                                                        <p class="text-muted">
                                                            {{ __('Start adding movies to your favorites list!') }}</p>
                                                        <a href="/movies" class="btn btn-primary mt-2">
                                                            <i class="fas fa-search"></i> {{ __('Browse Movies') }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @push('scripts')
    <script>
        const translations = {
            removeFromFavorites: "{{ __('Remove from Favorites?') }}",
            areYouSure: "{{ __('Are you sure you want to remove this movie from your favorites?') }}",
            yesRemoveIt: "{{ __('Yes, Remove it!') }}",
            cancel: "{{ __('Cancel') }}",
            movieRemovedFromFavorites: "{{ __('Movie removed from favorites') }}",
        };
        document.querySelectorAll('.remove-favorite').forEach(function(button) {
            button.addEventListener('click', function() {
                const imdbID = this.dataset.imdb;
                const row = this.closest('tr');

                Swal.fire({
                    title: translations.removeFromFavorites,
                    text: translations.areYouSure,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: translations.yesRemoveIt,
                    cancelButtonText: translations.cancel
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/favorites/${imdbID}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Accept': 'application/json',
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    row.remove();
                                    const remainingRows = document.querySelectorAll('tbody tr')
                                        .length;

                                    if (remainingRows === 0) {
                                        const tbody = document.querySelector('tbody');
                                        tbody.innerHTML = `
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                                                    <h5 class="text-muted">{{ __('No favorites yet') }}</h5>
                                                    <p class="text-muted">{{ __('Start adding movies to your favorites list!') }}</p>
                                                    <a href="/movies" class="btn btn-primary mt-2">
                                                        <i class="fas fa-search"></i> {{ __('Browse Movies') }}
                                                    </a>
                                                </td>
                                            </tr>
                                        `;
                                    }
                                    Swal.fire({
                                        icon: 'success',
                                        text: translations.movieRemovedFromFavorites,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            })
                            .catch(() => {
                                Swal.fire('Error!', 'Terjadi kesalahan.', 'error');
                            });
                    }
                });
            });
        });
    </script>
@endpush
@include('template.footer')
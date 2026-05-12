@include('template.header')
      <!-- Main Content -->
     <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ __('Movies') }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="#">{{ __('Dashboard') }}</a>
                    </div>
                    <div class="breadcrumb-item">{{ __('Movies') }}</div>
                    <div class="breadcrumb-item">{{ __('All Movies') }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('All Movies') }}</h4>
                            </div>

                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ url('/') }}/movies" id="search-form">
                                        <div class="input-group">
                                            <input type="text" name="q" id="search-input" class="form-control"
                                                placeholder="{{ __('Search movies...') }}" value="">

                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table table-striped" id="movie-table">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Poster') }}</th>
                                                <th>{{ __('Title') }}</th>
                                                <th>{{ __('Year') }}</th>
                                                <th>{{ __('Type') }}</th>
                                                <th>{{ __('Action') }}</th>
                                            </tr>
                                        </thead>

                                        <tbody id="movie-container">
                                            <tr id="empty-row">
                                                <td colspan="5" class="text-center py-5">
                                                    <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>

                                                    <span class="text-muted">
                                                        {{ __('Enter a keyword to search movies.') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="loader" class="text-center py-3" style="display: none;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="sr-only">{{ __('Loading...') }}</span>
                                    </div>

                                    <p class="text-muted mt-2">
                                        {{ __('Loading more movies...') }}
                                    </p>
                                </div>

                                <div id="no-more" class="text-center text-muted py-3" style="display: block;">
                                    <i class="fas fa-check-circle"></i>
                                    {{ __('All movies loaded.') }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@include('template.footer')
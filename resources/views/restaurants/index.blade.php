@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 bg-dark text-light">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="mb-0 text-accent">Restaurants</h1>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-accent" data-bs-toggle="modal" data-bs-target="#addRestaurantModal">
                <i class="fas fa-plus-circle me-2"></i>Ajouter un restaurant
            </button>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
        @foreach($restaurants as $restaurant)
        <div class="col">
            <div class="card bg-secondary h-100 restaurant-card">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-accent">{{ $restaurant->nom }}</h5>
                    <p class="card-text mb-2 text-light">
                        <i class="fas fa-map-marker-alt me-2 text-accent"></i>{{ $restaurant->adresse }}
                    </p>
                    <p class="card-text mb-2 text-light">
                        <i class="fas fa-tags me-2 text-accent"></i>
                        @foreach($restaurant->categories as $category)
                            <span class="badge bg-accent">{{ $category->name }}</span>
                        @endforeach
                    </p>
                    <div class="mt-auto">
                        <div class="rating mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $restaurant->note ? 'text-accent' : 'text-muted' }}"></i>
                            @endfor
                            <span class="ms-2 text-light">{{ $restaurant->note }}/5</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-accent btn-sm" data-bs-toggle="modal" data-bs-target="#editRestaurantModal{{ $restaurant->id }}">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </button>
                            <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST" class="d-inline delete-restaurant-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger btn-sm delete-restaurant" data-id="{{ $restaurant->id }}">
                                    <i class="fas fa-trash me-1"></i>Supprimer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-auto">
            {{ $restaurants->links() }}
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div id="map" style="height: 400px;"></div>
        </div>  
    </div>
</div>

<!-- Modal pour ajouter un restaurant -->
<div class="modal fade" id="addRestaurantModal" tabindex="-1" aria-labelledby="addRestaurantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-secondary">
            <div class="modal-header border-dark">
                <h5 class="modal-title text-accent" id="addRestaurantModalLabel">Ajouter un restaurant</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRestaurantForm" action="{{ route('restaurants.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label text-light">Nom</label>
                        <input type="text" class="form-control bg-dark text-light border-dark" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label text-light">Adresse</label>
                        <input type="text" class="form-control bg-dark text-light border-dark" id="adresse" name="adresse" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label text-light">Note</label>
                        <input type="number" class="form-control bg-dark text-light border-dark" id="note" name="note" min="1" max="5" required>
                    </div>
                    <div class="mb-3">
                        <label for="latitude" class="form-label text-light">Latitude</label>
                        <input type="number" step="any" class="form-control bg-dark text-light border-dark" id="latitude" name="latitude" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitude" class="form-label text-light">Longitude</label>
                        <input type="number" step="any" class="form-control bg-dark text-light border-dark" id="longitude" name="longitude" required>
                    </div>
                    <div class="mb-3">
                        <label for="categories" class="form-label text-light">Catégories</label>
                        <select multiple class="form-select bg-dark text-light border-dark" id="categories" name="categories[]" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-dark">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="addRestaurantForm" class="btn btn-accent">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier un restaurant -->
@foreach($restaurants as $restaurant)
<div class="modal fade" id="editRestaurantModal{{ $restaurant->id }}" tabindex="-1" aria-labelledby="editRestaurantModalLabel{{ $restaurant->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-secondary">
            <div class="modal-header border-dark">
                <h5 class="modal-title text-accent" id="editRestaurantModalLabel{{ $restaurant->id }}">Modifier {{ $restaurant->nom }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRestaurantForm{{ $restaurant->id }}" action="{{ route('restaurants.update', $restaurant) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nom{{ $restaurant->id }}" class="form-label text-light">Nom</label>
                        <input type="text" class="form-control bg-dark text-light border-dark" id="nom{{ $restaurant->id }}" name="nom" value="{{ $restaurant->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse{{ $restaurant->id }}" class="form-label text-light">Adresse</label>
                        <input type="text" class="form-control bg-dark text-light border-dark" id="adresse{{ $restaurant->id }}" name="adresse" value="{{ $restaurant->adresse }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="note{{ $restaurant->id }}" class="form-label text-light">Note</label>
                        <input type="number" class="form-control bg-dark text-light border-dark" id="note{{ $restaurant->id }}" name="note" min="1" max="5" value="{{ $restaurant->note }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="latitude{{ $restaurant->id }}" class="form-label text-light">Latitude</label>
                        <input type="number" step="any" class="form-control bg-dark text-light border-dark" id="latitude{{ $restaurant->id }}" name="latitude" value="{{ $restaurant->latitude }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitude{{ $restaurant->id }}" class="form-label text-light">Longitude</label>
                        <input type="number" step="any" class="form-control bg-dark text-light border-dark" id="longitude{{ $restaurant->id }}" name="longitude" value="{{ $restaurant->longitude }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="categories{{ $restaurant->id }}" class="form-label text-light">Catégories</label>
                        <select multiple class="form-select bg-dark text-light border-dark" id="categories{{ $restaurant->id }}" name="categories[]" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $restaurant->categories->contains($category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-dark">
                <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="editRestaurantForm{{ $restaurant->id }}" class="btn btn-accent">Modifier</button>
            </div>
        </div>
    </div>  
</div>
@endforeach

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Code de la carte Leaflet (inchangé)
    const map = L.map('map').setView([44.8378, -0.5792], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    @foreach($restaurants as $restaurant)
        L.marker([{{ $restaurant->latitude }}, {{ $restaurant->longitude }}])
            .addTo(map)
            .bindPopup("<b>{{ $restaurant->nom }}</b><br>{{ $restaurant->adresse }}");
    @endforeach

    // Nouveau code pour la suppression des restaurants
    document.querySelectorAll('.delete-restaurant').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?')) {
                const form = this.closest('.delete-restaurant-form');
                form.submit();
            }
        });
    });
});
</script>
@endpush
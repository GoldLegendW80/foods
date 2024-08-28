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
                <img src="https://picsum.photos/300/200?random={{ $loop->index }}" class="card-img-top" alt="{{ $restaurant->nom }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-accent">{{ $restaurant->nom }}</h5>
                    <p class="card-text mb-2 text-secondary">
                        <i class="fas fa-map-marker-alt me-2 text-accent"></i>{{ $restaurant->adresse }}
                    </p>
                    <p class="card-text mb-2 text-secondary">
                        <i class="fas fa-utensils me-2 text-accent"></i>{{ $restaurant->type_cuisine }}
                    </p>
                    <p class="card-text mb-2 text-secondary">
                        <i class="fas fa-tags me-2 text-accent"></i>
                        @foreach($restaurant->categories as $category)
                            <span class="badge bg-accent text-dark me-1">{{ $category->name }}</span>
                        @endforeach
                    </p>
                    <div class="mt-auto">
                        <div class="rating mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $restaurant->note ? 'text-accent' : 'text-muted' }}"></i>
                            @endfor
                            <span class="ms-2 text-secondary">{{ $restaurant->note }}/5</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-accent btn-sm" data-bs-toggle="modal" data-bs-target="#editRestaurantModal{{ $restaurant->id }}">
                                <i class="fas fa-edit me-1"></i>Modifier
                            </button>
                            <button class="btn btn-outline-danger btn-sm delete-restaurant" data-id="{{ $restaurant->id }}">
                                <i class="fas fa-trash me-1"></i>Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-auto">
            {{ $restaurants->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div id="map" class="rounded" style="height: 400px;"></div>
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
                        <label for="type_cuisine" class="form-label text-light">Type de cuisine</label>
                        <input type="text" class="form-control bg-dark text-light border-dark" id="type_cuisine" name="type_cuisine" required>
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
                        <label class="form-label text-light">Catégories</label>
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="category{{ $category->id }}" name="categories[]">
                                <label class="form-check-label text-light" for="category{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
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
                        <label for="type_cuisine{{ $restaurant->id }}" class="form-label text-light">Type de cuisine</label>
                        <input type="text" class="form-control bg-dark text-light border-dark" id="type_cuisine{{ $restaurant->id }}" name="type_cuisine" value="{{ $restaurant->type_cuisine }}" required>
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
                        <label for="longitude{{ $restaurant->id }}" class</div>
                    <div class="mb-3">
                        <label for="longitude{{ $restaurant->id }}" class="form-label text-light">Longitude</label>
                        <input type="number" step="any" class="form-control bg-dark text-light border-dark" id="longitude{{ $restaurant->id }}" name="longitude" value="{{ $restaurant->longitude }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-light">Catégories</label>
                        @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $category->id }}" id="category{{ $category->id }}_{{ $restaurant->id }}" name="categories[]" {{ $restaurant->categories->contains($category->id) ? 'checked' : '' }}>
                                <label class="form-check-label text-light" for="category{{ $category->id }}_{{ $restaurant->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
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
    const map = L.map('map').setView([48.8566, 2.3522], 12);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 20
    }).addTo(map);

    function loadRestaurants() {
        fetch('{{ route('restaurants.getAll') }}')
            .then(response => response.json())  
            .then(restaurants => {
                restaurants.forEach(restaurant => {
                    L.marker([restaurant.latitude, restaurant.longitude])
                        .addTo(map)
                        .bindPopup(`
                            <b class="text-accent">${restaurant.nom}</b><br>
                            ${restaurant.adresse}<br>
                            Cuisine : ${restaurant.type_cuisine}<br>
                            Note : ${restaurant.note}/5<br>
                            Catégories : ${restaurant.categories.map(c => c.name).join(', ')}
                        `);
                });
                const bounds = L.latLngBounds(restaurants.map(r => [r.latitude, r.longitude]));
                map.fitBounds(bounds);
            });
    }

    loadRestaurants();

    const deleteButtons = document.querySelectorAll('.delete-restaurant');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const restaurantId = this.getAttribute('data-id');
            if (confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?')) {
                fetch(`/restaurants/${restaurantId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.col').remove();
                        map.eachLayer(function (layer) {
                            if (layer instanceof L.Marker) {
                                map.removeLayer(layer);
                            }
                        });
                        loadRestaurants();
                        showToast('Restaurant supprimé avec succès', 'success');
                    } else {
                        showToast('Une erreur est survenue lors de la suppression', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Une erreur est survenue lors de la suppression', 'error');
                });
            }
        });
    });

    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0 position-fixed bottom-0 end-0 m-3`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
});
</script>
@endpush

@push('styles')
<style>
    :root {
        --bg-primary: #121212;
        --bg-secondary: #1E1E1E;
        --text-primary: #E0E0E0;
        --text-secondary: #B0B0B0;
        --accent: #FFB708;
        --border: #333333;
        --hover: #FF9500;
    }

    body {
        background-color: var(--bg-primary);
        color: var(--text-primary);
    }

    .bg-dark {
        background-color: var(--bg-primary) !important;
    }

    .bg-secondary {
        background-color: var(--bg-secondary) !important;
    }

    .text-light {
        color: var(--text-primary) !important;
    }

    .text-secondary {
        color: var(--text-secondary) !important;
    }

    .text-accent {
        color: var(--accent) !important;
    }

    .border-dark {
        border-color: var(--border) !important;
    }

    .btn-accent {
        background-color: var(--accent);
        border-color: var(--accent);
        color: var(--bg-primary);
    }

    .btn-accent:hover {
        background-color: var(--hover);
        border-color: var(--hover);
        color: var(--bg-primary);
    }

    .btn-outline-accent {
        color: var(--accent);
        border-color: var(--accent);
    }

    .btn-outline-accent:hover {
        background-color: var(--accent);
        color: var(--bg-primary);
    }

    .btn-outline-light {
        color: var(--text-primary);
        border-color: var(--text-primary);
    }

    .btn-outline-light:hover {
        background-color: var(--text-primary);
        color: var(--bg-primary);
    }

    .restaurant-card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .restaurant-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .restaurant-card .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .restaurant-card .card-title {
        font-size: 1.25rem;
        font-weight: bold;
    }

    .restaurant-card .rating {
        font-size: 0.9rem;
    }

    .pagination .page-link {
        background-color: var(--bg-secondary);
        border-color: var(--border);
        color: var(--text-primary);
    }

    .pagination .page-link:hover {
        background-color: var(--hover);
        border-color: var(--hover);
        color: var(--bg-primary);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--accent);
        border-color: var(--accent);
        color: var(--bg-primary);
    }

    #map {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .modal-content {
        border: none;
        border-radius: 10px;
    }

    .form-control {
        background-color: var(--bg-primary);
        border-color: var(--border);
        color: var(--text-primary);
    }

    .form-control:focus {
        background-color: var(--bg-primary);
        border-color: var(--accent);
        box-shadow: 0 0 0 0.25rem rgba(255, 183, 8, 0.25);
        color: var(--text-primary);
    }

    .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    .toast {
        background-color: var(--bg-secondary);
        border-radius: 10px;
    }

    .toast-success {
        border-left: 4px solid #4caf50;
    }

    .toast-error {
        border-left: 4px solid #f44336;
    }

    /* Personnalisation des scrollbars pour les navigateurs WebKit */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: var(--bg-secondary);
    }

    ::-webkit-scrollbar-thumb {
        background: var(--border);
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--accent);
    }
</style>
@endpush
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="mb-0">Liste des restaurants</h1>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRestaurantModal">
                <i class="fas fa-plus-circle me-2"></i>Ajouter
            </button>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
        @foreach($restaurants as $restaurant)
        <div class="col">
            <div class="card restaurant-card h-100">
                <img src="https://picsum.photos/300/200?random={{ $loop->index }}" class="card-img-top" alt="{{ $restaurant->nom }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $restaurant->nom }}</h5>
                    <p class="card-text mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>{{ $restaurant->adresse }}
                    </p>
                    <p class="card-text mb-2">
                        <i class="fas fa-utensils me-2"></i>{{ $restaurant->type_cuisine }}
                    </p>
                    <div class="d-flex align-items-center mt-auto">
                        <div class="rating flex-grow-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $restaurant->note ? 'active' : '' }}"></i>
                            @endfor
                            <span class="text-muted me-3">{{ $restaurant->note }}/5</span>
                        </div>
                        
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editRestaurantModal{{ $restaurant->id }}">
                            <i class="fas fa-edit"></i>
                        </button>
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
                <div id="map" style="height: 400px;"></div>
        </div>  
    </div>
</div>

<!-- Modale pour ajouter un restaurant -->
<div class="modal fade" id="addRestaurantModal" tabindex="-1" aria-labelledby="addRestaurantModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRestaurantModalLabel">Ajouter un restaurant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRestaurantForm" action="{{ route('restaurants.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                    </div>
                    <div class="mb-3">
                        <label for="type_cuisine" class="form-label">Type de cuisine</label>
                        <input type="text" class="form-control" id="type_cuisine" name="type_cuisine" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <input type="number" class="form-control" id="note" name="note" min="1" max="5" required>
                    </div>
                    <div class="mb-3">
                        <label for="latitude" class="form-label">Latitude</label>
                        <input type="number" step="any" class="form-control" id="latitude" name="latitude" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitude" class="form-label">Longitude</label>
                        <input type="number" step="any" class="form-control" id="longitude" name="longitude" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="addRestaurantForm" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </div>
</div>

<!-- Modale pour modifier un restaurant -->
@foreach($restaurants as $restaurant)
<div class="modal fade" id="editRestaurantModal{{ $restaurant->id }}" tabindex="-1" aria-labelledby="editRestaurantModalLabel{{ $restaurant->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRestaurantModalLabel{{ $restaurant->id }}">Modifier {{ $restaurant->nom }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRestaurantForm{{ $restaurant->id }}" action="{{ route('restaurants.update', $restaurant) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nom{{ $restaurant->id }}" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="nom{{ $restaurant->id }}" name="nom" value="{{ $restaurant->nom }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="adresse{{ $restaurant->id }}" class="form-label">Adresse</label>
                        <input type="text" class="form-control" id="adresse{{ $restaurant->id }}" name="adresse" value="{{ $restaurant->adresse }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="type_cuisine{{ $restaurant->id }}" class="form-label">Type de cuisine</label>
                        <input type="text" class="form-control" id="type_cuisine{{ $restaurant->id }}" name="type_cuisine" value="{{ $restaurant->type_cuisine }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="note{{ $restaurant->id }}" class="form-label">Note</label>
                        <input type="number" class="form-control" id="note{{ $restaurant->id }}" name="note" min="1" max="5" value="{{ $restaurant->note }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="latitude{{ $restaurant->id }}" class="form-label">Latitude</label>
                        <input type="number" step="any" class="form-control" id="latitude{{ $restaurant->id }}" name="latitude" value="{{ $restaurant->latitude }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="longitude{{ $restaurant->id }}" class="form-label">Longitude</label>
                        <input type="number" step="any" class="form-control" id="longitude{{ $restaurant->id }}" name="longitude" value="{{ $restaurant->longitude }}" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" form="editRestaurantForm{{ $restaurant->id }}" class="btn btn-primary">Modifier</button>
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
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    fetch('{{ route('restaurants.getAll') }}')
        .then(response => response.json())  
        .then(restaurants => {
            restaurants.forEach(restaurant => {
                L.marker([restaurant.latitude, restaurant.longitude])
                    .addTo(map)
                    .bindPopup(`
                        <b>${restaurant.nom}</b><br>
                        ${restaurant.adresse}<br>
                        Cuisine : ${restaurant.type_cuisine}<br>
                        Note : ${restaurant.note}/5
                    `);
            });
            const bounds = L.latLngBounds(restaurants.map(r => [r.latitude, r.longitude]));
            map.fitBounds(bounds);
        });
});
</script>
@endpush

@push('styles')
<style>
    .restaurant-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .restaurant-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    .restaurant-card .card-img-top {
        height: 200px;
        object-fit: cover;
        border-radius: 10px 10px 0 0;
    }

    .restaurant-card .card-title {
        font-size: 20px;
        font-weight: bold;
    }

    .restaurant-card .rating {
        font-size: 18px;
    }

    .restaurant-card .rating .fas {
        color: #e4e4e4;
    }

    .restaurant-card .rating .fas.active {
        color: #ffdf00;
    }

    .btn-primary {
        background-color: #2e86c1;
        border-color: #2e86c1;
    }

    .btn-primary:hover {
        background-color: #1c6393;
        border-color: #1c6393;
    }

    .btn-outline-primary {
        color: #2e86c1;
        border-color: #2e86c1;
    }

    .btn-outline-primary:hover {
        color: #fff;
        background-color: #2e86c1;
        border-color: #2e86c1;
    }

    .pagination .page-link {
        color: #333;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .pagination .page-link:hover {
        color: #2e86c1;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }

    .pagination .page-item.active .page-link {
        color: #fff;
        background-color: #2e86c1;
        border-color: #2e86c1;
    }
    
    #map {
        border-radius: 10px;
    }
</style>
@endpush
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 bg-dark text-light">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="mb-0 text-accent">Roue de la Fortune des Restaurants</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card bg-secondary">
                <div class="card-body text-center">
                    <div class="wheel-container">
                        <div class="wheel" id="wheel">
                            @foreach($restaurants as $index => $restaurant)
                                <div class="wheel-segment" style="--rotation: {{ $index * (360 / $restaurants->count()) }}deg; --bg-color: {{ '#' . substr(md5($restaurant->id), 0, 6) }};">
                                    <span>{{ $restaurant->nom }}</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="wheel-pointer"></div>
                    </div>
                    <button id="spin-btn" class="btn btn-accent mt-3">Tourner la roue</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 mx-auto">
            <div class="card bg-secondary">
                <div class="card-body">
                    <h5 class="card-title text-accent">Résultat</h5>
                    <p id="result" class="text-light"></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .wheel-container {
        position: relative;
        width: 300px;
        height: 300px;
        margin: 0 auto;
    }
    .wheel {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        position: relative;
        overflow: hidden;
        transition: transform 5s cubic-bezier(0.25, 0.1, 0.25, 1);
    }
    .wheel-segment {
        position: absolute;
        width: 50%;
        height: 50%;
        transform-origin: 100% 100%;
        left: 50%;
        top: 0;
        transform: rotate(var(--rotation));
    }
    .wheel-segment::before {
        content: '';
        position: absolute;
        width: 200%;
        height: 200%;
        border-radius: 50%;
        background-color: var(--bg-color);
        left: -100%;
        top: -100%;
        transform: skew(-60deg);
    }
    .wheel-segment span {
        position: absolute;
        left: -100%;
        width: 200%;
        text-align: center;
        transform: skew(60deg) rotate(90deg);
        padding-top: 20px;
        font-weight: bold;
        font-size: 12px;
    }
    .wheel-pointer {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 0;
        height: 0;
        border-left: 10px solid transparent;
        border-right: 10px solid transparent;
        border-top: 20px solid red;
        z-index: 2;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const wheel = document.getElementById('wheel');
    const spinBtn = document.getElementById('spin-btn');
    const result = document.getElementById('result');
    const segments = {{ $restaurants->count() }};
    let spinning = false;

    spinBtn.addEventListener('click', spinWheel);

    function spinWheel() {
        if (spinning) return;
        spinning = true;
        const rotation = Math.floor(Math.random() * 360) + 720; // Au moins 2 tours complets
        wheel.style.transform = `rotate(${rotation}deg)`;
        
        setTimeout(() => {
            const actualRotation = rotation % 360;
            const segmentSize = 360 / segments;
            const selectedIndex = Math.floor(actualRotation / segmentSize);
            const selectedRestaurant = '{{ $restaurants[0]->nom }}'; // Remplacer par la logique pour obtenir le bon restaurant

            result.textContent = `Vous devriez manger chez : ${selectedRestaurant}`;
            spinning = false;
        }, 5000);
    }
});
</script>
@endpush
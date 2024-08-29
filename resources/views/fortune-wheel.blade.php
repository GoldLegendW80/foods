@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 bg-dark text-light position-relative">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h1 class="mb-0 text-accent">Tourner la Roue</h1>
        </div>
        <div class="col-auto">
            <button id="settings-btn" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#settingsModal">
                <i class="fas fa-cog"></i> Réglages
            </button>
        </div>
    </div>

    <div id="fireworks" class="fireworks"></div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card bg-secondary">
                <div class="card-body text-center">
                    <div class="slot-machine">
                        <div class="slot-window">
                            <div class="slot" id="slot">
                                <!-- Les restaurants seront ajoutés ici dynamiquement -->
                            </div>
                        </div>
                        <div class="lever-container">
                            <div class="lever" id="lever"></div>
                        </div>
                    </div>
                    <button id="spin-btn" class="btn btn-accent mt-3">Tirer le levier</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 mx-auto">
            <div class="card bg-secondary">
                <div class="card-body text-center">
                    <h5 class="card-title text-accent">Résultat</h5>
                    <div id="result" class="text-light result-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de réglages -->
<div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="settingsModalLabel">Sélection des restaurants</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>Restaurants disponibles</h6>
                <ul id="available-restaurants" class="list-group">
                    @foreach($restaurants as $restaurant)
                        <li class="list-group-item bg-secondary text-light">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $restaurant->id }}" id="restaurant-{{ $restaurant->id }}" checked>
                                <label class="form-check-label" for="restaurant-{{ $restaurant->id }}">
                                    {{ $restaurant->nom }}
                                </label>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-accent" id="save-settings" data-bs-dismiss="modal">Enregistrer</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    body {
        overflow: hidden;
    }

    .slot-machine {
        width: 300px;
        height: 200px;
        border: 10px solid #8B4513;
        border-radius: 15px;
        overflow: hidden;
        margin: 0 auto;
        background: linear-gradient(145deg, #4a4a4a, #3a3a3a);
        box-shadow: 0 0 20px rgba(0,0,0,0.5);
        position: relative;
    }
    .slot-window {
        width: 80%;
        height: 100px;
        margin: 20px auto;
        border: 5px solid #ffd700;
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
    }
    .slot {
        display: flex;
        flex-direction: column;
        transition: transform 1s cubic-bezier(0.25, 0.1, 0.25, 1);
    }
    .slot-item {
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        background-color: #fff;
        border-bottom: 1px solid #ddd;
    }
    .lever-container {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 30px;
        height: 100px;
    }
    .lever {
        width: 100%;
        height: 50%;
        background-color: #ff4500;
        border-radius: 15px;
        cursor: pointer;
        transition: transform 0.3s;
    }
    .lever:hover {
        transform: scale(1.1);
    }
    .lever.pulled {
        transform: rotate(-20deg);
    }
    .fireworks {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .firework {
        position: fixed;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: white;
        z-index: 9999;
        box-shadow: 0 0 10px 5px rgba(255, 255, 255, 0.8);
    }

    .particle {
        position: fixed;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        z-index: 9999;
    }

    .particle::before {
        content: '';
        position: absolute;
        top: -3px;
        left: -3px;
        right: -3px;
        bottom: -3px;
        background: radial-gradient(circle at 30% 30%, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.2));
        border-radius: 50%;
        z-index: -1;
    }

    @keyframes explode {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    @keyframes shoot {
        0% { transform: translateY(0) scale(1); }
        100% { transform: translateY(100px) scale(0); }
    }

    @keyframes fall {
        0% { transform: translateY(-100%) rotate(0deg); }
        100% { transform: translateY(100vh) rotate(720deg); }
    }

    .result-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100px;
    }

    .result-label {
        font-weight: bold;
        color: #ffd700;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
    }

    .result-restaurant {
        font-size: 2rem;
        font-weight: bold;
        color: #ff4500;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    }

    #settings-btn {
        position: absolute;
        top: 20px;
        right: 20px;
    }

    .modal-content {
        background-color: #2a2a2a;
    }

    .list-group-item {
        background-color: #3a3a3a;
        color: #fff;
        border: 1px solid #4a4a4a;
    }

    .list-group-item:hover {
        background-color: #4a4a4a;
    }

    .form-check-input:checked {
        background-color: #ff4500;
        border-color: #ff4500;
    }

    #available-restaurants {
        max-height: 300px;
        overflow-y: auto;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slot = document.getElementById('slot');
    const spinBtn = document.getElementById('spin-btn');
    const result = document.getElementById('result');
    const lever = document.getElementById('lever');
    const fireworksContainer = document.getElementById('fireworks');
    const saveSettingsBtn = document.getElementById('save-settings');
    const availableRestaurants = document.getElementById('available-restaurants');
    let restaurants = @json($restaurants->pluck('nom'));
    let spinning = false;

    function updateSlotMachine() {
        const slotItems = [...restaurants, ...restaurants, ...restaurants];
        slot.innerHTML = slotItems.map(name => `<div class="slot-item">${name}</div>`).join('');
    }

    updateSlotMachine();

    spinBtn.addEventListener('click', spinSlot);
    lever.addEventListener('click', spinSlot);

    saveSettingsBtn.addEventListener('click', function() {
        const selectedCheckboxes = availableRestaurants.querySelectorAll('input[type="checkbox"]:checked');
        restaurants = Array.from(selectedCheckboxes).map(checkbox => checkbox.nextElementSibling.textContent.trim());
        updateSlotMachine();
        $('#settingsModal').modal('hide');
    });

    function spinSlot() {
        if (spinning || restaurants.length === 0) return;
        spinning = true;
        spinBtn.disabled = true;
        lever.classList.add('pulled');
        result.textContent = "";

        const totalHeight = slot.clientHeight;
        const itemHeight = totalHeight / (restaurants.length * 3);
        const spinDuration = 5000;
        const randomOffset = Math.floor(Math.random() * restaurants.length);
        const finalPosition = -(totalHeight / 3 + randomOffset * itemHeight);

        slot.style.transition = 'none';
        slot.style.transform = 'translateY(0)';
        slot.offsetHeight;
        slot.style.transition = `transform ${spinDuration}ms cubic-bezier(0.25, 0.1, 0.25, 1)`;
        slot.style.transform = `translateY(${finalPosition}px)`;

        setTimeout(() => {
            const selectedRestaurant = restaurants[randomOffset];
            displayResult(selectedRestaurant);
            spinning = false;
            spinBtn.disabled = false;
            lever.classList.remove('pulled');
            celebrateWin();
        }, spinDuration);
    }

    function displayResult(restaurant) {
        result.innerHTML = `
            <div class="result-label">Vous devriez manger chez :</div>
            <div class="result-restaurant">${restaurant}</div>
        `;
        result.style.opacity = '0';
        result.style.transform = 'translateY(20px)';
        result.style.transition = 'opacity 0.5s, transform 0.5s';

        setTimeout(() => {
            result.style.opacity = '1';
            result.style.transform = 'translateY(0)';
        }, 100);
    }

    function celebrateWin() {
        createFireworks();
    }

    function createFireworks() {
        const colors = ['#ff0000', '#ffa500', '#ffff00', '#00ff00', '#0000ff', '#ff00ff'];
        for (let i = 0; i < 15; i++) {
            setTimeout(() => {
                const firework = document.createElement('div');
                firework.classList.add('firework');
                firework.style.left = `${Math.random() * 100}vw`;
                firework.style.top = `${Math.random() * 100}vh`;
                document.body.appendChild(firework);

                const color = colors[Math.floor(Math.random() * colors.length)];
                createParticles(firework.offsetLeft, firework.offsetTop, color);

                setTimeout(() => {
                    document.body.removeChild(firework);
                }, 1000);
            }, i * 200);
        }
    }

    function createParticles(x, y, color) {
        for (let i = 0; i < 30; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            particle.style.backgroundColor = color;
            particle.style.left = `${x}px`;
            particle.style.top = `${y}px`;
            document.body.appendChild(particle);

            const angle = Math.random() * Math.PI * 2;
            const speed = Math.random() * 4 + 2;
            const vx = Math.cos(angle) * speed;
            const vy = Math.sin(angle) * speed;

            animateParticle(particle, vx, vy);
        }
    }

    function animateParticle(particle, vx, vy) {
        let x = parseInt(particle.style.left);
        let y = parseInt(particle.style.top);
        let opacity = 1;

        function update() {
            x += vx;
            y += vy;
            vy += 0.05; // Gravité
            opacity -= 0.02;

            particle.style.left = `${x}px`;
            particle.style.top = `${y}px`;
            particle.style.opacity = opacity;

            if (opacity > 0) {
                requestAnimationFrame(update);
            } else {
                document.body.removeChild(particle);
            }
        }

        requestAnimationFrame(update);
    }
});
</script>
@endpush
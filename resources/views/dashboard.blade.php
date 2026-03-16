<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client - L'ARTISTO Barbershop</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">
                    <span class="crown">👑</span>
                </div>
                <h1 class="brand-name">L'ARTISTO</h1>
            </div>

            <div class="user-info">
                <span class="welcome-text">Bienvenue, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">Déconnexion</button>
                </form>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Services disponibles -->
        <div class="card-title" style="margin: 30px 0 20px 0; font-size: 28px;">
            🎯 Nos Services & Tarifs
        </div>

        <div class="services-grid">
            <!-- Dans la section services -->
            @foreach ($services as $service)
                <div class="service-card">
                    <div class="service-icon">
                        <img src="{{ $service->image ?? 'default_image_url' }}" alt="{{ $service->name }}">
                    </div>
                    <div class="service-name">{{ $service->name }}</div>
                    <div class="service-price">{{ $service->price }}</div>
                    <div class="service-description">{{ $service->description }}</div>
                    <button class="btn-primary btn-book"
                        onclick="openBooking('{{ $service->id }}', '{{ $service->name }}', '{{ $service->price }}', '{{ $service->duration ?? 60 }}')">Réserver</button>
                </div>
            @endforeach
        </div>

        <!-- Grille principale -->
        <div class="dashboard-grid">
            <!-- Nos Coiffeurs -->
            <div class="card">
                <h2 class="card-title">👨‍💼 Nos Coiffeurs</h2>

                @foreach ($users as $user)
                    <div class="barber-item">

                        <div class="barber-avatar">👨</div>
                        <div class="barber-info">
                            <div class="barber-name">{{ $user->name }}</div>
                            <div class="barber-specialty">{{ $user->address }}</div>
                        </div>
                    </div>
                @endforeach


            </div>

            <!-- Rendez-vous en cours -->
            <div class="card">
                <h2 class="card-title">📅 Rendez-vous en Cours</h2>
                @foreach ($rdvs as $rdv)
                    @if (in_array($rdv->etat, ['en attente', 'confirmé']))
                        <div class="appointment-item">
                            <div class="appointment-details">
                                <div class="appointment-date">Le : {{ $rdv->date }} à {{ substr($rdv->heure, 0, 5) }}
                                </div>
                                <div class="appointment-service">
                                    @foreach ($rdv->services as $service)
                                        {{ $service->name }}@if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <span
                                class="appointment-status {{ $rdv->etat == 'confirmé' ? 'status-confirmed' : 'status-pending' }}">
                                {{ $rdv->etat }} </span>
                        </div>
                    @endif
                @endforeach


            </div>
        </div>

        <!-- Historique des rendez-vous -->
        <div class="card">
            <h2 class="card-title">📋 Historique des Rendez-vous</h2>
            @foreach ($rdvs as $rdv)
                @if ($rdv->etat == "terminé")
                    <div class="appointment-item">
                        <div class="appointment-details">
                            <div class="appointment-date">Le : {{ $rdv->date }} à {{ substr($rdv->heure, 0, 5) }}
                            </div>
                            <div class="appointment-service">
                                @foreach ($rdv->services as $service)
                                    {{ $service->name }}@if (!$loop->last)

                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <span class="appointment-status status-completed">Terminé</span>
                    </div>
                @endif
            @endforeach


        </div>

        <!-- Call to Action principal -->
        <div class="main-cta">
            <button class="btn-primary" onclick="openBooking()">📞 Prendre un Rendez-vous</button>
        </div>
    </div>

    <!-- Popup de réservation -->
    <div id="bookingOverlay" class="booking-overlay">
        <div class="booking-popup">
            <div class="booking-header">
                <button class="booking-close" onclick="closeBooking()">&times;</button>
                <div class="booking-title">📅 Réserver un Rendez-vous</div>
                <div class="booking-subtitle">Suivez ces étapes simples pour réserver votre créneau</div>

                <div class="progress-wrapper">
                    <div class="progress-bar">
                        <div class="progress-line">
                            <div id="progressFill" class="progress-fill"></div>
                        </div>
                        <div id="step1" class="progress-step active">1</div>
                        <div id="step2" class="progress-step">2</div>
                        <div id="step3" class="progress-step">3</div>
                        <div id="step4" class="progress-step">4</div>
                        <div id="step5" class="progress-step">5</div>
                    </div>
                    <div class="step-labels">
                        <span>Service</span>
                        <span>Coiffeur</span>
                        <span>Date</span>
                        <span>Heure</span>
                        <span>Confirmation</span>
                    </div>
                </div>
            </div>

            <div class="booking-content">
                <!-- Étapes 1..5 (service, stylist, date, time, summary) -->
                <!-- Étape 1: Sélection du service -->
                <div id="stepContent1" class="step-content active">
                    <div class="step-title">🎯 Choisissez votre service</div>
                    <div class="service-selection">
                        @foreach ($services as $service)
                            <div class="service-option" data-service="{{ $service->id }}" data-name="{{ $service->name }}"
                                data-price="{{ $service->price }}" data-duration="{{ $service->duration ?? 60 }}">
                                <div style="font-size: 48px; margin-bottom: 15px;">✂️</div>
                                <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">{{ $service->name }}
                                </div>
                                <div style="font-size: 24px; color: #D4AF37; font-weight: bold;">{{ $service->price }} DT
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Étape 2: Sélection du coiffeur -->
                <div id="stepContent2" class="step-content">
                    <div class="step-title">👨‍💼 Choisissez votre coiffeur</div>
                    <div id="loadingStylist" class="loading-state">
                        <div class="spinner"></div>
                        <p>Chargement des coiffeurs disponibles...</p>
                    </div>
                    <div id="stylistSelection" class="stylist-selection" style="display: none;">

                        @foreach ($users as $user)
                            <div class="stylist-option" data-stylist="{{ $user->id }}" data-name="{{ $user->name }}">
                                <div class="stylist-avatar">👨</div>
                                <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">{{ $user->name }}
                                </div>
                                <div style="color: #666; font-size: 14px;">{{ $user->address }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Étape 3: Sélection de la date -->
                <div id="stepContent3" class="step-content">
                    <div class="step-title">📅 Choisissez votre date</div>
                    <div id="loadingDate" class="loading-state">
                        <div class="spinner"></div>
                        <p>Chargement des dates disponibles...</p>
                    </div>
                    <div id="dateSelection" class="date-selection" style="display: none;">
                        <!-- Les dates seront générées dynamiquement -->
                    </div>
                </div>

                <!-- Étape 4: Sélection de l'heure -->
                <div id="stepContent4" class="step-content">
                    <div class="step-title">⏰ Choisissez votre heure</div>

                    <div id="loadingTime" class="loading-state" aria-hidden="true">
                        <div class="spinner"></div>
                        <p>Chargement des créneaux disponibles...</p>
                    </div>

                    <!-- message affiché s'il n'y a pas de créneaux -->
                    <div id="noTimeMessage" class="empty-state" style="display: none;" aria-live="polite">
                        Aucun créneau disponible pour cette date.
                    </div>

                    <!-- conteneur où la fonction generateTimes injecte les créneaux -->
                    <div id="timeSelection" class="time-selection" style="display: none;" role="list"
                        aria-live="polite">
                        <!-- Les heures seront générées dynamiquement par generateTimes(times) -->
                    </div>
                </div>

                <!-- Étape 5: Confirmation -->
                <div id="stepContent5" class="step-content">
                    <div class="step-title">✅ Confirmez votre réservation</div>
                    <div class="summary-card">
                        <div class="summary-item">
                            <span class="summary-label">Service :</span>
                            <span id="summaryService" class="summary-value">-</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Coiffeur :</span>
                            <span id="summaryStylist" class="summary-value">-</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Date :</span>
                            <span id="summaryDate" class="summary-value">-</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Heure :</span>
                            <span id="summaryTime" class="summary-value">-</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">Prix :</span>
                            <span id="summaryPrice" class="summary-value">-</span>
                        </div>
                    </div>
                </div>

                <!-- Boutons de navigation : placés ici (hors du scroll interne) -->
                <div class="nav-buttons">
                    <button id="prevBtn" class="btn btn-secondary" onclick="changeStep(-1)" style="display: none;">
                        ← Précédent
                    </button>
                    <button id="nextBtn" class="btn btn-gold" onclick="changeStep(1)" disabled>
                        Suivant →
                    </button>
                    <form action="{{ route('reservation') }}" method="POST" id="bookingForm"
                        style="flex: 1; margin: 0;">
                        @csrf
                        <button id="confirmBtn" type="button" class="btn btn-success" onclick="confirmBooking()"
                            style="display: none;">
                            🎉 Confirmer la réservation
                        </button>
                        <input type="text" hidden name="client_id" id="client_id" value="{{ Auth::user()->id }}">
                        <input type="text" hidden name="service_id" id="service_id">
                        <input type="text" hidden name="stylist_id" id="stylist_id">
                        <input type="text" hidden name="date" id="date">
                        <input type="text" hidden name="time" id="time">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales pour la réservation
        let currentStep = 1;
        let bookingData = {
            service: null,
            stylist: null,
            date: null,
            time: null
        };

        // Ouvrir le popup de réservation
        function openBooking(serviceId = null, serviceName = null, servicePrice = null, serviceDuration = 60) {
            document.getElementById('bookingOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';

            // Si un service spécifique est sélectionné depuis les cartes
            if (serviceId && serviceName && servicePrice) {
                selectService(serviceId, serviceName, servicePrice, serviceDuration);
            }

            updateProgress();
        }

        // Fermer le popup
        function closeBooking() {
            document.getElementById('bookingOverlay').style.display = 'none';
            document.body.style.overflow = 'auto';
            resetBooking();
        }

        // Réinitialiser la réservation
        function resetBooking() {
            currentStep = 1;
            bookingData = { service: null, stylist: null, date: null, time: null };

            // Réinitialiser les sélections
            document.querySelectorAll('.service-option, .stylist-option, .date-option, .time-option').forEach(el => {
                el.classList.remove('selected');
            });

            updateProgress();
            updateStepContent();
            updateNavigationButtons();
        }

        // Changer d'étape
        function changeStep(direction) {
            const newStep = currentStep + direction;

            if (newStep >= 1 && newStep <= 5) {
                // Validation avant de passer à l'étape suivante
                if (direction > 0 && !validateCurrentStep()) {
                    return;
                }

                currentStep = newStep;
                updateProgress();
                updateStepContent();
                updateNavigationButtons();

                // Charger les données pour les nouvelles étapes
                if (currentStep === 2) loadStylists();
                if (currentStep === 3) loadDates();
                if (currentStep === 4) loadTimes();
                if (currentStep === 5) updateSummary();
            }
        }

        // Valider l'étape actuelle
        function validateCurrentStep() {
            switch (currentStep) {
                case 1: return bookingData.service !== null;
                case 2: return bookingData.stylist !== null;
                case 3: return bookingData.date !== null;
                case 4: return bookingData.time !== null;
                default: return true;
            }
        }

        // Mettre à jour la barre de progression
        function updateProgress() {
            const progressFill = document.getElementById('progressFill');
            const progressWidth = (currentStep - 1) * 25;
            progressFill.style.width = progressWidth + '%';

            // Mettre à jour les étapes
            for (let i = 1; i <= 5; i++) {
                const stepEl = document.getElementById(`step${i}`);
                stepEl.classList.remove('active', 'completed');

                if (i < currentStep) {
                    stepEl.classList.add('completed');
                    stepEl.innerHTML = '✓';
                } else if (i === currentStep) {
                    stepEl.classList.add('active');
                    stepEl.innerHTML = i;
                } else {
                    stepEl.innerHTML = i;
                }
            }
        }

        // Mettre à jour le contenu de l'étape
        function updateStepContent() {
            document.querySelectorAll('.step-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(`stepContent${currentStep}`).classList.add('active');
        }

        // Mettre à jour les boutons de navigation
        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const confirmBtn = document.getElementById('confirmBtn');

            prevBtn.style.display = currentStep > 1 ? 'block' : 'none';

            if (currentStep < 5) {
                nextBtn.style.display = 'block';
                confirmBtn.style.display = 'none';
                nextBtn.disabled = !validateCurrentStep();
            } else {
                nextBtn.style.display = 'none';
                confirmBtn.style.display = 'block';
            }
        }

        // Sélection de service
        function selectService(serviceId, serviceName, servicePrice, serviceDuration = 60) {
            bookingData.service = {
                id: serviceId,
                name: serviceName,
                price: servicePrice,
                duration: parseInt(serviceDuration, 10) || 60
            };

            document.querySelectorAll('.service-option').forEach(option => {
                option.classList.remove('selected');
            });

            const selectedOption = document.querySelector(`[data-service="${serviceId}"]`);
            if (selectedOption) {
                selectedOption.classList.add('selected');
            }

            updateNavigationButtons();
            updateSummary();
        }

        // Sélection de coiffeur
        function selectStylist(stylistId, stylistName) {
            bookingData.stylist = { id: stylistId, name: stylistName };

            document.querySelectorAll('.stylist-option').forEach(option => {
                option.classList.remove('selected');
            });

            document.querySelector(`[data-stylist="${stylistId}"]`).classList.add('selected');
            updateNavigationButtons();
            updateSummary();
        }

        // Sélection de date
        function selectDate(dateValue, dateDisplay) {
            bookingData.date = { value: dateValue, display: dateDisplay };

            document.querySelectorAll('.date-option').forEach(option => option.classList.remove('selected'));
            const el = document.querySelector(`[data-date="${dateValue}"]`);
            if (el) el.classList.add('selected');
            updateNavigationButtons();

            // si un coiffeur est déjà choisi, charger ses horaires pour cette date
            if (bookingData.stylist && bookingData.stylist.id) {
                fetchHoraireForStylist(bookingData.stylist.id, dateValue);
            }
            updateSummary();
        }

        // Charger les coiffeurs
        function loadStylists() {
            const loading = document.getElementById('loadingStylist');
            const selection = document.getElementById('stylistSelection');

            loading.style.display = 'block';
            selection.style.display = 'none';

            setTimeout(() => {
                loading.style.display = 'none';
                selection.style.display = 'grid';
            }, 800);
        }

        // Charger les dates
        function loadDates() {
            const loading = document.getElementById('loadingDate');
            const selection = document.getElementById('dateSelection');

            loading.style.display = 'block';
            selection.style.display = 'none';

            setTimeout(() => {
                generateDates();
                loading.style.display = 'none';
                selection.style.display = 'grid';
            }, 800);
        }

        // Générer les dates disponibles
        function generateDates() {
            const dateSelection = document.getElementById('dateSelection');
            dateSelection.innerHTML = '';

            const today = new Date();

            for (let i = 0; i < 14; i++) {
                const date = new Date(today);
                date.setDate(today.getDate() + i);

                const dayName = date.toLocaleDateString('fr-FR', { weekday: 'short' });
                const dayNumber = date.getDate();
                const monthName = date.toLocaleDateString('fr-FR', { month: 'short' });

                const isDisabled = date.getDay() === 2; // Désactiver les mardis (jour 2)

                const dateOption = document.createElement('div');
                dateOption.className = `date-option ${isDisabled ? 'disabled' : ''}`;
                dateOption.setAttribute('data-date', date.toISOString().split('T')[0]);

                if (!isDisabled) {
                    dateOption.onclick = () => selectDate(
                        date.toISOString().split('T')[0],
                        `${dayName} ${dayNumber} ${monthName}`
                    );
                }

                dateOption.innerHTML = `
                    <div style="font-size: 12px; opacity: 0.8;">${dayName}</div>
                    <div style="font-size: 16px; font-weight: bold;">${dayNumber}</div>
                    <div style="font-size: 11px; opacity: 0.6;">${monthName}</div>
                `;

                dateSelection.appendChild(dateOption);
            }
        }

        // Charger les heures
        function loadTimes() {
            const loading = document.getElementById('loadingTime');
            const selection = document.getElementById('timeSelection');

            if (loading) loading.style.display = 'block';
            if (selection) { selection.innerHTML = ''; selection.style.display = 'none'; }

            setTimeout(() => {
                if (bookingData.stylist && bookingData.date && bookingData.stylist.id) {
                    fetchHoraireForStylist(bookingData.stylist.id, bookingData.date.value);
                } else {
                    generateTimes([]); // affichera "Aucun créneau..."
                    if (loading) loading.style.display = 'none';
                    if (selection) selection.style.display = 'grid';
                }
            }, 200);
        }

        // Générer les créneaux horaires (version dynamique)
        function generateTimes(times = []) {
            const timeSelection = document.getElementById('timeSelection');
            const noTimeMessage = document.getElementById('noTimeMessage');
            timeSelection.innerHTML = '';
            if (noTimeMessage) noTimeMessage.style.display = 'none';

            if (!Array.isArray(times) || times.length === 0) {
                if (noTimeMessage) {
                    noTimeMessage.style.display = 'block';
                    timeSelection.style.display = 'none';
                } else {
                    timeSelection.innerHTML = '<div class="empty-state">Aucun créneau disponible pour cette date.</div>';
                    timeSelection.style.display = 'grid';
                }
                return;
            }

            times.forEach((time) => {
                const timeOption = document.createElement('div');
                timeOption.className = 'time-option';
                timeOption.setAttribute('data-time', time);
                timeOption.textContent = time;
                timeOption.onclick = () => selectTime(time);
                timeSelection.appendChild(timeOption);
            });

            timeSelection.style.display = 'grid';
        }

        // Sélectionne un créneau (met à jour bookingData et l'UI)
        function selectTime(time) {
            bookingData.time = time;

            document.querySelectorAll('.time-option').forEach(el => el.classList.remove('selected'));
            const el = document.querySelector(`.time-option[data-time="${time}"]`);
            if (el) el.classList.add('selected');

            updateNavigationButtons();
            updateSummary();
        }

        // Récupère les horaires côté serveur et appelle generateTimes()
        async function fetchHoraireForStylist(stylistId, date) {
            const token = document.querySelector('input[name="_token"]')?.value || '';
            const serviceDuration = parseInt(bookingData.service?.duration || 60, 10);
            const loading = document.getElementById('loadingTime');
            const selection = document.getElementById('timeSelection');

            if (loading) loading.style.display = 'block';
            if (selection) { selection.innerHTML = ''; selection.style.display = 'none'; }

            try {
                const res = await fetch('{{ route("horaire.hours") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                    body: JSON.stringify({ stylist_id: stylistId, date: date, service_duration: serviceDuration })
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();
                const times = data.times || [];
                generateTimes(times);
            } catch (err) {
                console.error(err);
                if (selection) selection.innerHTML = '<div class="empty-state">Erreur lors de la récupération des horaires.</div>';
            } finally {
                if (loading) loading.style.display = 'none';
                if (selection) selection.style.display = 'grid';
            }
        }

        // Initialiser les événements
        document.addEventListener('DOMContentLoaded', function () {
            // Événements pour les sélections de services dans le popup
            document.addEventListener('click', function (e) {
                if (e.target.closest('.service-option')) {
                    const option = e.target.closest('.service-option');
                    const serviceId = option.getAttribute('data-service');
                    const serviceName = option.getAttribute('data-name');
                    const servicePrice = option.getAttribute('data-price');
                    const serviceDuration = option.getAttribute('data-duration') || 60;
                    selectService(serviceId, serviceName, servicePrice, serviceDuration);
                }

                if (e.target.closest('.stylist-option')) {
                    const option = e.target.closest('.stylist-option');
                    const stylistId = option.getAttribute('data-stylist');
                    const stylistName = option.getAttribute('data-name');
                    selectStylist(stylistId, stylistName);
                    // fetch working days for this stylist and populate dates
                    fetchWorkingDays(stylistId);
                    if (bookingData.date) {
                        fetchHoraireForStylist(stylistId, bookingData.date.value);
                    }
                }
            });

            // Fermeture en cliquant sur l'overlay
            document.getElementById('bookingOverlay').addEventListener('click', function (e) {
                if (e.target === this) {
                    closeBooking();
                }
            });

            // Fermer avec Escape
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && document.getElementById('bookingOverlay').style.display === 'flex') {
                    closeBooking();
                }
            });

            // Animation des boutons de réservation
            document.querySelectorAll('.btn-book').forEach(button => {
                button.addEventListener('click', function () {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 150);
                });
            });

            // Effet de pulsation sur les statuts en attente
            document.querySelectorAll('.status-pending').forEach(status => {
                setInterval(() => {
                    status.style.opacity = '0.7';
                    setTimeout(() => {
                        status.style.opacity = '1';
                    }, 500);
                }, 2000);
            });

            // Fetch working days for a stylist and populate dateSelection
            async function fetchWorkingDays(stylistId) {
                const token = document.querySelector('input[name="_token"]').value;
                const loading = document.getElementById('loadingDate');
                const selection = document.getElementById('dateSelection');
                loading.style.display = 'block';
                selection.style.display = 'none';
                try {
                    const res = await fetch('{{ route("horaire.days") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token
                        },
                        body: JSON.stringify({ stylist_id: stylistId })
                    });
                    const data = await res.json();
                    selection.innerHTML = '';
                    const days = data.days || [];
                    if (days.length === 0) {
                        selection.innerHTML = '<div class="empty-state">Aucun jour de travail trouvé pour ce coiffeur.</div>';
                        loading.style.display = 'none';
                        selection.style.display = 'grid';
                        return;
                    }
                    days.forEach(d => {
                        const dateObj = new Date(d);
                        const dayName = dateObj.toLocaleDateString('fr-FR', { weekday: 'short' });
                        const dayNumber = dateObj.getDate();
                        const monthName = dateObj.toLocaleDateString('fr-FR', { month: 'short' });
                        const dateOption = document.createElement('div');
                        dateOption.className = 'date-option';
                        dateOption.setAttribute('data-date', d);
                        dateOption.innerHTML = `\n                            <div style="font-size: 12px; opacity: 0.8;">${dayName}</div>\n                            <div style="font-size: 16px; font-weight: bold;">${dayNumber}</div>\n                            <div style="font-size: 11px; opacity: 0.6;">${monthName}</div>\n                        `;
                        dateOption.onclick = () => selectDate(d, `${dayName} ${dayNumber} ${monthName}`);
                        selection.appendChild(dateOption);
                    });
                    loading.style.display = 'none';
                    selection.style.display = 'grid';
                } catch (err) {
                    console.error(err);
                    loading.style.display = 'none';
                    selection.style.display = 'grid';
                    selection.innerHTML = '<div class="empty-state">Erreur lors de la récupération des jours.</div>';
                }
            }
        });

        // Met à jour le résumé dans l'étape 5
        function updateSummary() {
            document.getElementById('summaryService').textContent = bookingData.service?.name || '-';
            document.getElementById('summaryStylist').textContent = bookingData.stylist?.name || '-';
            document.getElementById('summaryDate').textContent = bookingData.date?.display || '-';
            document.getElementById('summaryTime').textContent = bookingData.time || '-';
            document.getElementById('summaryPrice').textContent = bookingData.service?.price ? bookingData.service.price + ' DT' : '-';
        }

        // Confirme et soumet la réservation (remplit le formulaire caché)
        function confirmBooking() {
            if (!validateCurrentStep()) {
                alert('Sélection incomplète — vérifiez toutes les étapes.');
                return;
            }
            // Remplir inputs cachés
            document.getElementById('service_id').value = bookingData.service?.id || '';
            document.getElementById('stylist_id').value = bookingData.stylist?.id || '';
            document.getElementById('date').value = bookingData.date?.value || '';
            document.getElementById('time').value = bookingData.time || '';

            // soumettre le formulaire
            document.getElementById('bookingForm').submit();
        }
    </script>
</body>

</html>
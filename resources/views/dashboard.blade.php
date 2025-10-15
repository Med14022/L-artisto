<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Client - L'ARTISTO Barbershop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0e7a8e7;
            min-height: 100vh;
            color: #333;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #D4AF37, #FFD700, #B8860B);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }

        .crown {
            font-size: 25px;
            color: #1a1a1a;
        }

        .brand-name {
            font-size: 24px;
            font-weight: bold;
            color: #1a1a1a;
            letter-spacing: 1px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .welcome-text {
            color: #666;
            font-weight: 500;
        }

        .logout-btn {
            padding: 8px 16px;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            border: none;
            border-radius: 8px;
            color: #1a1a1a;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-title::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            border-radius: 2px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .service-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .service-card:hover {
            transform: translateY(-5px);
            border-color: #D4AF37;
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.2);
        }

        .service-icon {
            height: 5cm;
            width: 5cm;
            margin: 0 auto 15px;
            overflow: hidden;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .service-icon img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .service-name {
            font-size: 18px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .service-price {
            font-size: 24px;
            color: #D4AF37;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .service-description {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .barber-item,
        .appointment-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 12px;
            margin-bottom: 12px;
            transition: all 0.3s ease;
        }

        .barber-item:hover,
        .appointment-item:hover {
            background: #e9ecef;
            transform: translateX(5px);
        }

        .barber-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 20px;
        }

        .barber-info {
            flex: 1;
        }

        .barber-name {
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 5px;
        }

        .barber-specialty {
            color: #666;
            font-size: 14px;
        }

        .appointment-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .btn-primary {
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            color: #1a1a1a;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.4);
        }

        .btn-book {
            width: 100%;
            margin-top: 10px;
        }

        .main-cta {
            text-align: center;
            margin: 40px 0;
        }

        .main-cta .btn-primary {
            font-size: 18px;
            padding: 18px 40px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .appointment-date {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .appointment-service {
            font-weight: bold;
            color: #1a1a1a;
        }

        .appointment-details {
            flex: 1;
            margin-right: 15px;
        }

        .empty-state {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }

        /* Styles du popup de réservation */
        .booking-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow-y: auto;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(8px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .booking-popup {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            width: 90%;

            max-width: 800px;
            height: fit-content;
            box-shadow: 0 30px 100px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(212, 175, 55, 0.2);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(60px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .booking-header {
            background: linear-gradient(135deg, #D4AF37, #FFD700, #B8860B);
            color: #1a1a1a;
            padding: 30px;
            position: relative;
        }

        .booking-close {
            position: absolute;
            top: 25px;
            right: 30px;
            background: rgba(26, 26, 26, 0.1);
            border: none;
            color: #1a1a1a;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 20px;
            font-weight: bold;
        }

        .booking-close:hover {
            background: rgba(26, 26, 26, 0.2);
            transform: rotate(90deg) scale(1.1);
        }

        .booking-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .booking-subtitle {
            opacity: 0.9;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .progress-wrapper {
            position: relative;
        }

        .progress-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-bottom: 15px;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background: rgba(26, 26, 26, 0.2);
            border-radius: 2px;
            transform: translateY(-50%);
        }

        .progress-fill {
            height: 100%;
            background: #1a1a1a;
            border-radius: 2px;
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            width: 0%;
        }

        .progress-step {
            background: rgba(26, 26, 26, 0.2);
            color: #1a1a1a;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            position: relative;
            z-index: 2;
            transition: all 0.5s ease;
            font-size: 16px;
        }

        .progress-step.active {
            background: #1a1a1a;
            color: #FFD700;
            box-shadow: 0 0 0 4px rgba(26, 26, 26, 0.2);
            transform: scale(1.15);
        }

        .progress-step.completed {
            background: #1a1a1a;
            color: #FFD700;
        }

        .step-labels {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
            opacity: 0.9;
        }

        .booking-content {
            padding: 35px;
            min-height: 500px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .step-content {
            display: none;
            animation: fadeInStep 0.5s ease-out;
        }

        .step-content.active {
            display: block;
        }

        @keyframes fadeInStep {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .step-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 30px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .service-selection, .stylist-selection {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .service-option, .stylist-option {
            border: 3px solid #e0e0e0;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9f9f9;
        }

        .service-option:hover, .stylist-option:hover {
            border-color: #D4AF37;
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.2);
        }

        .service-option.selected, .stylist-option.selected {
            border-color: #D4AF37;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            color: #1a1a1a;
            box-shadow: 0 12px 30px rgba(212, 175, 55, 0.3);
            transform: translateY(-5px);
        }

        .stylist-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(45deg, #ff9a9e 0%, #fecfef 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 35px;
            transition: transform 0.3s ease;
        }

        .stylist-option.selected .stylist-avatar {
            background: rgba(26, 26, 26, 0.1);
            transform: scale(1.1);
        }

        .date-selection {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 12px;
            margin: 25px 0;
        }

        .date-option {
            aspect-ratio: 1;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9f9f9;
            font-size: 14px;
            font-weight: 600;
        }

        .date-option:hover {
            border-color: #D4AF37;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(255, 215, 0, 0.1));
            transform: scale(1.05);
        }

        .date-option.selected {
            border-color: #D4AF37;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            color: #1a1a1a;
            transform: scale(1.05);
        }

        .date-option.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .date-option.disabled:hover {
            border-color: #e0e0e0;
            background: #f9f9f9;
            color: inherit;
            transform: none;
        }

        .time-selection {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 15px;
            margin: 25px 0;
        }

        .time-option {
            padding: 18px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9f9f9;
            font-weight: 600;
            font-size: 15px;
        }

        .time-option:hover {
            border-color: #D4AF37;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(255, 215, 0, 0.1));
        }

        .time-option.selected {
            border-color: #D4AF37;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            color: #1a1a1a;
        }

        .time-option.disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .summary-card {
            background: linear-gradient(135deg, #D4AF37, #FFD700, #B8860B);
            color: #1a1a1a;
            border-radius: 20px;
            padding: 30px;
            margin: 25px 0;
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.3);
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 18px;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(26, 26, 26, 0.1);
        }

        .summary-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .summary-label {
            font-weight: 600;
            opacity: 0.9;
            font-size: 16px;
        }

        .summary-value {
            font-weight: bold;
            font-size: 17px;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 35px;
            gap: 20px;
        }

        .btn {
            padding: 16px 32px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
            flex: 1;
            max-width: 200px;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(108, 117, 125, 0.4);
        }

        .btn-gold {
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            color: #1a1a1a;
            font-weight: bold;
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
        }

        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.4);
        }

        .btn-success {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(40, 167, 69, 0.4);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        .loading-state {
            display: none;
            text-align: center;
            padding: 50px 20px;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #D4AF37;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
            margin: 0 auto 25px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .container {
                padding: 0 15px;
            }

            .booking-popup {
                width: 95%;
                margin: 20px;
                max-height: 90vh;
            }

            .service-selection, .stylist-selection {
                grid-template-columns: 1fr;
            }

            .date-selection {
                grid-template-columns: repeat(4, 1fr);
            }

            .nav-buttons {
                flex-direction: column;
            }

            .btn {
                max-width: none;
            }

            .brand-name {
                font-size: 20px;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card,
        .service-card {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
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
                <button class="btn-primary btn-book " onclick="openBooking('{{ $service->id }}', '{{ $service->name }}', '{{ $service->price }}')">Réserver</button>
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
                @if ($rdv->etat == "terminé" )
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
                <!-- Étape 1: Sélection du service -->
                <div id="stepContent1" class="step-content active">
                    <div class="step-title">🎯 Choisissez votre service</div>
                    <div class="service-selection">
                        @foreach ($services as $service)
                        <div class="service-option" data-service="{{ $service->id }}" data-name="{{ $service->name }}" data-price="{{ $service->price }}">
                            <div style="font-size: 48px; margin-bottom: 15px;">✂️</div>
                            <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">{{ $service->name }}</div>
                            <div style="font-size: 24px; color: #D4AF37; font-weight: bold;">{{ $service->price }} DT</div>
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
                                <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">{{ $user->name }}</div>
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
                    <div id="loadingTime" class="loading-state">
                        <div class="spinner"></div>
                        <p>Chargement des créneaux disponibles...</p>
                    </div>
                    <div id="timeSelection" class="time-selection" style="display: none;">
                        <!-- Les heures seront générées dynamiquement -->
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

                <!-- Boutons de navigation -->
                <div class="nav-buttons">
                    <button id="prevBtn" class="btn btn-secondary" onclick="changeStep(-1)" style="display: none;">
                        ← Précédent
                    </button>
                    <button id="nextBtn" class="btn btn-gold" onclick="changeStep(1)" disabled>
                        Suivant →
                    </button>
                    <form action="{{ route('reservation') }}" method="POST" id="bookingForm" style="flex: 1; margin: 0;">
                        @csrf
                        <button id="confirmBtn" type="button" class="btn btn-success" onclick="confirmBooking()" style="display: none;">
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
        function openBooking(serviceId = null, serviceName = null, servicePrice = null) {
            document.getElementById('bookingOverlay').style.display = 'flex';
            document.body.style.overflow = 'hidden';

            // Si un service spécifique est sélectionné depuis les cartes
            if (serviceId && serviceName && servicePrice) {
                selectService(serviceId, serviceName, servicePrice);
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
        function selectService(serviceId, serviceName, servicePrice) {
            bookingData.service = { id: serviceId, name: serviceName, price: servicePrice };

            document.querySelectorAll('.service-option').forEach(option => {
                option.classList.remove('selected');
            });

            const selectedOption = document.querySelector(`[data-service="${serviceId}"]`);
            if (selectedOption) {
                selectedOption.classList.add('selected');
            }

            updateNavigationButtons();
        }

        // Sélection de coiffeur
        function selectStylist(stylistId, stylistName) {
            bookingData.stylist = { id: stylistId, name: stylistName };

            document.querySelectorAll('.stylist-option').forEach(option => {
                option.classList.remove('selected');
            });

            document.querySelector(`[data-stylist="${stylistId}"]`).classList.add('selected');
            updateNavigationButtons();
        }

        // Sélection de date
        function selectDate(dateValue, dateDisplay) {
            bookingData.date = { value: dateValue, display: dateDisplay };

            document.querySelectorAll('.date-option').forEach(option => {
                option.classList.remove('selected');
            });

            document.querySelector(`[data-date="${dateValue}"]`).classList.add('selected');
            updateNavigationButtons();
        }

        // Sélection d'heure
        function selectTime(timeValue) {
            bookingData.time = timeValue;

            document.querySelectorAll('.time-option').forEach(option => {
                option.classList.remove('selected');
            });

            document.querySelector(`[data-time="${timeValue}"]`).classList.add('selected');
            updateNavigationButtons();
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

            loading.style.display = 'block';
            selection.style.display = 'none';

            setTimeout(() => {
                generateTimes();
                loading.style.display = 'none';
                selection.style.display = 'grid';
            }, 800);
        }

        // Générer les créneaux horaires
        function generateTimes() {
            const timeSelection = document.getElementById('timeSelection');
            timeSelection.innerHTML = '';

            const times = [
                '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
                '14:00', '14:30', '15:00', '15:30', '16:00', '16:30',
                '17:00', '17:30', '18:00', '18:30'
            ];

            times.forEach((time) => {
                const isDisabled = Math.random() < 0.2; // 20% de chance d'être occupé

                const timeOption = document.createElement('div');
                timeOption.className = `time-option ${isDisabled ? 'disabled' : ''}`;
                timeOption.setAttribute('data-time', time);
                timeOption.textContent = time;

                if (!isDisabled) {
                    timeOption.onclick = () => selectTime(time);
                }

                timeSelection.appendChild(timeOption);
            });
        }

        // Mettre à jour le résumé
        function updateSummary() {
            document.getElementById('summaryService').textContent =
                `${bookingData.service.name} (${bookingData.service.price})`;
            document.getElementById('summaryStylist').textContent = bookingData.stylist.name;
            document.getElementById('summaryDate').textContent = bookingData.date.display;
            document.getElementById('summaryTime').textContent = bookingData.time;
            document.getElementById('summaryPrice').textContent = bookingData.service.price;
        }

        // Confirmer la réservation
        function confirmBooking() {
            const confirmBtn = document.getElementById('confirmBtn');
            const originalText = confirmBtn.innerHTML;

            confirmBtn.innerHTML = '<div style="width: 20px; height: 20px; border: 2px solid #fff; border-top: 2px solid transparent; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto;"></div>';
            confirmBtn.disabled = true;


            document.getElementById('service_id').value = bookingData.service.id;
            document.getElementById('stylist_id').value = bookingData.stylist.id;
            document.getElementById('date').value = bookingData.date.value;
            document.getElementById('time').value = bookingData.time;


            // Soumettre le formulaire au serveur
            // les champs hidden sont déjà remplis ci-dessus
            document.getElementById('bookingForm').submit();
        }

        // Initialiser les événements
        document.addEventListener('DOMContentLoaded', function() {
            // Événements pour les sélections de services dans le popup
            document.addEventListener('click', function(e) {
                if (e.target.closest('.service-option')) {
                    const option = e.target.closest('.service-option');
                    const serviceId = option.getAttribute('data-service');
                    const serviceName = option.getAttribute('data-name');
                    const servicePrice = option.getAttribute('data-price');
                    selectService(serviceId, serviceName, servicePrice);
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
            document.getElementById('bookingOverlay').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeBooking();
                }
            });

            // Fermer avec Escape
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && document.getElementById('bookingOverlay').style.display === 'flex') {
                    closeBooking();
                }
            });

            // Animation des boutons de réservation
            document.querySelectorAll('.btn-book').forEach(button => {
                button.addEventListener('click', function() {
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

            // Initialisation
            updateNavigationButtons();
        });
    </script>
</body>

</html>

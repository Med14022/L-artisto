<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - L'ARTISTO Barbershop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #D4AF37, #FFD700, #B8860B);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.3);
        }

        .crown {
            font-size: 35px;
            color: #1a1a1a;
        }

        .title {
            font-size: 28px;
            font-weight: bold;
            color: #1a1a1a;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .subtitle {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input, select, textarea {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
            color: #333;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        select {
            cursor: pointer;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .register-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, #D4AF37, #FFD700);
            border: none;
            border-radius: 12px;
            color: #1a1a1a;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .register-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
        }

        .register-btn:active {
            transform: translateY(-1px);
        }

        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e1e1e1;
        }

        .login-link a {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #B8860B;
            text-decoration: underline;
        }

        .input-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
        }

        .form-group.has-icon input {
            padding-right: 50px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
                margin: 10px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .title {
                font-size: 24px;
            }
        }

        /* Animation d'entrée */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            animation: slideUp 0.8s ease-out;
        }

        /* Style pour les messages d'erreur */
        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-section">
            <div class="logo">
                <span class="crown">👑</span>
            </div>
            <h1 class="title">L'ARTISTO</h1>
            <p class="subtitle">Créez votre compte</p>
        </div>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Nom et Email -->
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nom complet</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group has-icon">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    <span class="input-icon">📧</span>
                    @error('email')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Téléphone -->
            <div class="form-group has-icon">
                <label for="phone">Téléphone</label>
                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                <span class="input-icon">📱</span>
                @error('phone')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Adresse -->
            <div class="form-group">
                <label for="address">Adresse</label>
                <textarea id="address" name="address" placeholder="Votre adresse complète..." required>{{ old('address') }}</textarea>
                @error('address')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mot de passe -->
            <div class="form-row">
                <div class="form-group has-icon">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" required>
                    <span class="input-icon">🔒</span>
                    @error('password')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group has-icon">
                    <label for="password_confirmation">Confirmer</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    <span class="input-icon">🔒</span>
                    @error('password_confirmation')
                        <div class="error-message" style="display: block;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="register-btn">
                S'inscrire
            </button>

            <div class="login-link">
                <p>Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a></p>
            </div>
        </form>
    </div>

    <script>
        // Validation du formulaire côté client
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            let isValid = true;

            // Réinitialiser les messages d'erreur
            document.querySelectorAll('.error-message').forEach(msg => {
                msg.style.display = 'none';
            });

            // Validation du nom
            const name = document.getElementById('name').value.trim();
            if (name.length < 2) {
                showError('name-error', 'Le nom doit contenir au moins 2 caractères');
                isValid = false;
            }

            // Validation de l'email
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showError('email-error', 'Format d\'email invalide');
                isValid = false;
            }

            // Validation du téléphone
            const phone = document.getElementById('phone').value.trim();
            const phoneRegex = /^[\+]?[0-9\s\-\(\)]{8,}$/;
            if (!phoneRegex.test(phone)) {
                showError('phone-error', 'Numéro de téléphone invalide');
                isValid = false;
            }

            // Validation de l'adresse
            const address = document.getElementById('address').value.trim();
            if (address.length < 10) {
                showError('address-error', 'L\'adresse doit être plus détaillée');
                isValid = false;
            }

            // Validation du mot de passe
            const password = document.getElementById('password').value;
            if (password.length < 8) {
                showError('password-error', 'Le mot de passe doit contenir au moins 8 caractères');
                isValid = false;
            }

            // Validation de la confirmation du mot de passe
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            if (password !== passwordConfirmation) {
                showError('password-confirmation-error', 'Les mots de passe ne correspondent pas');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
            }
        });

        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        // Animation des champs au focus
        document.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            field.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>
</html>

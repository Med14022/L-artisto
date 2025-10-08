<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - L'ARTISTO Barbershop</title>
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
            max-width: 450px;
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

        .status-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
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

        input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fafafa;
            color: #333;
        }

        input:focus {
            outline: none;
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
            background: white;
            transform: translateY(-2px);
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

        .remember-section {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 10px 0;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-container input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
            transform: scale(1.2);
            accent-color: #D4AF37;
        }

        .checkbox-container span {
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .login-btn {
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
            margin-bottom: 20px;
        }

        .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212, 175, 55, 0.4);
        }

        .login-btn:active {
            transform: translateY(-1px);
        }

        .footer-links {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid #e1e1e1;
            flex-wrap: wrap;
            gap: 15px;
        }

        .footer-links a {
            color: #D4AF37;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: #B8860B;
            text-decoration: underline;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
                margin: 10px;
            }

            .title {
                font-size: 24px;
            }

            .footer-links {
                flex-direction: column;
                text-align: center;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-section">
            <div class="logo">
                <span class="crown">👑</span>
            </div>
            <h1 class="title">L'ARTISTO</h1>
            <p class="subtitle">Connectez-vous à votre compte</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email Address -->
            <div class="form-group has-icon">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                <span class="input-icon">📧</span>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group has-icon">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
                <span class="input-icon">🔒</span>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="remember-section">
                <label for="remember_me" class="checkbox-container">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Se souvenir de moi</span>
                </label>
            </div>

            <button type="submit" class="login-btn">
                Se connecter
            </button>

            <div class="footer-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        Mot de passe oublié ?
                    </a>
                @endif

                <a href="{{ route('register') }}">
                    Créer un compte
                </a>
            </div>
        </form>
    </div>

    <script>
        // Animation des champs au focus
        document.querySelectorAll('input').forEach(field => {
            field.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            field.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Validation simple côté client
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            if (!email || !password) {
                alert('Veuillez remplir tous les champs');
                e.preventDefault();
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Format d\'email invalide');
                e.preventDefault();
                return false;
            }
        });

        // Effet de survol sur le bouton
        const loginBtn = document.querySelector('.login-btn');
        loginBtn.addEventListener('mouseenter', function() {
            this.style.background = 'linear-gradient(135deg, #FFD700, #D4AF37)';
        });

        loginBtn.addEventListener('mouseleave', function() {
            this.style.background = 'linear-gradient(135deg, #D4AF37, #FFD700)';
        });
    </script>
</body>
</html>

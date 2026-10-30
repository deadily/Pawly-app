<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pawly — Начните свой путь длиною в любовь</title>
    <!-- Подключаем стили -->
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js']) 
</head>
<body class="{{ auth()->check() ? 'auth' : '' }}">
    
    <!-- Фоновое изображение -->
    <div class="background-image"></div>

    <div class="layout-wrapper">
        
        <!-- HEADER -->
        <header class="container">
            <div class="header-content">
                <div class="logo-container">
                    <a href="{{ route('home') }}">
                        <!-- МЕСТО ПОД ИКОНКУ ЛОГОТИПА -->
                        <img src="{{ asset('img/logo.svg') }}" alt="Pawly Logo">
                    </a>
                </div>

                <div class="login-container">
                    @auth
                        <!-- Если авторизован: показываем имя и иконку, но ссылка все равно может вести на профиль -->
                        <a href="{{ route('dashboard') }}" class="login-link">
                            {{ auth()->user()->name }}
                            <img src="{{ asset('img/user-icon.svg') }}" class="login-icon" alt="Profile">
                        </a>
                    @else
                        <!-- Если НЕ авторизован: ЭТОТ КЛИК ОТКРЫВАЕТ ПОПАП -->
                        <!-- Убрали href="#" чтобы не было скачка страницы, используем JS -->
                        <button type="button" id="open-login-modal" class="login-link" style="background:none; border:none; cursor:pointer; font-family:inherit; font-size:inherit; color:inherit; display:flex; align-items:center;">
                            Вход
                            <img src="{{ asset('img/sign-in.svg') }}" class="login-icon" alt="Sign In">
                        </button>
                    @endauth
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT -->
        <main class="container main-content">
            <h1 class="main-title">Начните свой путь длиною в любовь.</h1>

            <div class="features-container">
                <!-- Карточка 1 -->
                <div class="feature-card">
                    <ul>
                        <!-- МЕСТО ПОД ИКОНКУ ПРИНАДЛЕЖНОСТЕЙ (можно добавить <li> с img) -->
                        <li>Узнайте, какие принадлежности подходят вашему питомцу.</li>
                    </ul>
                </div>

                <!-- Карточка 2 -->
                <div class="feature-card">
                    <ul>
                        <li>Ведите дневник питомца, чтобы запечатлеть счастливые моменты.</li>
                    </ul>
                </div>

                <!-- Карточка 3 -->
                <div class="feature-card">
                    <ul>
                        <li>Узнавайте много полезной информации через статьи других пользователей.</li>
                    </ul>
                </div>

                <!-- Карточка 4 -->
                <div class="feature-card">
                    <ul>
                        <li>Наслаждайтесь моментами не забывая о здоровье питомца.</li>
                    </ul>
                </div>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="container footer">
            <div class="footer-content">
                <div class="footer-left">
                    <!-- МЕСТО ПОД ИКОНКУ GOOGLE / СОЦСЕТЕЙ -->
                    <a href="https://google.com" target="_blank" rel="noopener noreferrer">
                        <img src="{{ asset('img/google.svg') }}" alt="G">
                    </a>
                </div>
                <div class="copyright">©Pawly {{ date('Y') }}</div>
            </div>
        </footer>

    </div>

    <!-- ================= МОДАЛЬНЫЕ ОКНА ================= -->
    
    <!-- Затемняющий фон -->
    <div id="modal-overlay" class="modal-overlay"></div>

    <!-- Модалка: ВХОД -->
    <div id="modal-login" class="modal-window">
        <div class="modal-content">
            <h2 class="modal-title">Вход</h2>
            
            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <input type="text" name="email" placeholder="Введите адрес эл. почты/имя" 
                           value="{{ old('email') }}" required class="styled-input">
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Введите пароль" 
                           required class="styled-input">
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn-primary">Продолжить</button>
            </form>

            <div class="modal-footer-link">
                Нет аккаунта? <a href="#" onclick="switchModal('register')">Зарегистрироваться</a>
            </div>
        </div>
        
        <button class="btn-back" onclick="closeModals()">
            <span class="arrow">←</span> Назад
        </button>
    </div>

    <!-- Модалка: РЕГИСТРАЦИЯ -->
    <div id="modal-register" class="modal-window" style="display: none;">
        <div class="modal-content">
            <h2 class="modal-title">Регистрация</h2>
            
            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf
                
                <div class="form-group">
                    <input type="text" name="name" placeholder="Придумайте имя" 
                           value="{{ old('name') }}" required class="styled-input">
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <input type="email" name="email" placeholder="Введите адрес эл. почты" 
                           value="{{ old('email') }}" required class="styled-input">
                    @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <input type="password" name="password" placeholder="Придумайте пароль" 
                           required class="styled-input">
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="checkbox-group">
                    <label class="custom-checkbox">
                        <input type="checkbox" name="has_pet" value="1">
                        <span class="checkmark"></span>
                        Есть ли у вас питомец? <small>(при нажатии будете переведены на страницу заполнения)</small>
                    </label>
                    
                    <label class="custom-checkbox">
                        <input type="checkbox" name="agree_rules" required>
                        <span class="checkmark"></span>
                        Нажимая, вы соглашаетесь с правилами сайта и обработкой персональных данных
                    </label>
                </div>

                <button type="submit" class="btn-primary">Продолжить</button>
            </form>

            <div class="modal-footer-link">
                Есть аккаунт? <a href="#" onclick="switchModal('login')">Войти</a>
            </div>
        </div>

        <button class="btn-back" onclick="closeModals()">
            <span class="arrow">←</span> Назад
        </button>
    </div>

</body>
</html>
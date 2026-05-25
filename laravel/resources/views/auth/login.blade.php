<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure Sign-In - OneID-Pension Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
            overflow: hidden;
            min-height: 600px;
            border: 1px solid #e2e8f0;
        }

        .login-info {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #f1f5f9;
            border-right: 1px solid #e2e8f0;
        }

        .login-form-container {
            flex: 1;
            background: #ffffff;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .badge-official {
            background: #e2e8f0;
            color: #475569;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 24px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .main-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -0.02em;
        }

        .main-desc {
            font-size: 1.05rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .form-card {
            background: transparent;
            padding: 0;
            border: none;
            box-shadow: none;
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .auth-toggle {
            display: flex;
            background: #f1f5f9;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 24px;
        }

        .auth-toggle-btn {
            flex: 1;
            padding: 10px;
            text-align: center;
            font-size: 0.875rem;
            font-weight: 600;
            color: #64748b;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .auth-toggle-btn.active {
            background: white;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .form-control {
            border: 1px solid #e2e8f0;
            padding: 12px 16px;
            padding-left: 44px;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .btn-login {
            background: #0f172a;
            color: white;
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            margin-top: 16px;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #1e293b;
        }

        .captcha-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
        }

        .captcha-text {
            font-family: 'Courier New', monospace;
            font-size: 1.2rem;
            font-weight: bold;
            color: #0f172a;
            letter-spacing: 4px;
            background: repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(0,0,0,0.05) 2px, rgba(0,0,0,0.05) 4px);
            padding: 4px 10px;
        }

        .top-brand {
            position: absolute;
            top: 30px;
            left: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: #0f172a;
            font-size: 1.2rem;
        }

        .auth-switch {
            text-align: center;
            margin-top: 24px;
            font-size: 0.9rem;
            color: #64748b;
        }

        .auth-switch a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .auth-switch a:hover {
            color: #1d4ed8;
        }

        @media (max-width: 992px) {
            .login-wrapper { flex-direction: column; border-radius: 0; min-height: 100vh; }
            .login-info { padding: 40px 20px; flex: none; }
            .login-form-container { padding: 40px 20px; }
            .top-brand { position: relative; top: 0; left: 0; margin-bottom: 20px; }
        }
    </style>
</head>
<body>

    <div class="top-brand d-none d-lg-flex">
        <div style="width: 32px; height: 32px; background: #0f172a; border-radius: 6px; display: flex; align-items: center; justify-content: center; color: white;">
            <i class="fas fa-university"></i>
        </div>
        OneID Pension System
    </div>

    <div class="login-wrapper">
        <!-- Left Side: Info & Branding -->
        <div class="login-info">
            <div class="badge-official">Official Government Portal</div>
            <h1 class="main-title">One Citizen • One<br>Pension Identity</h1>
            <p class="main-desc">A unified platform designed to provide every citizen with a seamless, secure, and transparent digital pension identity. Empowering the workforce through modern digital governance.</p>
            
            <div class="hero-image">
                <!-- Abstract network graphic -->
                <div class="node-center node"><i class="fas fa-user"></i></div>
                <div class="node" style="top: 20%; left: 30%;"></div>
                <div class="node" style="top: 40%; left: 70%;"></div>
                <div class="node" style="top: 70%; left: 40%;"></div>
                <div class="node" style="top: 60%; left: 80%;"></div>
                <div class="node" style="top: 30%; left: 20%;"></div>
                
                <!-- Connecting lines simulation -->
                <svg width="100%" height="100%" style="position: absolute; top:0; left:0; pointer-events: none;">
                    <line x1="50%" y1="50%" x2="30%" y2="20%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <line x1="50%" y1="50%" x2="70%" y2="40%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <line x1="50%" y1="50%" x2="40%" y2="70%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <line x1="50%" y1="50%" x2="80%" y2="60%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <line x1="50%" y1="50%" x2="20%" y2="30%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                </svg>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="login-form-container">
            <div class="form-card">
                <h2 class="form-title">Secure Sign-In</h2>
                <p class="form-subtitle">Access administrative portal and citizen records</p>

                <div class="auth-toggle">
                    <div class="auth-toggle-btn active">Admin ID</div>
                    <div class="auth-toggle-btn">Citizen Login</div>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="position-relative mb-3">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="position-relative mb-3">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password / PIN" required>
                        <i class="fas fa-eye text-secondary position-absolute" style="right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Dummy Captcha for UI fidelity -->
                    <div class="captcha-box">
                        <div class="d-flex align-items-center gap-3">
                            <span class="captcha-text">X7R2K</span>
                            <i class="fas fa-redo text-primary" style="cursor: pointer;"></i>
                        </div>
                        <input type="text" class="form-control" style="width: 120px; padding-left: 12px; background: white;" placeholder="Captcha">
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3 mb-4 px-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-secondary" style="font-size: 0.9rem;" for="remember">
                                Remember me
                            </label>
                        </div>
                        <a href="#" style="font-size: 0.9rem; color: #1a237e; text-decoration: none; font-weight: 600;">Forgot PIN?</a>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i> Sign In to Dashboard
                    </button>

                    <div class="text-center mt-4" style="font-size: 0.9rem; color: #5a5a7a;">
                        Don't have an account? <a href="{{ route('register') }}" style="color: #1565c0; font-weight: 600; text-decoration: none;">Create one</a>
                    </div>
                </form>

                @if(app()->environment('local'))
                <div class="mt-4 pt-4 border-top">
                    <div class="text-center mb-2" style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Developer Quick Login</div>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="quickLogin('admin@onecitizen.gov.in', 'password')">Admin</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="quickLogin('user1@onecitizen.gov.in', 'password')">Citizen (Profile)</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="quickLogin('user2@onecitizen.gov.in', 'password')">Citizen (New)</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="quickLogin('vikram@onecitizen.gov.in', 'password')">Citizen (Vikram)</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="quickLogin('meera@onecitizen.gov.in', 'password')">Citizen (Meera)</button>
                    </div>
                </div>
                <script>
                    function quickLogin(email, password) {
                        document.querySelector('input[name="email"]').value = email;
                        document.querySelector('input[name="password"]').value = password;
                        document.querySelector('form').submit();
                    }
                </script>
                @endif


            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="position: fixed; bottom: 20px; left: 40px; right: 40px; display: flex; justify-content: space-between; font-size: 0.8rem; color: #5a5a7a;">
        <div>&copy; 2026 OneID Pension System. All Rights Reserved.</div>
        <div class="d-flex gap-4">
            <a href="#" class="text-secondary text-decoration-none">Privacy Policy</a>
            <a href="#" class="text-secondary text-decoration-none">Terms of Service</a>
            <a href="#" class="text-secondary text-decoration-none">Help Desk</a>
        </div>
        <div class="fw-bold text-primary">Powered by Digital Governance Mission</div>
    </div>

</body>
</html>

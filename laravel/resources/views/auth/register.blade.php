<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure Registration - OneID-Pension Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #eef1f5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(26, 35, 126, 0.1);
            overflow: hidden;
            min-height: 700px;
            border: 1px solid rgba(255,255,255,0.4);
        }

        .login-info {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: linear-gradient(135deg, rgba(26, 35, 126, 0.02), rgba(21, 101, 192, 0.05));
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
            background: linear-gradient(135deg, #1a237e, #1565c0);
            color: white;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(26,35,126,0.2);
        }

        .main-title {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #1a237e, #1565c0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -0.03em;
        }

        .main-desc {
            font-size: 1.1rem;
            color: #5a5a7a;
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 90%;
        }

        .hero-image {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #1a237e, #0d1553);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(26,35,126,0.3);
        }

        /* Abstract connection visualization */
        .node { position: absolute; width: 6px; height: 6px; background: rgba(255,255,255,0.8); border-radius: 50%; box-shadow: 0 0 10px rgba(255,255,255,0.8); }
        .node-center { width: 60px; height: 60px; background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.5); display: flex; align-items: center; justify-content: center; font-size: 24px; color: white; border-radius: 12px; backdrop-filter: blur(4px); }

        .form-card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #eaeaea;
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #5a5a7a;
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .form-control {
            border: 1px solid #e0e0e0;
            padding: 12px 16px;
            padding-left: 44px;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #fcfcfc;
        }

        .form-control:focus {
            border-color: #1a237e;
            box-shadow: 0 0 0 4px rgba(26, 35, 126, 0.1);
            background: white;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9aa0a6;
        }

        .btn-login {
            background: linear-gradient(135deg, #1a237e, #1565c0);
            color: white;
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            margin-top: 16px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(26,35,126,0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26,35,126,0.4);
        }

        .top-brand {
            position: absolute;
            top: 30px;
            left: 40px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
            color: #1a237e;
            font-size: 1.2rem;
        }

        .auth-switch {
            text-align: center;
            margin-top: 24px;
            font-size: 0.9rem;
            color: #5a5a7a;
        }

        .auth-switch a {
            color: #1565c0;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s;
        }

        .auth-switch a:hover {
            color: #1a237e;
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
        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #1a237e, #1565c0); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
            <i class="fas fa-university"></i>
        </div>
        OneID Pension System
    </div>

    <div class="login-wrapper">
        <!-- Left Side: Info & Branding -->
        <div class="login-info">
            <div class="badge-official">Admin Registration</div>
            <h1 class="main-title">Join the Digital<br>Governance Team</h1>
            <p class="main-desc">Register as a system administrator or data operator to manage citizen profiles and pension assignments securely.</p>
            
            <div class="hero-image">
                <!-- Abstract network graphic -->
                <div class="node-center node"><i class="fas fa-user-plus"></i></div>
                <div class="node" style="top: 20%; left: 30%;"></div>
                <div class="node" style="top: 40%; left: 70%;"></div>
                <div class="node" style="top: 70%; left: 40%;"></div>
                <div class="node" style="top: 60%; left: 80%;"></div>
                <div class="node" style="top: 30%; left: 20%;"></div>
                
                <svg width="100%" height="100%" style="position: absolute; top:0; left:0; pointer-events: none;">
                    <line x1="50%" y1="50%" x2="30%" y2="20%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <line x1="50%" y1="50%" x2="70%" y2="40%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <line x1="50%" y1="50%" x2="40%" y2="70%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <line x1="50%" y1="50%" x2="80%" y2="60%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <line x1="50%" y1="50%" x2="20%" y2="30%" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                </svg>
            </div>
        </div>

        <!-- Right Side: Registration Form -->
        <div class="login-form-container">
            <div class="form-card">
                <h2 class="form-title">Create Account</h2>
                <p class="form-subtitle">Fill in the details below to register.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="position-relative mb-3">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="position-relative mb-3">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="position-relative mb-3">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="position-relative mb-3">
                        <i class="fas fa-check-circle input-icon"></i>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-user-plus me-2"></i> Register Account
                    </button>

                    <div class="auth-switch">
                        Already have an account? <a href="{{ route('login') }}">Sign In</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div style="position: fixed; bottom: 20px; left: 40px; right: 40px; display: flex; justify-content: space-between; font-size: 0.8rem; color: #5a5a7a; z-index: 10;">
        <div>&copy; 2026 OneID Pension System. All Rights Reserved.</div>
        <div class="fw-bold" style="color: #1a237e;">Powered by Digital Governance Mission</div>
    </div>

</body>
</html>

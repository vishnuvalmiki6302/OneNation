<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure Sign-In - OneID-Pension Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, sans-serif;
            background: linear-gradient(
                135deg,
                rgba(255,153,51,0.4) 0%,
                rgba(255,255,255,1) 50%,
                rgba(19,136,8,0.4) 100%
            );
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-wrapper {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            min-height: 550px;
            position: relative;
        }

        /* The curved left pane */
        .login-info {
            flex: 0 0 45%;
            background: linear-gradient(135deg, #f15d07ff 0%, #44ae03ff 100%);
            /* The distinct purple from the image */
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            border-top-right-radius: 150px;
            border-bottom-right-radius: 150px;
            z-index: 10;
            box-shadow: 10px 0 20px rgba(0, 0, 0, 0.1);
        }

        .login-form-container {
            flex: 1;
            background: #ffffff;
            padding: 50px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .main-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .main-desc {
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .btn-outline-white {
            border: 1px solid white;
            color: white;
            background: transparent;
            padding: 10px 40px;
            border-radius: 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-outline-white:hover {
            background: white;
            color: #3e3270;
        }

        .form-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
        }

        /* Keeping the user's toggle buttons */
        .auth-toggle {
            display: flex;
            background: #f3f4f6;
            border-radius: 30px;
            padding: 4px;
            margin-bottom: 25px;
            width: 100%;
            max-width: 320px;
        }

        .auth-toggle-btn {
            flex: 1;
            padding: 8px;
            text-align: center;
            font-size: 0.85rem;
            font-weight: 600;
            color: #666;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .auth-toggle-btn.active {
            background: white;
            color: #333;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .login-form {
            width: 100%;
            max-width: 320px;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 15px;
        }

        .form-control {
            border: none;
            background: #f3f4f6;
            padding: 12px 20px;
            padding-left: 45px;
            border-radius: 10px;
            font-size: 0.95rem;
            color: #333;
            height: 48px;
            width: 100%;
        }

        .form-control:focus {
            background: #e5e7eb;
            box-shadow: none;
            outline: none;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 5;
        }

        .btn-login {
            background: #3e3270;
            /* Solid purple button */
            color: white;
            width: 100%;
            max-width: 180px;
            padding: 12px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            margin-top: 10px;
            transition: all 0.2s;
        }

        .btn-login:hover {
            background: #2d2454;
        }

        .captcha-box {
            background: #f3f4f6;
            border-radius: 10px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            height: 48px;
        }

        .captcha-text {
            font-family: 'Courier New', monospace;
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
            letter-spacing: 4px;
            background: repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(0, 0, 0, 0.05) 2px, rgba(0, 0, 0, 0.05) 4px);
            padding: 2px 8px;
            border-radius: 4px;
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
            z-index: 20;
        }

        .footer {
            position: absolute;
            bottom: 20px;
            left: 40px;
            right: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 0.8rem;
            color: #64748b;
            z-index: 20;
        }

        .footer a {
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: #3e3270;
        }

        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
                border-radius: 20px;
                min-height: auto;
                margin: 20px;
                margin-top: 80px;
                margin-bottom: 80px;
            }

            .login-info {
                flex: none;
                border-radius: 20px 20px 0 0;
                padding: 40px 20px;
                box-shadow: none;
            }

            .login-form-container {
                padding: 40px 20px;
            }

            .top-brand {
                position: absolute;
                top: 20px;
                left: 20px;
            }

            .footer {
                position: relative;
                bottom: 0;
                left: 0;
                right: 0;
                padding: 20px;
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
        }
    </style>
</head>

<body>

    <div class="top-brand d-none d-lg-flex" style="gap: 12px; align-items: center;">
        <img src="https://i.pinimg.com/originals/e4/4a/80/e44a8041c60a2b81de3dc5770383d586.png" alt="Logo"
            style="height: 36px; width: auto; object-fit: contain;">
        <div style="display: flex; flex-direction: column; line-height: 1.2;">
            <span style="color: #0f172a;">OneID Pension System</span>
            <span style="font-size: 0.75rem; font-weight: 500; color: #64748b;">Digital Governance Mission</span>
        </div>
    </div>

    <div class="login-wrapper">
        <!-- Left Side: Colored Pane with curved right edge -->
        <div class="login-info">
            <h1 class="main-title">New Here?</h1>
            <p class="main-desc">Enter your personal details and start your journey with us.</p>
            <a href="{{ route('register') }}" class="btn-outline-white">SIGN UP</a>
        </div>

        <!-- Right Side: Login Form -->
        <div class="login-form-container">
            <h2 class="form-title">Sign In</h2>

            <!-- The buttons you requested to keep are here -->
            <div class="auth-toggle">
                <div class="auth-toggle-btn active">Admin ID</div>
                <div class="auth-toggle-btn">Citizen Login</div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="login-form">
                @csrf

                <div class="input-group-custom">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Email Address" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert"
                            style="display: block; text-align: left; margin-top: 5px; font-size: 0.8rem;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="input-group-custom">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Password" required>
                    <i class="fas fa-eye text-secondary position-absolute"
                        style="right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; z-index: 5;"></i>
                    @error('password')
                        <span class="invalid-feedback" role="alert"
                            style="display: block; text-align: left; margin-top: 5px; font-size: 0.8rem;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Captcha included as requested -->
                <div class="captcha-box">
                    <div class="d-flex align-items-center gap-2">
                        <span class="captcha-text">X7R2K</span>
                        <i class="fas fa-redo text-primary" style="cursor: pointer; font-size: 0.9rem;"></i>
                    </div>
                    <input type="text" class="form-control m-0"
                        style="width: 100px; height: 32px; padding: 5px 10px; background: white; font-size: 0.85rem;"
                        placeholder="Captcha">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                    <div class="form-check m-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-secondary" style="font-size: 0.8rem;" for="remember">
                            Remember me
                        </label>
                    </div>
                    <a href="#" style="font-size: 0.8rem; color: #666; text-decoration: none;">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-login">SIGN IN</button>

            </form>

            @if(app()->environment('local'))
                <div class="mt-4 pt-4 border-top w-100">
                    <div class="text-center mb-2"
                        style="font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase;">Developer
                        Quick Login</div>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="quickLogin('admin@onecitizen.gov.in', 'password')">Admin</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="quickLogin('user1@onecitizen.gov.in', 'password')">Citizen</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="footer d-none d-lg-flex">
        <div>&copy; 2026 OneID Pension System.</div>
        <div class="d-flex gap-4">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Help Desk</a>
        </div>
        <div class="fw-bold" style="color: #3e3270;">Powered by DGM</div>
    </div>

    <script>
        function quickLogin(email, password) {
            document.querySelector('input[name="email"]').value = email;
            document.querySelector('input[name="password"]').value = password;
            document.querySelector('form').submit();
        }

        // Toggle functionality
        document.querySelectorAll('.auth-toggle-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.auth-toggle-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const emailInput = document.querySelector('input[name="email"]');
                if (this.innerText.includes('Admin')) {
                    emailInput.placeholder = 'Admin Email Address';
                } else {
                    emailInput.placeholder = 'Citizen Email Address';
                }
            });
        });
    </script>
</body>

</html>
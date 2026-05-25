<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OneID-Pension Portal')</title>
    <meta name="description" content="OneID-Pension Portal — Comprehensive government portal for managing citizen information, pension schemes, and pension assignments.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1a237e;
            --primary-light: #283593;
            --primary-dark: #0d1553;
            --accent: #00d2ff;
            --accent-light: #3a7bd5;
            --success: #00c6ff;
            --success-light: #0072ff;
            --danger: #ff416c;
            --danger-light: #ff4b2b;
            --warning: #f7b733;
            --warning-light: #fc4a1a;
            --info: #0277bd;
            
            /* Glassmorphism Variables */
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.4);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            
            --surface: transparent;
            --surface-card: var(--glass-bg);
            --text-primary: #1e1e2d;
            --text-secondary: #5e6278;
            --border-light: var(--glass-border);
            
            --sidebar-width: 260px;
            --navbar-height: 70px;
            
            --shadow-sm: 0 4px 12px 0 rgba(31, 38, 135, 0.05);
            --shadow-md: var(--glass-shadow);
            --shadow-lg: 0 12px 40px 0 rgba(31, 38, 135, 0.2);
            
            --radius-sm: 12px;
            --radius-md: 16px;
            --radius-lg: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            background-attachment: fixed;
            color: var(--text-primary);
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Ambient Orbs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            z-index: -1;
            filter: blur(100px);
            opacity: 0.6;
        }
        body::before { width: 500px; height: 500px; background: #ff9a9e; top: -100px; right: -100px; }
        body::after { width: 400px; height: 400px; background: #a18cd1; bottom: -50px; left: -100px; }

        /* ========== NAVBAR ========== */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 1100;
            box-shadow: var(--shadow-sm);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--primary);
            text-decoration: none;
            font-size: 1.15rem;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .navbar-brand .brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(58, 123, 213, 0.4);
        }

        .navbar-brand .brand-sub {
            font-size: 0.7rem;
            font-weight: 500;
            color: var(--text-secondary);
            display: block;
            letter-spacing: 0.05em;
        }

        .navbar-search {
            position: relative;
            width: 380px;
        }

        .navbar-search input {
            width: 100%;
            padding: 10px 16px 10px 44px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(4px);
            border-radius: 30px;
            color: var(--text-primary);
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }

        .navbar-search input::placeholder { color: var(--text-secondary); }
        .navbar-search input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        .navbar-search i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .navbar-actions .nav-icon {
            color: var(--text-secondary);
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.2s;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
        }

        .navbar-actions .nav-icon:hover { 
            color: var(--primary); 
            background: white;
            box-shadow: var(--shadow-sm);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-primary);
            text-decoration: none;
            padding: 4px 16px 4px 4px;
            background: rgba(255,255,255,0.5);
            border-radius: 30px;
            border: 1px solid rgba(255,255,255,0.6);
        }

        .navbar-user .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--success), var(--success-light));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: white;
            font-size: 0.9rem;
            box-shadow: 0 2px 8px rgba(0, 198, 255, 0.3);
        }

        .navbar-user .user-info {
            line-height: 1.2;
        }

        .navbar-user .user-name {
            font-weight: 600;
            font-size: 0.85rem;
        }

        .navbar-user .user-role {
            font-size: 0.7rem;
            opacity: 0.7;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid var(--border-light);
            overflow-y: auto;
            z-index: 1050;
            padding: 20px 0;
            transition: transform 0.3s;
        }

        .sidebar-section {
            padding: 0 16px;
            margin-bottom: 8px;
        }

        .sidebar-section-title {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--primary);
            padding: 8px 16px;
            margin-bottom: 4px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            border-radius: var(--radius-sm);
            margin: 2px 0;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.6);
            color: var(--primary);
            transform: translateX(4px);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.4));
            color: var(--primary);
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: var(--accent);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px var(--accent);
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px;
            border-top: 1px solid var(--border-light);
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .sidebar-bottom .btn-export {
            width: 100%;
            background: linear-gradient(135deg, var(--danger), var(--danger-light));
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(255, 65, 108, 0.3);
        }

        .sidebar-bottom .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 65, 108, 0.4);
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 28px 32px;
            min-height: calc(100vh - var(--navbar-height));
            position: relative;
            z-index: 1;
        }

        /* ========== CARDS ========== */
        .card {
            background: var(--surface-card);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255,255,255,0.3);
            padding: 20px 24px;
            font-weight: 700;
            color: var(--primary);
        }

        .card-body { padding: 24px; }

        /* ========== STAT CARDS ========== */
        .stat-card {
            background: var(--surface-card);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-md);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .stat-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 4px;
        }

        .stat-card .stat-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-card .stat-meta {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .stat-card.stat-blue { border-top: 3px solid var(--accent); }
        .stat-card.stat-blue .stat-icon { background: rgba(21,101,192,0.1); color: var(--accent); }

        .stat-card.stat-green { border-top: 3px solid var(--success); }
        .stat-card.stat-green .stat-icon { background: rgba(46,125,50,0.1); color: var(--success); }

        .stat-card.stat-orange { border-top: 3px solid var(--warning); }
        .stat-card.stat-orange .stat-icon { background: rgba(230,81,0,0.1); color: var(--warning); }

        .stat-card.stat-red { border-top: 3px solid var(--danger); }
        .stat-card.stat-red .stat-icon { background: rgba(198,40,40,0.1); color: var(--danger); }

        .stat-card.stat-purple { border-top: 3px solid #6a1b9a; }
        .stat-card.stat-purple .stat-icon { background: rgba(106,27,154,0.1); color: #6a1b9a; }

        /* ========== TABLES ========== */
        .table-container {
            background: var(--surface-card);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--surface);
            color: var(--text-secondary);
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-light);
            white-space: nowrap;
        }

        .table tbody td {
            padding: 12px 16px;
            font-size: 0.88rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-light);
            color: var(--text-primary);
        }

        .table tbody tr {
            transition: background 0.15s;
        }

        .table tbody tr:hover {
            background: rgba(21,101,192,0.03);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ========== BADGES ========== */
        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-active { background: rgba(46,125,50,0.1); color: var(--success); }
        .badge-pending { background: rgba(230,81,0,0.1); color: var(--warning); }
        .badge-inactive, .badge-none { background: rgba(90,90,122,0.1); color: var(--text-secondary); }
        .badge-suspended { background: rgba(198,40,40,0.1); color: var(--danger); }
        .badge-completed { background: rgba(21,101,192,0.1); color: var(--accent); }
        .badge-draft { background: rgba(106,27,154,0.1); color: #6a1b9a; }

        .badge-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        /* ========== BUTTONS ========== */
        .btn-oneid {
            padding: 8px 20px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary-oneid {
            background: var(--primary);
            color: white;
        }
        .btn-primary-oneid:hover { background: var(--primary-light); color: white; }

        .btn-accent-oneid {
            background: var(--accent);
            color: white;
        }
        .btn-accent-oneid:hover { background: var(--accent-light); color: white; }

        .btn-success-oneid {
            background: var(--success);
            color: white;
        }
        .btn-success-oneid:hover { background: var(--success-light); color: white; }

        .btn-danger-oneid {
            background: var(--danger);
            color: white;
        }
        .btn-danger-oneid:hover { background: var(--danger-light); color: white; }

        .btn-warning-oneid {
            background: var(--warning);
            color: white;
        }
        .btn-warning-oneid:hover { background: var(--warning-light); color: white; }

        .btn-outline-oneid {
            background: transparent;
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
        }
        .btn-outline-oneid:hover {
            background: var(--surface);
            color: var(--text-primary);
            border-color: var(--primary);
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-light);
            background: white;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-icon:hover { background: var(--surface); color: var(--primary); border-color: var(--primary); }
        .btn-icon.btn-icon-danger:hover { color: var(--danger); border-color: var(--danger); }
        .btn-icon.btn-icon-success:hover { color: var(--success); border-color: var(--success); }

        /* ========== FORMS ========== */
        .form-label {
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-control, .form-select {
            border: 1px solid var(--border-light);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: 0.88rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(21,101,192,0.1);
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--danger);
        }

        /* ========== ALERTS ========== */
        .alert-oneid {
            border: none;
            border-radius: var(--radius-md);
            padding: 14px 20px;
            font-size: 0.88rem;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        .alert-success-oneid {
            background: rgba(46,125,50,0.08);
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        .alert-danger-oneid {
            background: rgba(198,40,40,0.08);
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        /* ========== PAGE HEADER ========== */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
        }

        .page-header .page-subtitle {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        /* ========== PAGINATION ========== */
        .pagination {
            gap: 4px;
        }

        .pagination .page-link {
            border: 1px solid var(--border-light);
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 500;
            padding: 6px 12px;
            font-family: 'Inter', sans-serif;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* ========== ANIMATIONS ========== */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .fade-in { animation: fadeIn 0.4s ease; }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .navbar-search { display: none; }
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Top Navbar -->
    <header class="top-navbar">
        <a href="{{ route('dashboard') }}" class="navbar-brand">
            <div class="brand-icon">
                <i class="fas fa-fingerprint"></i>
            </div>
            <div>
                <span>OneID Pension System</span>
                <span class="brand-sub">Digital Governance Mission</span>
            </div>
        </a>

        <form class="navbar-search" action="{{ route('search.index') }}" method="GET">
            <i class="fas fa-search"></i>
            <input type="text" name="q" placeholder="Search citizens, schemes..." value="{{ request('q') }}">
        </form>

        <div class="navbar-actions">
            <span class="nav-icon"><i class="fas fa-bell"></i></span>
            <div class="navbar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="user-info d-none d-md-block">
                    <div class="user-name">{{ auth()->user()->name ?? 'User' }}</div>
                    <div class="user-role">{{ auth()->user()->role ?? 'Operator' }}</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-section">
            <div class="sidebar-section-title">Admin Portal</div>
            <span class="sidebar-link" style="color: var(--text-secondary); font-size: 0.78rem; padding: 4px 16px; cursor: default;">
                <i class="fas fa-shield-alt" style="font-size: 0.75rem;"></i> Verified Personnel
            </span>
        </div>

        <div class="sidebar-section" style="margin-top: 12px;">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Admin Dashboard
            </a>
            <a href="{{ route('citizens.index') }}" class="sidebar-link {{ request()->routeIs('citizens.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Beneficiary Mgmt
            </a>
            <a href="{{ route('pension-schemes.index') }}" class="sidebar-link {{ request()->routeIs('pension-schemes.*') ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i> Pension Schemes
            </a>
            <a href="{{ route('citizen-pensions.index') }}" class="sidebar-link {{ request()->routeIs('citizen-pensions.*') ? 'active' : '' }}">
                <i class="fas fa-money-bill-wave"></i> Assignments
            </a>
            <a href="{{ route('duplicate-detection.index') }}" class="sidebar-link {{ request()->routeIs('duplicate-detection.*') ? 'active' : '' }}">
                <i class="fas fa-clone"></i> Fraud Detection
            </a>
            <a href="{{ route('search.index') }}" class="sidebar-link {{ request()->routeIs('search.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> Search & Analytics
            </a>
        </div>

        <div class="sidebar-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-export">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content fade-in">
        @if($errors->any())
            <div class="alert-oneid alert-danger-oneid mb-3" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <div>
                    <strong>Validation Error</strong>
                    <ul class="mb-0 mt-1" style="padding-left: 16px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="alert-oneid alert-success-oneid mb-3" role="alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-dismiss alerts after 5 seconds
        document.querySelectorAll('.alert-oneid').forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s, transform 0.5s';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(function() { alert.remove(); }, 500);
            }, 5000);
        });
    </script>
    @yield('scripts')
</body>
</html>

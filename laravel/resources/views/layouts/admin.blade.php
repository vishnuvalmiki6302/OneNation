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
            --primary: #0f172a;       /* Slate 900 */
            --primary-light: #334155; /* Slate 700 */
            --primary-dark: #020617;  /* Slate 950 */
            --accent: #2563eb;        /* Blue 600 */
            --accent-light: #3b82f6;  /* Blue 500 */
            --success: #16a34a;       /* Green 600 */
            --danger: #dc2626;        /* Red 600 */
            --warning: #d97706;       /* Amber 600 */
            --info: #0284c7;          /* Light Blue 600 */
            
            --surface: #f8fafc;       /* Slate 50 */
            --surface-card: #ffffff;  /* White */
            --text-primary: #0f172a;
            --text-secondary: #64748b; /* Slate 500 */
            --border-light: #e2e8f0;  /* Slate 200 */
            
            --sidebar-width: 256px;
            --navbar-height: 64px;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            
            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--surface);
            color: var(--text-primary);
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* ========== NAVBAR ========== */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            background: var(--surface-card);
            border-bottom: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 1100;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--primary);
            text-decoration: none;
            font-size: 1.15rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .navbar-brand .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--primary);
            color: white;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .navbar-brand .brand-sub {
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-secondary);
            display: block;
        }

        .navbar-search {
            position: relative;
            width: 320px;
        }

        .navbar-search input {
            width: 100%;
            padding: 8px 16px 8px 40px;
            border: 1px solid var(--border-light);
            background: var(--surface);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .navbar-search input::placeholder { color: var(--text-secondary); }
        .navbar-search input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            background: var(--surface-card);
        }

        .navbar-search i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .navbar-actions .nav-icon {
            color: var(--text-secondary);
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.2s;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--radius-sm);
        }

        .navbar-actions .nav-icon:hover { 
            color: var(--primary); 
            background: var(--surface);
        }

        .navbar-user {
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--text-primary);
            text-decoration: none;
            padding: 4px 12px 4px 4px;
            border-radius: var(--radius-sm);
            transition: background 0.2s;
        }
        
        .navbar-user:hover {
            background: var(--surface);
        }

        .navbar-user .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            background: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            font-size: 0.875rem;
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
            background: var(--surface-card);
            border-right: 1px solid var(--border-light);
            overflow-y: auto;
            z-index: 1050;
            padding: 24px 16px;
            transition: transform 0.3s;
        }

        .sidebar-section {
            margin-bottom: 24px;
        }

        .sidebar-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: var(--text-secondary);
            padding: 0 12px;
            margin-bottom: 8px;
            letter-spacing: 0.05em;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: var(--radius-sm);
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            background: var(--surface);
            color: var(--primary);
        }

        .sidebar-link.active {
            background: rgba(37, 99, 235, 0.1);
            color: var(--accent);
            font-weight: 600;
        }

        .sidebar-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .sidebar-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 16px;
            background: var(--surface-card);
            border-top: 1px solid var(--border-light);
        }

        .sidebar-bottom .btn-export {
            width: 100%;
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border-light);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .sidebar-bottom .btn-export:hover {
            background: var(--border-light);
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 32px;
            min-height: calc(100vh - var(--navbar-height));
            position: relative;
            z-index: 1;
        }

        /* ========== CARDS ========== */
        .card {
            background: var(--surface-card);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s;
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background: var(--surface-card);
            border-bottom: 1px solid var(--border-light);
            padding: 16px 24px;
            font-weight: 600;
            color: var(--text-primary);
        }

        .card-body { padding: 24px; }

        /* ========== STAT CARDS ========== */
        .stat-card {
            background: var(--surface-card);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-md);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s;
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
            <div class="brand-icon" style="background: transparent;">
                <img src="https://i.pinimg.com/originals/e4/4a/80/e44a8041c60a2b81de3dc5770383d586.png" alt="Logo" style="height: 36px; width: auto; object-fit: contain;">
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
            <span class="nav-icon d-lg-none" id="sidebar-toggle"><i class="fas fa-bars"></i></span>
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
            <div class="sidebar-section-title">Main Menu</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isOperator())
        <div class="sidebar-section">
            <div class="sidebar-section-title">Records Management</div>
            <a href="{{ route('citizens.index') }}" class="sidebar-link {{ request()->routeIs('citizens.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Citizens
            </a>
            <a href="{{ route('pension-schemes.index') }}" class="sidebar-link {{ request()->routeIs('pension-schemes.*') ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i> Pension Schemes
            </a>
            <a href="{{ route('applications.index') }}" class="sidebar-link {{ request()->routeIs('applications.*') ? 'active' : '' }}">
                <i class="fas fa-inbox"></i> Pending Applications
                @php
                    $pendingCount = \App\Models\CitizenPension::where('pension_status', 'Pending')->count();
                @endphp
                @if($pendingCount > 0)
                <span class="badge bg-danger ms-auto rounded-pill">{{ $pendingCount }}</span>
                @endif
            </a>
            <a href="{{ route('citizen-pensions.index') }}" class="sidebar-link {{ request()->routeIs('citizen-pensions.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar"></i> Active Pensions
            </a>
            <a href="{{ route('admin.tickets.index') }}" class="sidebar-link {{ request()->routeIs('admin.tickets.*') ? 'active' : '' }}">
                <i class="fas fa-headset"></i> Support Tickets
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-section-title">System Tools</div>
            <a href="{{ route('search.index') }}" class="sidebar-link {{ request()->routeIs('search.*') ? 'active' : '' }}">
                <i class="fas fa-search"></i> Global Search
            </a>
            <a href="{{ route('duplicate-detection.index') }}" class="sidebar-link {{ request()->routeIs('duplicate-detection.*') ? 'active' : '' }}">
                <i class="fas fa-shield-alt"></i> Fraud Detection
            </a>
        </div>
        @endif

        @if(auth()->user()->isUser())
        <div class="sidebar-section">
            <div class="sidebar-section-title">My Account</div>
            <a href="{{ route('user.schemes.index') }}" class="sidebar-link {{ request()->routeIs('user.schemes.*') ? 'active' : '' }}">
                <i class="fas fa-hand-holding-usd"></i> Apply for Schemes
            </a>
            <a href="{{ route('profile.create') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fas fa-id-card"></i> Profile Details
            </a>
            <a href="{{ route('user.transactions.index') }}" class="sidebar-link {{ request()->routeIs('user.transactions.*') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Payment History
            </a>
            <a href="{{ route('user.certificates.index') }}" class="sidebar-link {{ request()->routeIs('user.certificates.*') ? 'active' : '' }}">
                <i class="fas fa-certificate"></i> My Documents
            </a>
            <a href="{{ route('user.support.create') }}" class="sidebar-link {{ request()->routeIs('user.support.*') ? 'active' : '' }}">
                <i class="fas fa-headset"></i> Support Desk
            </a>
        </div>
        @endif

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

        // Mobile Sidebar Toggle
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 992) {
                    if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target) && sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                    }
                }
            });
        }
    </script>
    @stack('modals')
    @yield('scripts')
</body>
</html>

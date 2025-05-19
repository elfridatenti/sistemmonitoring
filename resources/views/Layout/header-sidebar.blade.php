<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('js/notification-handler.js') }}"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.3/echo.iife.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title') Dashboard</title>
    <audio id="notificationSound" src="{{ asset('sounds/notifications.MP3') }}" preload="auto"></audio>
    <!-- Updated fonts: Added Poppins as primary and Montserrat as secondary -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 70px;
            --sidebar-mobile-width: 270px;
            --primary-blue: #183B7E;
            /* Darker blue for sidebar */
            --secondary-blue: #2A5DB5;
            /* For hover states */
            --active-blue: #3A6DDF;
            /* For active items */
            --text-white: #FFFFFF;
            /* For sidebar text */
            --light-hover: rgba(255, 255, 255, 0.15);
            /* For hover effects */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            height: 100%;
            overflow-x: hidden;
            font-size: 16px;
        }

        body {
            font-weight: 400;
            background-color: #eeeeee;
            position: relative;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }

        /* Dashboard Layout */
        .dashboard-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Scrollbar Styles */
        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: var(--primary-blue);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Logo and Header Container */
        .logo-header-container {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-header-container .logo {
            max-height: 36px;
            width: auto;
        }

        .logo-header-container h2 {
            color: var(--text-white);
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--primary-blue);
            z-index: 1040;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, width 0.3s ease;
        }

        /* Logo Section */
        .sidebar-logo {
            background-color: var(--primary-blue);
            height: var(--header-height);
            padding: 0 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: sticky;
            top: 0;
            z-index: 2;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo-header-container .logo {
            max-height: 36px;
            width: auto;
            background-color: #efefef;
            padding: 6px;
            border-radius: 3px;
        }

        /* Navigation Styles */
        .nav-menu {
            padding: 0.5rem 0;
            flex: 1;
        }

        .nav-link {
            color: var(--text-white);
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.25s ease;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            border-left: 3px solid transparent;
            margin-bottom: 5px;
        }

        .nav-link:hover {
            background-color: var(--light-hover);
            color: var(--text-white);
            font-weight: 500;
            border-left: 3px solid rgba(255, 255, 255, 0.5);
        }

        .nav-link.active {
            background-color: var(--secondary-blue);
            color: var(--text-white);
            font-weight: 500;
            border-left: 3px solid #ffffff;
        }

        /* Menu Group Styles */
        .menu-group-toggle {
            color: var(--text-white);
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            font-weight: 600;
            letter-spacing: 0.3px;
            padding: 0.95rem 1rem;
            /* Menambahkan padding yang konsisten */
            margin-bottom: 5px;
            /* Jarak yang sama dengan menu lain */
        }

        .menu-group-toggle .toggle-icon {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .menu-group-toggle.collapsed .toggle-icon {
            transform: rotate(-90deg);
        }

        .menu-group-toggle:hover {
            background-color: var(--light-hover);
            color: var(--text-white);
        }

        .submenu {
            background-color: rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            overflow: hidden;
            max-height: 0;
        }

        .submenu.show {
            max-height: 500px;
        }

        .submenu .nav-link {
            padding-left: 2.5rem;
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 4px;
        }

        .submenu .nav-link:hover {
            background-color: var(--light-hover);
            color: #ffffff;
        }

        .submenu .nav-link.active {
            background-color: var(--active-blue);
            color: #ffffff;
            font-weight: 500;
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            height: var(--header-height);
            background-color: #ffffff;
            padding: 0 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #f0f0f0;
            transition: left 0.3s ease, width 0.3s ease;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header-left h1 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 25vw;
            letter-spacing: 0.3px;
        }

        /* User Section */
        .user-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            background-color: #f8f9fa;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .user-info:hover {
            background-color: #f0f0f0;
        }

        .user-info span {
            font-weight: 500;
            font-size: 0.85rem;
            color: #444;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .user-icon {
            font-size: 1.1rem;
            color: var(--secondary-blue);
            flex-shrink: 0;
        }

        /* Notification Styles */
        .notification-container {
            position: relative;
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .notification-icon:hover {
            background-color: #f0f0f0;
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding-top: var(--header-height);
            width: calc(100% - var(--sidebar-width));
            transition: margin-left 0.3s ease, width 0.3s ease;
            min-height: 100vh;
        }

        .content-area {
            padding: 1.25rem;
        }

        /* Logout Section */
        .logout-container {
            padding: 1rem;
            background-color: rgba(0, 0, 0, 0.15);
            position: sticky;
            bottom: 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-container .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        /* Mobile Menu Toggle Button */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            left: 1rem;
            top: 1.25rem;
            z-index: 1050;
            background-color: var(--secondary-blue);
            color: white;
            border: none;
            border-radius: 4px;
            width: 36px;
            height: 36px;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background-color: var(--primary-blue);
        }

        /* Responsive Media Queries */
        @media (max-width: 1200px) {
            :root {
                --sidebar-width: 220px;
            }

            .user-info span {
                max-width: 120px;
            }

            .header-left h1 {
                max-width: 30vw;
            }
        }

        @media (max-width: 992px) {
            .header-left h1 {
                font-size: 1.1rem;
                max-width: 25vw;
            }

            .user-info span {
                max-width: 100px;
            }

            .user-section {
                gap: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            :root {
                --sidebar-width: 0;
                --sidebar-mobile-width: 270px;
            }

            .sidebar {
                width: var(--sidebar-mobile-width);
                transform: translateX(-100%);
            }

            .sidebar.mobile-show {
                transform: translateX(0);
            }

            .header {
                left: 0;
                padding-left: 4rem;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .user-info span {
                max-width: 80px;
            }

            .header-left h1 {
                max-width: 50%;
            }
        }

        @media (max-width: 576px) {
            .header {
                padding-left: 3.5rem;
                padding-right: 0.75rem;
            }

            .header-left h1 {
                font-size: 1rem;
                max-width: 120px;
            }

            .user-section {
                gap: 0.5rem;
            }

            .user-info {
                padding: 0.4rem 0.6rem;
            }

            .user-info span {
                max-width: 60px;
                font-size: 0.8rem;
            }

            .notification-icon {
                width: 32px;
                height: 32px;
            }

            .content-area {
                padding: 0.75rem;
            }
        }

        /* For very small screens */
        @media (max-width: 375px) {
            .header-left h1 {
                max-width: 100px;
            }

            .user-info span {
                max-width: 40px;
            }
        }

        /* Print Media Styles */
        @media print {

            .sidebar,
            .header,
            .logout-container,
            .mobile-menu-toggle {
                display: none !important;
            }

            .main-content {
                margin-left: 0;
                padding-top: 0;
                width: 100%;
            }

            .content-area {
                padding: 0;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pastikan Pusher dan Echo tersedia
            if (window.Pusher) {
                window.Echo = new Echo({
                    broadcaster: 'pusher',
                    key: '{{ config('broadcasting.connections.pusher.key') }}',
                    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                    forceTLS: true
                });

                console.log('Echo initialized in header');

                // Mengizinkan browser notification
                if ('Notification' in window) {
                    Notification.requestPermission();
                }

                // Inisialisasi audio saat user interaction pertama
                document.addEventListener('click', function enableAudio() {
                    const audio = document.getElementById('notificationSound');
                    if (audio) {
                        audio.volume = 0.5; // Set volume 50%
                        audio.play().then(() => {
                            audio.pause();
                            audio.currentTime = 0;
                        }).catch(err => {
                            /* ignore */
                        });
                    }
                    document.removeEventListener('click', enableAudio);
                }, {
                    once: true
                });
            } else {
                console.error('Pusher not loaded!');
            }
        });
    </script>
</head>

<body data-user-id="{{ Auth::id() }}">
    <div class="dashboard-container">
        <!-- Mobile Menu Toggle Button -->
        <button class="mobile-menu-toggle">
            <i class="bi bi-list"></i>
        </button>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-header-container">
                    <img src="{{ Storage::url('images/logo3.png') }}" class="logo" alt="Logo">
                    <h2 class="text-center">MOLDING INFORMATION </br> SYSTEM</h2>
                </div>
            </div>

            <nav class="nav-menu">
                {{-- Dashboard - Accessible by All Users --}}
                <div class="menu-group">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-title="Dashboard">
                        <i class="fas fa-house-user"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                @php
                    $userRole = auth()->user()->role;
                @endphp

                {{-- Admin Only Menus --}}
                @if ($userRole === 'admin')
                    {{-- Data Management --}}
                    <div class="menu-group">
                        <a href="{{ route('datauser.index') }}"
                            class="nav-link {{ request()->routeIs('datauser.index') ? 'active' : '' }}"
                            data-title="Data User">
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Users Data</span>
                        </a>
                    </div>
                    <div class="menu-group">
                        <a href="{{ route('mesin.index') }}"
                            class="nav-link {{ request()->routeIs('mesin.index') ? 'active' : '' }}"
                            data-title="Data Mesin">
                            <i class="bi bi-gear-wide-connected"></i>
                            <span>Active Machine </span>
                        </a>
                    </div>
                    <div class="menu-group">
                        <a href="{{ route('defect.index') }}"
                            class="nav-link {{ request()->routeIs('defect.index') ? 'active' : '' }}"
                            data-title="Molding Defect">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <span>Molding Defect</span>
                        </a>
                    </div>
                @endif
                
                {{-- Machine Setup Menu --}}
                @if ($userRole === 'leader')
                    {{-- For Leader: Show submenu with dropdown --}}
                    <div class="menu-group">
                        <div class="nav-link menu-group-toggle" data-bs-toggle="collapse" data-bs-target="#setupSubmenu"
                            data-title="Setup">
                            <div>
                                <i class="fas fa-tools"></i>
                                <span>Machine Molding Setup</span>
                            </div>
                            <i class="bi bi-chevron-down toggle-icon"></i>
                        </div>
                        <div id="setupSubmenu" class="submenu">
                            <a href="{{ route('setup.create') }}"
                                class="nav-link {{ request()->routeIs('setup.create') ? 'active' : '' }}">
                                <span>Request Setup Molding    </span>
                            </a>
                            <a href="{{ route('setup.index') }}"
                                class="nav-link {{ request()->routeIs('setup.index') ? 'active' : '' }}">
                                <span> Records Setup Molding   </span>
                            </a>
                        </div>
                    </div>
                @elseif (in_array($userRole, ['admin', 'teknisi']))
                    {{-- For Admin and Teknisi: Direct link to setup data --}}
                    <div class="menu-group">
                        <a href="{{ route('setup.index') }}"
                            class="nav-link {{ request()->routeIs('setup.index') ? 'active' : '' }}"
                            data-title="Machine Setup">
                            <i class="fas fa-tools"></i>
                            <span> Records Setup Molding </span>
                        </a>
                    </div>
                @elseif ($userRole === 'ipqc')
                    {{-- Direct access for IPQC to Approve Setup --}}
                    <div class="menu-group">
                        <a href="{{ route('setup.index') }}"
                            class="nav-link {{ request()->routeIs('setup.index') ? 'active' : '' }}">
                            <i class="fas fa-tools"></i>
                            <span>Records Setup Molding</span>
                        </a>
                    </div>
                @endif

                {{-- Machine Downtime Menu --}}
                @if ($userRole === 'leader')
                    {{-- For Leader: Show submenu with dropdown --}}
                    <div class="menu-group">
                        <div class="nav-link menu-group-toggle" data-bs-toggle="collapse"
                            data-bs-target="#downtimeSubmenu" data-title="Downtime">
                            <div>
                                <i class="fas fa-clock"></i>
                                <span> Machine Molding Downtime</span>
                            </div>
                            <i class="bi bi-chevron-down toggle-icon"></i>
                        </div>
                        <div id="downtimeSubmenu" class="submenu">
                            <a href="{{ route('downtime.create') }}"
                                class="nav-link {{ request()->routeIs('downtime.create') ? 'active' : '' }}">
                                <span>Submit Downtime Molding</span>
                            </a>
                            <a href="{{ route('downtime.index') }}"
                                class="nav-link {{ request()->routeIs('downtime.index') ? 'active' : '' }}">
                                <span>Records Downtime Molding</span>
                            </a>
                        </div>
                    </div>
                @elseif (in_array($userRole, ['admin', 'teknisi']))
                    {{-- For Admin and Teknisi: Direct link to downtime data --}}
                    <div class="menu-group">
                        <a href="{{ route('downtime.index') }}"
                            class="nav-link {{ request()->routeIs('downtime.index') ? 'active' : '' }}"
                            data-title="Machine Downtime">
                            <i class="fas fa-clock"></i>
                            <span>Records Downtime Molding </span>
                        </a>
                    </div>
                @elseif ($userRole === 'ipqc')
                    {{-- Direct access for IPQC to Approve Downtime --}}
                    <div class="menu-group">
                        <a href="{{ route('downtime.index') }}"
                            class="nav-link {{ request()->routeIs('downtime.index') ? 'active' : '' }}">
                            <i class="fas fa-clock"></i>
                            <span>Records Downtime Molding</span>
                        </a>
                    </div>
                @endif
            </nav>
            <div class="logout-container">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header class="header">
                <div class="header-left">
                    <h1>@yield('title')</h1>
                </div>
                <div class="user-section">
                    <div class="user-info">
                        <span>Hi, {{ auth()->user()->nama }}</span>
                        <i class="fas fa-user-circle user-icon"></i>
                    </div>

                    <div class="notification-container">
                        @include('partials.notifikasi')
                    </div>
                </div>
            </header>
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // const notificationIcon = document.querySelector(".notification-icon");
            const sidebar = document.querySelector(".sidebar");
            const mobileMenuToggle = document.querySelector(".mobile-menu-toggle");
            const menuGroups = document.querySelectorAll(".menu-group-toggle");
            const regularMenus = document.querySelectorAll(".nav-menu .nav-link:not(.menu-group-toggle)");

            // Handle window resize
            function handleResize() {
                // Adjust any heights that need to be dynamic
                const submenuItems = document.querySelectorAll('.submenu.show');
                submenuItems.forEach(submenu => {
                    submenu.style.maxHeight = submenu.scrollHeight + "px";
                });

                // Reset mobile menu when window is resized to desktop
                if (window.innerWidth > 768) {
                    sidebar.classList.remove("mobile-show");
                }
            }

            // Add resize event listener
            window.addEventListener('resize', handleResize);

            // Navigasi notifikasi
            // if (notificationIcon) {
            //     notificationIcon.addEventListener("click", function(e) {
            //         e.preventDefault();
            //         window.location.href = "{{ route('notifications.index') }}";
            //     });
            // }

            // Mobile menu toggle
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener("click", function() {
                    sidebar.classList.toggle("mobile-show");
                });
            }

            // Menutup semua submenu di awal
            document.querySelectorAll(".submenu").forEach((submenu) => {
                submenu.style.maxHeight = "0px";
                submenu.style.overflow = "hidden";
                submenu.style.display = "none";
            });

            // Check for active submenu items and open their parent submenu
            const activeSubmenuItem = document.querySelector('.submenu .nav-link.active');
            if (activeSubmenuItem) {
                const parentSubmenu = activeSubmenuItem.closest('.submenu');
                if (parentSubmenu) {
                    parentSubmenu.style.display = "block";
                    parentSubmenu.style.maxHeight = parentSubmenu.scrollHeight + "px";

                    // Update the toggle icon for the parent menu
                    const parentToggle = parentSubmenu.previousElementSibling;
                    if (parentToggle && parentToggle.querySelector('.toggle-icon')) {
                        parentToggle.querySelector('.toggle-icon').classList.remove('bi-plus');
                        parentToggle.querySelector('.toggle-icon').classList.add('bi-dash');
                    }
                }
            }

            // Fungsi untuk membuka dan menutup submenu
            function toggleSubMenu(submenu, toggleIcon) {
                if (submenu.style.maxHeight === "0px" || submenu.style.maxHeight === "") {
                    submenu.style.display = "block";
                    submenu.style.maxHeight = submenu.scrollHeight + "px";
                    // Change icon to minus
                    if (toggleIcon) {
                        toggleIcon.classList.remove('bi-plus');
                        toggleIcon.classList.add('bi-dash');
                    }
                } else {
                    submenu.style.maxHeight = "0px";
                    // Change icon to plus
                    if (toggleIcon) {
                        toggleIcon.classList.remove('bi-dash');
                        toggleIcon.classList.add('bi-plus');
                    }
                    setTimeout(() => {
                        submenu.style.display = "none";
                    }, 200); // Sesuai dengan durasi transisi
                }
            }

            // Function to close all submenus
            function closeAllSubmenus() {
                document.querySelectorAll(".submenu").forEach((submenu) => {
                    const toggleIcon = submenu.previousElementSibling ?
                        submenu.previousElementSibling.querySelector('.toggle-icon') : null;

                    submenu.style.maxHeight = "0px";
                    if (toggleIcon) {
                        toggleIcon.classList.remove('bi-dash');
                        toggleIcon.classList.add('bi-plus');
                    }
                    setTimeout(() => {
                        submenu.style.display = "none";
                    }, 200);
                });
            }

            // Event listener for regular menu items (not toggles)
            regularMenus.forEach((menu) => {
                menu.addEventListener("click", function() {
                    closeAllSubmenus();

                    // On mobile, close sidebar when a menu item is clicked
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove("mobile-show");
                    }
                });
            });

            // Event listener for menu group toggles
            menuGroups.forEach((group) => {
                // First, change chevron-down to plus icon
                const toggleIcon = group.querySelector('.toggle-icon');
                if (toggleIcon) {
                    toggleIcon.classList.remove('bi-chevron-down');
                    toggleIcon.classList.add('bi-plus');
                }

                group.addEventListener("click", function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;

                    if (!submenu || !submenu.classList.contains("submenu")) return;

                    // Close all other submenus
                    document.querySelectorAll(".submenu").forEach((otherSubmenu) => {
                        if (otherSubmenu !== submenu) {
                            const otherToggleIcon = otherSubmenu.previousElementSibling ?
                                otherSubmenu.previousElementSibling.querySelector(
                                    '.toggle-icon') : null;

                            otherSubmenu.style.maxHeight = "0px";
                            if (otherToggleIcon) {
                                otherToggleIcon.classList.remove('bi-dash');
                                otherToggleIcon.classList.add('bi-plus');
                            }
                            setTimeout(() => {
                                otherSubmenu.style.display = "none";
                            }, 200);
                        }
                    });

                    // Toggle clicked submenu
                    toggleSubMenu(submenu, toggleIcon);
                });
            });

            // Mencegah submenu menutup ketika submenu link diklik
            document.querySelectorAll(".submenu .nav-link").forEach((link) => {
                link.addEventListener("click", (e) => {
                    e.stopPropagation();

                    // On mobile, close sidebar when a submenu item is clicked
                    if (window.innerWidth <= 768) {
                        sidebar.classList.remove("mobile-show");
                    }
                });
            });

            // Tutup sidebar di mode mobile saat klik di luar
            document.addEventListener("click", (e) => {
                if (
                    window.innerWidth <= 768 &&
                    !sidebar.contains(e.target) &&
                    !mobileMenuToggle.contains(e.target)
                ) {
                    sidebar.classList.remove("mobile-show");
                }
            });

            // Run resize handler once at start
            handleResize();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                setTimeout(function() {
                    bsAlert.close();
                }, 5000);
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            function performSearch(searchText) {
                const filterType = $('select[name="filter_type"]').val();

                $.ajax({
                    url: window.location.pathname,
                    type: 'GET',
                    data: {
                        search: searchText,
                        filter_type: filterType,
                        show: $('select[name="show"]').val()
                    },
                    success: function(response) {
                        // Update table content
                        $('.table-responsive').html($(response).find('.table-responsive').html());
                        // Update pagination
                        $('.d-flex.justify-content-end').html($(response).find(
                            '.d-flex.justify-content-end').html());

                        // Handle alert messages
                        const existingAlert = $('.alert');
                        const newAlert = $(response).find('.alert');

                        if (newAlert.length) {
                            if (existingAlert.length) {
                                existingAlert.replaceWith(newAlert);
                            } else {
                                $('.card-body').prepend(newAlert);
                            }
                        } else {
                            existingAlert.remove();
                        }
                    },
                    error: function(xhr) {
                        console.error('Search error:', xhr);
                    }
                });
            }


            // Add handler for show dropdown if it exists
            $('select[name="show"]').on('change', function() {
                const searchText = $('input[name="search"]').val();
                performSearch(searchText);
            });
        });
    </script>

    <!-- Add viewport adjustment script to improve responsiveness -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Function to handle tables on small screens
            function makeTablesResponsive() {
                const tables = document.querySelectorAll('.table');

                tables.forEach(table => {
                    // Add responsive wrapper if not already added
                    if (!table.parentElement.classList.contains('table-responsive')) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'table-responsive';
                        table.parentNode.insertBefore(wrapper, table);
                        wrapper.appendChild(table);
                    }
                });

                // Adjust card padding on small screens
                const cards = document.querySelectorAll('.card');
                if (window.innerWidth < 576) {
                    cards.forEach(card => {
                        const cardBody = card.querySelector('.card-body');
                        if (cardBody) {
                            cardBody.style.padding = '0.75rem';
                        }
                    });
                } else {
                    cards.forEach(card => {
                        const cardBody = card.querySelector('.card-body');
                        if (cardBody) {
                            cardBody.style.padding = '';
                        }
                    });
                }
            }

            // Ensure form elements are responsive
            function makeFormsResponsive() {
                const formGroups = document.querySelectorAll('.form-group, .mb-3');
                formGroups.forEach(group => {
                    const label = group.querySelector('label');
                    const input = group.querySelector('input, select, textarea');

                    if (label && input && window.innerWidth < 576) {
                        label.classList.add('mb-1');
                        label.style.fontSize = '0.9rem';
                    } else if (label) {
                        label.classList.remove('mb-1');
                        label.style.fontSize = '';
                    }
                });
            }

            // Run functions on load and resize
            makeTablesResponsive();
            makeFormsResponsive();

            window.addEventListener('resize', function() {
                makeTablesResponsive();
                makeFormsResponsive();
            });

            // Zoom handling - this helps with better user experience when pinch zooming
            document.addEventListener('touchstart', function(e) {
                if (e.touches.length > 1) {
                    // Handle multi-touch (zoom) gesture
                    e.preventDefault();
                }
            }, {
                passive: false
            });
        });
    </script>
</body>

</html>

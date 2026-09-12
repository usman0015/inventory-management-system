<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyInventory')</title>

    <script>
        (function () {
            var saved = localStorage.getItem('theme');
            var theme = saved || (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-bs-theme', theme);
        })();
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 60px;
            --primary: #0d6efd;
            --primary-light: #e7f1ff;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.04);
            --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.07);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.1);
            --transition-fast: 0.15s ease;
            --transition: 0.25s ease;
            --transition-slow: 0.4s cubic-bezier(0.4, 0, 0.2, 1);

            /* Light theme surfaces */
            --bg-body: #f0f2f5;
            --bg-sidebar: #ffffff;
            --bg-topbar: #ffffff;
            --bg-surface: #ffffff;
            --bg-surface-2: #f9fafb;
            --bg-hover: #f3f4f6;
            --bg-active: #e7f1ff;
            --bg-input: #ffffff;
            --text-primary: #1a1d21;
            --text-secondary: #4b5563;
            --text-muted: #6b7280;
            --text-faint: #9ca3af;
            --border-color: #e5e7eb;
            --border-color-soft: #f3f4f6;
            --border-input: #d1d5db;
        }

        [data-bs-theme="dark"] {
            --bg-body: #0b1220;
            --bg-sidebar: #111a2e;
            --bg-topbar: #111a2e;
            --bg-surface: #16233c;
            --bg-surface-2: #1b2b48;
            --bg-hover: #1f3152;
            --bg-active: #1e3a5f;
            --bg-input: #0d1730;
            --text-primary: #e5eaf3;
            --text-secondary: #a8b3c7;
            --text-muted: #94a3b8;
            --text-faint: #64748b;
            --border-color: #24375c;
            --border-color-soft: #1f3152;
            --border-input: #2b4170;
            --shadow-md: 0 4px 12px rgba(0,0,0,0.3);
            --shadow-lg: 0 10px 30px rgba(0,0,0,0.4);
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-primary);
            transition: background-color var(--transition), color var(--transition);
        }

        /* ============ PAGE ENTRANCE ============ */
        @keyframes pageFadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ============ SIDEBAR ============ */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--bg-sidebar);
            border-right: 1px solid var(--border-color);
            padding-top: var(--topbar-height);
            z-index: 1040;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s ease, background-color var(--transition), border-color var(--transition);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-brand {
            padding: 16px 20px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand .brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-text {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            white-space: nowrap;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .sidebar .nav {
            padding: 0 12px;
            flex: 1;
        }

        .sidebar .nav-section {
            font-size: 0.68rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-faint);
            padding: 12px 12px 6px;
            white-space: nowrap;
            overflow: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .sidebar .nav-link {
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.875rem;
            padding: 10px 14px;
            border-radius: 8px;
            margin-bottom: 2px;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.2s ease, color 0.2s ease;
            text-decoration: none;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar .nav-link span {
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .sidebar .nav-link:hover {
            background-color: var(--bg-hover);
            color: var(--primary);
        }

        .sidebar .nav-link.active {
            background-color: var(--bg-active);
            color: var(--primary);
            font-weight: 600;
            box-shadow: inset 3px 0 0 var(--primary);
        }

        .sidebar-footer {
            padding: 12px;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
        }

        /* Collapsed state (desktop only) */
        @media (min-width: 992px) {
            .sidebar.collapsed {
                width: 72px;
            }
            .sidebar.collapsed .brand-text,
            .sidebar.collapsed .nav-section,
            .sidebar.collapsed .nav-link span {
                opacity: 0;
                width: 0;
                overflow: hidden;
                visibility: hidden;
                transition: opacity 0.15s ease, visibility 0.15s ease, width 0.2s ease;
            }
            .sidebar.collapsed .sidebar-brand {
                justify-content: center;
                padding: 16px 8px;
            }
            .sidebar.collapsed .nav {
                padding: 0 8px;
            }
            .sidebar.collapsed .nav-link {
                justify-content: center;
                padding: 10px 0;
            }
            .sidebar.collapsed .nav-link i {
                margin: 0;
            }
            .sidebar.collapsed .sidebar-footer {
                padding: 12px 8px;
            }
            .sidebar.collapsed .sidebar-footer .d-flex {
                justify-content: center;
            }
            .sidebar.collapsed .sidebar-footer span {
                display: none;
            }
        }

        /* ============ TOPBAR ============ */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: var(--bg-topbar);
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            z-index: 1030;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color var(--transition), border-color var(--transition);
        }

        .topbar .left-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .topbar .right-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar .breadcrumb-custom {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .topbar .breadcrumb-custom span {
            font-weight: 600;
            color: var(--text-primary);
        }

        .topbar .welcome-text {
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .toggle-sidebar-btn {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-surface);
            color: var(--text-secondary);
            cursor: pointer;
            transition: background-color 0.15s ease, border-color 0.15s ease;
        }

        .toggle-sidebar-btn:hover {
            background-color: var(--bg-hover);
            border-color: var(--gray-300);
        }

        .toggle-sidebar-btn:focus-visible {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
        }

        /* Collapsed topbar */
        @media (min-width: 992px) {
            .topbar.collapsed {
                left: 72px;
            }
        }

        /* ============ MOBILE ============ */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            .topbar {
                left: 0;
            }
            main.app-main {
                margin-left: 0;
                padding-top: calc(var(--topbar-height) + 16px);
            }
        }

        /* Desktop */
        @media (min-width: 992px) {
            main.app-main {
                margin-left: var(--sidebar-width);
                padding-top: calc(var(--topbar-height) + 16px);
                transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            main.app-main.collapsed {
                margin-left: 72px;
            }
        }

        /* ============ MOBILE BACKDROP ============ */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1035;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-backdrop.visible {
            display: block;
            opacity: 1;
        }

        /* ============ MAIN ============ */
        main.app-main {
            min-height: 100vh;
            background-color: var(--bg-body);
            transition: background-color var(--transition);
        }

        /* ============ CONTENT AREA ============ */
        .page-content {
            padding: 0 20px 40px;
            animation: pageFadeIn 0.5s ease both;
        }

        @media (min-width: 768px) {
            .page-content {
                padding: 0 28px 48px;
            }
        }

        /* ============ CARDS (shared) ============ */
        .app-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: box-shadow 0.2s ease, background-color var(--transition), border-color var(--transition);
        }

        .app-card-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color-soft);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            transition: border-color var(--transition);
        }

        .app-card-header h5,
        .app-card-header h6 {
            margin: 0;
            font-weight: 600;
            font-size: 0.95rem;
            color: var(--text-primary);
        }

        .app-card-body {
            padding: 0;
        }

        /* ============ STAT CARDS ============ */
        .stat-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 20px 22px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            transition: transform var(--transition), box-shadow var(--transition), background-color var(--transition), border-color var(--transition);
            animation: cardSlideUp 0.5s ease both;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--info));
            opacity: 0;
            transition: opacity var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.12s; }
        .stat-card:nth-child(3) { animation-delay: 0.19s; }
        .stat-card:nth-child(4) { animation-delay: 0.26s; }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            flex-shrink: 0;
            transition: transform var(--transition);
        }

        .stat-card:hover .stat-icon {
            transform: scale(1.1);
        }

        .stat-card .stat-info {
            flex: 1;
            min-width: 0;
        }

        .stat-card .stat-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            font-weight: 500;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .stat-card .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        /* ============ PAGE HEADER ============ */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        .page-header h1,
        .page-header h4 {
            margin: 0;
            font-weight: 700;
            font-size: 1.35rem;
            color: var(--text-primary);
        }

        .page-header-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* ============ SEARCH BAR ============ */
        .search-bar {
            position: relative;
        }

        .search-bar .form-control {
            border-radius: 10px;
            padding: 9px 14px 9px 40px;
            border: 1px solid var(--border-input);
            font-size: 0.875rem;
            background: var(--bg-input);
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background-color var(--transition);
        }

        .search-bar .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
        }

        .search-bar .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-faint);
            font-size: 0.9rem;
            pointer-events: none;
        }

        .search-bar .clear-search {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-faint);
            cursor: pointer;
            padding: 4px;
            line-height: 1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-bar .clear-search:hover {
            color: var(--text-secondary);
            background: var(--bg-hover);
        }

        /* ============ DATA TABLE ============ */
        .table-scroll-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.875rem;
        }

        .data-table thead th {
            background: var(--bg-surface-2);
            border-bottom: 1px solid var(--border-color);
            padding: 12px 16px;
            font-weight: 600;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--text-muted);
            white-space: nowrap;
            position: sticky;
            top: 0;
            z-index: 1;
            transition: background-color var(--transition), border-color var(--transition);
        }

        .data-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color-soft);
            color: var(--text-secondary);
            vertical-align: middle;
            transition: border-color var(--transition);
        }

        .data-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .data-table tbody tr:hover {
            background-color: var(--bg-surface-2);
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* Table image thumbnails */
        .table-thumb {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--border-color);
        }

        .table-thumb-placeholder {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: var(--bg-surface-2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-faint);
            font-size: 0.8rem;
        }

        /* Table action buttons */
        .table-actions {
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .table-actions .btn {
            padding: 5px 12px;
            font-size: 0.8rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-icon-only {
            width: 34px;
            height: 34px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        /* ============ BADGES ============ */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        .status-badge .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.pending .status-dot {
            background: #f59e0b;
        }

        .status-badge.completed {
            background: #d1fae5;
            color: #065f46;
        }

        .status-badge.completed .status-dot {
            background: #10b981;
        }

        [data-bs-theme="dark"] .status-badge.pending {
            background: rgba(245, 158, 11, 0.15);
            color: #fbbf24;
        }

        [data-bs-theme="dark"] .status-badge.completed {
            background: rgba(16, 185, 129, 0.15);
            color: #34d399;
        }

        [data-bs-theme="dark"] .badge.bg-danger.bg-opacity-10,
        [data-bs-theme="dark"] .badge.bg-warning.bg-opacity-10 {
            background-color: rgba(239, 68, 68, 0.15);
            color: #f87171;
        }

        /* ============ EMPTY STATE ============ */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            color: var(--text-faint);
            margin-bottom: 12px;
        }

        .empty-state h6 {
            color: var(--text-muted);
            font-weight: 600;
            margin-bottom: 6px;
        }

        .empty-state p {
            color: var(--text-faint);
            font-size: 0.85rem;
            margin-bottom: 16px;
        }

        /* ============ TOAST NOTIFICATIONS ============ */
        .toast-container-custom {
            position: fixed;
            top: 76px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }

        .toast-custom {
            pointer-events: auto;
            min-width: 300px;
            max-width: 420px;
            padding: 14px 16px;
            border-radius: 10px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            font-size: 0.875rem;
            animation: toastIn 0.35s cubic-bezier(0.21,1.02,0.73,1) forwards;
            border-left: 4px solid;
        }

        .toast-custom.success {
            background: #ecfdf5;
            border-color: #10b981;
            color: #065f46;
        }

        .toast-custom.error {
            background: #fef2f2;
            border-color: #ef4444;
            color: #991b1b;
        }

        .toast-custom.warning {
            background: #fffbeb;
            border-color: #f59e0b;
            color: #92400e;
        }

        .toast-custom.info {
            background: #eff6ff;
            border-color: #3b82f6;
            color: #1e40af;
        }

        [data-bs-theme="dark"] .toast-custom.success {
            background: rgba(16, 185, 129, 0.12);
            border-color: #10b981;
            color: #34d399;
        }

        [data-bs-theme="dark"] .toast-custom.error {
            background: rgba(239, 68, 68, 0.12);
            border-color: #ef4444;
            color: #f87171;
        }

        [data-bs-theme="dark"] .toast-custom.warning {
            background: rgba(245, 158, 11, 0.12);
            border-color: #f59e0b;
            color: #fbbf24;
        }

        [data-bs-theme="dark"] .toast-custom.info {
            background: rgba(59, 130, 246, 0.12);
            border-color: #3b82f6;
            color: #60a5fa;
        }

        [data-bs-theme="dark"] .toast-custom {
            box-shadow: 0 8px 24px rgba(0,0,0,0.4);
        }

        .toast-custom .toast-icon {
            font-size: 1.15rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .toast-custom .toast-body {
            flex: 1;
            line-height: 1.45;
        }

        .toast-custom .toast-close {
            background: none;
            border: none;
            color: inherit;
            opacity: 0.5;
            cursor: pointer;
            padding: 0;
            font-size: 1.1rem;
            line-height: 1;
            flex-shrink: 0;
        }

        .toast-custom .toast-close:hover {
            opacity: 1;
        }

        .toast-custom.removing {
            animation: toastOut 0.3s ease forwards;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(40px) scale(0.96); }
            to { opacity: 1; transform: translateX(0) scale(1); }
        }

        @keyframes toastOut {
            from { opacity: 1; transform: translateX(0) scale(1); }
            to { opacity: 0; transform: translateX(40px) scale(0.96); }
        }

        @media (max-width: 575.98px) {
            .toast-container-custom {
                right: 10px;
                left: 10px;
            }
            .toast-custom {
                min-width: auto;
                max-width: none;
            }
        }

        /* ============ BACK TO TOP ============ */
        .back-to-top {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #0d6efd;
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(13,110,253,0.35);
            z-index: 999;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: opacity 0.25s ease, visibility 0.25s ease, transform 0.25s ease, background-color 0.15s ease;
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            background-color: #0b5ed7;
        }

        /* ============ ALERTS ============ */
        .alert {
            border-radius: var(--radius);
            font-size: 0.875rem;
            border: none;
            animation: fadeInUp 0.4s ease both;
        }

        /* ============ FORM CONTROLS ============ */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--border-input);
            padding: 10px 14px;
            font-size: 0.875rem;
            background-color: var(--bg-input);
            color: var(--text-primary);
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background-color var(--transition), color var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
        }

        .form-control::placeholder {
            color: var(--text-faint);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        /* ============ MOBILE TABLE OVERRIDES ============ */
        @media (max-width: 767.98px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .page-header-actions {
                width: 100%;
            }
            .page-header-actions .btn {
                flex: 1;
            }
            .search-bar {
                width: 100%;
            }
            .data-table thead th {
                font-size: 0.72rem;
                padding: 10px 12px;
            }
            .data-table tbody td {
                padding: 12px;
                font-size: 0.82rem;
            }
            .stat-card {
                padding: 14px 16px;
            }
            .stat-card .stat-value {
                font-size: 1.2rem;
            }
            .app-card-header {
                padding: 14px 16px;
            }
        }

        /* ============ FOCUS VISIBLE ============ */
        a:focus-visible, button:focus-visible {
            outline: 2px solid #0d6efd;
            outline-offset: 2px;
        }

        /* ============ LOADING SPINNER ============ */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.75;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            top: 50%;
            left: 50%;
            margin-top: -8px;
            margin-left: -8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ============ DELETE MODAL ============ */
        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 24px 80px rgba(0,0,0,0.18);
            animation: scaleIn 0.3s cubic-bezier(0.34,1.56,0.64,1) both;
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color-soft);
            padding: 20px 24px;
        }

        .modal-body {
            padding: 20px 24px;
        }

        .modal-footer {
            border-top: 1px solid var(--border-color-soft);
            padding: 16px 24px;
        }

        /* ============ ENTRANCE ANIMATIONS ============ */
        @keyframes cardSlideUp {
            from { opacity: 0; transform: translateY(24px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-24px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.08); }
            70% { transform: scale(0.96); }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(13,110,253,0.25); }
            50% { box-shadow: 0 0 0 10px rgba(13,110,253,0); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        /* Sidebar nav entrance */
        .sidebar .nav-item {
            animation: slideInLeft 0.35s ease both;
        }
        .sidebar .nav-item:nth-child(1) { animation-delay: 0.05s; }
        .sidebar .nav-item:nth-child(2) { animation-delay: 0.10s; }
        .sidebar .nav-item:nth-child(3) { animation-delay: 0.15s; }
        .sidebar .nav-item:nth-child(4) { animation-delay: 0.20s; }

        /* Brand icon float on hover */
        .sidebar-brand:hover .brand-icon {
            animation: float 0.6s ease;
        }

        /* Sidebar nav link hover glow */
        .sidebar .nav-link {
            position: relative;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 3px;
            height: 60%;
            background: var(--primary);
            border-radius: 0 3px 3px 0;
            transition: transform 0.25s ease;
        }

        .sidebar .nav-link.active::before {
            transform: translateY(-50%) scaleY(1);
        }

        .sidebar .nav-link:hover::before {
            transform: translateY(-50%) scaleY(0.6);
        }

        /* Sidebar brand icon pulse on active */
        .sidebar-brand .brand-icon {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .sidebar-brand:hover .brand-icon {
            box-shadow: 0 4px 14px rgba(13,110,253,0.35);
        }

        /* Staggered table row animation */
        .data-table tbody tr {
            animation: fadeInUp 0.4s ease both;
        }
        .data-table tbody tr:nth-child(1)  { animation-delay: 0.04s; }
        .data-table tbody tr:nth-child(2)  { animation-delay: 0.08s; }
        .data-table tbody tr:nth-child(3)  { animation-delay: 0.12s; }
        .data-table tbody tr:nth-child(4)  { animation-delay: 0.16s; }
        .data-table tbody tr:nth-child(5)  { animation-delay: 0.20s; }
        .data-table tbody tr:nth-child(6)  { animation-delay: 0.24s; }
        .data-table tbody tr:nth-child(7)  { animation-delay: 0.28s; }
        .data-table tbody tr:nth-child(8)  { animation-delay: 0.32s; }
        .data-table tbody tr:nth-child(9)  { animation-delay: 0.36s; }
        .data-table tbody tr:nth-child(10) { animation-delay: 0.40s; }

        /* Table row hover enhanced */
        .data-table tbody tr {
            transition: background-color 0.2s ease, transform 0.15s ease;
        }

        .data-table tbody tr:hover {
            background-color: #f8faff;
            transform: scale(1.002);
        }

        /* App card entrance */
        .app-card {
            animation: cardSlideUp 0.5s ease both;
            animation-delay: 0.2s;
        }

        /* Page header entrance */
        .page-header {
            animation: fadeInUp 0.45s ease both;
        }

        /* Empty state bounce */
        .empty-state .empty-icon {
            animation: bounceIn 0.7s ease 0.3s both;
        }

        /* Empty state icon float */
        .empty-state:hover .empty-icon {
            animation: float 1.5s ease infinite;
        }

        /* ============ ENHANCED BUTTONS ============ */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.875rem;
            transition: all var(--transition-fast);
            position: relative;
            overflow: hidden;
        }

        .btn:active {
            transform: scale(0.96) !important;
        }

        .btn-primary {
            box-shadow: 0 1px 4px rgba(13,110,253,0.2);
        }

        .btn-primary:hover {
            box-shadow: 0 4px 16px rgba(13,110,253,0.35);
            transform: translateY(-1px);
        }

        .btn-success {
            box-shadow: 0 1px 4px rgba(16,185,129,0.2);
        }

        .btn-success:hover {
            box-shadow: 0 4px 16px rgba(16,185,129,0.35);
            transform: translateY(-1px);
        }

        .btn-danger {
            box-shadow: 0 1px 4px rgba(239,68,68,0.2);
        }

        .btn-danger:hover {
            box-shadow: 0 4px 16px rgba(239,68,68,0.35);
            transform: translateY(-1px);
        }

        .btn-outline-primary:hover,
        .btn-outline-secondary:hover {
            transform: translateY(-1px);
        }

        .btn-sm {
            border-radius: 8px;
            font-size: 0.8rem;
            padding: 5px 12px;
        }

        .btn-sm:active {
            transform: scale(0.94) !important;
        }

        /* Ripple effect */
        .btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10);
            opacity: 0;
            transition: transform 0.5s, opacity 0.8s;
        }

        .btn:active::after {
            transform: scale(0);
            opacity: 1;
            transition: 0s;
        }

        /* ============ ENHANCED SEARCH BAR ============ */
        .search-bar .form-control {
            transition: border-color var(--transition-fast), box-shadow var(--transition-fast), width var(--transition);
        }

        .search-bar .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(13,110,253,0.08), var(--shadow-md);
        }

        /* ============ ENHANCED TABLE CARD ============ */
        .app-card {
            transition: box-shadow var(--transition);
        }

        .app-card:hover {
            box-shadow: var(--shadow-md);
        }

        /* ============ STATUS BADGE PULSE ============ */
        .status-badge.pending .status-dot {
            animation: pulseGlow 2s ease infinite;
        }

        .status-badge.completed .status-dot {
            animation: pulseGlow 2.5s ease infinite;
            background: var(--success);
        }

        /* ============ TOOLTIP STYLE ============ */
        .table-actions .btn {
            position: relative;
        }

        .table-actions .btn[title]::before {
            content: attr(title);
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%) translateY(4px);
            background: var(--gray-800);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s ease, transform 0.2s ease;
            z-index: 10;
        }

        .table-actions .btn[title]:hover::before {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* ============ STAT CARD COUNTER ============ */
        .stat-value .counter {
            display: inline-block;
        }

        /* ============ SCROLLBAR ============ */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }

        /* ============ TOPBAR ANIMATION ============ */
        .topbar {
            animation: fadeIn 0.4s ease both;
        }

        /* ============ IMAGE THUMBNAIL HOVER ============ */
        .table-thumb {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .table-thumb:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 10px;
        }

        /* ============ FORM PAGE ============ */
        .form-page {
            max-width: 780px;
            margin: 0 auto;
        }

        .form-card .app-card-body {
            padding: 24px;
        }

        .form-section {
            margin-bottom: 28px;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .form-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-muted);
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--border-color-soft);
        }

        .form-section-title .section-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            color: var(--primary);
            background: var(--bg-active);
            flex-shrink: 0;
        }

        /* Input with icon */
        .input-icon {
            position: relative;
        }

        .input-icon > i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-faint);
            font-size: 0.95rem;
            z-index: 5;
            pointer-events: none;
        }

        .input-icon .form-control {
            padding-left: 42px;
        }

        .input-icon .form-select {
            padding-left: 42px;
        }

        .field-hint {
            font-size: 0.78rem;
            color: var(--text-faint);
            margin-top: 6px;
        }

        .form-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            padding-top: 20px;
            border-top: 1px solid var(--border-color-soft);
            margin-top: 8px;
        }

        /* AI Generate button */
        .ai-generate-btn {
            border: 1px dashed var(--primary);
            color: var(--primary);
            background: transparent;
            font-size: 0.82rem;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .ai-generate-btn:hover {
            background: var(--primary);
            color: #fff;
            border-style: solid;
        }

        .ai-generate-btn:disabled {
            opacity: 0.6;
            pointer-events: none;
        }

        /* Image upload dropzone */
        .image-upload {
            border: 2px dashed var(--border-input);
            border-radius: var(--radius);
            padding: 28px 20px;
            text-align: center;
            cursor: pointer;
            background: var(--bg-surface-2);
            transition: border-color 0.2s ease, background-color 0.2s ease, padding 0.2s ease;
        }

        .image-upload:hover {
            border-color: var(--primary);
            background: var(--bg-active);
        }

        .image-upload .upload-icon {
            font-size: 2rem;
            color: var(--text-faint);
            margin-bottom: 8px;
            display: block;
        }

        .image-upload .upload-text {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        .image-upload .upload-sub {
            font-size: 0.75rem;
            color: var(--text-faint);
            margin-top: 2px;
        }

        .image-upload.has-image {
            border-style: solid;
            padding: 16px;
        }

        .image-upload input[type="file"] {
            display: none;
        }

        .image-preview-wrap {
            position: relative;
            display: inline-block;
            margin: 8px 0;
        }

        .image-preview-wrap img {
            max-width: 220px;
            max-height: 170px;
            border-radius: var(--radius);
            object-fit: cover;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
        }

        .image-preview-wrap .image-remove {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: none;
            background: var(--danger);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(239,68,68,0.4);
            transition: transform 0.15s ease;
        }

        .image-preview-wrap .image-remove:hover {
            transform: scale(1.15);
        }

        .existing-image {
            max-width: 100px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border-color);
        }

        /* Validation error highlight */
        .is-invalid {
            border-color: var(--danger) !important;
        }

        .form-control.is-invalid {
            box-shadow: 0 0 0 3px rgba(239,68,68,0.1);
        }

        .error-text {
            font-size: 0.78rem;
            color: var(--danger);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ============ APP FOOTER ============ */
        .app-footer {
            margin-left: var(--sidebar-width);
            background: var(--bg-surface);
            border-top: 1px solid var(--border-color);
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color var(--transition);
        }

        @media (min-width: 992px) {
            .app-footer.collapsed {
                margin-left: 72px;
            }
        }

        @media (max-width: 991.98px) {
            .app-footer {
                margin-left: 0;
            }
        }

        .app-footer .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.2fr;
            gap: 32px;
            padding: 36px 28px 28px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-brand-name {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .footer-brand-name .footer-logo {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: linear-gradient(135deg, #0d6efd, #6610f2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.9rem;
        }

        .footer-tagline {
            font-size: 0.82rem;
            line-height: 1.6;
            color: var(--text-muted);
            max-width: 300px;
        }

        .footer-column h6 {
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--text-secondary);
            margin-bottom: 14px;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column ul li {
            margin-bottom: 8px;
        }

        .footer-column ul li a,
        .footer-column .footer-text {
            font-size: 0.84rem;
            color: var(--text-muted);
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .footer-column ul li a:hover {
            color: var(--primary);
        }

        .footer-column .footer-text {
            display: block;
            margin-bottom: 8px;
        }

        .footer-column .footer-text i {
            margin-right: 8px;
            color: var(--primary);
        }

        .footer-bottom {
            border-top: 1px solid var(--border-color-soft);
            padding: 16px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            font-size: 0.8rem;
            color: var(--text-faint);
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-bottom .made-with i {
            color: var(--danger);
            font-size: 0.7rem;
        }

        @media (max-width: 991.98px) {
            .app-footer .footer-top {
                grid-template-columns: 1fr 1fr;
                gap: 24px;
                padding: 28px 20px;
            }
        }

        @media (max-width: 575.98px) {
            .app-footer .footer-top {
                grid-template-columns: 1fr;
            }
            .footer-bottom {
                justify-content: center;
                text-align: center;
            }
        }

        /* ============ BREADCRUMB ============ */
        .breadcrumb-custom {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .breadcrumb-custom a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .breadcrumb-custom a:hover {
            color: var(--primary);
        }

        .breadcrumb-custom .sep {
            color: var(--text-faint);
            font-size: 0.7rem;
        }

        .breadcrumb-custom .current {
            color: var(--text-primary);
            font-weight: 600;
        }
    </style>
    @yield('styles')
</head>
<body>

    {{-- Mobile Backdrop --}}
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="bi bi-box-seam"></i></div>
            <span class="brand-text">MyInventory</span>
        </div>

        <ul class="nav flex-column">
            <li class="nav-section">Menu</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"
                   href="{{ route('dashboard.index') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('items.*') ? 'active' : '' }}"
                   href="{{ route('items.index') }}">
                    <i class="bi bi-box-seam"></i>
                    <span>Items</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                   href="{{ route('orders.index') }}">
                    <i class="bi bi-cart-check"></i>
                    <span>Orders</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-person-circle text-secondary"></i>
                <span class="text-muted" style="font-size:0.8rem;">Admin</span>
            </div>
        </div>
    </aside>

    {{-- Topbar --}}
    <nav class="topbar" id="topbar">
        <div class="left-section">
            <button class="toggle-sidebar-btn" id="toggleSidebar" aria-label="Toggle sidebar">
                <i class="bi bi-list fs-5"></i>
            </button>
            <nav aria-label="breadcrumb" class="breadcrumb-custom d-none d-sm-block">
                @hasSection('breadcrumb')
                    @yield('breadcrumb')
                @else
                    <span>@yield('title', 'Dashboard')</span>
                @endif
            </nav>
        </div>

        <div class="right-section">
            <span class="welcome-text d-none d-md-inline">Welcome, Admin</span>
            <button class="toggle-sidebar-btn" id="themeToggle" aria-label="Toggle dark mode" title="Toggle dark mode">
                <i class="bi bi-sun-fill" id="themeIconSun" style="display:none;"></i>
                <i class="bi bi-moon-stars-fill" id="themeIconMoon"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-light btn-sm d-flex align-items-center gap-2 dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false" aria-label="User menu">
                    <i class="bi bi-person-circle"></i>
                    <span class="d-none d-lg-inline" style="font-size:0.85rem;">Account</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="min-width: 160px;">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST"  class="m-0">
                        {{-- <form method="POST" action="{{ route('logout') }}" class="m-0"> --}}
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="app-main" id="mainContent">
        <div class="page-content">
            @yield('content')
        </div>
    </main>

    @yield('scripts')

    {{-- Footer --}}
    <footer class="app-footer" id="appFooter">
        <div class="footer-top">
            <div>
                <div class="footer-brand-name">
                    <span class="footer-logo"><i class="bi bi-box-seam"></i></span>
                    MyInventory
                </div>
                <p class="footer-tagline">A modern inventory management platform that helps you track stock, manage orders, and scale your business with confidence.</p>
            </div>

            <div class="footer-column">
                <h6>Quick Links</h6>
                <ul>
                    <li><a href="{{ route('dashboard.index') }}"><i class="bi bi-speedometer2 me-2" style="font-size:0.72rem;"></i>Dashboard</a></li>
                    <li><a href="{{ route('items.index') }}"><i class="bi bi-box-seam me-2" style="font-size:0.72rem;"></i>Items</a></li>
                    <li><a href="{{ route('orders.index') }}"><i class="bi bi-cart-check me-2" style="font-size:0.72rem;"></i>Orders</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h6>Manage</h6>
                <ul>
                    <li><a href="{{ route('items.create') }}"><i class="bi bi-plus-circle me-2" style="font-size:0.72rem;"></i>Add Item</a></li>
                    <li><a href="{{ route('orders.create') }}"><i class="bi bi-plus-circle me-2" style="font-size:0.72rem;"></i>Create Order</a></li>
                    <li><a href="{{ route('items.index') }}"><i class="bi bi-search me-2" style="font-size:0.72rem;"></i>Search Inventory</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h6>Get in Touch</h6>
                <span class="footer-text"><i class="bi bi-envelope"></i>support@myinventory.app</span>
                <span class="footer-text"><i class="bi bi-telephone"></i>+1 (555) 000-0000</span>
                <span class="footer-text"><i class="bi bi-geo-alt"></i>Silicon Valley, CA</span>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} MyInventory. All rights reserved.</span>
            <span class="made-with">Built with <i class="bi bi-heart-fill"></i> &amp; Bootstrap 5</span>
        </div>
    </footer>

    {{-- Toast Container --}}
    <div class="toast-container-custom" id="toastContainer"></div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-semibold" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>Confirm Delete
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0" id="deleteModalText">Are you sure you want to delete this item? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="deleteModalConfirm">
                        <i class="bi bi-trash me-1"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Back to Top --}}
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    (function () {
        const STORAGE_KEY = 'sidebar_collapsed';
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const footer = document.getElementById('appFooter');

        function isMobile() {
            return window.innerWidth < 992;
        }

        function applyDesktopState() {
            const collapsed = localStorage.getItem(STORAGE_KEY) === 'true';
            sidebar.classList.toggle('collapsed', collapsed);
            topbar.classList.toggle('collapsed', collapsed);
            mainContent.classList.toggle('collapsed', collapsed);
            if (footer) footer.classList.toggle('collapsed', collapsed);
        }

        function closeMobileSidebar() {
            sidebar.classList.remove('mobile-open');
            backdrop.classList.remove('visible');
            document.body.style.overflow = '';
        }

        function openMobileSidebar() {
            sidebar.classList.add('mobile-open');
            backdrop.classList.add('visible');
            document.body.style.overflow = 'hidden';
        }

        toggleBtn.addEventListener('click', function () {
            if (isMobile()) {
                if (sidebar.classList.contains('mobile-open')) {
                    closeMobileSidebar();
                } else {
                    openMobileSidebar();
                }
            } else {
                sidebar.classList.toggle('collapsed');
                topbar.classList.toggle('collapsed');
                mainContent.classList.toggle('collapsed');
                const collapsed = sidebar.classList.contains('collapsed');
                localStorage.setItem(STORAGE_KEY, collapsed);
                if (footer) footer.classList.toggle('collapsed', collapsed);
            }
        });

        backdrop.addEventListener('click', closeMobileSidebar);

        window.addEventListener('resize', function () {
            if (!isMobile()) {
                closeMobileSidebar();
                applyDesktopState();
            } else {
                sidebar.classList.remove('collapsed');
                topbar.classList.remove('collapsed');
                mainContent.classList.remove('collapsed');
            }
        });

        document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
            link.addEventListener('click', function () {
                if (isMobile()) closeMobileSidebar();
            });
        });

        applyDesktopState();

        if (isMobile()) {
            sidebar.classList.remove('collapsed');
            topbar.classList.remove('collapsed');
            mainContent.classList.remove('collapsed');
        }
    })();
    </script>

    <script>
    (function () {
        /* ===== THEME TOGGLE ===== */
        var themeToggle = document.getElementById('themeToggle');
        var themeIconSun = document.getElementById('themeIconSun');
        var themeIconMoon = document.getElementById('themeIconMoon');

        function syncThemeIcons() {
            var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            if (themeIconSun) themeIconSun.style.display = isDark ? 'inline-block' : 'none';
            if (themeIconMoon) themeIconMoon.style.display = isDark ? 'none' : 'inline-block';
        }

        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
                var next = isDark ? 'light' : 'dark';
                document.documentElement.setAttribute('data-bs-theme', next);
                localStorage.setItem('theme', next);
                syncThemeIcons();
                window.dispatchEvent(new CustomEvent('themeChanged', { detail: next }));
            });
        }

        syncThemeIcons();

        /* ===== TOAST NOTIFICATIONS ===== */
        window.showToast = function (message, type) {
            type = type || 'success';
            var container = document.getElementById('toastContainer');
            var icons = {
                success: 'bi-check-circle-fill',
                error: 'bi-x-circle-fill',
                warning: 'bi-exclamation-triangle-fill',
                info: 'bi-info-circle-fill'
            };
            var toast = document.createElement('div');
            toast.className = 'toast-custom ' + type;
            toast.innerHTML =
                '<i class="bi ' + (icons[type] || icons.info) + ' toast-icon"></i>' +
                '<div class="toast-body">' + message + '</div>' +
                '<button class="toast-close" aria-label="Close">&times;</button>';
            toast.querySelector('.toast-close').addEventListener('click', function () {
                dismissToast(toast);
            });
            container.appendChild(toast);
            setTimeout(function () { dismissToast(toast); }, 5000);
        };

        function dismissToast(el) {
            if (el.classList.contains('removing')) return;
            el.classList.add('removing');
            setTimeout(function () { el.remove(); }, 300);
        }

        @if(session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif
        @if(session('error'))
            showToast('{{ session('error') }}', 'error');
        @endif
        @if(session('warning'))
            showToast('{{ session('warning') }}', 'warning');
        @endif
        @if(session('info'))
            showToast('{{ session('info') }}', 'info');
        @endif

        /* ===== DELETE CONFIRMATION MODAL ===== */
        var deleteForm = null;
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        var confirmBtn = document.getElementById('deleteModalConfirm');
        var modalText = document.getElementById('deleteModalText');

        document.querySelectorAll('[data-delete-form]').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                deleteForm = this.closest('form');
                var name = this.getAttribute('data-item-name') || 'this item';
                modalText.textContent = 'Are you sure you want to delete "' + name + '"? This action cannot be undone.';
                deleteModal.show();
            });
        });

        confirmBtn.addEventListener('click', function () {
            if (deleteForm) {
                var btn = this;
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Deleting...';
                deleteForm.submit();
            }
        });

        document.getElementById('deleteModal').addEventListener('hidden.bs.modal', function () {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="bi bi-trash me-1"></i>Delete';
            deleteForm = null;
        });

        /* ===== BACK TO TOP ===== */
        var backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });
        backToTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        /* ===== FORM LOADING STATE ===== */
        document.querySelectorAll('form[data-loading]').forEach(function (form) {
            form.addEventListener('submit', function () {
                var btn = form.querySelector('[type="submit"]');
                if (btn && !btn.disabled) {
                    btn.disabled = true;
                    btn.classList.add('btn-loading');
                    var originalText = btn.getAttribute('data-original-text') || btn.innerHTML;
                    btn.setAttribute('data-original-text', originalText);
                }
            });
        });

        /* ===== COUNTER ANIMATION ===== */
        function animateCounters() {
            document.querySelectorAll('.stat-value .counter').forEach(function (el) {
                var target = parseFloat(el.getAttribute('data-target'));
                var prefix = el.getAttribute('data-prefix') || '';
                var suffix = el.getAttribute('data-suffix') || '';
                var decimals = el.getAttribute('data-decimals') || 0;
                decimals = parseInt(decimals);
                var duration = 1200;
                var startTime = null;

                function easeOutQuart(t) {
                    return 1 - Math.pow(1 - t, 4);
                }

                function step(timestamp) {
                    if (!startTime) startTime = timestamp;
                    var progress = Math.min((timestamp - startTime) / duration, 1);
                    var easedProgress = easeOutQuart(progress);
                    var current = easedProgress * target;

                    if (decimals > 0) {
                        el.textContent = prefix + current.toFixed(decimals) + suffix;
                    } else {
                        el.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
                    }

                    if (progress < 1) {
                        requestAnimationFrame(step);
                    } else {
                        if (decimals > 0) {
                            el.textContent = prefix + target.toFixed(decimals) + suffix;
                        } else {
                            el.textContent = prefix + target.toLocaleString() + suffix;
                        }
                    }
                }

                requestAnimationFrame(step);
            });
        }

        /* Run counters when visible */
        var counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounters();
                    counterObserver.disconnect();
                }
            });
        }, { threshold: 0.3 });

        var firstStatCard = document.querySelector('.stat-card');
        if (firstStatCard) {
            counterObserver.observe(firstStatCard);
        }
    })();
    </script>

</body>
</html>

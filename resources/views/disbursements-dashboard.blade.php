<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disbursements Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        :root {
            --bg-dark: #09090e;
            --bg-panel: rgba(255, 255, 255, 0.03);
            --border-glow: rgba(255, 255, 255, 0.1);
            --accent-primary: #ef4444;
            --accent-glow: #f87171;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Ambient Glow Backgrounds */
        .ambient-glow {
            position: absolute;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(239, 68, 68, 0.1) 0%, rgba(0,0,0,0) 70%);
            top: -25vw;
            left: -15vw;
            z-index: 0;
            pointer-events: none;
        }
        
        .ambient-glow-2 {
            position: absolute;
            width: 40vw;
            height: 40vw;
            background: radial-gradient(circle, rgba(248, 113, 113, 0.05) 0%, rgba(0,0,0,0) 70%);
            bottom: -10vw;
            right: -10vw;
            z-index: 0;
            pointer-events: none;
        }

        .container {
            width: 100%;
            max-width: 1300px;
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            margin-bottom: 1rem;
            width: 100%;
        }

        .nav-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav-links a.active {
            color: var(--text-main);
            border-bottom: 2px solid var(--accent-primary);
            padding-bottom: 4px;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 600;
            background: linear-gradient(to right, #ffffff, #fca5a5);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
        }

        .filter-group {
            display: flex;
            gap: 1rem;
            align-items: center;
            background: var(--bg-panel);
            padding: 0.5rem 1rem;
            border-radius: 16px;
            border: 1px solid var(--border-glow);
            backdrop-filter: blur(12px);
        }

        .date-input {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .date-input label {
            font-size: 0.75rem;
            color: var(--text-muted);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .date-input input {
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Outfit', sans-serif;
            color-scheme: dark;
            width: 100%;
        }

        .date-input input:focus {
            border-color: var(--accent-primary);
            box-shadow: 0 0 10px rgba(239, 68, 68, 0.2);
        }

        button {
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-glow));
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 42px;
            align-self: flex-end;
            margin-bottom: 5px;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(248, 113, 113, 0.4);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: var(--bg-panel);
            border: 1px solid var(--border-glow);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(16px);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .icon-money { background: rgba(239, 68, 68, 0.1); color: #f87171; }
        .icon-disbursements { background: rgba(249, 115, 22, 0.1); color: #fb923c; }
        .icon-recipients { background: rgba(59, 130, 246, 0.1); color: #60a5fa; }

        .stat-title {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Tables Grid */
        .rosters-grid {
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        /* Table Section */
        .table-container {
            width: 100%;
            background: var(--bg-panel);
            border: 1px solid var(--border-glow);
            border-radius: 24px;
            backdrop-filter: blur(16px);
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.6s ease forwards;
        }

        .zakat-container {
            border-color: rgba(255, 215, 0, 0.2);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 215, 0, 0.02) 100%);
        }

        .table-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .zakat-badge {
            background: rgba(255, 215, 0, 0.1);
            color: #ffd700;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1.25rem 1.5rem;
            text-align: left;
        }

        th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(0, 0, 0, 0.2);
        }

        td {
            font-size: 0.9rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
            transition: background 0.2s ease;
        }

        tbody tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .total-row td {
            background: rgba(255, 255, 255, 0.03) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
            padding: 1.25rem 1.5rem !important;
            font-weight: 600;
        }

        /* Drawer Styles */
        .drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .drawer-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .drawer {
            position: fixed;
            top: 0;
            right: -600px;
            width: 600px;
            height: 100vh;
            background: #0d0d12;
            border-left: 1px solid var(--border-glow);
            z-index: 1001;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 0;
            display: flex;
            flex-direction: column;
            box-shadow: -20px 0 50px rgba(0,0,0,0.5);
        }

        .drawer.active {
            right: 0;
        }

        .drawer-header {
            padding: 2rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .drawer-content {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        .ledger-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ledger-table th {
            background: rgba(255,255,255,0.02);
            color: var(--text-muted);
            font-size: 0.7rem;
            text-transform: uppercase;
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .ledger-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid rgba(255,255,255,0.02);
            font-size: 0.85rem;
        }

        .debit-text { color: #f87171; font-weight: 600; }
        .credit-text { color: #34d399; font-weight: 600; }

        .view-btn {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: var(--text-muted);
            padding: 0.4rem;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .view-btn:hover {
            background: var(--accent-primary);
            color: white;
            border-color: var(--accent-glow);
        }

        .recipient-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-glow));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.8rem;
            margin-right: 0.75rem;
            vertical-align: middle;
        }

        .zakat-avatar {
            background: linear-gradient(135deg, #ffd700, #b8860b);
        }

        .amount-pill {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
            border: 1px solid rgba(239, 68, 68, 0.2);
            display: inline-block;
        }

        .zakat-pill {
            background: rgba(255, 215, 0, 0.1);
            color: #ffd700;
            border-color: rgba(255, 215, 0, 0.2);
        }

        .grant-container {
            border-color: rgba(6, 182, 212, 0.2);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.03) 0%, rgba(6, 182, 212, 0.02) 100%);
        }

        .grant-badge {
            background: rgba(6, 182, 212, 0.1);
            color: #06b6d4;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.7rem;
            text-transform: uppercase;
            font-weight: 700;
            border: 1px solid rgba(6, 182, 212, 0.2);
        }

        .grant-avatar {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
        }

        .grant-pill {
            background: rgba(6, 182, 212, 0.1);
            color: #22d3ee;
            border-color: rgba(6, 182, 212, 0.2);
        }

        .outstanding-pill {
            background: rgba(239, 68, 68, 0.15);
            color: #ff4d4d;
            border-color: rgba(239, 68, 68, 0.3);
        }

        .cleared-pill {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border-color: rgba(16, 185, 129, 0.2);
        }

        .type-badge {
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            background: rgba(255,255,255,0.05);
            color: var(--text-muted);
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.05) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 8px;
            height: 24px;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: var(--text-muted);
        }
    </style>
</head>
<body>
    @include('partials.auth')

    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>

    <div class="container">
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; border-bottom: 1px solid var(--border-glow);">
            <div style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.02em; background: linear-gradient(to right, #fff, var(--accent-primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; padding-bottom: 1rem; line-height: 1;">Kanak Foundation</div>
            <nav style="display: flex; gap: 2rem;">
                <a href="/" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; transition: color 0.3s; padding-bottom: 1rem; line-height: 1;">Financial Overview</a>
                <a href="/donations" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; transition: color 0.3s; padding-bottom: 1rem; line-height: 1;">Donors</a>
                <a href="/disbursements" style="color: var(--text-main); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; position: relative; padding-bottom: 1rem; line-height: 1;">
                    Disbursements
                    <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background: var(--accent-primary); box-shadow: 0 0 10px var(--accent-primary);"></span>
                </a>
            </nav>
        </div>

        <header>
            <h1>Disbursements</h1>
            
            <div class="filter-group">
                <div class="date-input">
                    <label>Select Date Range</label>
                    <input type="text" id="date_range" placeholder="Pick a range..." readonly style="min-width: 250px;">
                </div>
                <button onclick="fetchData()">Apply Filter</button>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-money">$</div>
                <div class="stat-title">Returnable Disbursements</div>
                <div class="stat-value" id="val-returnable"><div class="skeleton"></div></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-disbursements">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3 1.343 3 3-1.343 3-3 3m0-12c1.657 0 3-1.343 3-3S13.657 2 12 2s-3 1.343-3 3 1.343 3 3 3zm0 0v1.5m0 9V22m3-14h1m-7 0H2m16 4h2a2 2 0 012 2v4a2 2 0 01-2 2h-2m-10-8H4a2 2 0 00-2 2v4a2 2 0 002 2h2"></path></svg>
                </div>
                <div class="stat-title">Grants Disbursements</div>
                <div class="stat-value" id="val-grants"><div class="skeleton"></div></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-recipients" style="background: rgba(255, 215, 0, 0.1); color: #ffd700;">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path></svg>
                </div>
                <div class="stat-title">Zakat Disbursements</div>
                <div class="stat-value" id="val-zakat" style="color: #ffd700;"><div class="skeleton"></div></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-money" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <div class="stat-title">Total Disbursed</div>
                <div class="stat-value" id="val-total-disbursed"><div class="skeleton"></div></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-money" style="background: rgba(99, 102, 241, 0.1); color: #6366f1;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M7 12l3-3 3 3 4-4M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
                <div class="stat-title">Total Payments</div>
                <div class="stat-value" id="val-payments-count"><div class="skeleton"></div></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-money" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="stat-title">Unique Recipients</div>
                <div class="stat-value" id="val-recipients-count"><div class="skeleton"></div></div>
            </div>
        </div>

        <!-- Tables Grid -->
        <div class="rosters-grid">
            <!-- Normal Table -->
            <div class="table-container">
                <div class="table-header">
                    <h2>Returnable Roster</h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Recipient</th>
                            <th>Type</th>
                            <th>Payments</th>
                            <th>Total Got</th>
                            <th>Repaid</th>
                            <th>Outstanding</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="normal-tbody">
                        <tr><td colspan="7"><div class="skeleton" style="width: 100%"></div></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Zakat Table -->
            <div class="table-container zakat-container">
                <div class="table-header">
                    <h2>Zakat Roster <span class="zakat-badge">Zakat Only</span></h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Recipient</th>
                            <th>Type</th>
                            <th>Payments</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="zakat-tbody">
                        <tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Grants Table -->
            <div class="table-container grant-container">
                <div class="table-header">
                    <h2>Grants Roster <span class="grant-badge">Grants / Help</span></h2>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Recipient</th>
                            <th>Type</th>
                            <th>Payments</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="grant-tbody">
                        <tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('partials.footer')

    <!-- Ledger Drawer -->
    <div id="drawer-overlay" class="drawer-overlay" onclick="closeDrawer()"></div>
    <div id="drawer" class="drawer">
        <div class="drawer-header">
            <div>
                <h2 id="drawer-title" style="font-size: 1.5rem; font-weight: 600;">Recipient Ledger</h2>
                <p id="drawer-subtitle" style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.25rem;">Transaction History</p>
            </div>
            <button onclick="closeDrawer()" style="background: transparent; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer; box-shadow: none; padding: 0; height: auto;">&times;</button>
        </div>
        <div class="drawer-content">
            <div id="ledger-loading" class="skeleton" style="height: 200px; display: none; margin-bottom: 2rem;"></div>
            <div id="ledger-container">
                <table class="ledger-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th style="text-align: right;">Debit (Out)</th>
                            <th style="text-align: right;">Credit (In)</th>
                            <th style="text-align: right;">Balance</th>
                        </tr>
                    </thead>
                    <tbody id="ledger-tbody">
                        <!-- Transactions will be loaded here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Formatter for currency
        const formatter = new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 0
        });

        let fp;

        // Setup Init
        document.addEventListener('DOMContentLoaded', () => {
            fp = flatpickr("#date_range", {
                mode: "range",
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "F j, Y",
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        fetchData();
                    }
                }
            });

            fetchData();
        });

        function animateValue(obj, start, end, duration, formatCurrency = false) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const easeOut = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                const currentVal = start + (end - start) * easeOut;
                
                obj.innerHTML = formatCurrency ? formatter.format(currentVal) : Math.floor(currentVal);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                } else {
                    obj.innerHTML = formatCurrency ? formatter.format(end) : end;
                }
            };
            window.requestAnimationFrame(step);
        }

        async function fetchData() {
            let startDate = '';
            let endDate = '';

            if (fp && fp.selectedDates.length === 2) {
                startDate = fp.formatDate(fp.selectedDates[0], "Y-m-d");
                endDate = fp.formatDate(fp.selectedDates[1], "Y-m-d");
            }

            // Show Loading state
            document.getElementById('val-returnable').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-grants').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-zakat').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-total-disbursed').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-payments-count').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-recipients-count').innerHTML = '<div class="skeleton"></div>';
            
            document.getElementById('normal-tbody').innerHTML = '<tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>';
            document.getElementById('zakat-tbody').innerHTML = '<tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>';
            document.getElementById('grant-tbody').innerHTML = '<tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>';

            const params = new URLSearchParams();
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);
            
            const queryString = params.toString() ? '?' + params.toString() : '';

            try {
                const [statsRes, recipientsRes] = await Promise.all([
                    fetch('/api/disbursement-stats' + queryString),
                    fetch('/api/recipients' + queryString)
                ]);

                const statsData = await statsRes.json();
                const recipientsData = await recipientsRes.json();

                if (statsData.success) {
                    const elReturnable = document.getElementById('val-returnable');
                    const elGrants = document.getElementById('val-grants');
                    const elZakat = document.getElementById('val-zakat');
                    const elTotal = document.getElementById('val-total-disbursed');
                    const elPayments = document.getElementById('val-payments-count');
                    const elRecipients = document.getElementById('val-recipients-count');
                    
                    animateValue(elReturnable, 0, statsData.data.total_returnable, 1500, true);
                    animateValue(elGrants, 0, statsData.data.total_grants, 1500, true);
                    animateValue(elZakat, 0, statsData.data.total_zakat, 1500, true);
                    animateValue(elTotal, 0, statsData.data.total_disbursed_amount, 1500, true);
                    animateValue(elPayments, 0, statsData.data.total_disbursements_count, 1500, false);
                    animateValue(elRecipients, 0, statsData.data.total_recipients_count, 1500, false);
                }

                if (recipientsData.success) {
                    const populateTable = (elementId, data, category) => {
                        const tbody = document.getElementById(elementId);
                        const isNormal = category === 'normal';
                        const colCount = isNormal ? 7 : 4;
                        
                        if (data.length === 0) {
                            tbody.innerHTML = `<tr><td colspan="${colCount}"><div class="empty-state">No recipients found.</div></td></tr>`;
                            return;
                        }

                        let totalGot = 0;
                        let totalRepaid = 0;
                        let totalOutstanding = 0;

                        const rowsHtml = data.map(recipient => {
                            const initials = (recipient.name || 'R').substring(0, 2).toUpperCase();
                            totalGot += parseFloat(recipient.total_disbursed_amount || 0);
                            
                            let avatarClass = 'recipient-avatar';
                            let pillClass = 'amount-pill';
                            
                            if (category === 'zakat') {
                                avatarClass += ' zakat-avatar';
                                pillClass += ' zakat-pill';
                            } else if (category === 'grants') {
                                avatarClass += ' grant-avatar';
                                pillClass += ' grant-pill';
                            }
                            
                            let extraRows = '';
                            if (isNormal) {
                                totalRepaid += parseFloat(recipient.total_repaid_amount || 0);
                                totalOutstanding += parseFloat(recipient.outstanding_amount || 0);
                                
                                const balanceClass = recipient.outstanding_amount > 0 ? 'outstanding-pill' : 'cleared-pill';
                                extraRows = `
                                    <td><span style="opacity: 0.8; font-size: 0.9rem;">${formatter.format(recipient.total_repaid_amount || 0)}</span></td>
                                    <td><span class="amount-pill ${balanceClass}">${formatter.format(recipient.outstanding_amount || 0)}</span></td>
                                    <td>
                                        <button class="view-btn" onclick="openLedger(${recipient.id}, '${recipient.name.replace(/'/g, "\\'")}')" title="View Transaction Ledger">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        </button>
                                    </td>
                                `;
                            }
                            
                            return `
                            <tr>
                                <td>
                                    <div class="${avatarClass}">${initials}</div>
                                    <strong style="font-size: 0.9rem;">${recipient.name}</strong>
                                </td>
                                <td><span class="type-badge">${recipient.type || 'N/A'}</span></td>
                                <td><span style="opacity: 0.8; font-size: 0.9rem;">${recipient.total_disbursements_count} payments</span></td>
                                <td><span class="${pillClass}">${formatter.format(recipient.total_disbursed_amount)}</span></td>
                                ${extraRows}
                            </tr>
                            `;
                        }).join('');

                        // Append Total Row
                        const footerHtml = `
                            <tr class="total-row">
                                <td colspan="3" style="text-align: right; color: var(--text-muted); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Total</td>
                                <td><span class="amount-pill" style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(255,255,255,0.1);">${formatter.format(totalGot)}</span></td>
                                ${isNormal ? `
                                    <td><span style="font-weight: 700; font-size: 0.9rem; color: var(--text-main);">${formatter.format(totalRepaid)}</span></td>
                                    <td><span class="amount-pill ${totalOutstanding > 0 ? 'outstanding-pill' : 'cleared-pill'}" style="font-weight: 700;">${formatter.format(totalOutstanding)}</span></td>
                                    <td></td>
                                ` : ''}
                            </tr>
                        `;
                        
                        tbody.innerHTML = rowsHtml + footerHtml;
                    };

                    populateTable('normal-tbody', recipientsData.data.normal, 'normal');
                    populateTable('zakat-tbody', recipientsData.data.zakat, 'zakat');
                    populateTable('grant-tbody', recipientsData.data.grants, 'grants');
                }
            } catch (err) {
                console.error('Failed to fetch dashboard data', err);
            }
        }

        async function openLedger(id, name) {
            const drawer = document.getElementById('drawer');
            const overlay = document.getElementById('drawer-overlay');
            const tbody = document.getElementById('ledger-tbody');
            const loading = document.getElementById('ledger-loading');
            const container = document.getElementById('ledger-container');
            const title = document.getElementById('drawer-title');

            title.innerText = name;
            tbody.innerHTML = '';
            loading.style.display = 'block';
            container.style.display = 'none';
            
            drawer.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';

            try {
                const res = await fetch(`/api/recipients/${id}/ledger`);
                const data = await res.json();

                if (data.success) {
                    tbody.innerHTML = data.data.ledger.map(item => {
                        const date = new Date(item.date).toLocaleDateString('en-IN', { day: '2-digit', month: 'short' });
                        const year = new Date(item.date).getFullYear();
                        
                        const isDebit = item.type === 'debit';
                        const amountFormatted = formatter.format(item.amount);
                        
                        const debitHtml = isDebit ? `
                            <div class="debit-text" style="display: flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                                ${amountFormatted}
                            </div>
                        ` : `<span style="opacity: 0.1;">—</span>`;

                        const creditHtml = !isDebit ? `
                            <div class="credit-text" style="display: flex; align-items: center; gap: 4px;">
                                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                                ${amountFormatted}
                            </div>
                        ` : `<span style="opacity: 0.1;">—</span>`;

                        const balanceClass = item.running_balance > 0 ? 'debit-text' : (item.running_balance < 0 ? 'credit-text' : '');
                        let statusLabel = '';
                        if (item.running_balance > 0) statusLabel = 'DUE';
                        else if (item.running_balance < 0) statusLabel = 'OVERPAID';
                        else statusLabel = 'CLEARED';

                        return `
                            <tr>
                                <td>
                                    <div style="font-weight: 500; font-size: 0.9rem;">${date}</div>
                                    <div style="font-size: 0.7rem; opacity: 0.5;">${year}</div>
                                </td>
                                <td>
                                    <div style="font-weight: 500; color: var(--text-main); font-size: 0.85rem;">${isDebit ? 'Disbursement' : 'Repayment'}</div>
                                    <div style="font-size: 0.75rem; color: var(--text-muted); max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="${item.notes || 'No notes'}">
                                        ${item.notes || 'No notes'}
                                    </div>
                                </td>
                                <td style="text-align: right;">${debitHtml}</td>
                                <td style="text-align: right;">${creditHtml}</td>
                                <td style="text-align: right;">
                                    <div class="${balanceClass}" style="font-weight: 700; font-size: 0.9rem;">
                                        ${formatter.format(Math.abs(item.running_balance))}
                                        <div style="font-size: 0.6rem; font-weight: 400; opacity: 0.6; margin-top: 2px; color: ${item.running_balance === 0 ? '#10b981' : ''}">${statusLabel}</div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    }).join('');
                }
            } catch (err) {
                console.error('Failed to fetch ledger', err);
                tbody.innerHTML = '<tr><td colspan="5" class="empty-state">Error loading ledger.</td></tr>';
            } finally {
                loading.style.display = 'none';
                container.style.display = 'block';
            }
        }

        function closeDrawer() {
            document.getElementById('drawer').classList.remove('active');
            document.getElementById('drawer-overlay').classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>
</body>
</html>

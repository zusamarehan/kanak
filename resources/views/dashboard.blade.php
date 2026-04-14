<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        :root {
            --bg-dark: #09090e;
            --bg-panel: rgba(255, 255, 255, 0.03);
            --border-glow: rgba(255, 255, 255, 0.1);
            --accent-primary: #6366f1;
            --accent-glow: #8b5cf6;
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
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(0,0,0,0) 70%);
            top: -25vw;
            left: -15vw;
            z-index: 0;
            pointer-events: none;
        }
        
        .ambient-glow-2 {
            position: absolute;
            width: 40vw;
            height: 40vw;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.1) 0%, rgba(0,0,0,0) 70%);
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
            background: linear-gradient(to right, #ffffff, #a5b4fc);
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
            box-shadow: 0 0 10px rgba(99, 102, 241, 0.2);
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
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
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

        .icon-money { background: rgba(34, 197, 94, 0.1); color: #4ade80; }
        .icon-donations { background: rgba(99, 102, 241, 0.1); color: #818cf8; }
        .icon-donors { background: rgba(236, 72, 153, 0.1); color: #f472b6; }

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

        /* Table Section */
        .table-container {
            background: var(--bg-panel);
            border: 1px solid var(--border-glow);
            border-radius: 24px;
            backdrop-filter: blur(16px);
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.6s ease forwards;
            margin-bottom: 3rem;
        }

        .zakat-container {
            border-color: rgba(255, 215, 0, 0.2);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.03) 0%, rgba(255, 215, 0, 0.02) 100%);
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

        .zakat-pill {
            background: rgba(255, 215, 0, 0.1);
            color: #ffd700;
            border-color: rgba(255, 215, 0, 0.2);
        }

        .zakat-avatar {
            background: linear-gradient(135deg, #ffd700, #b8860b);
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1.25rem 2rem;
            text-align: left;
        }

        th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            background: rgba(0, 0, 0, 0.2);
        }

        td {
            font-size: 0.95rem;
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
            padding: 1.25rem 2rem !important;
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

        .credit-text { color: #34d399; font-weight: 600; }
        .debit-text { color: #f87171; font-weight: 600; }

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

        .donor-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-glow));
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 1rem;
            vertical-align: middle;
        }

        .amount-pill {
            background: rgba(34, 197, 94, 0.1);
            color: #4ade80;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid rgba(34, 197, 94, 0.2);
            display: inline-block;
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

        /* Mobile Optimization */
        @media (max-width: 640px) {
            .container {
                padding: 1.25rem;
            }

            /* Responsive Top Bar */
            .container > div:first-child {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 1.25rem !important;
                margin-bottom: 2rem !important;
                padding-bottom: 0.5rem !important;
            }

            .container > div:first-child nav {
                width: 100%;
                gap: 1.25rem !important;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding-bottom: 0px;
            }

            .container > div:first-child nav::-webkit-scrollbar { display: none; }

            .container > div:first-child nav a {
                font-size: 0.75rem !important;
                white-space: nowrap;
                padding-bottom: 1rem !important;
            }

            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.5rem;
                margin-bottom: 2rem;
            }

            h1 {
                font-size: 1.8rem;
            }

            .filter-group {
                width: 100%;
                flex-direction: column;
                align-items: stretch;
                padding: 1rem;
            }

            .date-input {
                width: 100%;
            }

            #date_range {
                min-width: 100% !important;
            }

            button {
                width: 100%;
                margin-top: 0.5rem;
                margin-bottom: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .stat-value {
                font-size: 2rem;
            }

            .table-container {
                border-radius: 16px;
                margin-bottom: 2rem;
            }

            .table-header {
                padding: 1.25rem;
            }

            .table-header h2 {
                font-size: 1.1rem;
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start;
            }

            /* Disable Hover Effects on Mobile */
            .stat-card:hover, .stat-card:active,
            tbody tr:hover td, tbody tr:active td {
                transform: none !important;
                box-shadow: none !important;
                background: transparent !important;
                border-color: var(--border-glow) !important;
            }
            .stat-card::before { display: none !important; }

            button:hover, .view-btn:hover, 
            button:active, .view-btn:active,
            button, .view-btn {
                transform: none !important;
                box-shadow: none !important;
            }

            /* Simplified Card Design (Less Noise) */
            .table-container {
                background: transparent;
                border: none;
                box-shadow: none;
                overflow: visible;
            }

            .table-container .table-header {
                background: var(--bg-panel);
                border: 1px solid var(--border-glow);
                border-radius: 20px;
                margin-bottom: 1rem;
                padding: 1.25rem;
            }

            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }

            thead {
                display: none;
            }

            tbody tr {
                background: var(--bg-panel);
                border: 1px solid var(--border-glow);
                border-radius: 24px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
                backdrop-filter: blur(12px);
                position: relative;
                box-shadow: 0 8px 32px rgba(0,0,0,0.2) !important;
            }

            td {
                padding: 0.5rem 0 !important;
                border: none !important; /* Remove internal border/HR lines */
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                font-size: 0.9rem !important;
                white-space: normal !important;
            }

            td[data-label]::before {
                content: attr(data-label);
                font-size: 0.7rem;
                text-transform: uppercase;
                color: var(--text-muted);
                font-weight: 600;
                letter-spacing: 0.05rem;
            }

            td:first-child {
                padding-top: 0 !important;
                justify-content: flex-start !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important; /* Subtler header line */
                margin-bottom: 0.75rem;
                padding-bottom: 0.75rem !important;
            }

            td:first-child::before {
                content: none !important;
            }

            /* Totals Section Enhancement */
            .table-container .total-row {
                background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(0, 0, 0, 0)) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                border-top: 2px solid var(--accent-primary) !important;
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: wrap;
                justify-content: space-around !important;
                padding: 1.5rem !important;
                gap: 0.5rem;
                box-shadow: none !important;
            }

            .table-container .total-row td {
                width: calc(50% - 1rem) !important;
                align-items: center !important;
                text-align: center !important;
                margin-bottom: 0 !important;
                padding-bottom: 0 !important;
            }

            .table-container .total-row td:first-child {
                width: 100% !important;
                font-weight: 800;
                letter-spacing: 0.1em;
                color: #fff !important;
                justify-content: center !important;
                border-bottom: 1px solid rgba(255,255,255,0.05) !important;
                margin-bottom: 0.5rem;
                padding-bottom: 0.5rem !important;
            }

            .table-container .total-row td::before {
                margin-bottom: 0.25rem;
            }

            /* Action Button Enhancement */
            .table-container td[data-label="Action"] {
                justify-content: center !important;
                border-top: 1px solid rgba(255, 255, 255, 0.05) !important;
                padding-top: 1.25rem !important;
                margin-top: 0.5rem;
            }

            .table-container td[data-label="Action"]::before {
                display: none !important;
            }

            .table-container .view-btn {
                width: 100% !important;
                background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(99, 102, 241, 0.05)) !important;
                border: 1px solid rgba(99, 102, 241, 0.3) !important;
                color: #a5b4fc !important;
                border-radius: 12px !important;
                padding: 0.8rem !important;
                height: auto !important;
                font-size: 0.85rem !important;
                font-weight: 600 !important;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 0.75rem;
                margin-left: 0 !important;
            }

            .table-container .view-btn::after {
                content: 'View Donor History';
            }

            /* Drawer Mobile */
            .drawer {
                width: 100% !important;
                right: -100% !important;
            }

            .drawer.active {
                right: 0 !important;
            }

            .drawer-header {
                padding: 1.25rem;
            }

            .drawer-content {
                padding: 1rem;
            }
            
            .ledger-table tr {
                background: rgba(255, 255, 255, 0.01);
                border: 1px solid var(--border-glow);
                margin-bottom: 0.75rem;
                border-radius: 12px;
                padding: 1rem;
            }
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
                <a href="/donations" style="color: var(--text-main); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; position: relative; padding-bottom: 1rem; line-height: 1;">
                    Donors
                    <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background: var(--accent-primary); box-shadow: 0 0 10px var(--accent-primary);"></span>
                </a>
                <a href="/disbursements" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; transition: color 0.3s; padding-bottom: 1rem; line-height: 1;">Disbursements</a>
            </nav>
        </div>
        <header>
            <h1>Overview</h1>
            
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
                <div class="stat-title">Total Normal Collection</div>
                <div class="stat-value" id="val-amount"><div class="skeleton"></div></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-money" style="background: rgba(255, 215, 0, 0.1); color: #ffd700;">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path></svg>
                </div>
                <div class="stat-title">Total Zakat Collection</div>
                <div class="stat-value" id="val-zakat" style="color: #ffd700;"><div class="skeleton"></div></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-donations">#</div>
                <div class="stat-title">All Transactions</div>
                <div class="stat-value" id="val-donations"><div class="skeleton"></div></div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-donors">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path></svg>
                </div>
                <div class="stat-title">Unique Donors</div>
                <div class="stat-value" id="val-donors"><div class="skeleton"></div></div>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="table-container">
            <div class="table-header">
                <h2>Donation Roster</h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Donations Made</th>
                        <th>Total Contributed</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody id="donor-tbody">
                    <tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>
                </tbody>
            </table>
        </div>

        <div class="table-container zakat-container">
            <div class="table-header">
                <h2>Zakat Collection Roster <span class="zakat-badge">Zakat Only</span></h2>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Donor</th>
                        <th>Collections Made</th>
                        <th>Total Contributed</th>
                        <th style="text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody id="zakat-tbody">
                    <tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>
                </tbody>
            </table>
        </div>
    </div>

    @include('partials.footer')

    <!-- Ledger Drawer -->
    <div id="drawer-overlay" class="drawer-overlay" onclick="closeDrawer()"></div>
    <div id="drawer" class="drawer">
        <div class="drawer-header">
            <div>
                <h2 id="drawer-title" style="font-size: 1.5rem; font-weight: 600;">Donor Ledger</h2>
                <p id="drawer-subtitle" style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.25rem;">Donation History</p>
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
                            <th style="text-align: right;">Amount</th>
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
            document.getElementById('val-amount').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-zakat').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-donations').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-donors').innerHTML = '<div class="skeleton"></div>';
            
            document.getElementById('donor-tbody').innerHTML = '<tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>';
            document.getElementById('zakat-tbody').innerHTML = '<tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>';

            const params = new URLSearchParams();
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);
            
            const queryString = params.toString() ? '?' + params.toString() : '';

            try {
                const [statsRes, donorsRes] = await Promise.all([
                    fetch('/api/donation-stats' + queryString),
                    fetch('/api/donors' + queryString)
                ]);

                const statsData = await statsRes.json();
                const donorsData = await donorsRes.json();

                if (statsData.success) {
                    const elAmount = document.getElementById('val-amount');
                    const elZakat = document.getElementById('val-zakat');
                    const elDonations = document.getElementById('val-donations');
                    const elDonors = document.getElementById('val-donors');
                    
                    animateValue(elAmount, 0, statsData.data.total_collected_amount, 1500, true);
                    animateValue(elZakat, 0, statsData.data.total_zakat_amount, 1500, true);
                    animateValue(elDonations, 0, statsData.data.total_donations_count + statsData.data.total_zakat_count, 1500, false);
                    animateValue(elDonors, 0, statsData.data.total_unique_donors_count, 1500, false);
                }

                if (donorsData.success) {
                    const populateRoster = (elementId, data, category) => {
                        const tbody = document.getElementById(elementId);
                        const isZakat = category === 'zakat';
                        
                        if (!data || data.length === 0) {
                            tbody.innerHTML = `<tr><td colspan="4"><div class="empty-state">No records found.</div></td></tr>`;
                            return;
                        }

                        let sumCount = 0;
                        let sumAmount = 0;

                        let avatarClass = 'donor-avatar';
                        let pillClass = 'amount-pill';
                        if (isZakat) {
                            avatarClass += ' zakat-avatar';
                            pillClass += ' zakat-pill';
                        }

                        const rowsHtml = data.map(donor => {
                            const donorName = donor.name || 'Anonymous User';
                            const initials = donorName.substring(0, 2).toUpperCase();
                            const escapedName = donorName.replace(/'/g, "\\'");
                            
                            sumCount += parseInt(donor.total_count || 0);
                            sumAmount += parseFloat(donor.total_amount || 0);
                            
                            return `
                            <tr>
                                <td>
                                    <div class="${avatarClass}">${initials}</div>
                                    <strong>${donorName}</strong>
                                </td>
                                <td data-label="Activity">
                                    <span style="opacity: 0.8">${donor.total_count} ${isZakat ? 'records' : 'donations'}</span>
                                </td>
                                <td data-label="Total">
                                    <span class="${pillClass}">${formatter.format(donor.total_amount)}</span>
                                </td>
                                <td data-label="Action" style="text-align: right;">
                                    <button class="view-btn" style="margin-left: auto;" onclick="openLedger(${donor.id}, '${escapedName}')" title="View Transaction History">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                    </button>
                                </td>
                            </tr>
                            `;
                        }).join('');

                        const footerHtml = `
                            <tr class="total-row">
                                <td data-label="Totals" style="text-align: right; color: var(--text-muted); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Totals</td>
                                <td data-label="Total Count" style="font-weight: 700;">${sumCount} ${isZakat ? 'records' : 'donations'}</td>
                                <td data-label="Total Amount"><span class="${pillClass}" style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(255,255,255,0.1); font-weight: 700;">${formatter.format(sumAmount)}</span></td>
                                <td style="display: none;"></td>
                            </tr>
                        `;

                        tbody.innerHTML = rowsHtml + footerHtml;
                    };

                    populateRoster('donor-tbody', donorsData.data.normal, 'normal');
                    populateRoster('zakat-tbody', donorsData.data.zakat, 'zakat');
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
                const res = await fetch(`/api/donors/${id}/ledger`);
                const data = await res.json();

                if (data.success) {
                    let runningBalance = 0;
                    // Sort by year/month ascending for running balance calculation if needed, 
                    // but usually donors just want to see a list.
                    // Let's calculate running balance from oldest to newest.
                    const ledgerData = [...data.data.ledger].reverse();

                    tbody.innerHTML = data.data.ledger.map((item, index) => {
                        // For the UI, we'll calculate running balance in reverse for the display if it's Desc
                        const reversedIndex = data.data.ledger.length - 1 - index;
                        let balance = 0;
                        for(let i=0; i<=reversedIndex; i++) balance += parseFloat(ledgerData[i].amount);

                        const dateStr = item.date;
                        const date = new Date(dateStr).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' });
                        const isZakat = item.type === 'Zakat';
                        const typeColor = isZakat ? '#ffd700' : 'var(--text-muted)';
                        const amountColor = isZakat ? '#ffd700' : 'var(--accent-glow)';
                        
                        return `
                            <tr>
                                <td data-label="Date">
                                    <div style="font-size: 0.85rem; font-weight: 500;">${date}</div>
                                    <div style="font-size: 0.7rem; color: ${typeColor};">${item.type}</div>
                                </td>
                                <td data-label="Description">
                                    <div style="font-weight: 500; font-size: 0.85rem;">${item.description}</div>
                                    <div style="font-size: 0.7rem; color: var(--text-muted);">${isZakat ? 'Direct Collection' : 'Monthly Contribution'}</div>
                                </td>
                                <td data-label="Amount" style="text-align: right;"><span style="color: ${amountColor}; font-weight: 600;">+ ${formatter.format(item.amount)}</span></td>
                                <td data-label="Balance" style="text-align: right; font-weight: 700;">${formatter.format(balance)}</td>
                            </tr>
                        `;
                    }).join('');
                }
            } catch (err) {
                console.error('Failed to fetch ledger', err);
                tbody.innerHTML = '<tr><td colspan="4" class="empty-state">Error loading history.</td></tr>';
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

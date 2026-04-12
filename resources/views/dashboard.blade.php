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
            justify-content: center;
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
            max-width: 1200px;
            padding: 3rem 2rem;
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
    </style>
</head>
<body>

    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>

    <div class="container">
        <div class="nav-links">
            <a href="/dashboard" class="active">Donations</a>
            <a href="/disbursements">Disbursements</a>
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
                <div class="stat-title">Total Collected Amount</div>
                <div class="stat-value" id="val-amount"><div class="skeleton"></div></div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon icon-donations">#</div>
                <div class="stat-title">Total Donations</div>
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

        <!-- Table -->
        <div class="table-container">
            <div class="table-header">
                <h2>Donor Roster</h2>
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
                    <!-- Javascript will populate rows here -->
                    <tr>
                        <td colspan="4"><div class="skeleton" style="width: 100%"></div></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

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
            document.getElementById('val-donations').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('val-donors').innerHTML = '<div class="skeleton"></div>';
            document.getElementById('donor-tbody').innerHTML = '<tr><td colspan="4"><div class="skeleton" style="width: 100%"></div></td></tr>';

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
                    const elDonations = document.getElementById('val-donations');
                    const elDonors = document.getElementById('val-donors');
                    
                    animateValue(elAmount, 0, statsData.data.total_collected_amount, 1500, true);
                    animateValue(elDonations, 0, statsData.data.total_donations_count, 1500, false);
                    animateValue(elDonors, 0, statsData.data.total_donors_count, 1500, false);
                }

                if (donorsData.success) {
                    const tbody = document.getElementById('donor-tbody');
                    const rows = donorsData.data;

                    if (rows.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="4"><div class="empty-state">No donors found for this period.</div></td></tr>`;
                        return;
                    }

                    let sumDonations = 0;
                    let sumAmount = 0;

                    const rowsHtml = rows.map(donor => {
                        const initials = (donor.name || 'A').substring(0, 2).toUpperCase();
                        sumDonations += parseInt(donor.total_donations_count || 0);
                        sumAmount += parseFloat(donor.total_donated_amount || 0);
                        
                        return `
                        <tr>
                            <td>
                                <div class="donor-avatar">${initials}</div>
                                <strong>${donor.name || 'Anonymous User'}</strong>
                            </td>
                            <td>
                                <span style="opacity: 0.8">${donor.total_donations_count} donations</span>
                            </td>
                            <td>
                                <span class="amount-pill">${formatter.format(donor.total_donated_amount)}</span>
                            </td>
                            <td style="text-align: right;">
                                <button class="view-btn" style="margin-left: auto;" onclick="openLedger(${donor.id}, '${donor.name.replace(/'/g, "\\'")}')" title="View Donation Ledger">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </button>
                            </td>
                        </tr>
                        `;
                    }).join('');

                    const footerHtml = `
                        <tr class="total-row">
                            <td style="text-align: right; color: var(--text-muted); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em;">Totals</td>
                            <td style="font-weight: 700;">${sumDonations} donations</td>
                            <td><span class="amount-pill" style="background: rgba(255,255,255,0.05); color: #fff; border-color: rgba(255,255,255,0.1); font-weight: 700;">${formatter.format(sumAmount)}</span></td>
                            <td></td>
                        </tr>
                    `;

                    tbody.innerHTML = rowsHtml + footerHtml;
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

                        const date = new Date(item.date).toLocaleDateString('en-IN', { month: 'short', year: 'numeric' });
                        
                        return `
                            <tr>
                                <td><span style="opacity: 0.7; font-size: 0.8rem;">${date}</span></td>
                                <td>
                                    <div style="font-weight: 500; font-size: 0.85rem;">Contribution</div>
                                    <div style="font-size: 0.7rem; color: var(--text-muted);">Donation for Period</div>
                                </td>
                                <td style="text-align: right;"><span class="credit-text">+ ${formatter.format(item.amount)}</span></td>
                                <td style="text-align: right; font-weight: 700;">${formatter.format(balance)}</td>
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

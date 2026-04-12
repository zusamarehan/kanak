<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strategic Overview | Kanak Foundation</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <style>
        :root {
            --bg-dark: #07070a;
            --bg-panel: rgba(255, 255, 255, 0.03);
            --border-glow: rgba(255, 255, 255, 0.08);
            --accent-primary: #6366f1;
            --accent-glow: #8b5cf6;
            --accent-success: #22c55e;
            --accent-warning: #f59e0b;
            --accent-danger: #ef4444;
            --zakat-gold: #ffd700;
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
            display: flex;
            justify-content: center;
            overflow-x: hidden;
        }

        .ambient-glow {
            position: absolute;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.12) 0%, rgba(0,0,0,0) 70%);
            top: -30vw;
            left: -20vw;
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

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 2.5rem;
            border-bottom: 1px solid var(--border-glow);
        }

        .brand {
            font-size: 1.6rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            background: linear-gradient(to right, #fff, var(--accent-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding-bottom: 1rem;
            line-height: 1;
        }

        nav {
            display: flex;
            gap: 2rem;
        }

        nav a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s;
            position: relative;
            padding-bottom: 1rem;
            line-height: 1;
        }

        nav a.active {
            color: var(--text-main);
        }

        nav a.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--accent-primary);
            box-shadow: 0 0 10px var(--accent-primary);
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 3rem;
            gap: 2rem;
        }

        .header-left h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(to right, #fff, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 0.5rem;
        }

        .header-left p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .filter-group {
            background: var(--bg-panel);
            border: 1px solid var(--border-glow);
            padding: 0.75rem 1.25rem;
            border-radius: 16px;
            backdrop-filter: blur(12px);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .date-picker-wrapper {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .date-picker-wrapper label {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 600;
        }

        #date-range {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            outline: none;
            width: 240px;
            cursor: pointer;
        }

        /* Overview Sections */
        .section-title {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-glow);
        }

        /* Hero Grid (Position) */
        .hero-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 3.5rem;
        }

        .main-card {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.05));
            border: 1px solid rgba(99, 102, 241, 0.2);
            border-radius: 28px;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .main-card::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.2) 0%, transparent 70%);
            filter: blur(40px);
        }

        /* Stats Cards */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.25rem;
            margin-bottom: 3.5rem;
        }

        .card {
            background: var(--bg-panel);
            border: 1px solid var(--border-glow);
            border-radius: 20px;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .card:hover {
            border-color: rgba(255,255,255,0.15);
            background: rgba(255,255,255,0.05);
            transform: translateY(-2px);
        }

        .card-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .main-value {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            background: linear-gradient(to right, #fff, #c7d2fe);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Colors & Accents */
        .text-success { color: var(--accent-success); }
        .text-danger { color: var(--accent-danger); }
        .text-warning { color: var(--accent-warning); }
        .text-gold { color: var(--zakat-gold); }
        .text-primary { color: var(--accent-primary); }

        /* Recovery Bar */
        .recovery-container {
            margin-top: 1rem;
        }

        .progress-track {
            width: 100%;
            height: 8px;
            background: rgba(255,255,255,0.05);
            border-radius: 4px;
            margin-bottom: 0.5rem;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(to right, var(--accent-primary), var(--accent-glow));
            border-radius: 4px;
            width: 0%;
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 0 10px var(--accent-primary);
        }

        .skeleton {
            background: linear-gradient(90deg, rgba(255,255,255,0.05) 25%, rgba(255,255,255,0.08) 50%, rgba(255,255,255,0.05) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 4px;
            height: 1em;
            width: 60%;
        }

        @keyframes shimmer {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        @media (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr; }
            header { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>
    
    <div class="container">
        <div class="top-bar">
            <div class="brand">Kanak Foundation</div>
            <nav>
                <a href="/overview" class="active">Financial Overview</a>
                <a href="/dashboard">Donors</a>
                <a href="/disbursements">Disbursements</a>
            </nav>
        </div>

        <header>
            <div class="header-left">
                <h1>Strategic Overview</h1>
                <p>Global financial position and recovery status.</p>
            </div>
        </header>

        <!-- SECTION 1: Strategic Position -->
        <div class="section-title">Strategic Position</div>
        <div class="hero-grid">
            <div class="main-card">
                <div class="card-label">CURRENT LIQUID BALANCE</div>
                <div class="main-value" id="val-net-balance">₹0</div>
                <div style="margin-top: 1rem; color: var(--text-muted); font-size: 0.9rem;">
                    Computed as <span class="text-success">Total Cash In</span> minus <span class="text-danger">Total Out</span>.
                </div>
            </div>
            <div class="card" style="display: flex; flex-direction: column; justify-content: center;">
                <div class="card-label">TOTAL COLLECTIONS <span class="text-success">↑</span></div>
                <div class="card-value" id="val-total-in">₹0</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">Includes donations, zakat, & resolved loans.</div>
            </div>
            <div class="card" style="display: flex; flex-direction: column; justify-content: center;">
                <div class="card-label">TOTAL DISBURSEMENTS <span class="text-danger">↓</span></div>
                <div class="card-value" id="val-total-out">₹0</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">All-time money distributed across all channels.</div>
            </div>
        </div>

        <!-- SECTION 2: Revenue Streams (Inbound) -->
        <div class="section-title">Inbound Streams Breakdown</div>
        <div class="stats-row">
            <div class="card">
                <div class="card-label">DONATIONS</div>
                <div class="card-value text-primary" id="val-in-donations">₹0</div>
            </div>
            <div class="card">
                <div class="card-label">ZAKAT COLLECTIONS</div>
                <div class="card-value text-gold" id="val-in-zakat">₹0</div>
            </div>
            <div class="card">
                <div class="card-label">LOAN REPAYMENTS</div>
                <div class="card-value text-success" id="val-in-repayments">₹0</div>
            </div>
            <div class="card">
                <div class="card-label">BAD DEBT RESOLVED</div>
                <div class="card-value" style="color: #64748b;" id="val-in-bad-debt">₹0</div>
            </div>
        </div>

        <!-- SECTION 3: Expenditure Streams (Outbound) -->
        <div class="section-title">Outbound Streams Breakdown</div>
        <div class="stats-row">
            <div class="card">
                <div class="card-label">RETURNABLE LOANS</div>
                <div class="card-value" id="val-out-loans">₹0</div>
            </div>
            <div class="card">
                <div class="card-label">ZAKAT GRANTS</div>
                <div class="card-value text-gold" id="val-out-zakat">₹0</div>
            </div>
            <div class="card">
                <div class="card-label">EMERGENCY AID</div>
                <div class="card-value" id="val-out-help">₹0</div>
            </div>
        </div>

        <!-- SECTION 4: Recovery Status -->
        <div class="section-title">Capital Recovery Status (Lifetime)</div>
        <div class="stats-row" style="grid-template-columns: 1.5fr 1fr;">
            <div class="card">
                <div class="card-label">
                    <span>RECOVERY PIPELINE</span>
                    <span id="val-recovery-pct" class="text-primary" style="font-weight: 700;">0%</span>
                </div>
                <div class="recovery-container">
                    <div class="progress-track">
                        <div class="progress-fill" id="recovery-bar"></div>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--text-muted);">
                        <span>Resolved: <strong class="text-main" id="val-resolved">₹0</strong></span>
                        <span>Loaned: <strong class="text-main" id="val-total-loaned">₹0</strong></span>
                    </div>
                </div>
            </div>
            <div class="card" style="border-color: rgba(239, 68, 68, 0.2); background: rgba(239, 68, 68, 0.02);">
                <div class="card-label">OUTSTANDING BALANCE <span class="text-danger">⚠</span></div>
                <div class="card-value text-danger" id="val-outstanding">₹0</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">Capital currently in circulation.</div>
            </div>
        </div>
    </div>

    <script>
        const formatter = new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            maximumFractionDigits: 0
        });

        function animateValue(obj, start, end, duration, formatCurrency = true) {
            if (!obj) return;
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const val = Math.floor(progress * (end - start) + start);
                obj.innerHTML = formatCurrency ? formatter.format(val) : val;
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        async function fetchData() {
            // Set loading skeletons
            const targets = [
                'val-net-balance', 'val-total-in', 'val-total-out',
                'val-in-donations', 'val-in-zakat', 'val-in-repayments', 'val-in-bad-debt',
                'val-out-loans', 'val-out-zakat', 'val-out-help',
                'val-resolved', 'val-total-loaned', 'val-outstanding'
            ];
            targets.forEach(id => {
                document.getElementById(id).innerHTML = '<div class="skeleton"></div>';
            });

            try {
                const response = await fetch('/api/overview');
                const result = await response.json();

                if (result.success) {
                    const d = result.data;
                    
                    // Populate Position
                    animateValue(document.getElementById('val-net-balance'), 0, d.position.net_balance, 1500);
                    animateValue(document.getElementById('val-total-in'), 0, d.position.total_in, 1500);
                    animateValue(document.getElementById('val-total-out'), 0, d.position.total_out, 1500);

                    // Populate Inbound
                    animateValue(document.getElementById('val-in-donations'), 0, d.inbound.donations, 1200);
                    animateValue(document.getElementById('val-in-zakat'), 0, d.inbound.zakat_collections, 1200);
                    animateValue(document.getElementById('val-in-repayments'), 0, d.inbound.repayments, 1200);
                    animateValue(document.getElementById('val-in-bad-debt'), 0, d.inbound.bad_debts, 1200);

                    // Populate Outbound
                    animateValue(document.getElementById('val-out-loans'), 0, d.outbound.loans, 1200);
                    animateValue(document.getElementById('val-out-zakat'), 0, d.outbound.zakat_grants, 1200);
                    animateValue(document.getElementById('val-out-help'), 0, d.outbound.help_aids, 1200);

                    // Populate Recovery
                    animateValue(document.getElementById('val-resolved'), 0, d.recovery.total_resolved, 1500);
                    animateValue(document.getElementById('val-total-loaned'), 0, d.recovery.total_loaned, 1500);
                    animateValue(document.getElementById('val-outstanding'), 0, d.recovery.outstanding, 1500);
                    
                    const recoveryPct = d.recovery.total_loaned > 0 
                        ? (d.recovery.total_resolved / d.recovery.total_loaned) * 100 
                        : 0;
                    
                    document.getElementById('val-recovery-pct').innerHTML = Math.round(recoveryPct) + '%';
                    setTimeout(() => {
                        document.getElementById('recovery-bar').style.width = recoveryPct + '%';
                    }, 100);
                }
            } catch (err) {
                console.error('Failed to fetch overview data', err);
            }
        }

        document.addEventListener('DOMContentLoaded', fetchData);
    </script>

</body>
</html>

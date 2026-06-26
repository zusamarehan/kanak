<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Repayment — Kanak Foundation</title>
    <meta name="description" content="Enter and record repayments from recipients for Kanak Foundation.">
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
            --success-color: #22c55e;
            --success-glow: rgba(34, 197, 94, 0.15);
            --error-color: #ef4444;
            --error-glow: rgba(239, 68, 68, 0.15);
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

        /* ── Form Card ── */
        .form-card {
            max-width: 640px;
            margin: 0 auto;
            background: var(--bg-panel);
            border: 1px solid var(--border-glow);
            border-radius: 24px;
            padding: 2.5rem;
            backdrop-filter: blur(16px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeUp 0.6s ease forwards;
        }

        .form-card-header {
            margin-bottom: 2.5rem;
        }

        .form-card-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(to right, #ffffff, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .form-card-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 400;
        }

        /* ── Form Fields ── */
        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            margin-bottom: 0.6rem;
        }

        .form-group label .required {
            color: var(--accent-glow);
            margin-left: 2px;
        }

        /* Shared input styles */
        .form-input,
        .form-select {
            width: 100%;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            padding: 0.85rem 1rem;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: 'Outfit', sans-serif;
            outline: none;
            transition: all 0.3s ease;
            appearance: none;
            -webkit-appearance: none;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15), 0 0 20px rgba(99, 102, 241, 0.1);
        }

        .form-input::placeholder {
            color: rgba(148, 163, 184, 0.5);
        }

        .form-input.error,
        .form-select.error {
            border-color: var(--error-color);
            box-shadow: 0 0 0 3px var(--error-glow);
        }

        /* ── Custom Select Wrapper ── */
        .select-wrapper {
            position: relative;
        }

        .select-wrapper::after {
            content: '';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid var(--text-muted);
            pointer-events: none;
            transition: transform 0.2s ease;
        }

        .form-select option {
            background: #1a1a2e;
            color: var(--text-main);
            padding: 0.5rem;
        }

        /* ── Amount Input ── */
        .amount-wrapper {
            position: relative;
        }

        .amount-wrapper .currency-symbol {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-weight: 600;
            font-size: 1rem;
            pointer-events: none;
        }

        .amount-wrapper .form-input {
            padding-left: 2.25rem;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 0.02em;
        }

        /* ── Submit Button ── */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-glow));
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(139, 92, 246, 0.4);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-submit .spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        .btn-submit.loading .spinner {
            display: block;
        }

        .btn-submit.loading .btn-text {
            display: none;
        }

        /* ── Toast Notification ── */
        .toast {
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 14px;
            font-size: 0.9rem;
            font-weight: 500;
            backdrop-filter: blur(16px);
            z-index: 9999;
            transform: translateX(120%);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            max-width: 400px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .toast.show {
            transform: translateX(0);
        }

        .toast-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #4ade80;
        }

        .toast-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        /* ── Recent Entries ── */
        .recent-entries {
            max-width: 640px;
            margin: 2rem auto 0;
            animation: fadeUp 0.6s ease 0.15s forwards;
            opacity: 0;
        }

        .recent-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .recent-header h3 {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .recent-count {
            font-size: 0.75rem;
            color: var(--accent-glow);
            background: rgba(139, 92, 246, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        .entry-item {
            background: var(--bg-panel);
            border: 1px solid var(--border-glow);
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            animation: slideIn 0.4s ease forwards;
            opacity: 0;
        }

        .entry-item:hover {
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateX(4px);
        }

        .entry-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .entry-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-primary), var(--accent-glow));
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .entry-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .entry-date {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.15rem;
        }

        .entry-amount {
            background: rgba(34, 197, 94, 0.1);
            color: #4ade80;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(34, 197, 94, 0.2);
            white-space: nowrap;
        }

        .empty-recent {
            text-align: center;
            padding: 2rem;
            color: var(--text-muted);
            font-size: 0.9rem;
            background: var(--bg-panel);
            border: 1px dashed var(--border-glow);
            border-radius: 16px;
        }

        /* ── Field Error ── */
        .field-error {
            color: var(--error-color);
            font-size: 0.78rem;
            margin-top: 0.4rem;
            display: none;
        }

        .field-error.show {
            display: block;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-12px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ── Mobile ── */
        @media (max-width: 640px) {
            .container {
                padding: 1.25rem;
            }

            .top-bar-mobile {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 1.25rem !important;
                margin-bottom: 2rem !important;
                border-bottom: 1px solid var(--border-glow) !important;
                padding-bottom: 0 !important;
            }

            .top-bar-mobile .brand {
                font-size: 1.4rem !important;
                padding-bottom: 0.25rem !important;
            }

            .top-bar-mobile nav {
                width: 100%;
                gap: 1.25rem !important;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                margin-bottom: -1px;
            }

            .top-bar-mobile nav::-webkit-scrollbar { display: none; }

            .top-bar-mobile nav a {
                font-size: 0.75rem !important;
                white-space: nowrap;
                padding-bottom: 0.75rem !important;
                position: relative;
            }

            .top-bar-mobile nav a.active {
                color: var(--text-main) !important;
                border-bottom: 2px solid var(--accent-primary);
            }

            .top-bar-mobile nav a.active span {
                display: none !important;
            }

            .form-card {
                padding: 1.75rem;
                border-radius: 20px;
            }

            .form-card-header h1 {
                font-size: 1.4rem;
            }

            .btn-submit:hover {
                transform: none;
                box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
            }

            .entry-item:hover {
                transform: none;
            }

            .toast {
                top: 1rem;
                right: 1rem;
                left: 1rem;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    @include('partials.auth')
    <div class="ambient-glow"></div>
    <div class="ambient-glow-2"></div>

    <div class="container">
        <!-- Top Navigation Bar -->
        <div class="top-bar-mobile" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2rem; border-bottom: 1px solid var(--border-glow);">
            <div class="brand" style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.02em; background: linear-gradient(to right, #fff, var(--accent-primary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; padding-bottom: 1rem; line-height: 1;">Kanak Foundation</div>
            <nav style="display: flex; gap: 2rem;">
                <a href="/" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; transition: color 0.3s; padding-bottom: 1rem; line-height: 1;">Financial Overview</a>
                <a href="/donations" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; transition: color 0.3s; padding-bottom: 1rem; line-height: 1;">Donors</a>
                <a href="/disbursements" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; transition: color 0.3s; padding-bottom: 1rem; line-height: 1;">Disbursements</a>
                <a href="/repayment-entry" class="active" style="color: var(--text-main); text-decoration: none; font-size: 0.9rem; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; position: relative; padding-bottom: 1rem; line-height: 1;">
                    Record Repayment
                    <span style="position: absolute; bottom: -1px; left: 0; width: 100%; height: 2px; background: var(--accent-primary); box-shadow: 0 0 10px var(--accent-primary);"></span>
                </a>
            </nav>
        </div>

        <!-- Form Card -->
        <div class="form-card" id="repayment-form-card">
            <div class="form-card-header">
                <h1>Record Repayment</h1>
                <p>Enter a new repayment to a recipient below.</p>
            </div>

            <form id="repayment-form" novalidate>
                <!-- Recipient Select -->
                <div class="form-group">
                    <label for="recipient_id">Recipient <span class="required">*</span></label>
                    <div class="select-wrapper">
                        <select id="recipient_id" class="form-select" required>
                            <option value="" disabled selected>Loading recipients…</option>
                        </select>
                    </div>
                    <div class="field-error" id="recipient-error">Please select a recipient.</div>
                </div>

                <!-- Date -->
                <div class="form-group">
                    <label for="entry_date">Date of Entry <span class="required">*</span></label>
                    <input type="text" id="entry_date" class="form-input" placeholder="Select date…" readonly required>
                    <div class="field-error" id="date-error">Please select a date.</div>
                </div>

                <!-- Type -->
                <div class="form-group">
                    <label for="type">Type of Repayment <span class="required">*</span></label>
                    <div class="select-wrapper">
                        <select id="type" class="form-select" required>
                            <option value="" disabled selected>Select a type…</option>
                            <option value="regular">Regular Repayment</option>
                            <option value="bad_debt">Written Off / Bad Debt</option>
                        </select>
                    </div>
                    <div class="field-error" id="type-error">Please select a type.</div>
                </div>

                <!-- Amount -->
                <div class="form-group">
                    <label for="amount">Amount <span class="required">*</span></label>
                    <div class="amount-wrapper">
                        <span class="currency-symbol">₹</span>
                        <input type="number" id="amount" class="form-input" placeholder="0.00" min="0.01" step="0.01" required>
                    </div>
                    <div class="field-error" id="amount-error">Please enter a valid amount.</div>
                </div>

                <button type="submit" class="btn-submit" id="submit-btn">
                    <div class="spinner"></div>
                    <span class="btn-text">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 5v14M5 12h14"></path>
                        </svg>
                        Record Repayment
                    </span>
                </button>
            </form>
        </div>

        <!-- Recent Entries (session only) -->
        <div class="recent-entries" id="recent-section" style="display: none;">
            <div class="recent-header">
                <h3>Entries This Session</h3>
                <span class="recent-count" id="recent-count">0</span>
            </div>
            <div id="recent-list"></div>
        </div>
    </div>

    @include('partials.footer')

    <!-- Toast -->
    <div id="toast" class="toast"></div>

    <script>
        const formatter = new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            minimumFractionDigits: 0
        });

        let datePicker;
        let recentEntries = [];

        // ─── Init ───
        document.addEventListener('DOMContentLoaded', () => {
            loadRecipients();

            datePicker = flatpickr('#entry_date', {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'F j, Y',
                maxDate: 'today',
                defaultDate: 'today'
            });

            document.getElementById('repayment-form').addEventListener('submit', handleSubmit);

            // Clear field errors on interaction
            document.getElementById('recipient_id').addEventListener('change', () => clearError('recipient'));
            document.getElementById('entry_date').addEventListener('change', () => clearError('date'));
            document.getElementById('type').addEventListener('change', () => clearError('type'));
            document.getElementById('amount').addEventListener('input', () => clearError('amount'));
        });

        // ─── Load Recipients ───
        async function loadRecipients() {
            try {
                const res = await fetch('/api/recipients-list');
                const data = await res.json();

                const select = document.getElementById('recipient_id');

                if (data.success && data.data.length > 0) {
                    select.innerHTML = '<option value="" disabled selected>Select a recipient…</option>';
                    data.data.forEach(recipient => {
                        const opt = document.createElement('option');
                        opt.value = recipient.id;
                        opt.textContent = recipient.name;
                        select.appendChild(opt);
                    });
                } else {
                    select.innerHTML = '<option value="" disabled selected>No recipients found</option>';
                }
            } catch (err) {
                console.error('Failed to load recipients', err);
                document.getElementById('recipient_id').innerHTML = '<option value="" disabled selected>Error loading recipients</option>';
            }
        }

        // ─── Submit ───
        async function handleSubmit(e) {
            e.preventDefault();

            const recipientId = document.getElementById('recipient_id').value;
            const entryDate = document.getElementById('entry_date').value;
            const type = document.getElementById('type').value;
            const amount = document.getElementById('amount').value;

            // Validate
            let isValid = true;

            if (!recipientId) {
                showError('recipient');
                isValid = false;
            }
            if (!entryDate) {
                showError('date');
                isValid = false;
            }
            if (!type) {
                showError('type');
                isValid = false;
            }
            if (!amount || parseFloat(amount) <= 0) {
                showError('amount');
                isValid = false;
            }

            if (!isValid) return;

            const btn = document.getElementById('submit-btn');
            btn.classList.add('loading');
            btn.disabled = true;

            try {
                const res = await fetch('/api/repayments', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        recipient_id: parseInt(recipientId),
                        amount: parseFloat(amount),
                        entry_date: entryDate,
                        type: type
                    })
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    showToast('success', `Repayment of ${formatter.format(data.data.amount)} recorded for ${data.data.recipient_name}.`);
                    addRecentEntry(data.data);

                    // Reset form
                    document.getElementById('amount').value = '';
                    document.getElementById('type').selectedIndex = 0;
                    document.getElementById('recipient_id').selectedIndex = 0;
                    datePicker.setDate('today');
                } else {
                    // Handle validation errors
                    const errors = data.errors;
                    if (errors) {
                        const firstError = Object.values(errors)[0];
                        showToast('error', Array.isArray(firstError) ? firstError[0] : firstError);
                    } else {
                        showToast('error', data.message || 'Something went wrong.');
                    }
                }
            } catch (err) {
                console.error('Submission failed', err);
                showToast('error', 'Network error. Please try again.');
            } finally {
                btn.classList.remove('loading');
                btn.disabled = false;
            }
        }

        // ─── Recent Entries ───
        function addRecentEntry(entry) {
            recentEntries.unshift(entry);

            const section = document.getElementById('recent-section');
            const list = document.getElementById('recent-list');
            const countEl = document.getElementById('recent-count');

            section.style.display = 'block';
            countEl.textContent = recentEntries.length;

            const initials = (entry.recipient_name || 'AU').substring(0, 2).toUpperCase();
            const dateObj = new Date(entry.paid_on);
            const dateLabel = `${dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} • ${entry.type.charAt(0).toUpperCase() + entry.type.slice(1)}`;

            const item = document.createElement('div');
            item.className = 'entry-item';
            item.style.animationDelay = '0s';
            item.innerHTML = `
                <div class="entry-left">
                    <div class="entry-avatar">${initials}</div>
                    <div>
                        <div class="entry-name">${entry.recipient_name}</div>
                        <div class="entry-date">${dateLabel}</div>
                    </div>
                </div>
                <div class="entry-amount">${formatter.format(entry.amount)}</div>
            `;

            list.insertBefore(item, list.firstChild);

            // Animate
            requestAnimationFrame(() => {
                item.style.opacity = '1';
            });
        }

        // ─── Validation Helpers ───
        function showError(field) {
            const errorEl = document.getElementById(field + '-error');
            const inputEl = document.getElementById(
                field === 'recipient' ? 'recipient_id' :
                field === 'date' ? 'entry_date' :
                field === 'type' ? 'type' : 'amount'
            );
            errorEl.classList.add('show');
            inputEl.classList.add('error');
        }

        function clearError(field) {
            const errorEl = document.getElementById(field + '-error');
            const inputEl = document.getElementById(
                field === 'recipient' ? 'recipient_id' :
                field === 'date' ? 'entry_date' :
                field === 'type' ? 'type' : 'amount'
            );
            errorEl.classList.remove('show');
            inputEl.classList.remove('error');
        }

        // ─── Toast ───
        function showToast(type, message) {
            const toast = document.getElementById('toast');
            toast.className = `toast toast-${type}`;

            const icon = type === 'success'
                ? `<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`
                : `<svg class="toast-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`;

            toast.innerHTML = icon + `<span>${message}</span>`;

            // Show
            requestAnimationFrame(() => {
                toast.classList.add('show');
            });

            // Hide after 4s
            setTimeout(() => {
                toast.classList.remove('show');
            }, 4000);
        }
    </script>
</body>
</html>

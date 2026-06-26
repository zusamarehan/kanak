import os
import glob
import re

nav_html = """
<style>
    /* Standardized Nav Styles */
    .kanak-nav {
        display: flex;
        gap: 2rem;
        align-items: center;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .kanak-nav::-webkit-scrollbar { display: none; }
    
    .kanak-nav-link {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: color 0.3s;
        padding-bottom: 1rem;
        line-height: 1;
        position: relative;
        white-space: nowrap;
    }
    .kanak-nav-link:hover {
        color: var(--text-main);
    }
    .kanak-nav-link.active {
        color: var(--text-main);
    }
    .kanak-nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 2px;
        background: var(--accent-primary, #6366f1);
        box-shadow: 0 0 10px var(--accent-primary, #6366f1);
    }

    /* Dropdown */
    .kanak-dropdown {
        position: relative;
        display: inline-block;
        padding-bottom: 1rem; /* match padding-bottom of nav links for alignment */
    }
    .kanak-dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: color 0.3s;
        line-height: 1;
        cursor: pointer;
    }
    .kanak-dropdown-toggle:hover, .kanak-dropdown-toggle.active {
        color: var(--text-main);
    }
    .kanak-dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #0d0d12;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 0.5rem;
        min-width: 220px;
        z-index: 1000;
        box-shadow: 0 10px 30px rgba(0,0,0,0.6);
    }
    .kanak-dropdown:hover .kanak-dropdown-menu {
        display: flex;
        flex-direction: column;
    }
    .kanak-dropdown-item {
        padding: 0.75rem 1rem;
        color: var(--text-muted);
        text-decoration: none;
        text-transform: none;
        font-size: 0.9rem;
        transition: all 0.2s;
        border-radius: 8px;
        margin-bottom: 2px;
        display: block;
    }
    .kanak-dropdown-item:hover, .kanak-dropdown-item.active {
        background: rgba(255,255,255,0.08);
        color: var(--text-main);
    }
    
    @media (max-width: 640px) {
        .kanak-nav {
            margin-bottom: -1px;
            padding-bottom: 0;
        }
        .kanak-nav-link.active::after {
            display: none;
        }
        .kanak-nav-link.active {
            border-bottom: 2px solid var(--accent-primary, #6366f1);
        }
    }
</style>

<nav class="kanak-nav">
    <a href="/" class="kanak-nav-link {{ request()->is('/') ? 'active' : '' }}">Financial Overview</a>
    <a href="/donations" class="kanak-nav-link {{ request()->is('donations') ? 'active' : '' }}">Donors</a>
    <a href="/disbursements" class="kanak-nav-link {{ request()->is('disbursements') ? 'active' : '' }}">Disbursements</a>
    
    <div class="kanak-dropdown">
        <div class="kanak-dropdown-toggle {{ request()->is('*-entry') ? 'active' : '' }}">
            Create
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </div>
        <div class="kanak-dropdown-menu">
            <a href="/donation-entry" class="kanak-dropdown-item {{ request()->is('donation-entry') ? 'active' : '' }}">Record Donation</a>
            <a href="/disbursement-entry" class="kanak-dropdown-item {{ request()->is('disbursement-entry') ? 'active' : '' }}">Record Disbursement</a>
            <a href="/repayment-entry" class="kanak-dropdown-item {{ request()->is('repayment-entry') ? 'active' : '' }}">Record Repayment</a>
        </div>
    </div>
</nav>
"""

os.makedirs('/Users/rehan/Herd/kanak/resources/views/partials', exist_ok=True)
with open('/Users/rehan/Herd/kanak/resources/views/partials/nav.blade.php', 'w') as f:
    f.write(nav_html)

blade_files = glob.glob('/Users/rehan/Herd/kanak/resources/views/*.blade.php')

for file_path in blade_files:
    with open(file_path, 'r') as f:
        content = f.read()

    # We need to replace the old nav blocks
    # Possible nav start tags
    patterns = [
        r'<nav style="display: flex; gap: 2rem;">.*?</nav>',
        r'<div class="nav-links">.*?</div>',
        r'<nav>.*?</nav>'
    ]
    
    new_content = content
    replaced = False
    for p in patterns:
        if re.search(p, new_content, re.DOTALL):
            new_content = re.sub(p, "@include('partials.nav')", new_content, count=1, flags=re.DOTALL)
            replaced = True
            break
            
    if replaced:
        with open(file_path, 'w') as f:
            f.write(new_content)
        print(f"Updated nav in {file_path}")
    else:
        print(f"No nav found to update in {file_path}")


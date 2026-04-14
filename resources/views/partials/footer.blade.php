<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-content">
            <p class="footer-made-with">
                Made with
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="heart-icon">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                </svg>
                at
                <a href="https://maakhq.com/" target="_blank" rel="noopener noreferrer" class="footer-link-accent">Développement MaaK inc.</a>
            </p>
            <div class="footer-right">
                <p class="footer-copyright">© 2026 Kanak Foundation. All rights reserved.</p>
                <div class="footer-socials">
                    <a href="https://www.linkedin.com/company/maakinc" target="_blank" rel="noopener noreferrer" class="footer-social-link" aria-label="LinkedIn">
                        <svg class="social-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white"><path d="M19 0h-14c-2.76 0-5 2.24-5 5v14c0 2.76 2.24 5 5 5h14c2.76 0 5-2.24 5-5v-14c0-2.76-2.24-5-5-5zm-11 19h-3v-10h3v10zm-1.5-11.27c-.97 0-1.75-.79-1.75-1.76s.78-1.75 1.75-1.75 1.75.78 1.75 1.75-.78 1.76-1.75 1.76zm13.5 11.27h-3v-5.6c0-1.34-.03-3.07-1.87-3.07-1.87 0-2.16 1.46-2.16 2.97v5.7h-3v-10h2.88v1.37h.04c.4-.75 1.38-1.54 2.84-1.54 3.04 0 3.6 2 3.6 4.6v5.6z"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .site-footer {
        padding-top: 2rem;
        padding-bottom: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        color: #f8fafc;
        width: 100%;
    }
    .footer-container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    .footer-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }
    @media (min-width: 640px) {
        .footer-content {
            flex-direction: row;
            justify-content: space-between;
        }
    }
    .footer-made-with {
        color: #94a3b8;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }
    .heart-icon {
        width: 1.25rem;
        height: 1.25rem;
        color: #ef4444;
        animation: pulse-heart 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse-heart {
        50% { opacity: .5; }
    }
    .footer-link-accent {
        color: #6366f1;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s;
    }
    .footer-link-accent:hover {
        color: #8b5cf6;
    }
    .footer-right {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .footer-copyright {
        color: #94a3b8;
        font-size: 0.875rem;
    }
    .footer-socials {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .footer-social-link {
        color: #ffffff;
        transition: opacity 0.3s;
        text-decoration: none;
        display: flex;
    }
    .footer-social-link:hover {
        opacity: 0.8;
    }
    .social-icon {
        width: 1.25rem;
        height: 1.25rem;
    }
</style>

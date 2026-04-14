<script>
    (function() {
        const STORAGE_KEY = 'kanak_foundation_auth';
        const PASSWORD = 'Kanak!@Founded';

        if (sessionStorage.getItem(STORAGE_KEY) === 'true') {
            return;
        }

        function authenticate() {
            let password = prompt("Restricted Access: Please enter the password for Kanak Foundation");
            
            if (password === null) {
                // User cancelled
                window.stop();
                document.documentElement.innerHTML = '<body style="background:#07070a;color:white;display:flex;justify-content:center;align-items:center;height:100vh;font-family:sans-serif;"><h1>Access Denied</h1></body>';
                return;
            }

            if (password === PASSWORD) {
                sessionStorage.setItem(STORAGE_KEY, 'true');
            } else {
                alert("Incorrect password.");
                authenticate();
            }
        }

        authenticate();
    })();
</script>

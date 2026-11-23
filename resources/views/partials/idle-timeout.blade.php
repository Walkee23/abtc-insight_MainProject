<script>
(function () {
    const IDLE_LIMIT = 5 * 60 * 1000;      // 5 minutes of no activity = logout
    const PING_EVERY = 2 * 60 * 1000;      // keep the server session alive while active
    let idleTimer;
    let lastPing = Date.now();
    let lastActivity = Date.now();

    async function logoutNow() {
        try {
            await fetch("{{ route('logout') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                credentials: 'same-origin',
            });
        } catch (e) {}
        window.location.href = "{{ route('login') }}?timeout=1";
    }

    function resetTimer() {
        lastActivity = Date.now();
        clearTimeout(idleTimer);
        idleTimer = setTimeout(logoutNow, IDLE_LIMIT);

        // tell the server the user is still active
        if (Date.now() - lastPing > PING_EVERY) {
            lastPing = Date.now();
            fetch("{{ route('keep-alive') }}", { credentials: 'same-origin' }).catch(() => {});
        }
    }

    ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart', 'click']
        .forEach(evt => document.addEventListener(evt, resetTimer, { passive: true }));

    // A phone freezes a page's timers while the screen is off or the tab is in the background, so the idle timer
    // above may not have fired. When the page comes back after the idle limit, sign out right away instead of
    // showing a page whose session has ended.
    const checkIdleOnReturn = () => { if (Date.now() - lastActivity >= IDLE_LIMIT) logoutNow(); };
    document.addEventListener('visibilitychange', () => { if (document.visibilityState === 'visible') checkIdleOnReturn(); });
    window.addEventListener('pageshow', (e) => { if (e.persisted) checkIdleOnReturn(); });

    resetTimer();
})();
</script>
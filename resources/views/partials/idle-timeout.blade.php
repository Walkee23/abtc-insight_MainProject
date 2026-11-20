<script>
(function () {
    const IDLE_LIMIT = 5 * 60 * 1000;      // 5 minutes of no activity = logout
    const PING_EVERY = 2 * 60 * 1000;      // keep the server session alive while active
    let idleTimer;
    let lastPing = Date.now();

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

    resetTimer();
})();
</script>
/*
 * ABTC-Insight: mobile navigation and table helper (works together with css/mobile.css).
 *
 *  - below 1024px the sidebar is a drawer: a hamburger in the page's top bar opens it, tapping
 *    the dark overlay, a link, or pressing Escape closes it
 *  - the desktop "collapsed sidebar" memory (sidebar-toggle.js) is paused while on a phone so the
 *    drawer always opens at full width, and comes back when the window is wide again
 *  - tables that are not already inside a scrolling box get one, so wide tables scroll sideways
 *    inside the card instead of stretching the page
 */
(function () {
    'use strict';

    var MOBILE = window.matchMedia('(max-width: 1023.98px)');
    var root = document.documentElement;
    var aside, overlay, toggles = [];

    var ICON = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">'
        + '<path d="M4 6h16M4 12h16M4 18h16"/></svg>';

    function setOpen(open) {
        document.body.classList.toggle('mn-open', open);
        toggles.forEach(function (b) { b.setAttribute('aria-expanded', open ? 'true' : 'false'); });
    }

    function makeButton(extraClass) {
        var b = document.createElement('button');
        b.type = 'button';
        b.className = 'mn-toggle' + (extraClass ? ' ' + extraClass : '');
        b.setAttribute('aria-label', 'Open menu');
        b.setAttribute('aria-expanded', 'false');
        b.innerHTML = ICON;
        b.addEventListener('click', function () { setOpen(!document.body.classList.contains('mn-open')); });
        toggles.push(b);
        return b;
    }

    // The page's top bar: the first header that sticks or is fixed to the top
    function findTopBar() {
        var headers = document.querySelectorAll('header');
        for (var i = 0; i < headers.length; i++) {
            var cs = getComputedStyle(headers[i]);
            if ((cs.position === 'sticky' || cs.position === 'fixed') && headers[i].getBoundingClientRect().top < 40) {
                return headers[i];
            }
        }
        return null;
    }

    function addHamburger() {
        // the top bar's brand name is only a repeat of the sidebar's: it makes room on a phone
        document.querySelectorAll('header h1').forEach(function (h) {
            if (!aside.contains(h) && /ABTC/i.test(h.textContent)) h.classList.add('mn-hide-sm');
        });
        // ...and so is the ABTC logo square beside it
        document.querySelectorAll('header .material-symbols-outlined').forEach(function (icon) {
            if (!aside.contains(icon) && icon.textContent.trim() === 'health_and_safety' && icon.parentElement) {
                icon.parentElement.classList.add('mn-hide-sm');
            }
        });
        var bar = findTopBar();
        if (bar) bar.style.viewTransitionName = 'mn-top';
        // a top bar that takes its own space (sticky) must not also be allowed for in the page's top padding
        if (bar && getComputedStyle(bar).position === 'sticky') document.body.classList.add('mn-sticky-header');
        if (!bar) {
            document.body.classList.add('mn-has-fab');
            document.body.appendChild(makeButton('mn-fab'));
            return;
        }
        // put the button at the very start of the bar's row
        var row = getComputedStyle(bar).display.indexOf('flex') !== -1 ? bar : (bar.firstElementChild || bar);
        var first = row.firstElementChild;
        if (first && getComputedStyle(first).display.indexOf('flex') !== -1 && first.tagName !== 'FORM') {
            first.insertBefore(makeButton(), first.firstChild);
        } else {
            row.insertBefore(makeButton(), row.firstChild);
        }
    }

    // Desktop "collapsed" memory must not shrink the drawer
    function syncCollapsed() {
        var saved = false;
        try { saved = localStorage.getItem('abtcSidebarCollapsed') === '1'; } catch (e) { /* ignore */ }
        if (MOBILE.matches) {
            root.classList.remove('sb-collapsed');
        } else {
            if (saved) root.classList.add('sb-collapsed');
            setOpen(false);
        }
    }

    // ---- tables -----------------------------------------------------------------------
    function wrapTables() {
        if (!MOBILE.matches) return;
        document.querySelectorAll('table').forEach(function (t) {
            var p = t.parentElement;
            if (!p || p.classList.contains('mn-table-scroll')) return;
            var ox = getComputedStyle(p).overflowX;
            if (ox === 'auto' || ox === 'scroll') return;          // already scrolls inside its card
            var wrap = document.createElement('div');
            wrap.className = 'mn-table-scroll';
            p.insertBefore(wrap, t);
            wrap.appendChild(t);
        });
    }

    // Line charts are drawn on a 1000px-wide canvas: squeezed into a phone their labels become
    // unreadable, so they keep a readable width and scroll sideways inside their card instead
    function wrapCharts() {
        if (!MOBILE.matches) return;
        document.querySelectorAll('[style*="aspect-ratio: 1000 / 340"]').forEach(function (c) {
            var p = c.parentElement;
            if (!p || p.classList.contains('mn-chart-scroll')) return;
            var wrap = document.createElement('div');
            wrap.className = 'mn-chart-scroll';
            p.insertBefore(wrap, c);
            wrap.appendChild(c);
            var hint = document.createElement('p');
            hint.className = 'mn-chart-hint';
            hint.textContent = 'Swipe sideways to see more. Tap a point for its details.';
            wrap.insertAdjacentElement('afterend', hint);
        });
    }

    // ---- phone spacing helpers ---------------------------------------------------------
    // Tables whose only row is a "nothing to show" message become a plain message (see mobile.css).
    function markEmptyTables() {
        document.querySelectorAll('table').forEach(function (t) {
            if (t.closest('aside')) return;
            var rows = t.tBodies.length ? t.tBodies[0].rows : [];
            var empty = MOBILE.matches && rows.length === 1 && rows[0].cells.length === 1 && rows[0].cells[0].colSpan > 1;
            t.classList.toggle('mn-empty-table', empty);
        });
    }

    // The full-width wrapper(s) of a page's content get the same 16px gutter on every page.
    function markGutters() {
        var W = window.innerWidth;
        document.querySelectorAll('main, main > div, main > div > div, main > section').forEach(function (el) {
            if (!MOBILE.matches) { el.classList.remove('mn-gutter'); return; }
            var r = el.getBoundingClientRect();
            var pl = parseFloat(getComputedStyle(el).paddingLeft) || 0;
            if (pl >= 16 && pl <= 24 && r.width >= W - 8) el.classList.add('mn-gutter');
        });
    }

    // ---- sideways-scrolling boxes ------------------------------------------------------
    // A box that really overflows sideways is marked (slim visible scrollbar, see mobile.css) and, when its
    // content is laid out as a block (a table), gets a small "swipe sideways" line that stays put while scrolling.
    function markScrollable() {
        // a box that scrolls up/down (overflow-y-auto) scrolls sideways too when its content is wider, so it is included
        document.querySelectorAll('.overflow-x-auto, .overflow-y-auto, .overflow-auto, .overflow-x-scroll, .overflow-scroll, .mn-table-scroll, .mn-chart-scroll').forEach(function (el) {
            if (el.closest('aside')) return;
            var ox = getComputedStyle(el).overflowX;
            if (ox !== 'auto' && ox !== 'scroll') return;
            var hint = null;
            for (var i = 0; i < el.children.length; i++) {
                if (el.children[i].classList.contains('mn-swipe-hint')) { hint = el.children[i]; break; }
            }
            var can = MOBILE.matches && el.scrollWidth > el.clientWidth + 4;
            el.classList.toggle('mn-scrollable', can);
            if (!can) { if (hint) hint.remove(); return; }
            var display = getComputedStyle(el).display;
            if (el.classList.contains('mn-chart-scroll') || display === 'flex' || display === 'grid' || display === 'inline-flex') return;
            if (!hint) {
                hint = document.createElement('div');
                hint.className = 'mn-swipe-hint';
                hint.textContent = '\u2194 Swipe sideways to see more';
                el.insertBefore(hint, el.firstChild);
            }
            hint.style.width = el.clientWidth + 'px';
        });
    }

    var pending = null;
    function scheduleWrap() {
        if (pending) return;
        pending = setTimeout(function () { pending = null; wrapTables(); wrapCharts(); markEmptyTables(); markGutters(); markScrollable(); }, 120);
    }

    // ---- keep the scroll position when a click reloads the same page -------------------
    // Filters, pagination links and saved forms reload the page; on a phone that used to throw
    // the reader back to the top. The position is remembered when the page is left and put back
    // when the same page (same path) opens again straight after it. A link with a #fragment
    // keeps scrolling to its own anchor instead.
    var SCROLL_KEY = 'mnScroll';

    function rememberScroll() {
        if (!MOBILE.matches) return;
        try {
            sessionStorage.setItem(SCROLL_KEY, JSON.stringify({ p: location.pathname, y: Math.round(window.pageYOffset), t: Date.now() }));
        } catch (e) { /* private mode */ }
    }

    function restoreScroll() {
        if (!MOBILE.matches || location.hash) return;
        var saved;
        try {
            saved = JSON.parse(sessionStorage.getItem(SCROLL_KEY) || 'null');
            sessionStorage.removeItem(SCROLL_KEY);
        } catch (e) { return; }
        if (!saved || saved.p !== location.pathname || Date.now() - saved.t > 15000 || saved.y < 5) return;
        // only when we came from this same page (a click on it), not from somewhere else
        try {
            if (document.referrer && new URL(document.referrer).pathname !== location.pathname) return;
        } catch (e) { return; }

        var target = saved.y, tries = 0, userMoved = false;
        var stop = function () { userMoved = true; };
        window.addEventListener('touchstart', stop, { once: true, passive: true });
        window.addEventListener('wheel', stop, { once: true, passive: true });
        // the page may still be growing (charts, images): keep trying for a moment
        (function attempt() {
            if (userMoved) return;
            window.scrollTo(0, target);
            if (Math.abs(window.pageYOffset - target) > 2 && tries++ < 15) setTimeout(attempt, 100);
        })();
    }

    // ---- arriving from a sibling page: land on the part the reader came for -------------
    // An element marked data-arrival-anchor="/some/path" is scrolled to (just under the top bar) when the
    // reader arrives from another page under that path, e.g. "Next Section" in Clinical Encoding lands on
    // the Active Encoding Session card instead of the top of the page, where the queue is stacked above it.
    function scrollToArrivalAnchor() {
        if (!MOBILE.matches || location.hash) return;
        var anchor = document.querySelector('[data-arrival-anchor]');
        if (!anchor || !document.referrer) return;
        var ref;
        try { ref = new URL(document.referrer); } catch (e) { return; }
        if (ref.origin !== location.origin || ref.pathname === location.pathname) return;   // a reload of this page is handled above
        var prefix = anchor.getAttribute('data-arrival-anchor');
        if (prefix && ref.pathname.indexOf(prefix) !== 0) return;
        var go = function () { window.scrollTo(0, Math.max(0, anchor.getBoundingClientRect().top + window.pageYOffset - 76)); };
        go();
        window.addEventListener('load', go, { once: true });   // once images and fonts have settled the layout
    }

    var restored = false;
    function restoreOnce() { if (restored) return; restored = true; restoreScroll(); scrollToArrivalAnchor(); }
    // fires just before the new page is first shown (also when a view transition is about to start)
    window.addEventListener('pagereveal', restoreOnce);

    window.addEventListener('pagehide', rememberScroll);
    window.addEventListener('beforeunload', rememberScroll);

    // ---- start ------------------------------------------------------------------------
    function init() {
        restoreOnce();
        aside = document.querySelector('aside.fixed.left-0');
        if (aside) {
            overlay = document.createElement('div');
            overlay.className = 'mn-overlay';
            overlay.addEventListener('click', function () { setOpen(false); });
            document.body.appendChild(overlay);

            addHamburger();

            aside.addEventListener('click', function (e) {
                if (e.target.closest && e.target.closest('a[href]')) setOpen(false);
            });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setOpen(false); });
        }

        syncCollapsed();
        wrapTables();
        wrapCharts();
        markEmptyTables();
        markGutters();
        markScrollable();
        window.addEventListener('load', function () { markScrollable(); setTimeout(markScrollable, 400); });
        window.addEventListener('resize', scheduleWrap);
        document.addEventListener('soft:updated', scheduleWrap);

        var onChange = function () { syncCollapsed(); wrapTables(); wrapCharts(); markEmptyTables(); markGutters(); markScrollable(); };
        if (MOBILE.addEventListener) MOBILE.addEventListener('change', onChange);
        else if (MOBILE.addListener) MOBILE.addListener(onChange);

        // tables drawn later by page scripts (charts, search results, ...)
        if (window.MutationObserver) {
            new MutationObserver(scheduleWrap).observe(document.body, { childList: true, subtree: true });
        }
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();

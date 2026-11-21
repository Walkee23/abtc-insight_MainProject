/*
 * ABTC-Insight: filters, search and pagination without a page reload.
 *
 * A page marks the parts that change with its filters as  data-soft-region="name".
 * Clicking a link, or submitting a GET form, that sits inside such a region (or carries
 * data-soft) and points at the SAME page then:
 *   1. fetches the page in the background,
 *   2. swaps only the matching regions for the fresh ones (header, sidebar, scroll position,
 *      focus outside the regions and everything else stay exactly as they are),
 *   3. updates the address bar so Back / Forward and bookmarks keep working.
 * Anything else (another page, a POST, a download, a new tab, Ctrl/Cmd-click) navigates as usual,
 * and so does any problem (offline, expired session, a page that lacks the regions): the
 * browser simply loads the page the old way, so nothing is ever lost.
 *
 * Rules for regions: keep <script> tags outside them, and use delegated event listeners
 * (on document) for anything inside them, because a region is replaced as a whole.
 */
(function () {
    'use strict';

    if (!window.fetch || !window.DOMParser || !window.AbortController || !history.pushState) return;

    var style = document.createElement('style');
    style.textContent =
        '[data-soft-region]{transition:opacity .15s ease}' +
        '[data-soft-region].soft-loading{opacity:.55;pointer-events:none}' +
        '@keyframes soft-in{from{opacity:.4}to{opacity:1}}' +
        '[data-soft-region].soft-in{animation:soft-in .22s ease-out}';
    document.head.appendChild(style);

    var controller = null;
    var marked = false;

    function samePage(url) {
        return url.origin === location.origin && url.pathname === location.pathname;
    }

    function regionNodes(root) {
        return Array.prototype.slice.call(root.querySelectorAll('[data-soft-region]'));
    }

    function inSoftScope(el) {
        return !!(el.closest('[data-soft-region]') || el.closest('[data-soft]'));
    }

    // ---- the swap ---------------------------------------------------------------------
    function go(url, push, scrollToTop) {
        if (controller) controller.abort();
        controller = new AbortController();
        var mine = controller;

        var live = regionNodes(document);
        live.forEach(function (r) { r.classList.add('soft-loading'); });

        var hard = function () { var e = new Error('hard'); e.hard = true; return e; };

        fetch(url.href, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' },
            credentials: 'same-origin',
            signal: mine.signal
        }).then(function (res) {
            // a redirect to another page (login after the session ended, an error page, ...) is a real navigation
            if (!res.ok || (res.redirected && !samePage(new URL(res.url)))) throw hard();
            return res.text();
        }).then(function (html) {
            var doc = new DOMParser().parseFromString(html, 'text/html');
            var fresh = {};
            regionNodes(doc).forEach(function (n) { fresh[n.getAttribute('data-soft-region')] = n; });
            var names = live.map(function (r) { return r.getAttribute('data-soft-region'); });
            if (!names.length || names.some(function (n) { return !fresh[n]; })) throw hard();

            if (push) {
                if (!marked) { history.replaceState({ soft: true }, '', location.href); marked = true; }
                history.pushState({ soft: true }, '', url.href);
            }
            if (doc.title) document.title = doc.title;

            var first = null;
            live.forEach(function (r) {
                var node = document.importNode(fresh[r.getAttribute('data-soft-region')], true);
                node.classList.remove('soft-loading');
                node.classList.add('soft-in');
                r.replaceWith(node);
                if (!first) first = node;
            });

            // after a page change, bring the top of the list back into view if it has scrolled away
            if (scrollToTop && first) {
                var top = first.getBoundingClientRect().top;
                if (top < 80) window.scrollTo({ top: Math.max(0, window.pageYOffset + top - 96), behavior: 'smooth' });
            }
            document.dispatchEvent(new CustomEvent('soft:updated'));
        }).catch(function (err) {
            if (err && err.name === 'AbortError') return;
            location.href = url.href;   // anything unexpected: load the page the normal way
        });
    }

    // ---- links ------------------------------------------------------------------------
    document.addEventListener('click', function (e) {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        var a = e.target.closest && e.target.closest('a[href]');
        if (!a || !inSoftScope(a)) return;
        if ((a.target && a.target !== '_self') || a.hasAttribute('download')) return;

        var url;
        try { url = new URL(a.href, location.href); } catch (err) { return; }
        if (!samePage(url)) return;
        if (url.search === location.search && !a.hasAttribute('data-soft')) {
            if (url.hash) return;   // a plain in-page anchor
        }
        var pageChanged = new URLSearchParams(url.search).toString() !== new URLSearchParams(location.search).toString()
            && /(^|[?&])[a-z_]*page=/.test(url.search);

        e.preventDefault();
        go(url, true, pageChanged);
    });

    // ---- GET forms --------------------------------------------------------------------
    document.addEventListener('submit', function (e) {
        var form = e.target;
        if (e.defaultPrevented || !form || form.tagName !== 'FORM') return;
        if ((form.getAttribute('method') || 'get').toLowerCase() !== 'get') return;
        if (!inSoftScope(form)) return;
        if (form.target && form.target !== '_self') return;

        var url;
        try { url = new URL(form.getAttribute('action') || location.href, location.href); } catch (err) { return; }
        if (!samePage(url)) return;

        var params = new URLSearchParams();
        new FormData(form).forEach(function (value, key) {
            if (typeof value === 'string') params.append(key, value);
        });
        if (e.submitter && e.submitter.name) params.append(e.submitter.name, e.submitter.value);
        url.search = params.toString();

        e.preventDefault();
        go(url, true, false);
    });

    // ---- Back / Forward ---------------------------------------------------------------
    window.addEventListener('popstate', function (e) {
        if (e.state && e.state.soft) go(new URL(location.href), false, false);
    });
})();

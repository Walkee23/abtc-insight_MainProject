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
 * Rules for regions: a region is replaced as a whole, so event listeners inside it must be
 * delegated (on document) or set up by a script that lives INSIDE the region and is written to
 * run again. Mark such a region data-soft-scripts and its inline <script>s are re-run after
 * every swap (a script must clean up anything it attached to document / window / body itself).
 * data-soft-scroll="name" on a link or form scrolls that region into view after the update.
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

    // inline scripts inside a swapped-in region do not run by themselves: run them again
    function runScripts(root) {
        Array.prototype.slice.call(root.querySelectorAll('script')).forEach(function (old) {
            var type = (old.getAttribute('type') || '').toLowerCase();
            if (type && type !== 'text/javascript' && type !== 'application/javascript') return;   // data blocks stay data
            var fresh = document.createElement('script');
            Array.prototype.forEach.call(old.attributes, function (a) { fresh.setAttribute(a.name, a.value); });
            fresh.text = old.textContent;
            old.parentNode.replaceChild(fresh, old);
        });
    }

    function inSoftScope(el) {
        return !!(el.closest('[data-soft-region]') || el.closest('[data-soft]'));
    }

    // ---- the swap ---------------------------------------------------------------------
    // scroll: true = bring the first region's top into view if it scrolled away; "name" = that region, always
    function go(url, push, scroll) {
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

            var first = null, named = null;
            live.forEach(function (r) {
                var name = r.getAttribute('data-soft-region');
                var node = document.importNode(fresh[name], true);
                node.classList.remove('soft-loading');
                node.classList.add('soft-in');
                r.replaceWith(node);
                if (node.hasAttribute('data-soft-scripts')) {
                    try { runScripts(node); } catch (err) { if (window.console) console.error(err); }
                }
                if (!first) first = node;
                if (typeof scroll === 'string' && name === scroll) named = node;
            });

            // bring the updated list / results into view if they have scrolled away (or sit below the fold)
            var target = typeof scroll === 'string' ? named : (scroll ? first : null);
            if (target) {
                var top = target.getBoundingClientRect().top;
                var must = typeof scroll === 'string' ? (top < 80 || top > window.innerHeight * 0.45) : top < 80;
                if (must) window.scrollTo({ top: Math.max(0, window.pageYOffset + top - 96), behavior: 'smooth' });
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
        go(url, true, a.getAttribute('data-soft-scroll') || pageChanged);
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
        go(url, true, form.getAttribute('data-soft-scroll') || false);
    });

    // For scripts that used to do  location.href = url  after an option was picked: update the page in place
    // when it is the same page and has regions, otherwise navigate as before.
    window.softNavigate = function (href, scrollRegion) {
        var url;
        try { url = new URL(href, location.href); } catch (err) { location.href = href; return; }
        if (!samePage(url) || !document.querySelector('[data-soft-region]')) { location.href = url.href; return; }
        go(url, true, scrollRegion || false);
    };

    // ---- Back / Forward ---------------------------------------------------------------
    window.addEventListener('popstate', function (e) {
        if (e.state && e.state.soft) go(new URL(location.href), false, false);
    });
})();

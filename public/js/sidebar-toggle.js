/*
 * Collapsible sidebar for every page that has one (Admin, Health Worker, Staff, BHW).
 *
 * A hamburger button is added beside the "ABTC-INSIGHT" logo name. Collapsed, the sidebar
 * shrinks to a narrow rail that shows only the icons (hover an icon for its name), the
 * hamburger disappears and the logo becomes the button that expands it again. The page
 * content slides over to fill the space. The choice is remembered across pages.
 *
 * Smoothness: the sidebar, the page content and every label share one duration and easing.
 * Labels fade and clip instead of vanishing, icons never change position, and nothing
 * animates on page load (the `sb-ready` class switches the transitions on after first paint).
 *
 * Loaded in the <head> so a remembered "collapsed" state is applied before the page paints.
 */
(function () {
    'use strict';

    var KEY = 'abtcSidebarCollapsed';
    var root = document.documentElement;

    function saved() {
        try { return localStorage.getItem(KEY) === '1'; } catch (e) { return false; }
    }
    function save(collapsed) {
        try { localStorage.setItem(KEY, collapsed ? '1' : '0'); } catch (e) { /* private mode */ }
    }

    if (saved()) root.classList.add('sb-collapsed');

    // ----------------------------------------------------------------- styles
    // Pages size their content with a few Tailwind classes (ml-64, ml-72, pl-72 and the BHW
    // header's w-[calc(100%-16rem)]); the overrides below follow the sidebar width.
    var T = '.3s cubic-bezier(.4,0,.2,1)';   // one duration + easing for everything
    var LABEL = 'a > span:not(.material-symbols-outlined)';
    var css = [
        /* --- always: layout that must not change between states ------------------- */
        'aside.sb-aside{overflow-x:hidden}',
        'aside nav ' + LABEL + ',aside .sb-brand-name{white-space:nowrap;overflow:hidden;max-width:14rem;opacity:1}',
        '.sb-toggle{flex:none;width:2.25rem;height:2.25rem;margin-left:auto;display:inline-flex;align-items:center;justify-content:center;',
        '  border:0;border-radius:.5rem;background:transparent;color:#64748b;cursor:pointer}',
        '.sb-toggle:hover{background:rgba(148,163,184,.25);color:#004a93}',
        '.sb-toggle:focus-visible{outline:2px solid #004a93;outline-offset:2px}',

        /* --- collapsed ------------------------------------------------------------ */
        'html.sb-collapsed aside.sb-aside{width:5rem !important}',
        'html.sb-collapsed .ml-64{margin-left:5rem !important}',
        'html.sb-collapsed .ml-72{margin-left:7rem !important}',
        'html.sb-collapsed .pl-72{padding-left:7rem !important}',
        'html.sb-collapsed .w-\\[calc\\(100\\%-16rem\\)\\]{width:calc(100% - 5rem) !important}',

        /* brand: only the logo stays (centred in the rail), name + hamburger fade out */
        'html.sb-collapsed aside .px-6{padding-left:.75rem !important;padding-right:.75rem !important}',
        'html.sb-collapsed aside .sb-brand{gap:0 !important;padding-left:.5rem}',
        'html.sb-collapsed aside .sb-brand-name{max-width:0;opacity:0}',
        'html.sb-collapsed aside .sb-toggle{width:0;margin:0;opacity:0;overflow:hidden;pointer-events:none}',
        'html.sb-collapsed aside .sb-logo{cursor:pointer}',
        'html.sb-collapsed aside .sb-logo:hover{box-shadow:0 0 0 3px rgba(0,74,147,.25)}',
        'html.sb-collapsed aside .sb-logo:focus-visible{outline:2px solid #004a93;outline-offset:3px}',

        /* links keep their px-4 so the icon never moves; the labels just fade and clip away */
        'html.sb-collapsed aside nav{padding-left:.75rem !important;padding-right:.75rem !important}',
        'html.sb-collapsed aside nav a{gap:0 !important;transform:none !important}',
        'html.sb-collapsed aside nav ' + LABEL + '{max-width:0;opacity:0}',
        'html.sb-collapsed aside button:not(.sb-toggle){opacity:0;visibility:hidden;pointer-events:none}',

        /* --- motion: only after the first paint, and never for people who opt out ---- */
        'html.sb-ready aside.sb-aside{transition:width ' + T + '}',
        'html.sb-ready .ml-64,html.sb-ready .ml-72,html.sb-ready .pl-72,html.sb-ready .w-\\[calc\\(100\\%-16rem\\)\\]{',
        '  transition:margin-left ' + T + ',padding-left ' + T + ',width ' + T + '}',
        'html.sb-ready aside .px-6,html.sb-ready aside nav,html.sb-ready aside .sb-brand,html.sb-ready aside nav a{',
        '  transition:padding ' + T + ',gap ' + T + ',background-color .15s,color .15s}',
        'html.sb-ready aside nav ' + LABEL + ',html.sb-ready aside .sb-brand-name{transition:max-width ' + T + ',opacity .18s ease}',
        'html.sb-ready aside .sb-toggle{transition:width ' + T + ',margin ' + T + ',opacity .18s ease,background-color .15s,color .15s}',
        'html.sb-ready aside .sb-logo{transition:box-shadow .15s}',
        'html.sb-ready aside button:not(.sb-toggle){transition:opacity .18s ease,visibility 0s linear .18s}',
        'html.sb-collapsed.sb-ready aside button:not(.sb-toggle){transition:opacity .18s ease,visibility 0s}',
        '@media (prefers-reduced-motion:reduce){html.sb-ready *{transition:none !important}}'
    ].join('\n');

    var style = document.createElement('style');
    style.id = 'sb-style';
    style.textContent = css;
    (document.head || root).appendChild(style);

    // ------------------------------------------------------------------- button
    function init() {
        var aside = document.querySelector('aside.fixed');
        if (!aside) {
            // no sidebar on this page (login, patient pages, ...): nothing to collapse
            root.classList.remove('sb-collapsed');
            return;
        }
        aside.classList.add('sb-aside');

        var h1 = aside.querySelector('h1');
        var row = h1 ? h1.closest('.flex.items-center') : null;
        if (!row) return;
        row.classList.add('sb-brand');

        var nameEl = h1;
        while (nameEl.parentElement && nameEl.parentElement !== row) nameEl = nameEl.parentElement;
        nameEl.classList.add('sb-brand-name');

        // hovering an icon in the collapsed rail shows what it is
        aside.querySelectorAll('nav a').forEach(function (a) {
            if (a.title) return;
            var label = Array.prototype.filter.call(a.children, function (c) {
                return !c.classList.contains('material-symbols-outlined');
            }).map(function (c) { return c.textContent.replace(/\s+/g, ' ').trim(); }).join(' ');
            if (label) a.title = label;
        });

        // the header on some pages repeats the brand under the sidebar; keep it from peeking out
        document.querySelectorAll('header h1').forEach(function (title) {
            if (aside.contains(title) || !/ABTC/i.test(title.textContent)) return;
            var brand = title.closest('.flex.items-center');
            if (brand) brand.style.visibility = 'hidden';
        });

        var btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'sb-toggle';
        btn.innerHTML = '<span class="material-symbols-outlined">menu</span>';
        row.appendChild(btn);

        // the logo: inert while expanded, "expand" button while collapsed
        var logo = row.firstElementChild === nameEl ? null : row.firstElementChild;
        if (logo === btn) logo = null;
        if (logo) logo.classList.add('sb-logo');

        function sync() {
            var collapsed = root.classList.contains('sb-collapsed');
            btn.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
            btn.setAttribute('aria-label', 'Collapse sidebar');
            btn.title = 'Collapse sidebar';
            btn.tabIndex = collapsed ? -1 : 0;
            if (!logo) return;
            if (collapsed) {
                logo.setAttribute('role', 'button');
                logo.setAttribute('tabindex', '0');
                logo.setAttribute('aria-label', 'Expand sidebar');
                logo.title = 'Expand sidebar';
            } else {
                ['role', 'tabindex', 'aria-label', 'title'].forEach(function (a) { logo.removeAttribute(a); });
            }
        }

        var resizeTimer = null;
        function toggle() {
            var collapsed = root.classList.toggle('sb-collapsed');
            save(collapsed);
            sync();
            // let maps and charts re-fit once the sidebar has finished moving (a single reflow, not one per frame)
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () { window.dispatchEvent(new Event('resize')); }, 320);
        }
        btn.addEventListener('click', toggle);
        if (logo) {
            logo.addEventListener('click', function () { if (root.classList.contains('sb-collapsed')) toggle(); });
            logo.addEventListener('keydown', function (e) {
                if ((e.key === 'Enter' || e.key === ' ') && root.classList.contains('sb-collapsed')) { e.preventDefault(); toggle(); }
            });
        }
        sync();

        // switch the motion on only after the page (in its remembered state) has painted
        function ready() { root.classList.add('sb-ready'); }
        requestAnimationFrame(function () { requestAnimationFrame(ready); });
        setTimeout(ready, 120);   // fallback for backgrounded tabs, where animation frames are paused
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();

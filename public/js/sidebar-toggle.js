/*
 * Collapsible sidebar for every page that has one (Admin, Health Worker, Staff, BHW).
 *
 * A hamburger button is added beside the "ABTC-INSIGHT" logo name. Collapsed, the sidebar
 * shrinks to a narrow rail that shows only the icons (hover an icon for its name) and the
 * page content slides over to fill the space. The choice is remembered across pages.
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
    var css = [
        'aside.sb-aside{transition:width .2s ease}',
        '.ml-64,.ml-72,.pl-72{transition:margin-left .2s ease,padding-left .2s ease}',
        '.sb-toggle{margin-left:auto;flex:none;width:2.25rem;height:2.25rem;display:inline-flex;align-items:center;justify-content:center;',
        '  border:0;border-radius:.5rem;background:transparent;color:#64748b;cursor:pointer;transition:background-color .15s,color .15s}',
        '.sb-toggle:hover{background:rgba(148,163,184,.25);color:#004a93}',
        '.sb-toggle:focus-visible{outline:2px solid #004a93;outline-offset:2px}',

        'html.sb-collapsed aside.sb-aside{width:5rem !important;overflow-x:hidden}',
        'html.sb-collapsed .ml-64{margin-left:5rem !important}',
        'html.sb-collapsed .ml-72{margin-left:7rem !important}',
        'html.sb-collapsed .pl-72{padding-left:7rem !important}',
        'html.sb-collapsed .w-\\[calc\\(100\\%-16rem\\)\\]{width:calc(100% - 5rem) !important}',

        /* brand: hamburger above the logo, name hidden */
        'html.sb-collapsed aside .sb-brand{flex-direction:column;align-items:center;gap:.75rem !important}',
        'html.sb-collapsed aside .sb-brand-name{display:none !important}',
        'html.sb-collapsed aside .sb-toggle{margin-left:0 !important;order:-1}',
        'html.sb-collapsed aside .px-6{padding-left:.75rem !important;padding-right:.75rem !important}',

        /* links: icons only, centred */
        'html.sb-collapsed aside nav{padding-left:.75rem !important;padding-right:.75rem !important}',
        'html.sb-collapsed aside nav a{justify-content:center !important;padding-left:0 !important;padding-right:0 !important;gap:0 !important;transform:none !important}',
        'html.sb-collapsed aside nav a > span:not(.material-symbols-outlined){display:none !important}',
        'html.sb-collapsed aside button:not(.sb-toggle){display:none !important}'
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

        function sync() {
            var collapsed = root.classList.contains('sb-collapsed');
            btn.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
            btn.setAttribute('aria-label', collapsed ? 'Expand sidebar' : 'Collapse sidebar');
            btn.title = collapsed ? 'Expand sidebar' : 'Collapse sidebar';
        }
        btn.addEventListener('click', function () {
            var collapsed = root.classList.toggle('sb-collapsed');
            save(collapsed);
            sync();
        });
        sync();
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
})();

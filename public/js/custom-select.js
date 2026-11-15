/*
 * ABTC-Insight - styled dropdown lists
 *
 * Replaces the browser's plain popup of every <select> with a styled menu (rounded card, soft shadow,
 * highlighted + checked current choice, keyboard support). The <select> itself stays on the page exactly
 * as it was - same classes, layout, label, validation, value and "change" event - so existing forms and
 * onchange="..." handlers keep working. Selects added later by JavaScript are picked up automatically.
 *
 * Add to a page:  <script src="{{ asset('js/custom-select.js') }}" defer></script>
 * Opt a select out:  <select data-native> ... </select>
 * Touch screens keep the phone's own picker, which is nicer to use there.
 */
(function () {
    'use strict';
    if (window.__csSelect) return;
    window.__csSelect = true;

    var CHECK = '<svg class="cs-check" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.5 10.5l3.6 3.6 7.4-8.2"/></svg>';

    var CSS = [
        '.cs-menu{position:fixed;z-index:2147483000;box-sizing:border-box;padding:6px;background:#fff;color:#334155;',
        'border:1px solid rgba(15,23,42,.08);border-radius:14px;overflow-y:auto;overscroll-behavior:contain;',
        'box-shadow:0 16px 36px -10px rgba(15,23,42,.22),0 4px 12px -4px rgba(15,23,42,.10);',
        'font-family:Inter,system-ui,-apple-system,"Segoe UI",sans-serif;line-height:1.25;',
        'opacity:0;transform:translateY(-6px) scale(.98);transform-origin:top center;',
        'transition:opacity .14s ease,transform .14s cubic-bezier(.4,0,.2,1);scrollbar-width:thin;scrollbar-color:#cbd5e1 transparent}',
        '.cs-menu.cs-up{transform:translateY(6px) scale(.98);transform-origin:bottom center}',
        '.cs-menu.cs-show{opacity:1;transform:none}',
        '.cs-menu::-webkit-scrollbar{width:6px}',
        '.cs-menu::-webkit-scrollbar-thumb{background:#cbd5e1;border-radius:6px}',
        '.cs-opt{display:flex;align-items:center;justify-content:space-between;gap:14px;padding:9px 10px;margin:1px 0;',
        'border-radius:9px;cursor:pointer;font-weight:500;user-select:none;-webkit-user-select:none;transition:background-color .08s ease}',
        '.cs-opt .cs-txt{flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}',
        '.cs-opt.cs-active{background:#f1f5f9;color:#0f172a}',
        '.cs-opt[aria-selected="true"]{background:#eff6ff;color:#004a93;font-weight:700}',
        '.cs-opt[aria-selected="true"].cs-active{background:#dbeafe}',
        '.cs-opt.cs-empty .cs-txt{color:#94a3b8;font-weight:500}',
        '.cs-opt.cs-disabled{opacity:.4;cursor:not-allowed}',
        '.cs-check{flex:none;width:15px;height:15px;color:#004a93;opacity:0;transform:scale(.6);transition:opacity .12s ease,transform .12s ease}',
        '.cs-opt[aria-selected="true"] .cs-check{opacity:1;transform:none}',
        '.cs-group{padding:10px 10px 4px;font-size:.78em;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:#94a3b8;cursor:default}',
        '.cs-group:first-child{padding-top:4px}',
        /* dark pages */
        '.cs-menu.cs-dark{background:#1e293b;color:#cbd5e1;border-color:rgba(255,255,255,.08);box-shadow:0 16px 36px -10px rgba(0,0,0,.6)}',
        '.cs-dark .cs-opt.cs-active{background:#334155;color:#fff}',
        '.cs-dark .cs-opt[aria-selected="true"]{background:rgba(59,130,246,.18);color:#93c5fd}',
        '.cs-dark .cs-opt[aria-selected="true"].cs-active{background:rgba(59,130,246,.3)}',
        '.cs-dark .cs-check{color:#93c5fd}',
        '@media (prefers-reduced-motion:reduce){.cs-menu,.cs-opt,.cs-check{transition:none}}'
    ].join('');

    var style = document.createElement('style');
    style.id = 'cs-select-style';
    style.textContent = CSS;
    (document.head || document.documentElement).appendChild(style);

    // phones and tablets: leave the native picker alone
    function coarse() {
        return window.matchMedia && window.matchMedia('(pointer: coarse)').matches;
    }

    function eligible(s) {
        return !!s && s.tagName === 'SELECT' && !s.multiple && !s.disabled && (!s.size || s.size <= 1)
            && !s.hasAttribute('data-native') && !(s.closest && s.closest('[data-native-select]')) && !coarse();
    }

    var state = null;          // { select, menu, items: [{opt, el, disabled}], active }
    var typed = '', typedTimer = null;

    function isDisabled(opt) {
        return opt.disabled || (opt.parentNode && opt.parentNode.tagName === 'OPTGROUP' && opt.parentNode.disabled);
    }

    function build(select) {
        var menu = document.createElement('div');
        menu.className = 'cs-menu';
        menu.setAttribute('role', 'listbox');
        var items = [];

        function addOption(opt) {
            if (opt.hidden) return;
            var el = document.createElement('div');
            var disabled = isDisabled(opt);
            el.className = 'cs-opt' + (disabled ? ' cs-disabled' : '') + (opt.value === '' ? ' cs-empty' : '');
            el.setAttribute('role', 'option');
            el.setAttribute('aria-selected', opt.selected ? 'true' : 'false');
            if (disabled) el.setAttribute('aria-disabled', 'true');
            var txt = document.createElement('span');
            txt.className = 'cs-txt';
            txt.textContent = (opt.text || '').trim() || ' ';
            el.appendChild(txt);
            el.insertAdjacentHTML('beforeend', CHECK);
            menu.appendChild(el);
            items.push({ opt: opt, el: el, disabled: disabled });
        }

        Array.prototype.forEach.call(select.children, function (child) {
            if (child.tagName === 'OPTGROUP') {
                var g = document.createElement('div');
                g.className = 'cs-group';
                g.textContent = child.label || '';
                menu.appendChild(g);
                Array.prototype.forEach.call(child.children, function (o) { if (o.tagName === 'OPTION') addOption(o); });
            } else if (child.tagName === 'OPTION') {
                addOption(child);
            }
        });
        return { menu: menu, items: items };
    }

    function setActive(i, scroll) {
        if (!state) return;
        if (state.active >= 0 && state.items[state.active]) state.items[state.active].el.classList.remove('cs-active');
        state.active = i;
        var it = state.items[i];
        if (!it) return;
        it.el.classList.add('cs-active');
        if (scroll) {
            var m = state.menu, top = it.el.offsetTop, bottom = top + it.el.offsetHeight;
            if (top - 6 < m.scrollTop) m.scrollTop = Math.max(0, top - 6);
            else if (bottom + 6 > m.scrollTop + m.clientHeight) m.scrollTop = bottom + 6 - m.clientHeight;
        }
    }

    function move(step) {
        if (!state) return;
        var n = state.items.length, i = state.active;
        for (var k = 0; k < n; k++) {
            i = i + step;
            if (i < 0 || i >= n) return;            // stop at the ends, like a native list
            if (!state.items[i].disabled) { setActive(i, true); return; }
        }
    }

    function edge(last) {
        if (!state) return;
        var list = state.items, i = last ? list.length - 1 : 0;
        while (i >= 0 && i < list.length && list[i].disabled) i += last ? -1 : 1;
        if (list[i]) setActive(i, true);
    }

    function open(select) {
        if (state) close(false);
        var built = build(select);
        if (!built.items.length) return;
        var menu = built.menu;
        document.body.appendChild(menu);

        var cs = window.getComputedStyle(select);
        menu.style.fontSize = Math.min(14, Math.max(12, parseFloat(cs.fontSize) || 14)) + 'px';
        if (document.documentElement.classList.contains('dark') || (select.closest && select.closest('.dark'))) {
            menu.classList.add('cs-dark');
        }

        var r = select.getBoundingClientRect();
        menu.style.minWidth = Math.max(r.width, 120) + 'px';
        menu.style.maxWidth = Math.max(160, Math.min(480, window.innerWidth - 16)) + 'px';
        menu.style.visibility = 'hidden';

        var natural = menu.offsetHeight;
        var below = window.innerHeight - r.bottom - 12, above = r.top - 12;
        var up = natural > below && above > below;
        menu.style.maxHeight = Math.max(120, Math.min(320, up ? above : below)) + 'px';
        var h = menu.offsetHeight;
        menu.classList.toggle('cs-up', up);
        menu.style.top = (up ? r.top - h - 6 : r.bottom + 6) + 'px';
        menu.style.left = Math.max(8, Math.min(r.left, window.innerWidth - menu.offsetWidth - 8)) + 'px';
        menu.style.visibility = '';
        void menu.offsetWidth;                       // commit the start state so the fade-in plays
        menu.classList.add('cs-show');

        state = { select: select, menu: menu, items: built.items, active: -1 };
        select.setAttribute('aria-expanded', 'true');

        var cur = -1;
        built.items.forEach(function (it, i) { if (it.opt.selected && cur < 0) cur = i; });
        if (cur < 0) { for (var i = 0; i < built.items.length; i++) { if (!built.items[i].disabled) { cur = i; break; } } }
        setActive(cur, true);
    }

    function close(refocus) {
        if (!state) return;
        var s = state.select, menu = state.menu;
        state = null;
        s.removeAttribute('aria-expanded');
        menu.classList.remove('cs-show');
        setTimeout(function () { if (menu.parentNode) menu.parentNode.removeChild(menu); }, 140);
        if (refocus) { try { s.focus({ preventScroll: true }); } catch (e) { s.focus(); } }
    }

    function choose(i) {
        if (!state) return;
        var it = state.items[i];
        if (!it || it.disabled) return;
        var s = state.select;
        var changed = s.selectedIndex !== it.opt.index;
        close(true);
        if (changed) {
            s.selectedIndex = it.opt.index;
            s.dispatchEvent(new Event('input', { bubbles: true }));
            s.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    function typeahead(ch) {
        clearTimeout(typedTimer);
        typed += ch.toLowerCase();
        typedTimer = setTimeout(function () { typed = ''; }, 700);
        var n = state.items.length;
        var sameKey = typed.split('').every(function (c) { return c === typed[0]; });
        var start = sameKey ? state.active + 1 : state.active;   // repeating one letter cycles through matches
        var needle = sameKey ? typed[0] : typed;
        for (var k = 0; k < n; k++) {
            var idx = (start + k + n) % n, it = state.items[idx];
            if (!it.disabled && it.opt.text.trim().toLowerCase().indexOf(needle) === 0) { setActive(idx, true); return; }
        }
    }

    // ---- events (delegated, so selects added later work too) --------------------------------------------

    document.addEventListener('mousedown', function (e) {
        if (e.button !== 0) return;
        var t = e.target;
        if (state && state.menu.contains(t)) { e.preventDefault(); return; }   // keep focus on the select
        var s = t && t.closest ? t.closest('select') : null;
        if (eligible(s)) {
            e.preventDefault();                                                // stops the native popup
            s.focus();
            if (state && state.select === s) close(false); else open(s);
            return;
        }
        if (state) close(false);
    }, true);

    document.addEventListener('click', function (e) {
        if (!state || !state.menu.contains(e.target)) return;
        var el = e.target.closest('.cs-opt');
        if (!el) return;
        for (var i = 0; i < state.items.length; i++) { if (state.items[i].el === el) { choose(i); return; } }
    }, true);

    document.addEventListener('mousemove', function (e) {
        if (!state || !state.menu.contains(e.target)) return;
        var el = e.target.closest('.cs-opt');
        if (!el) return;
        for (var i = 0; i < state.items.length; i++) {
            if (state.items[i].el === el) { if (!state.items[i].disabled && state.active !== i) setActive(i, false); return; }
        }
    }, true);

    document.addEventListener('keydown', function (e) {
        if (state) {
            var k = e.key, handled = true;
            if (k === 'ArrowDown') move(1);
            else if (k === 'ArrowUp') move(-1);
            else if (k === 'Home') edge(false);
            else if (k === 'End') edge(true);
            else if (k === 'PageDown') { for (var a = 0; a < 7; a++) move(1); }
            else if (k === 'PageUp') { for (var b = 0; b < 7; b++) move(-1); }
            else if (k === 'Enter' || k === ' ') choose(state.active);
            else if (k === 'Escape') close(true);
            else if (k === 'Tab') { close(false); handled = false; }
            else if (k.length === 1 && !e.ctrlKey && !e.metaKey && !e.altKey) typeahead(k);
            else handled = false;
            if (handled) { e.preventDefault(); e.stopImmediatePropagation(); }
            return;
        }
        var s = e.target;
        if (s && s.tagName === 'SELECT' && eligible(s)
            && (e.key === ' ' || e.key === 'F4' || (e.altKey && (e.key === 'ArrowDown' || e.key === 'ArrowUp')))) {
            e.preventDefault();
            open(s);
        }
    }, true);

    window.addEventListener('scroll', function (e) {
        if (state && !state.menu.contains(e.target)) close(false);
    }, true);
    window.addEventListener('resize', function () { close(false); });
    window.addEventListener('blur', function () { close(false); });
})();

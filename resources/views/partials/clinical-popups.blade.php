{{--
    Confirmation pop-ups for the Health Worker's Clinical Encoding pages (Sections VI to IX).

    Include it just before </body> of a section page:
        @include('partials.clinical-popups', [
            'ceFormId' => 'section6Form',
            'ceSection' => 'Section VI',
            'ceNext' => ['icon' => 'arrow_forward', 'title' => 'Save and continue?', 'text' => '...', 'ok' => 'Save and Continue'],
        ])

    - "Save as Draft" asks first, then submits exactly as before.
    - Whatever the page sends with form.submit() (Next / Finalize) asks first, AFTER the page's own checks passed,
      so a pop-up never appears for a form that still has missing fields.
    - Nothing else on the page changes: the page's own handlers still run once the pop-up is confirmed.
--}}
<div id="ceConfirmModal" role="dialog" aria-modal="true" aria-labelledby="ceConfirmTitle"
    class="hidden fixed inset-0 z-[70] bg-slate-900/60 backdrop-blur-sm items-center justify-center p-4 opacity-0 transition-opacity duration-200">
    <div id="ceConfirmCard" class="bg-white rounded-2xl max-w-sm w-full p-7 text-center shadow-2xl border border-slate-100 scale-95 transition-transform duration-200">
        <div id="ceConfirmIconWrap" class="mx-auto mb-4 w-14 h-14 rounded-full flex items-center justify-center">
            <span id="ceConfirmIcon" class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;"></span>
        </div>
        <h3 id="ceConfirmTitle" class="text-xl font-extrabold tracking-tight text-slate-900"></h3>
        <p id="ceConfirmText" class="mt-2 text-sm text-slate-600 leading-relaxed"></p>
        <p id="ceConfirmDetail" class="hidden mt-3 text-sm font-bold text-slate-900 bg-slate-50 rounded-xl px-4 py-2.5 break-words"></p>
        <div class="mt-6 grid grid-cols-2 gap-3">
            <button type="button" id="ceConfirmCancel" class="px-4 py-3 rounded-full font-bold text-sm text-slate-600 bg-slate-100 hover:bg-slate-200 active:scale-95 transition-all">Go Back</button>
            <button type="button" id="ceConfirmOk" class="px-4 py-3 rounded-full font-bold text-sm text-white active:scale-95 transition-all shadow-lg disabled:opacity-60 disabled:cursor-wait focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-primary"></button>
        </div>
    </div>
</div>

<script>
(function () {
    const form = document.getElementById(@json($ceFormId));
    if (!form) return;   // no case selected: there is nothing to confirm

    const tones = {
        blue:  { wrap: 'bg-blue-100 text-blue-700',       ok: 'bg-primary shadow-primary/20' },
        green: { wrap: 'bg-emerald-100 text-emerald-600', ok: 'bg-emerald-600 shadow-emerald-600/20' },
    };
    const modal = document.getElementById('ceConfirmModal');
    const card = document.getElementById('ceConfirmCard');
    const okBtn = document.getElementById('ceConfirmOk');
    let onYes = null;

    function ask(o, yes) {
        const t = tones[o.tone] || tones.blue;
        document.getElementById('ceConfirmIconWrap').className = 'mx-auto mb-4 w-14 h-14 rounded-full flex items-center justify-center ' + t.wrap;
        document.getElementById('ceConfirmIcon').textContent = o.icon;
        document.getElementById('ceConfirmTitle').textContent = o.title;
        document.getElementById('ceConfirmText').textContent = o.text;
        const d = document.getElementById('ceConfirmDetail');
        d.textContent = o.detail || '';
        d.classList.toggle('hidden', !o.detail);
        okBtn.className = 'px-4 py-3 rounded-full font-bold text-sm text-white active:scale-95 transition-all shadow-lg disabled:opacity-60 disabled:cursor-wait focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-primary ' + t.ok;
        okBtn.textContent = o.ok;
        okBtn.disabled = false;
        onYes = yes;
        document.body.classList.add('overflow-hidden');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => { modal.classList.remove('opacity-0'); card.classList.remove('scale-95'); okBtn.focus(); }, 10);
    }
    function close() {
        onYes = null;
        modal.classList.add('opacity-0');
        card.classList.add('scale-95');
        setTimeout(() => { modal.classList.add('hidden'); modal.classList.remove('flex'); document.body.classList.remove('overflow-hidden'); }, 200);
    }
    document.getElementById('ceConfirmCancel').addEventListener('click', close);
    modal.addEventListener('click', (e) => { if (e.target === modal) close(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) close(); });
    okBtn.addEventListener('click', () => {
        if (!onYes) return;
        okBtn.disabled = true;   // one click is enough
        onYes();
    });

    const who = @json(trim(($case->patient_name ?? '') . (!empty($case->case_number) ? ' · Case #' . $case->case_number : '')));
    const section = @json($ceSection ?? 'this section');
    const nextOpts = Object.assign({ tone: 'blue', icon: 'arrow_forward', title: 'Save and continue?', text: '', ok: 'Continue' }, @json($ceNext ?? []));

    // Save as Draft: ask, then let the page's own click handler and the normal submit run
    const draftBtn = document.getElementById('draftBtn');
    if (draftBtn) {
        draftBtn.addEventListener('click', function (e) {
            if (draftBtn.dataset.ceOk === '1') { delete draftBtn.dataset.ceOk; return; }
            e.preventDefault();
            e.stopImmediatePropagation();
            ask({
                tone: 'blue', icon: 'save', title: 'Save as draft?',
                text: 'What you entered in ' + section + ' is saved so you can finish it later. You stay on this section.',
                detail: who, ok: 'Save Draft',
            }, () => { draftBtn.dataset.ceOk = '1'; draftBtn.click(); });
        }, true);
    }

    // Next / Finalize: the page checks its fields, then calls form.submit(); ask at that point
    const realSubmit = HTMLFormElement.prototype.submit;
    form.submit = function () {
        if (form.dataset.ceSkip === '1') { return realSubmit.call(form); }   // e.g. Discharge has its own pop-up
        ask(Object.assign({}, nextOpts, { detail: who }), () => realSubmit.call(form));
    };
})();
</script>

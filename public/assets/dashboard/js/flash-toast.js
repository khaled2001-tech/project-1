document.addEventListener('DOMContentLoaded', function () {
    const toastEl = document.querySelector('[data-toast]');
    if (!toastEl) return;

    const type = toastEl.dataset.toast;
    const msg  = toastEl.textContent.trim();
    toastEl.remove();

    showFlashToast(type, msg);
});

function showFlashToast(type, msg) {
    const colors = {
        success: { bg: '#e8f7ee', border: '#2e7d52', text: '#1a5c38', icon: '✓' },
        danger:  { bg: '#fdecea', border: '#c0392b', text: '#922b21', icon: '✕' }
    };
    const c = colors[type] || colors.danger;

    const wrap = document.createElement('div');
    wrap.style.cssText = `
        position:fixed; top:20px; left:50%; transform:translateX(-50%) translateY(-120%);
        z-index:9999; min-width:320px; max-width:520px; width:90%;
        display:flex; align-items:center; gap:12px;
        padding:14px 18px; border-radius:12px;
        background:${c.bg}; border:1px solid ${c.border}; color:${c.text};
        font-size:14px; box-shadow:0 4px 16px rgba(0,0,0,.1);
        transition:transform .4s cubic-bezier(.22,1,.36,1), opacity .3s ease;
        opacity:0;
    `;

    wrap.innerHTML = `
        <div style="width:22px;height:22px;border-radius:50%;background:${c.text};color:#fff;
                    display:flex;align-items:center;justify-content:center;
                    font-size:13px;flex-shrink:0;">${c.icon}</div>
        <span style="flex:1;line-height:1.5;">${msg}</span>
        <button onclick="this.parentElement.remove()"
                style="background:none;border:none;cursor:pointer;font-size:20px;
                       line-height:1;color:${c.text};opacity:.6;padding:0 4px;">×</button>
        <div style="position:absolute;bottom:0;left:0;height:3px;
             border-radius:0 0 12px 12px;background:${c.text};
             animation:toast-shrink 4s linear forwards;width:100%;transform-origin:left;"></div>
    `;

    if (!document.getElementById('toast-style')) {
        const s = document.createElement('style');
        s.id = 'toast-style';
        s.textContent = '@keyframes toast-shrink{from{transform:scaleX(1)}to{transform:scaleX(0)}}';
        document.head.appendChild(s);
    }

    document.body.appendChild(wrap);

    requestAnimationFrame(() => {
        wrap.style.transform = 'translateX(-50%) translateY(0)';
        wrap.style.opacity   = '1';
    });

    setTimeout(() => {
        wrap.style.opacity   = '0';
        wrap.style.transform = 'translateX(-50%) translateY(-120%)';
        setTimeout(() => wrap.remove(), 400);
    }, 4000);
}

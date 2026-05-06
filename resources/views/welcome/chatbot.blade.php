{{--
    ════════════════════════════════════════════════════════════
    CHATBOT WIDGET — أضف هذا الملف في:
    resources/views/welcome/partials/chatbot.blade.php

    ثم في welcome/layout.blade.php قبل </body> أضف:
    @include('welcome.partials.chatbot')
    ════════════════════════════════════════════════════════════
--}}

{{-- ══ CSS ══════════════════════════════════════════════════════ --}}
<style>
/* ── زر التفعيل ─────────────────────────── */
#cb-toggle {
    position: fixed;
    bottom: 28px;
    right: 28px;
    width: 62px;
    height: 62px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f9a825, #f57f17);
    color: #fff;
    border: none;
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 20px rgba(245,127,23,0.45);
    z-index: 9999;
    cursor: pointer;
    transition: transform .2s, box-shadow .2s;
}
#cb-toggle:hover { transform: scale(1.1); box-shadow: 0 8px 28px rgba(245,127,23,.55); }

/* نقطة حمراء (notification) */
#cb-badge {
    position: absolute;
    top: 3px; right: 3px;
    width: 14px; height: 14px;
    background: #e53935;
    border: 2px solid #fff;
    border-radius: 50%;
}

/* ── نافذة الشات ────────────────────────── */
#cb-window {
    position: fixed;
    bottom: 104px;
    right: 28px;
    width: 360px;
    max-height: 540px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.18);
    z-index: 9998;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: opacity .22s, transform .22s;
    transform-origin: bottom right;
}
#cb-window.cb-hidden {
    opacity: 0;
    transform: scale(0.85) translateY(12px);
    pointer-events: none;
}

/* header */
.cb-header {
    background: linear-gradient(135deg, #f9a825, #e65100);
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 11px;
    border-radius: 18px 18px 0 0;
}
.cb-avatar {
    width: 42px; height: 42px;
    background: rgba(255,255,255,.25);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem; flex-shrink: 0;
}
.cb-header-info .cb-name   { font-weight: 700; color: #fff; font-size: .95rem; }
.cb-header-info .cb-status { font-size: .72rem; color: rgba(255,255,255,.85); }
.cb-close {
    margin-left: auto;
    background: none; border: none;
    color: rgba(255,255,255,.8);
    font-size: 1.2rem; cursor: pointer;
    padding: 2px 6px; border-radius: 6px;
    transition: background .15s;
}
.cb-close:hover { background: rgba(255,255,255,.2); }

/* messages */
#cb-messages {
    flex: 1;
    overflow-y: auto;
    padding: 14px 14px 6px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    scroll-behavior: smooth;
}
#cb-messages::-webkit-scrollbar { width: 4px; }
#cb-messages::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 4px; }

.cb-msg-wrap { display: flex; flex-direction: column; }
.cb-msg-wrap.bot  { align-items: flex-start; }
.cb-msg-wrap.user { align-items: flex-end; }

.cb-bubble {
    max-width: 80%;
    padding: 9px 13px;
    border-radius: 14px;
    font-size: .875rem;
    line-height: 1.55;
    word-break: break-word;
    white-space: pre-wrap;
}
.cb-bubble.bot  {
    background: #fff8e1;
    color: #3e2723;
    border-bottom-left-radius: 4px;
    border: 1px solid #ffe082;
}
.cb-bubble.user {
    background: linear-gradient(135deg, #f9a825, #e65100);
    color: #fff;
    border-bottom-right-radius: 4px;
}
.cb-time {
    font-size: .68rem;
    color: #9e9e9e;
    margin-top: 2px;
    padding: 0 2px;
}

/* typing dots */
.cb-typing { display: flex; gap: 4px; padding: 10px 14px; align-items: center; }
.cb-typing span {
    width: 7px; height: 7px;
    background: #f9a825;
    border-radius: 50%;
    animation: cbBounce 1.2s infinite;
}
.cb-typing span:nth-child(2) { animation-delay: .2s; }
.cb-typing span:nth-child(3) { animation-delay: .4s; }
@keyframes cbBounce {
    0%,80%,100% { transform: translateY(0); }
    40%         { transform: translateY(-7px); }
}

/* quick replies */
#cb-quick {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 6px 14px 10px;
}
#cb-quick button {
    background: #fff;
    border: 1.5px solid #f9a825;
    color: #e65100;
    border-radius: 20px;
    padding: 4px 12px;
    font-size: .78rem;
    cursor: pointer;
    transition: all .15s;
    font-weight: 500;
}
#cb-quick button:hover { background: #f9a825; color: #fff; }

/* input */
.cb-input-row {
    padding: 10px 12px;
    border-top: 1px solid #f5f5f5;
    display: flex;
    gap: 8px;
    align-items: center;
}
.cb-input-row input {
    flex: 1;
    border: 1.5px solid #eeeeee;
    border-radius: 22px;
    padding: 9px 15px;
    font-size: .86rem;
    outline: none;
    transition: border-color .2s;
}
.cb-input-row input:focus { border-color: #f9a825; }
.cb-send {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f9a825, #e65100);
    color: #fff;
    border: none;
    display: flex; align-items: center; justify-content: center;
    font-size: .95rem;
    cursor: pointer;
    transition: opacity .2s;
    flex-shrink: 0;
}
.cb-send:disabled { opacity: .4; cursor: not-allowed; }
</style>

{{-- ══ HTML ═════════════════════════════════════════════════════ --}}

{{-- زر الفتح --}}
<button id="cb-toggle" aria-label="فتح المساعد">
    <span id="cb-badge"></span>
    <i class="fas fa-robot"></i>
</button>

{{-- نافذة الشات --}}
<div id="cb-window" class="cb-hidden" role="dialog" aria-label="مساعد Cental">

    {{-- Header --}}
    <div class="cb-header">
        <div class="cb-avatar"><i class="fas fa-robot"></i></div>
        <div class="cb-header-info">
            <div class="cb-name">مساعد Cental</div>
            <div class="cb-status">● متاح الآن · يساعدك في اختيار سيارتك</div>
        </div>
        <button class="cb-close" id="cb-close-btn" aria-label="إغلاق"><i class="fas fa-times"></i></button>
    </div>

    {{-- Messages --}}
    <div id="cb-messages">
        <div class="cb-msg-wrap bot">
            <div class="cb-bubble bot">
                أهلاً بك في Cental! 🚗<br>
                أنا مساعدك الذكي. أخبرني ماذا تبحث عن، إيجار أم شراء؟
            </div>
            <div class="cb-time">الآن</div>
        </div>
    </div>

    {{-- Quick Replies --}}
    <div id="cb-quick">
        <button onclick="cbSendQuick('ما هي السيارات المتاحة للإيجار؟')">🚗 للإيجار</button>
        <button onclick="cbSendQuick('ما هي السيارات المتاحة للبيع؟')">💰 للبيع</button>
        <button onclick="cbSendQuick('ما هي أرخص سيارة عندكم؟')">💸 أرخص سيارة</button>
        <button onclick="cbSendQuick('قارن بين السيارات المتاحة')">📊 مقارنة</button>
    </div>

    {{-- Input --}}
    <div class="cb-input-row">
        <input type="text"
               id="cb-input"
               placeholder="اكتب سؤالك..."
               maxlength="500"
               autocomplete="off" />
        <button class="cb-send" id="cb-send" aria-label="إرسال">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

{{-- ══ JS ═══════════════════════════════════════════════════════ --}}
<script>
(function () {
    /* ─── عناصر DOM ─── */
    const toggle   = document.getElementById('cb-toggle');
    const window_  = document.getElementById('cb-window');
    const closeBtn = document.getElementById('cb-close-btn');
    const messages = document.getElementById('cb-messages');
    const input    = document.getElementById('cb-input');
    const sendBtn  = document.getElementById('cb-send');
    const quick    = document.getElementById('cb-quick');
    const badge    = document.getElementById('cb-badge');
    const csrf     = document.querySelector('meta[name="csrf-token"]').content;

    let history = [];          // تاريخ المحادثة
    let isOpen  = false;

    /* ─── فتح / إغلاق ─── */
    function openChat() {
        window_.classList.remove('cb-hidden');
        badge.style.display = 'none';
        isOpen = true;
        input.focus();
    }
    function closeChat() {
        window_.classList.add('cb-hidden');
        isOpen = false;
    }

    toggle.addEventListener('click', () => isOpen ? closeChat() : openChat());
    closeBtn.addEventListener('click', closeChat);

    /* ─── إرسال بـ Enter ─── */
    input.addEventListener('keypress', e => {
        if (e.key === 'Enter' && !sendBtn.disabled) cbSend();
    });
    sendBtn.addEventListener('click', cbSend);

    /* ─── اقتراح سريع ─── */
    window.cbSendQuick = function(text) {
        input.value = text;
        cbSend();
    };

    /* ─── الدالة الرئيسية ─── */
    function cbSend() {
        const msg = input.value.trim();
        if (!msg) return;

        quick.style.display = 'none';   // إخفاء الأسئلة السريعة
        appendMsg(msg, 'user');
        history.push({ role: 'user', content: msg });

        input.value      = '';
        sendBtn.disabled = true;

        const typingId = showTyping();

        fetch('{{ route("welcome.chatbot.message") }}', {
            method: 'POST',
            headers: {
                'Content-Type' : 'application/json',
                'X-CSRF-TOKEN'  : csrf,
                'Accept'        : 'application/json',
            },
            body: JSON.stringify({
                message : msg,
                history : history.slice(-8),   // آخر 8 رسائل فقط
            }),
        })
        .then(r => r.json())
        .then(data => {
            removeTyping(typingId);
            const reply = data.message || 'عذراً، لم أتمكن من الإجابة.';
            appendMsg(reply, 'bot');
            history.push({ role: 'assistant', content: reply });
        })
        .catch(() => {
            removeTyping(typingId);
            appendMsg('تعذّر الاتصال بالخادم. تحقق من الإنترنت وحاول مجدداً.', 'bot');
        })
        .finally(() => {
            sendBtn.disabled = false;
            input.focus();
        });
    }

    /* ─── إضافة فقاعة ─── */
    function appendMsg(text, side) {
        const wrap = document.createElement('div');
        wrap.className = 'cb-msg-wrap ' + side;

        const bubble = document.createElement('div');
        bubble.className = 'cb-bubble ' + side;
        bubble.textContent = text;

        const time = document.createElement('div');
        time.className = 'cb-time';
        time.textContent = new Date().toLocaleTimeString('ar', { hour: '2-digit', minute: '2-digit' });

        wrap.appendChild(bubble);
        wrap.appendChild(time);
        messages.appendChild(wrap);
        messages.scrollTop = messages.scrollHeight;

        /* إذا كانت النافذة مغلقة أظهر الـ badge */
        if (!isOpen && side === 'bot') badge.style.display = 'block';
    }

    /* ─── مؤشر الكتابة ─── */
    function showTyping() {
        const id = 'cb-typing-' + Date.now();
        const wrap = document.createElement('div');
        wrap.id = id;
        wrap.className = 'cb-msg-wrap bot';
        wrap.innerHTML = `<div class="cb-bubble bot cb-typing"><span></span><span></span><span></span></div>`;
        messages.appendChild(wrap);
        messages.scrollTop = messages.scrollHeight;
        return id;
    }
    function removeTyping(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

})();
</script>

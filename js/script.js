// =======================================
// MEU CADERNO DE ESTUDOS
// script.js (com animações de XP / nível)
// =======================================

// Depuração: confirmar carregamento do arquivo em navegadores (Edge test)
console.log('js/script.js carregado — depuração Edge');

// Aguarda o carregamento da página
document.addEventListener("DOMContentLoaded", () => {

    // ============================
    // ELEMENTOS E CONFIG
    // ============================
    const formulario = document.getElementById("formPergunta");
    const btnPesquisar = document.getElementById("btnPesquisar");
    const resultado = document.getElementById("resultadoPesquisa");
    const respostaTextarea = document.getElementById("resposta");
    const quillEditor = window.quillEditor || null;

    const nivelEl = document.getElementById('nivel');
    const xpEl = document.getElementById('xp');
    const xpToNextEl = document.getElementById('xpToNext');
    const xpBar = document.getElementById('xpBar');
    const xpNotifications = document.getElementById('xpNotifications');

    // valores prévios para detectar mudanças
    let prevXp = xpEl ? parseInt(xpEl.textContent || '0', 10) : 0;
    let prevNivel = nivelEl ? parseInt(nivelEl.textContent || '0', 10) : 0;

    // ============================
    // FUNÇÕES DE UI E ANIMAÇÃO
    // ============================
    const showXpGain = (amount) => {
        if (!xpNotifications) return;
        const el = document.createElement('div');
        el.className = 'xp-gain';
        el.textContent = `+${amount} XP`;
        const offset = Math.floor(Math.random() * 40);
        el.style.right = `${8 + offset}px`;
        xpNotifications.appendChild(el);
        el.addEventListener('animationend', () => {
            try { el.remove(); } catch (e) { if (el.parentNode) el.parentNode.removeChild(el); }
        });
        setTimeout(() => { if (el.parentNode) el.remove(); }, 1800);
    };

    const showLevelToast = (nivel) => {
        const t = document.createElement('div');
        t.className = 'xp-toast';
        t.textContent = `Nível ${nivel}! 🎉`;
        document.body.appendChild(t);
        setTimeout(() => {
            t.style.opacity = 0;
            setTimeout(()=>{ try{ t.remove(); }catch(e){} }, 400);
        }, 2200);
    };

    // ============================
    // CADASTRO
    // ============================
    if (formulario) {
        const clearFieldErrors = () => {
            ['pergunta', 'resposta', 'categoria'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.classList.remove('input-error');
                const ferr = document.getElementById('error-' + id);
                if (ferr) ferr.textContent = '';
            });
        };

        const showFieldError = (id, msg) => {
            const el = document.getElementById(id);
            if (el) el.classList.add('input-error');
            let ferr = document.getElementById('error-' + id);
            if (!ferr) {
                ferr = document.createElement('div');
                ferr.id = 'error-' + id;
                ferr.className = 'field-error';
                el && el.parentNode && el.parentNode.appendChild(ferr);
            }
            ferr.textContent = msg;
        };

        const showToast = (msg, type = 'success') => {
            const t = document.createElement('div');
            t.className = 'app-toast ' + (type === 'error' ? 'error' : 'success');
            t.textContent = msg;
            document.body.appendChild(t);
            setTimeout(() => { t.style.opacity = '1'; }, 50);
            setTimeout(() => { t.style.opacity = '0'; setTimeout(()=>t.remove(), 420); }, 2600);
        };

        formulario.addEventListener("submit", async function (e) {
            e.preventDefault();
            clearFieldErrors();
            const perguntaEl = document.getElementById("pergunta");
            const categoriaEl = document.getElementById("categoria");
            const pergunta = perguntaEl ? perguntaEl.value.trim() : '';
            const categoria = categoriaEl ? categoriaEl.value.trim() : '';
            let respostaText = '';
            if (quillEditor) {
                respostaText = quillEditor.getText().trim();
                respostaTextarea.value = quillEditor.root.innerHTML;
            } else {
                respostaText = document.getElementById("resposta").value.trim();
            }

            let hasError = false;
            if (!pergunta) { showFieldError('pergunta', 'A pergunta é obrigatória.'); hasError = true; }
            if (!respostaText) { showFieldError('resposta', 'A resposta não pode ficar vazia.'); hasError = true; }
            if (!categoria) { showFieldError('categoria', 'A categoria é obrigatória.'); hasError = true; }
            if (hasError) {
                const firstErr = document.querySelector('.input-error');
                if (firstErr) firstErr.focus();
                showToast('Corrija os erros antes de enviar.', 'error');
                return;
            }

            // disable submit
            const submitBtn = formulario.querySelector('button[type="submit"]');
            const prevText = submitBtn ? submitBtn.textContent : null;
            if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = 'Salvando...'; }

            const formData = new FormData(formulario);
            try {
                const response = await fetch(formulario.action, { method: formulario.method || 'POST', body: formData });
                const text = await response.text();
                if (response.ok) {
                    showToast(text.trim() || 'Pergunta cadastrada com sucesso!', 'success');
                    formulario.reset();
                    try { window.__enviarAcaoProgresso && window.__enviarAcaoProgresso('cadastro'); } catch(e){}
                    setTimeout(() => { window.location.href = 'index.php'; }, 900);
                } else {
                    showToast('Erro ao salvar: ' + text.trim(), 'error');
                    if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = prevText; }
                }
            } catch (err) {
                showToast('Erro de conexão: ' + err.message, 'error');
                if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = prevText; }
            }
        });
    }

    // ============================
    // PESQUISA
    // ============================
    const ativarBotoesMostrarResposta = () => {
        if (!resultado) return;
        const botoesMostrar = resultado.querySelectorAll('.btn-mostrar-resposta');
        botoesMostrar.forEach((btn) => {
            btn.addEventListener('click', () => {
                const respostaOculta = btn.nextElementSibling;
                if (respostaOculta) {
                    const estaVisivel = respostaOculta.style.display === 'block';
                    respostaOculta.style.display = estaVisivel ? 'none' : 'block';
                    btn.textContent = estaVisivel ? 'Mostrar resposta' : 'Ocultar resposta';
                    if (!estaVisivel) {
                        try { window.__enviarAcaoProgresso && window.__enviarAcaoProgresso('revisao'); } catch(e){}
                    }
                }
            });
        });
    };

    const carregarResultados = async (busca = '') => {
        if (!resultado) return;
        try {
            const res = await fetch(`php/pesquisar.php?busca=${encodeURIComponent(busca)}`);
            const html = await res.text();
            resultado.innerHTML = `<h2>Resultados</h2>${html}`;
            ativarBotoesMostrarResposta();
        } catch (err) {
            resultado.innerHTML = `<h2>Resultados</h2><p>Erro: ${err.message}</p>`;
        }
    };

    if (btnPesquisar) {
        btnPesquisar.addEventListener('click', () => {
            const buscarInput = document.getElementById('buscar');
            const texto = buscarInput ? buscarInput.value.trim() : '';
            carregarResultados(texto);
        });
    }

    if (resultado) carregarResultados('');

    // ============================
    // PROGRESSO (XP / NIVEL)
    // ============================
    const atualizarProgressoDOM = (data) => {
        if (!data) return;
        const nivelVal = parseInt(data.nivel) || 0;
        const xpVal = parseInt(data.xp) || 0;
        const xpNext = parseInt(data.xp_to_next || data.xpToNext) || 100;

        const diffXp = xpVal - prevXp;
        if (diffXp > 0) showXpGain(diffXp);

        if (nivelVal > prevNivel) {
            try {
                if (nivelEl) {
                    nivelEl.classList.add('pulse');
                    const _rm = () => { nivelEl.classList.remove('pulse'); nivelEl.removeEventListener('animationend', _rm); };
                    nivelEl.addEventListener('animationend', _rm);
                }
                showLevelToast(nivelVal);
            } catch(e){}
        }

        if (nivelEl) nivelEl.textContent = nivelVal;
        if (xpEl) xpEl.textContent = xpVal;
        if (xpToNextEl) xpToNextEl.textContent = xpNext;
        if (xpBar && xpNext > 0) xpBar.style.width = Math.round((xpVal / xpNext) * 100) + '%';

        prevXp = xpVal;
        prevNivel = nivelVal;
    };

    const fetchProgresso = async () => {
        try {
            const res = await fetch('php/progresso.php', { cache: 'no-store' });
            const json = await res.json();
            atualizarProgressoDOM(json);
        } catch (err) {
            console.error('Erro ao buscar progresso', err);
        }
    };

    // busca inicial
    fetchProgresso();

    const enviarAcaoProgresso = async (action) => {
        try {
            const body = new URLSearchParams();
            body.append('action', action);
            const res = await fetch('php/progresso.php', { method: 'POST', body, cache: 'no-store' });
            const json = await res.json();
            atualizarProgressoDOM(json);
            return json;
        } catch (err) {
            console.error('Erro ao enviar ação de progresso', err);
            return null;
        }
    };

    // Expor função global
    window.__enviarAcaoProgresso = enviarAcaoProgresso;

});
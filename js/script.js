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
        formulario.addEventListener("submit", async function (e) {
            e.preventDefault();
            const pergunta = document.getElementById("pergunta").value.trim();
            const categoria = document.getElementById("categoria").value.trim();
            let resposta = '';
            if (quillEditor) {
                resposta = quillEditor.getText().trim();
                respostaTextarea.value = quillEditor.root.innerHTML;
            } else {
                resposta = document.getElementById("resposta").value.trim();
            }
            if (!pergunta || !resposta || !categoria) {
                alert('Preencha todos os campos.');
                return;
            }
            const formData = new FormData(formulario);
            try {
                const response = await fetch(formulario.action, { method: formulario.method || 'POST', body: formData });
                const text = await response.text();
                if (response.ok) {
                    alert(text.trim() || 'Pergunta cadastrada com sucesso!');
                    formulario.reset();
                    try { window.__enviarAcaoProgresso && window.__enviarAcaoProgresso('cadastro'); } catch(e){}
                } else {
                    alert('Erro ao salvar: ' + text.trim());
                }
                setTimeout(() => { window.location.href = 'index.php'; }, 600);
            } catch (err) {
                alert('Erro de conexão: ' + err.message);
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
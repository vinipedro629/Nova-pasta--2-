// =======================================
// MEU CADERNO DE ESTUDOS
// script.js
// =======================================

// Aguarda o carregamento da página
document.addEventListener("DOMContentLoaded", () => {

    console.log("Sistema iniciado!");

    // ============================
    // FORMULÁRIO DE CADASTRO
    // ============================

    const formulario = document.getElementById("formPergunta");

    if (formulario) {

        formulario.addEventListener("submit", async function (e) {

            e.preventDefault();

            const pergunta = document.getElementById("pergunta").value.trim();
            const resposta = document.getElementById("resposta").value.trim();
            const categoria = document.getElementById("categoria").value.trim();

            if (pergunta === "") {
                alert("Digite uma pergunta.");
                return;
            }

            if (resposta === "") {
                alert("Digite uma resposta.");
                return;
            }

            if (categoria === "") {
                alert("Selecione uma categoria.");
                return;
            }

            const formData = new FormData(formulario);

            try {
                const response = await fetch(formulario.action, {
                    method: formulario.method || "POST",
                    body: formData
                });
                const text = await response.text();

                if (response.ok) {
                    alert(text.trim() || "Pergunta cadastrada com sucesso!");
                    formulario.reset();
                } else {
                    alert("Erro ao salvar pergunta: " + text.trim());
                }
            } catch (error) {
                alert("Erro de conexão: " + error.message);
            }

        });

    }

    // ============================
    // PESQUISA
    // ============================

    const btnPesquisar = document.getElementById("btnPesquisar");
    const resultado = document.getElementById("resultadoPesquisa");

    const ativarBotoesMostrarResposta = () => {
        const botoesMostrar = resultado.querySelectorAll('.btn-mostrar-resposta');
        botoesMostrar.forEach((btn) => {
            btn.addEventListener('click', () => {
                const respostaOculta = btn.nextElementSibling;
                if (respostaOculta) {
                    const estaVisivel = respostaOculta.style.display === 'block';
                    respostaOculta.style.display = estaVisivel ? 'none' : 'block';
                    btn.textContent = estaVisivel ? 'Mostrar resposta' : 'Ocultar resposta';
                }
            });
        });
    };

    const carregarResultados = async (busca = "") => {
        try {
            const response = await fetch(`php/pesquisar.php?busca=${encodeURIComponent(busca)}`);
            const html = await response.text();
            resultado.innerHTML = `<h2>Resultados</h2>${html}`;
            ativarBotoesMostrarResposta();
        } catch (error) {
            resultado.innerHTML = `<h2>Resultados</h2><p>Erro ao buscar: ${error.message}</p>`;
        }
    };

    if (btnPesquisar) {

        btnPesquisar.addEventListener("click", async () => {
            const buscarInput = document.getElementById("buscar");
            const texto = buscarInput.value.trim();
            carregarResultados(texto);
        });

    }

    if (resultado) {
        carregarResultados("");
    }

});
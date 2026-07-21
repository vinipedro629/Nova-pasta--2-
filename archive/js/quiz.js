// Arquivo de backup: js/quiz.js (ARCHIVE)
// ===========================================
// QUIZ - Meu Caderno de Estudos
// ===========================================

let perguntas = [];
let indiceAtual = 0;

const perguntaQuiz = document.getElementById("perguntaQuiz");
const respostaCorreta = document.getElementById("respostaCorreta");
const respostaUsuario = document.getElementById("respostaUsuario");
const btnMostrarResposta = document.getElementById("btnMostrarResposta");
const btnProxima = document.getElementById("btnProxima");

function atualizarPergunta() {
    if (perguntas.length === 0) {
        perguntaQuiz.textContent = "Nenhuma pergunta disponível.";
        respostaCorreta.innerHTML = `<h2>Resposta Correta</h2><p>Cadastre perguntas no sistema para jogar o quiz.</p>`;
        return;
    }

    perguntaQuiz.textContent = perguntas[indiceAtual].pergunta;
    respostaCorreta.innerHTML = `
        <h2>Resposta Correta</h2>
        <p style="display:none;" id="textoResposta">
            ${perguntas[indiceAtual].resposta}
        </p>
    `;
    if (respostaUsuario) {
        respostaUsuario.value = "";
    }
}

async function carregarPerguntas() {
    try {
        const response = await fetch("php/quiz.php");
        if (!response.ok) {
            throw new Error("Erro ao carregar perguntas.");
        }
        perguntas = await response.json();
    } catch (error) {
        perguntas = [
            {
                pergunta: "O que é HTML?",
                resposta: "HTML é uma linguagem de marcação utilizada para estruturar páginas da web."
            },
            {
                pergunta: "O que é CSS?",
                resposta: "CSS é utilizado para estilizar páginas da web."
            },
            {
                pergunta: "O que é JavaScript?",
                resposta: "JavaScript é uma linguagem de programação utilizada para adicionar interatividade às páginas."
            },
            {
                pergunta: "O que é PHP?",
                resposta: "PHP é uma linguagem de programação executada no servidor."
            }
        ];
        console.error(error);
    }

    atualizarPergunta();
}

if (btnMostrarResposta) {
    btnMostrarResposta.addEventListener("click", () => {
        const texto = document.getElementById("textoResposta");
        if (texto) {
            texto.style.display = "block";
        }
    });
}

if (btnProxima) {
    btnProxima.addEventListener("click", () => {
        if (perguntas.length === 0) {
            return;
        }
        indiceAtual = (indiceAtual + 1) % perguntas.length;
        atualizarPergunta();
    });
}

carregarPerguntas();

btnMostrarResposta.addEventListener("click", () => {

    const texto = document.getElementById("textoResposta");

    texto.style.display = "block";

});

// =============================
// Próxima pergunta
// =============================

btnProxima.addEventListener("click", () => {

    indiceAtual++;

    if (indiceAtual >= perguntas.length) {

        indiceAtual = 0;

    }

    carregarPergunta();

});

// =============================
// Iniciar Quiz
// =============================

carregarPergunta();

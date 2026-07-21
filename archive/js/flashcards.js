// Arquivo de backup: js/flashcards.js (ARCHIVE)
// ===========================================
// Flashcards - Meu Caderno de Estudos
// ===========================================

let flashcards = [];
let flashcardIndex = 0;
let versoVisivel = false;

const perguntaFlashcard = document.getElementById("perguntaFlashcard");
const respostaFlashcard = document.getElementById("respostaFlashcard");
const btnVirar = document.getElementById("btnVirar");
const btnAnterior = document.getElementById("btnAnterior");
const btnProximo = document.getElementById("btnProximo");
const flashcardElemento = document.querySelector(".flashcard");

function atualizarFlashcard() {
    if (flashcards.length === 0) {
        perguntaFlashcard.textContent = "Nenhuma pergunta disponível.";
        respostaFlashcard.textContent = "Cadastre perguntas para usar os flashcards.";
        flashcardElemento.classList.remove("virado");
        return;
    }

    perguntaFlashcard.textContent = flashcards[flashcardIndex].pergunta;
    respostaFlashcard.textContent = flashcards[flashcardIndex].resposta;
    versoVisivel = false;
    flashcardElemento.classList.remove("virado");
}

async function carregarFlashcards() {
    try {
        const response = await fetch("php/quiz.php");
        if (!response.ok) {
            throw new Error("Não foi possível carregar os flashcards.");
        }
        flashcards = await response.json();
    } catch (error) {
        flashcards = [
            { pergunta: "O que é HTML?", resposta: "HTML é uma linguagem de marcação utilizada para estruturar páginas da web." },
            { pergunta: "O que é CSS?", resposta: "CSS é utilizado para estilizar páginas da web." },
            { pergunta: "O que é JavaScript?", resposta: "JavaScript é uma linguagem de programação utilizada para adicionar interatividade às páginas." },
            { pergunta: "O que é PHP?", resposta: "PHP é uma linguagem de programação executada no servidor." }
        ];
        console.error(error);
    }

    atualizarFlashcard();
}

if (btnVirar) {
    btnVirar.addEventListener("click", () => {
        versoVisivel = !versoVisivel;
        flashcardElemento.classList.toggle("virado", versoVisivel);
    });
}

if (btnAnterior) {
    btnAnterior.addEventListener("click", () => {
        if (flashcards.length === 0) return;
        flashcardIndex = (flashcardIndex - 1 + flashcards.length) % flashcards.length;
        atualizarFlashcard();
    });
}

if (btnProximo) {
    btnProximo.addEventListener("click", () => {
        if (flashcards.length === 0) return;
        flashcardIndex = (flashcardIndex + 1) % flashcards.length;
        atualizarFlashcard();
    });
}

carregarFlashcards();

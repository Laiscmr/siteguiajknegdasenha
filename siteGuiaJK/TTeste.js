const questions = [
    { course: "Informática", question: "Você se sente confortável em resolver problemas complexos e lógicos?" },
    { course: "Administração", question: "Você se vê atuando em um papel de liderança, tomando decisões estratégicas e motivando uma equipe?" },
    { course: "Turismo", question: "Você tem interesse em conhecer novas culturas e trabalhar com pessoas de diferentes origens?" },
    { course: "Eletrotécnica", question: "Você se sente confortável em trabalhar tanto em ambientes internos quanto externos, lidando com equipamentos técnicos?" },
    { course: "Análises Clínicas", question: "Você gosta de realizar trabalhos meticulosos e tem paciência para seguir procedimentos rigorosos?" }
];

let currentQuestionIndex = 0;
let scores = {
    "Informática": 0,
    "Administração": 0,
    "Turismo": 0,
    "Eletrotécnica": 0,
    "Análises Clínicas": 0
};
let noAnswers = 0;

function renderQuestion() {
    if (currentQuestionIndex >= questions.length) {
        showResult();
        return;
    }

    const questionContainer = document.getElementById('question-container');
    questionContainer.innerHTML = `
        <p>${questions[currentQuestionIndex].question}</p>
        <button onclick="answerQuestion('não')">Não</button>
        <button onclick="answerQuestion('não sei')">Não sei</button>
        <button onclick="answerQuestion('sim')">Sim</button>
    `;

    const progress = document.getElementById('progress');
    progress.style.width = ((currentQuestionIndex / questions.length) * 100) + '%';
}

function answerQuestion(answer) {
    if (answer === 'sim') {
        const course = questions[currentQuestionIndex].course;
        scores[course]++;
    } else if (answer === 'não sei') {
        noAnswers++;
    }
    currentQuestionIndex++;
    renderQuestion();
}

function showResult() {
    const quizContainer = document.getElementById('quiz-container');
    const resultContainer = document.getElementById('result-container');
    quizContainer.style.display = 'none';
    resultContainer.style.display = 'block';

    const result = document.getElementById('result');

    if (noAnswers === questions.length) {
        result.textContent = "Não conseguimos calcular uma resposta, devido a falta de respostas exatas";
        return;
    }

    let recommendedCourse = '';
    let maxScore = 0;
    for (const course in scores) {
        if (scores[course] > maxScore) {
            maxScore = scores[course];
            recommendedCourse = course;
        }
    }

    result.textContent = recommendedCourse ? recommendedCourse : "Não conseguimos calcular uma resposta, devido a falta de respostas exatas";
}

function nextQuestion() {
    renderQuestion();
}

function restartQuiz() {
    currentQuestionIndex = 0;
    noAnswers = 0;
    scores = {
        "Informática": 0,
        "Administração": 0,
        "Turismo": 0,
        "Eletrotécnica": 0,
        "Análises Clínicas": 0
    };
    document.getElementById('quiz-container').style.display = 'block';
    document.getElementById('result-container').style.display = 'none';
    renderQuestion();
}

document.addEventListener('DOMContentLoaded', () => {
    renderQuestion();
});
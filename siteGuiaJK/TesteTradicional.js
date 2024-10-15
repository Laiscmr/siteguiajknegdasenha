const questions = [
    { course: "Informática", question: "Você se sente confortável em resolver problemas complexos e lógicos?" },
    { course: "Informática", question: "Se interessa em aprender e se atualizar constantemente sobre novas tecnologias?" },
    { course: "Administração", question: "Você gosta de organizar e gerenciar recursos, pessoas e processos para atingir objetivos específicos?" },
    { course: "Administração", question: "Você se vê atuando em um papel de liderança, tomando decisões estratégicas e motivando uma equipe?" },
    { course: "turismo", question: "Você tem interesse em conhecer novas culturas e trabalhar com pessoas de diferentes origens?" },
    { course: "turismo", question: "Você se sente à vontade organizando viagens e eventos?" },
    { course: "Eletrotécnica", question: "Você gosta de descobrir como as coisas funcionam e se interessa por tecnologias relacionadas à eletricidade?" },
    { course: "Eletrotécnica", question: "Você se sente confortável em trabalhar tanto em ambientes internos quanto externos?" },
    { course: "Análises Clínicas", question: "Você se interessa por biologia e química e gosta de entender os processos do corpo humano?" },
    { course: "Análises Clínicas", question: "Você gosta de realizar trabalhos meticulosos e tem paciência para seguir procedimentos rigorosos?" },
    { course: "Informática", question: "Você gosta de trabalhar com computadores e se sente à vontade com tecnologia?" },
    { course: "Informática", question: "Você tem interesse em aprender como resolver problemas técnicos e encontrar soluções criativas?" },
    { course: "administração", question: "Você se sente confortável em organizar e coordenar atividades para atingir objetivos?" },
    { course: "administração", question: "Você gosta de trabalhar com planejamento e de pensar em estratégias para alcançar metas?" },
    { course: "turismo", question: "Você se interessa em ajudar as pessoas a aproveitar novas experiências e explorar diferentes lugares?" },
    { course: "turismo", question: "Você se sente realizado ao ajudar a planejar e executar experiências que proporcionem momentos inesquecíveis para os outros?" },
    { course: "Eletrotécnica", question: "Você gosta de trabalhar com sistemas e equipamentos que exigem habilidades técnicas e analíticas?" },
    { course: "Eletrotécnica", question: "Você se sente atraído por áreas que envolvem a aplicação prática de conhecimentos técnicos para resolver problemas?" },
    { course: "Análises Clínicas", question: "Você gosta de participar de processos que envolvem a coleta e análise de informações para obter resultados significativos?" },
    { course: "Análises Clínicas", question: "Você aprecia atividades que envolvem a organização e a gestão de informações complexas?" }
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
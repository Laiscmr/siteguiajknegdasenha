// Adicionar nova pergunta
document.getElementById('add-question-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const course = document.getElementById('course').value;
    const question = document.getElementById('question').value;
    // Enviar requisição para o servidor para adicionar a pergunta
    fetch('/add-question', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ course, question }),
    })
    .then((response) => response.json())
    .then((data) => {
      // Atualizar a tabela com a nova pergunta
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td>${data.id}</td>
        <td>${data.course}</td>
        <td>${data.question}</td>
        <td>
          <button class="edit-btn">Editar</button>
          <button class="delete-btn">Excluir</button>
        </td>
      `;
      document.getElementById('questions-tbody').appendChild(newRow);
    })
    .catch((error) => console.error(error));
  });
  
  // Editar pergunta existente
  document.getElementById('edit-question-form').addEventListener('submit', (e) => {
    e.preventDefault();
    const id = document.getElementById('id').value;
    const course = document.getElementById('course').value;
    const question = document.getElementById('question').value;
    // Enviar requisição para o servidor para editar a pergunta
    fetch(`/edit-question/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ course, question }),
    })
    .then((response) => response.json())
    .then((data) => {
      // Atualizar a tabela com as alterações
      const row = document.getElementById(`question-${id}`);
      row.cells[1].textContent = data.course;
      row.cells[2].textContent = data.question;
    })
    .catch((error) => console.error(error));
  });
  
  // Excluir pergunta
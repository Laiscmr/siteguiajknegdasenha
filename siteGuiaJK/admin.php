<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table id="questions-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Curso</th>
            <th>Pergunta</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="questions-tbody">
          <!-- perguntas serão listadas aqui -->
          
        </tbody>
      </table>

      <!-- Formulário para adicionar nova pergunta -->
<form id="add-question-form">
  <label for="course">Curso:</label>
  <input type="text" id="course" name="course">
  <label for="question">Pergunta:</label>
  <input type="text" id="question" name="question">
  <button type="submit">Adicionar pergunta</button>
</form>

<!-- Formulário para editar pergunta existente -->
<form id="edit-question-form">
  <label for="course">Curso:</label>
  <input type="text" id="course" name="course">
  <label for="question">Pergunta:</label>
  <input type="text" id="question" name="question">
  <button type="submit">Salvar alterações</button>
</form>

<script src="admin.js"></script>
</body>
</html>
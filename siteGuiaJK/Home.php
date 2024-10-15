<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\Home.css" />
    <script src="js\sweetalert2.js"></script>
    <script src="js\custom.js"></script>
    <title>Guia JK</title>

    
</head>

<body>
    <?php
    session_start();
    include_once ("conexao.php");
    ?>
    <?php
    if (isset($_POST["submit"])) {
        $email = $_POST['email'];
        $confirma_email = $_POST["confirmar_email"];

        if ($email != $confirma_email) {
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'O e-mail não confere.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Fechar'
                    });
                });
            </script>
            <?php
        } else {
            // Prepare a consulta SQL para verificar se o e-mail existe
            $stmt = $conexao->prepare("SELECT * FROM usuario WHERE email =?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $num_rows = $result->num_rows;

            if ($num_rows == 0) {
                ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'Este e-mail não existe.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Fechar'
                        });
                    });
                </script>
                <?php
            } else {
                // Prepare a consulta SQL para excluir o usuário
                $stmt = $conexao->prepare("DELETE FROM usuario WHERE email =?");
                $stmt->bind_param("s", $email);
                if ($stmt->execute()) {
                    // Limpe a sessão e redirecione para a página de login com um parâmetro de sucesso
                    $_SESSION = array();
                    session_destroy();
                    ?>

                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: 'Conta excluída com sucesso!',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Fechar'
                        }).then(() => {
                            window.location.href = 'TelaLogin.php?account_deleted=true';
                        });
                    </script>
                    <?php
                    exit;

                } else {
                    echo "<div class='alert'>
                                    <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>×</span> 
                                    Erro ao excluir a conta: " . $conexao->error . "
                                </div>";
                }
            }
        }
    }
    ?>


    <?php
    if (isset($_POST["sair"])) {
        ?>
        <script>
            Swal.fire({
                title: "Você tem certeza que deseja sair?",
                icon: "question",
                iconHtml: "?",
                confirmButtonText: "Sair",
                cancelButtonText: "Voltar",
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonColor: '#FF0000'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Se o usuário clicou em SAIR, redireciona para TelaHome.php e exibe mensagem de sucesso
                    Swal.fire({
                        icon: 'success',
                        title: 'Você saiu com sucesso!',
                        text: 'Você foi desconectado com sucesso.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Fechar'
                    }).then(() => {
                        window.location.href = 'TelaHome.php';
                    });
                }
            });
        </script>
        <?php
    }

    $query = "SELECT id, foto FROM usuario";
    $dados = mysqli_query($conexao, $query);


    if ($dados) {

        while ($linha = mysqli_fetch_assoc($dados)) {

            $foto = $linha["foto"];
        }
    } else {

        echo "Erro ao recuperar dados do usuário!";
    }
    ?>




    <nav>

        <p id="guia">Guia </p>
        <h1 id="jk">JK</h1>

        <section id="ba5"></section>

        <div class="dropdown dropdown1">
            <?php if (!empty($foto)): ?>
                <img id="ze" src="<?php echo $foto; ?>" class="foto_perfil">
            <?php else: ?>
                Sem imagem
            <?php endif; ?>
            <div class="dropdown-content">

                <div class='text'>



                    <h1 id="pflais">Bem-vindo(a),<br> <?php echo $_SESSION['nome']; ?> ! </h1>
                </div>

                <section id="linhazinha"></section>
                <form method="post" action="Home.php" style="display: inline-block;">



                    <a id="eee" href="TelaEditar.php">
                        <div class="btn">Editar conta</div>
                    </a><br>
                    <button id="bugado" type="submit" name="sair" value="sair">Sair da conta</button><br><br>
                    <div onclick="abrirModal()" class="btn" id="eeee">Excluir conta</div><br>

                </form>

            </div>
        </div>
        <section id="link">


            <a href="#sec1">Teste Vocacional</a>
            <a href="#sec2">Mapa Escolar</a>
            <a href="#sec3">Sobre os Cursos</a>
            <a href="#sec4">Sobre a Escola</a>
        </section>

    </nav>

    <section id="sec1">
        <br>
        <br>

        <h2 id="tv">Teste Vocacional</h2>
        <section id="ba1"></section>
        <p>descubra em qual curso técnico você se encaixa! :D</p>
        <p>vamos lá?</p>

        <a href="TelaTeste.php">
            <input id="tvbt" type="submit" value="Descobrir">
        </a>
    </section>


    </section>
    <section id="sec2">

        <h2 id="mp">Mapa da Escola</h2>
        <section id="ba2"></section>
        <p>localização dos laboratórios e pontos importantes!!</p>
        <p>deseja ver?</p>

        <a href="MapaEscolar.php">
            <input id="mpbt" type="submit" value="Visualizar">
        </a>

    </section>
    <section id="sec3">

        <h2 id="sc">Nossos Cursos</h2>
        <section id="ba3"></section>
        <p>saiba mais sobre os nossos cursos profissionalizantes ;P</p>
        <p>Reforce seus conhecimentos!</p>
        <a href="TelaCurso.php">
            <input id="scbt" type="submit" value="Saber">
        </a>

    </section>
    <section id="sec4">

        <h2 id="se">Sobre a Escola</h2>
        <section id="ba4"></section>
        <p>Saiba mais sobre o Juscelino Kubitschek</p>
        <p>conheça a história</p>

        <a href="SobreEscola.php">
            <input id="sebt" type="submit" value="Saber">
        </a>
    </section>

    <div class="janela-modal" id="janela-modal">
        <div class="modal">
            <button class="fechar" id="fechar">X</button>
            <h1 id="cortxt">EXCLUIR CONTA</h1>

            <p id="corr">Ao excluir a sua conta você perde algumas funcionalidades do site como o Teste Vocacional</p>

            <p id="corr">Você tem certeza dessa escolha? D:</p>
            <div onclick="abrirModal2()" class="btn" href="" id="pa">
                <p id="pb">Excluir conta</a></p>
            </div>
        </div>
    </div>

    <div class="janela-modal2" id="janela-modal2">
        <div class="modal2">
            <button class="fechar" id="fechar">X</button>
            <h1 id="cortxt">EXCLUIR CONTA</h1>
            <form method="post" action="">
                <h3>E-mail:</h3>
                <label for="email"></label><br>
                <input id="cem" type="text" name="email" placeholder="Insira o seu E-mail"><img id="imgEmail"
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAd9JREFUSEvt1rmLFUEQx/HPeoYKYiDi8Q+ImIiYmGjmASLIggaaiCAimHgE3mggKBpsJoiKLCwLHpkGZgoGBmIoiiAGYqCJeDsF3TAOb2fmPYb3DLaj6e6q+lb9unu6x4yojY2IaxY8NOWrUh/AMazuOIO3OIcbOW4ZvAlPOgZWw63H8xgsg0/gQrI803ECp1K847hUBZ9GNtiL2x3B9+BWqaDg/FNxGRxzEziC7wMmsABXcbDkH0o2gsP+BbbhfZ/w5XiAdRW/WvAf3EFIFO0TxvGoJXwL7mJJso8ly7F6gmN9Q4YAz8FhXC423Hz8Tusfmy/me7XYqCeL5Yvg4f8DR4sErpd8WoEj+Abcx9JEeoxd+FwhL8IUNqfxD9iJZ6mfk22UOjLObRmmUxIx9g5b8TIZrMHD4uewMvUDth0fSzEGAof/PFzBoRTsW5HA/vQdf6OF6ftakvdnRZGBwTnObtwsgfL4V+zD5Azr3wocG2luzQ5eWxyTe1iVbF4Xx24HXtX4tAL/StLWnZ7FCFkjydj9XxqOWitwU8UNjJ7TrcBtKu4X/n+C87UY2Z3tt6QG+3zrBeNi2A77IbART6vg6McVFpf1io4rflOclPMzPX06ZtWHm31XD03ukUn9F8FMcB8KRgALAAAAAElFTkSuQmCC" /><br>
                <h3>Confirme o seu e-mail:</h3>
                <label for="confirmar_email"></label><br>
                <input id="cem" type="text" name="confirmar_email" placeholder="Confirme o seu E-mail"><img
                    id="imgConfirma"
                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAltJREFUSEvtlktIVVEUhr9bEUklhQQOjKImgZOoCKlQsaI3JA6bNGhYg4gKtZlGgeJAnTgQHCv0EKmo6EENgnwgPYmMIhoUhRRZgyja/2UdOZzuvft07sE7ccOFffZea/1n/etf69wMJVqZEuEyDzxnzKdF9RHgLLAOsuV7BVwABvNlkgbwOaAtD4Duzue6KxZ4C/DYAr8DLtu+CVhte9mMRcGLBb4G7ANeApuBHwawDJg06q8Ch9MGngZWAB0O9EwkeBdwEvgAVMUBVoA+5/Q1hsQ/AauATuB0xF5np4CPQKUPuMXEMA7UAd894PeBWquhahleT4FqF+cu0FAIeCEwCmw0o0fAbg/4AWDE7J8DN22/F9hg+/3AdV/GK4HbwCYzfAjsCYkmFwFiqd36N3z/B2gFLsZtp3LgFrDVHESVMhMjQ8AJ4HUkmBSteu6yc2WoGj/53wGyHLjhqNtmjtovtlpNubsa4HMM8eU1KdTH6kUBbo94TwA7AbWSloSzw9Va4hJbWuoIDY0HJq5/XsA3QMoc5RoS9SHBqebfgLVuOvXnUmwE5Q5wFHgfPvcBy1bgUu4Cp/qDrl9nrHdfABUWTGfP3Ifipz3LR6201J6/mMpnyxMHWL5LTLVB4GFH5SEDktiUea51DOi2l7/ixmhjYBQXOBx0jaPurR0ItNcjsuOOmR6z0ejUCE3010dvfckCrQfeeID1jVYnaIml7MBJknEwVuW/CPjtAZbNL7NpDgZKEmApVD+tQO0ebO6ZwYDrBv0SZewDiXWfJONYgX1G88A+hlK7LxnVfwGux2Ef9rA5ZwAAAABJRU5ErkJggg==" /><br>
                <br>


                <!-- Seus campos de entrada aqui -->
                <button type="submit" name="submit" class="btn" id="pad">Excluir conta</button>
            </form>
        </div>
    </div>






    <!-- Widget de Ajuda -->
    <div class="help-widget">
        <div class="help-icon">
            <img id="icone"
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAq9JREFUSEvFlkuIjlEYx3+DJApJGZFLIXJpRK4LShbEQiRRw4qyGHLJTBbul4hcVqwoJU2iDDYWlIVLI4kkuYUhUpgo5HL+Ou/0znHOe873fWqezXzN8/yf/znv+T+XKjrIqjqIl1KJOwNTgCFAf3voFuAZcAv4mXqRVOLhQAOwAOgdSP4BOAfsAZ7GDhAj7g7sBVYDum2KfQf2A9sB/fZaEfFg4CIwOoXNE3MbmGcO/c6HDxGPAq4DfcokzWCvganASzePj7gfcBPQjUMmIV22zjnApILY+1aQX/IxPuIzwOJAIql3EXDH8U8GzgPVAdxhYG0R8VjgXgDcCkwAHgf84+yX6ubxfwOGAm8yn3vjk6YUagOJNwAHrG8HsBT4AZwGttn/qwI2BfC7TfxmH3FX4D3QMwAcYW87AHjlxEgXUu90K0pfiifAMB/xLOBKgUhUm1+BMcBCJ24JIG2oo0kHIcsO365lLjfAEwWgkOs5MN6I56Npm3Nt7Ydi5wNNcubfeCOwr0TiB8DsnGguGYGpvEK2xvSGIy7xupx4UvhFOg34bIO3mL9bI8D1RkMHXWK9kxSaYr8BlY+ag3q41K7bxEz9odElVhO4EUNaf7N5q4n296FEUoULI2y7N9bJ3wJ9E8g/AXdtXA3QKwGjuT0Q0Nf6ZxE4BqxMSFJOyFGgLgO6nUsF/sjM0k6RzNeAmTbmKjAjEq/NRC2zbUr5hsQp06GW/Wfi46bkVuVz+oj1xhp7OmHIXuSazYrICH1ox2JWdn9zhhYB7VhSeKWLgASlanF7e+GWqb57wfbmcsSkslGLbBuFsU+d9/cAdlo1xgSX4bTgaTzuKnfZyx9gJFBv19vQ2NR6exbQ3JUGCi223rrgLnZ5G+Qs9Jq12ip/xQhDdZyKqziu1BtXTJgl+APXzHQfvEJE/QAAAABJRU5ErkJggg==" />
        </div>
        <div class="help-content">
            <h3>Sobre o Site</h3>
            <p id="fran">Criamos o site com o objetivo
                de ajudar os novos alunos. Oferecendo
                recursos auxiliadores.</p>
            <h3>Contacte-nos</h3>
            <p> Qualquer problema entre em contato pelo email abaixo.</p>
            <h3>guiaajk@gmail.com</h3>

        </div>
    </div>
    </div>

    <div class="main-content">
    </div>
    </div>

    <script src="Ajuda.js"></script>

    <script src="script.js"></script>

    

</body>

</html>
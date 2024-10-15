<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Mapaa.css" />
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
        <a href="Home.php">
            <p id="guia">Guia</p>
        </a>
        <a href="Home.php">
            <h1 id="jk">JK</h1>
        </a>
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







        <section id="link">
            <a id="at" href="TelaTeste.php">Teste Vocacional</a>
            <a id="at" href="MapaEscolar.php">Mapa Escolar</a>
            <a id="at" href="TelaCurso.php">Sobre os Cursos</a>
            <a id="at" href="SobreEscola.php">Sobre a Escola</a>
        </section>
    </nav>

    <section id="sec1">
        <br>
        <br>
        <h2 id="tv">MAPA ESCOLAR</h2>
        <p><strong>Novo aqui? Se liga no mapa para não se perder!</strong></p>
        <p>;D</p>

        <section id="sec2">
            <div class="carousel">
                <div class="carousel-container">
                    <a class="prev" onclick="changeSlide(-1)">&#10094;</a>
                    <a class="next" onclick="changeSlide(1)">&#10095;</a>
                    
                    <div class="carousel-images">
                        <div class="carousel-slide" data-text="Este é o nosso pátio principal, um espaço central e vibrante onde a comunidade se encontra. É o lugar ideal para desfrutar de um lanche, bater papo com amigos ou simplesmente relaxar.">
                            <img  src="WhatsApp Image 2024-08-25 at 12.14.20.jpeg" alt="patio1">
                        </div>
                        <div class="carousel-slide" data-text="À direita da entrada do pátio principal, você encontrará o nosso auditório, um espaço versátil e moderno destinado a eventos importantes. Seja para palestras inspiradoras, eventos e até mesmo apresentações culturais.">
                                <img  src="WhatsApp Image 2024-08-25 at 12.14.58.jpeg" alt="auditorio">
                        </div>
                        <div class="carousel-slide" data-text="No lado esquerdo do pátio principal, localiza-se nossa biblioteca, um refúgio de tranquilidade e conhecimento. Este é o espaço ideal para aqueles que buscam um ambiente calmo para ler, estudar ou simplesmente descansar.">
                            <img  src="WhatsApp Image 2024-08-25 at 12.14.19.jpeg" alt="biblioteca">
                        </div>
                        <div class="carousel-slide" data-text="qui você encontra a parte aberta do pátio, um espaço ao ar livre que combina a beleza natural com o conforto. Com áreas verdes e elementos naturais, este espaço oferece um ambiente relaxante e agradável.">
                            <img  src="WhatsApp Image 2024-08-25 at 12.14.21.jpeg" alt="patio2">
                        </div>
                        <div class="carousel-slide" data-text="Subindo as escadas e indo para a direita, veremos o laboratório 4 de informática.  Este espaço é dedicado ao aprendizado e ao desenvolvimento de habilidades tecnológicas, proporcionando um ambiente ideal para estudos, pesquisas e práticas.">
                            <img  src="WhatsApp Image 2024-08-10 at 23.06.11.jpeg" alt="lab4">
                        </div>
        
        
                       
                    </div>
                    <a class="next" onclick="changeSlide(1)">&#10095;</a>
                </div>
                <div class="carousel-thumbnails">
                    <img src="WhatsApp Image 2024-08-25 at 12.14.20.jpeg" alt="patio1" class="thumbnail" onclick="currentSlide(1)">
                    <img src="WhatsApp Image 2024-08-25 at 12.14.58.jpeg" alt="patio1" class="thumbnail" onclick="currentSlide(2)">
                    <img src="WhatsApp Image 2024-08-25 at 12.14.19.jpeg" alt="biblio" class="thumbnail" onclick="currentSlide(3)">
                    <img src="WhatsApp Image 2024-08-25 at 12.14.21.jpeg" alt="patio2" class="thumbnail" onclick="currentSlide(4)">
                    <img src="WhatsApp Image 2024-08-10 at 23.06.11.jpeg" alt="lab4" class="thumbnail" onclick="currentSlide(5)">
                    
                </div>
                <div class="carousel-text">
                    <p id="carousel-description">MAPA ESCOLAR</p>
                </div>
            </div>
        </section>
        
                <script src="Mapa.js"></script>
                <script src="script.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Escolaa.css" />
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
        <h2 id="tv">NOSSA ESCOLA</h2>
        <p><strong> Vem saber um pouco sobre a história da nossa escola<br>
        e sobre seus processos seletivos!</strong></p>
        <p>:D</p>
        
    </section>
    
    </section>
    
    <section id="sec2">
        <img id="info" src="https://th.bing.com/th/id/R.55d9438a6f9a408f09e4e25544c99d29?rik=ykC8lNBnpGBOaA&riu=http%3a%2f%2fphotos.wikimapia.org%2fp%2f00%2f02%2f26%2f21%2f82_full.jpeg&ehk=bxJvj1z2nRh7Bk%2bojD%2fSeS4R%2b3frOJN7REYW9UGgaZE%3d&risl=&pid=ImgRaw&r=0" alt="img">
        <h2 id="pp">HISTÓRIA</h2>
        <p id="ai">A Escola Técnica Estadual Juscelino Kubitschek foi criada em 1980 pelo Decreto 2755, durante o governo de Chagas Freitas.<br> Ela surgiu como parte de um programa conjunto entre o Ministério da Educação e o Banco Mundial, com o objetivo de atender<br> cinco escolas satélites. A inauguração ocorreu em 13 de março de 1980, com a presença do Governador Chagas Freitas<br> e do Ex-Presidente do Brasil Juscelino Kubitschek, acompanhado de sua esposa Sarah Kubitschek.</p>
           <br>
           <p id="ai"> Em 1998, a escola deixou de ser administrada pela Secretaria de Estado de Educação (SEEDUC-RJ)<br> e passou a ser mantida pela Fundação de Apoio à Escola Técnica (FAETEC), órgão vinculado<br> à Secretaria de Estado de Ciência e Tecnologia do Rio de Janeiro (SECTI-RJ).</p>
    </section>
    
    <section id="sec3">
        <img id="process" src="https://mmc.tirto.id/image/otf/600x0/2019/05/13/ilustrasi-ujian-istockphoto-1_ratio-16x9.jpg" alt="img">
        <h2 id="pp">PROCESSO SELETIVO</h2>
        <p id="ai">Para se inscrever em cursos técnicos na FAETEC, você deve acessar o site oficial da instituição,<br>
             cujas datas são divulgadas no site e nas redes sociais da FAETEC.<br>
              É importante acompanhar essas informações para não perder o prazo.</p>
        <br>
        <p id="ai">O processo seletivo para os cursos técnicos inclui uma prova objetiva,<br>
             que aborda 20 questões de Português e 20 questões de Matemática.<br> O que totaliza 40 questões de múltipla escolha.
        </p>
        <br>
        <p id="ai">você pode saber mais sobre os cursos aqui em nosso site e fazer nosso teste vocacional por curiosidade.<br>
            É importante ler o edital para melhores informações, boa sorte!
    
        </p>
    
    </section>
    
        <section id="sec4" class="container">
            
            <h2 id="pp">ATUALMENTE</h2>
            <p><strong>Um pouco dos projetos que fazem parte da nossa escola;</strong></p>
    
                <div class="slider-wrapper">
                    <div class="slider">
                        <img id="a" src="WhatsApp Image 2024-06-02 at 00.02.54.jpeg" alt="ana"/>
                        <img id="t" src="WhatsApp Image 2024-06-02 at 00.28.19.jpeg" alt="tur"/>
                    </div>
                    <div class="slider-nav">
                        <a href="#a"></a>
                        <a href="#t"></a>
                    </div>
                </div>
                <br>
            <p id="ai">Em nossa escola temos os projetos Gaia, JK sustentável e o DiárioJK.<br>
                       Gaia e o JK sustentável possuem foco na sustentabilidade e equidade de genero. Já o<br>
                       diário, é um jornal da escola que incentiva o aprendizado e a valorização da cultura.
            </p>
        
            <p id="ai">Alguns deles, como JK Sustentável, existem há muitos anos e fazem parte da história da escola.<br>
                 Foram iniciados eventos e subprojetos que se mantêm até hoje em dia.</p>
        </section>
        <section id="sec3">
           
            <h2 id="pp">LOCALIZAÇÃO</h2>
           <br>
           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3677.673020137668!2d-43.3212591249148!3d-22.8145767793201!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x997b3a1099806d%3A0xe3818904714795c!2sETE%20Juscelino%20Kubitschek!5e0!3m2!1sen!2sbr!4v1725217117892!5m2!1sen!2sbr" 
    width="600" 
    height="450" 
    style="border: 5px solid #000; border-radius: 25px;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
</iframe>

        </section>


        
    <script src="script.js"></script>


    
    </body>
    </html>
<!DOCTYPE html>
<html>

<head>
    <title>Tela de Cadastro</title>
    <link rel="stylesheet" type="text/css" href="css\Cadastro.css">
    <link rel="stylesheet" type="text/css" href="css\erro.css">
    <script src="js\sweetalert2.js"></script>
    <script src="js\custom.js"></script>


</head>

<body>
    <?php
    include_once ("conexao.php");
    if (isset($_POST["submit"])) {
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];
        $aluno = isset($_POST['aluno']) ? 1 : 0;
        $data_nasc = $_POST["data_nascimento"];
        $confirma_senha = $_POST["confirmar_senha"];

        // Verifique se o e-mail já existe
        $checkEmail = mysqli_query($conexao, "SELECT * FROM usuario WHERE email='$email'");
        if (mysqli_num_rows($checkEmail) > 0) {
            ?>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro',
                        text: 'Este e-mail já está cadastrado.',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Fechar'
                    });
                });
            </script>
            <?php
        } else if ($senha != $confirma_senha) {
            ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Erro',
                            text: 'As senhas não conferem.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Fechar'
                        });
                    });
                </script>
            <?php
        } else {
            // Trata o upload de imagem
            // Checa se o upload foi realizado com sucesso
            if (isset($_FILES['foto']) && !empty($_FILES["foto"])) {
                $foto = "./uploads/" . $_FILES["foto"]["name"];
                move_uploaded_file($_FILES["foto"]["tmp_name"], $foto);
            } else {
                $foto - "";
            }

            // Insere os dados no banco de dados
            $result = mysqli_query($conexao, "INSERT INTO usuario (nome,email,aluno,data_nasc,senha,foto) 
        VALUES ('$nome','$email','$aluno','$data_nasc','$senha','$foto')");
            ?>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        Swal.fire({
                            icon: 'success',
                            title: 'Sucesso',
                            text: 'Cadastrado com sucesso!',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Fechar'
                        }).then(() => {
                            window.location.href = 'TelaLogin.php';
                        });
                    });
                </script>
            <?php
        }
    }
    ?>


    <form id="cad-usuario-form" action="TelaCadastro.php" method="post" enctype="multipart/form-data">

        <h1 id="cad">CADASTRO</h1>

        <label for="nome"></label><br>
        <input type="text" placeholder="Insira o seu nome" id="nome" name="nome" required><img id="User"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAlRJREFUSEvt1j2IE0EYBuD32yRmN4eQzM6FaxRRsTiQE6zsVBC0sFAObAQV9AQR7A5BS0UOOxX8ac5KBVEQBAsLrbQQRAW9SvxDCCSzCehl11yyn26Sg3iXZGY14Szcdt55n53d2R/CCh20Qi5iw8xs+Z43ScB4dNIMvHOEuEtEHGcRseCqUtsIuAlg0xJkLmQ+NCLlC1PcGPZLpZ0gegRgVY/yeQZ2ZVz3uQluBHOhMBKkUp8BCE3pF1uIjURU0+FGsK/UMQA3dGXtez6Zcd17uqwpfA3AcV1ZNE7ARdt1p3VZU/g6gCldWXOc+aoj5Qld1gwulc6A6JyurOkSnc4IMaPLGsE/lBoPgbe6suZjnUhscLLZD7qsERyV+ErNAjjcr5CBSxnXPaVD23vBJBbdOk77SkVvqL09ZszaQhwlotCk0XjFrX3DFCh1kIj2MXPrmSYqWMy301I+MAEXM7HgOMW67L8NV5VaYwH7GdgMYB2Yk7+tiKj+a+N9JObXIXA/I+XXv1pxrVyeaIThBQB7dEWd48z8MAFMp6Wc6zWv56UOPG+Kma8ASMVBO7I1EB1xhLjVbX5XuKrUAQLu/CHYOS0kYLftuo+Xdi2DvxUK+WQq9QmAPQA4qvDshYW1NDY239m3DK563mViPjkgtFXDfNaR8nxf2FeqCEAOEiail7YQW3vCQaWynhuN94NEF7vsRmM15fPfu7652j9zz4YBW0QTaSHedIX9YnE7LOvJMGCE4Q5ndPRpV7hcLmften3LMOAgmXyVy+Uq/z8Sw7i6fTt/AuAwuh+/dV6LAAAAAElFTkSuQmCC" /><br>
        <label for="email"></label><br>
        <input type="email" placeholder="Insira o seu E-mail" id="email" name="email" required><img id="imgEmail"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAfhJREFUSEvtlrtrFUEUxn9fUFMqBAsRH/+ASBoRGxvtfIAIImihjQRCEGxMLDRo0EJQtEgXEAURRPDRaWGnYJFCLENCIFiIhTbiAz/34GzYu9ybvY/l3iZTDTsz3++cb87sjBhQ04C4rIP75nyD1bYvAJeB3TVHsARclzSX666CbR8E3tYMLMvtk/QhPhbBU8BMmjldcwBXk96kpFtl8DUgn3BW0qM64LbPAA/zhCQFpyHjIjjGZoGLkn51E4DtTcBdYKywfrodcMyfB45KWukEbns78BIYLa2rBIfNYVG0r8BpSa/bgds+DDwGRtL8olZTcOzvf/8l2Z4AbmcFtxH4m/Z/JoaaBWA7CvVKtjwKcyjr/wYuSbpvO19TDQ5x2/uBF8DWBHsDnJT0rQi3vRl4ChxK3z8DJyS9TzprgleLKzLOhW1vA54BEUS0ZeCIpI9JdA/wCtiZxgN2TNKXgkbn4CS+AbgDjCexn1kA51M//kbDqX8v2fun5Eh34ELkp4AHBVA+9AM4J+lJi/3vDZyy35sdk+fArgRZyI7dcUmfWlV9VXE13eMWGWwBwtao9glJ39c6arWB2znPte5xp8Ceq7pbYLvgflyLU5JuRkD9fggckPSuAZyOSlxhk8COXu0trV8EbjR9+tQMqpRbf1dXWlTXhIFZ/Q90J+gf8FHAbQAAAABJRU5ErkJggg==" /><br>

        <label for="senha"></label><br>
        <input type="password" placeholder="Insira a sua senha" id="senha" name="senha" required><img id="imgSenha"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAfdJREFUSEvtlkFr1FAUhc9JpmPSgSmTl1QRFFEQt1bdKdRF3dUfIIJbcaHQhaC4EroUdSUuRfoDBEEEQWldFoo7FwoKhZZJXuyibYI1uZqhhUHTyZuO0EUnu8c793z33vdyE2KfHu4TF32DRaS2qfVZ27LOFUlnWbY46vtLJLN+ijAGiwhTre8JeZfAWDeEwI8ceDiq1BNTuDE4iaKXIK/3Mv6T0GNHqRkTuBE4ieNrEJnbNvwuIjO/6vX5Yl3b2pok8AjA8WJNkSnH999Vwc3AWn8FcLJo6c+RkdPNZjPqNl5vt4/Ytv0FQAPAR1epSwOD07W1U5JlhSkg8sD1/dky0ySOZyFyH0DuZNkYx8fXK46ld26bcXyRIgudNpLTjue9LotIw/CqWNarYi/P8wuNIFgcCJyE4SQs633HJM8vu0HwobRiQ91ObOUZHxzwRhhO0LavUOQMgBvbLXoB4NsuZ3eiWyfkZyHfNlqtpTJ9aatTre8IYDyFel4i8qbjec//1pSCkyhqgwyq3kXD/WVXqWNmYK3F0NRI5ir1T4HlFQ/BRg3dXTRsdWful87d4eU6CJdrFcDhAQvdCV9xlTpqNDLTKLot5NP/ASZ5y/G8Z0bgQrQRhuctcgrkob0kIGRaI9/UW61Pxp/FvYD6jan89enX0FT/GwfD2h9sTumdAAAAAElFTkSuQmCC" /><br>
            <div class="info">
                <div id="char-count" class="feed">Número de caracteres: Mínimo 8</div>
                <div id="uppercase" class="feed">Letras maiúscula: ABC</div>
                <div id="number" class="feed">Números: Entre 0 a 9</div>
                <div id="special-char" class="feed">Caracteres especiais: @$%&!</div>
            </div>
    

        <label for="confirmar_senha"></label><br>
        <input type="password" placeholder="Confirme a sua senha" id="confirmar_senha" name="confirmar_senha"
            required><img id="imgCSenha"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAfdJREFUSEvtlkFr1FAUhc9JpmPSgSmTl1QRFFEQt1bdKdRF3dUfIIJbcaHQhaC4EroUdSUuRfoDBEEEQWldFoo7FwoKhZZJXuyibYI1uZqhhUHTyZuO0EUnu8c793z33vdyE2KfHu4TF32DRaS2qfVZ27LOFUlnWbY46vtLJLN+ijAGiwhTre8JeZfAWDeEwI8ceDiq1BNTuDE4iaKXIK/3Mv6T0GNHqRkTuBE4ieNrEJnbNvwuIjO/6vX5Yl3b2pok8AjA8WJNkSnH999Vwc3AWn8FcLJo6c+RkdPNZjPqNl5vt4/Ytv0FQAPAR1epSwOD07W1U5JlhSkg8sD1/dky0ySOZyFyH0DuZNkYx8fXK46ld26bcXyRIgudNpLTjue9LotIw/CqWNarYi/P8wuNIFgcCJyE4SQs633HJM8vu0HwobRiQ91ObOUZHxzwRhhO0LavUOQMgBvbLXoB4NsuZ3eiWyfkZyHfNlqtpTJ9aatTre8IYDyFel4i8qbjec//1pSCkyhqgwyq3kXD/WVXqWNmYK3F0NRI5ir1T4HlFQ/BRg3dXTRsdWful87d4eU6CJdrFcDhAQvdCV9xlTpqNDLTKLot5NP/ASZ5y/G8Z0bgQrQRhuctcgrkob0kIGRaI9/UW61Pxp/FvYD6jan89enX0FT/GwfD2h9sTumdAAAAAElFTkSuQmCC" /><br>

        <br><label for="data_nascimento"></label>
        <p id="roxo">Data de Nascimento:</p>
        <input type="date" id="data_nascimento" name="data_nascimento" required><br>
        <br><label for="aluno"></label>
        <p id="roxo">É aluno da rede FAETEC?</p>

        <input type="checkbox" id="sim" name="aluno" value="sim"><br>
        <label for="sim"></label>
        <p id="roxo">Sim</p>




        <!--... outros campos do formulário... -->

        <p id="roxo">Insira uma imagem de perfil (opcional):</p>
        <input type="file" id="foto" name="foto" accept="image/*"><br><br>
        <input type="submit" name="submit" value="Cadastrar"><br>

    </form>

    <script>
    document.getElementById('senha').addEventListener('input', function() {
    const senha = this.value;
    
    // Verifica se a senha tem 8 ou mais caracteres
    if (senha.length >= 8) {
        document.getElementById('char-count').classList.add('valid');
    } else {
        document.getElementById('char-count').classList.remove('valid');
    }

    // Verifica se a senha tem ao menos uma letra maiúscula
    if (/[A-Z]/.test(senha)) {
        document.getElementById('uppercase').classList.add('valid');
    } else {
        document.getElementById('uppercase').classList.remove('valid');
    }

    // Verifica se a senha tem ao menos um número
    if (/\d/.test(senha)) {
        document.getElementById('number').classList.add('valid');
    } else {
        document.getElementById('number').classList.remove('valid');
    }

    // Verifica se a senha tem ao menos um caractere especial
    if (/[!@#$%^&*]/.test(senha)) {
        document.getElementById('special-char').classList.add('valid');
    } else {
        document.getElementById('special-char').classList.remove('valid');
    }

    // Verifica se todos os requisitos estão preenchidos
    const allValid = document.querySelectorAll('.valid').length === 4;
    document.querySelector('input[type="submit"]').disabled = !allValid;
});

    </script>





</body>

</html>
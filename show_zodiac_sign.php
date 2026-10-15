<?php
include('layouts/header.php');

$signo_encontrado = null;
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && !empty($_POST['data_nascimento'])) {

    $data_nascimento = $_POST['data_nascimento'];
    $data = DateTime::createFromFormat('!Y-m-d', $data_nascimento);

    if (!$data || $data->format('Y-m-d') !== $data_nascimento
        || $data > new DateTime('today')) {
        $erro = 'Informe uma data de nascimento válida.';
    } else {
        $dia_mes = (int) $data->format('md');

        $signos = simplexml_load_file(__DIR__ . '/signos.xml');

        if ($signos === false) {
            $erro = 'Não foi possível carregar os signos.';
        } else {
            foreach ($signos->signo as $signo) {
                $inicio = DateTime::createFromFormat(
                    '!d/m/Y',
                    (string)$signo->dataInicio . '/2000'
                );
                $fim = DateTime::createFromFormat(
                    '!d/m/Y',
                    (string)$signo->dataFim . '/2000'
                );

                if (!$inicio || !$fim) {
                    continue;
                }

                $inicio_num = (int)$inicio->format('md');
                $fim_num = (int)$fim->format('md');

                if ($inicio_num <= $fim_num) {
                    $corresponde = $dia_mes >= $inicio_num
                        && $dia_mes <= $fim_num;
                } else {
                    // Signos que atravessam a virada do ano
                    $corresponde = $dia_mes >= $inicio_num
                        || $dia_mes <= $fim_num;
                }

                if ($corresponde) {
                    $signo_encontrado = $signo;
                    break;
                }
            }

            if (!$signo_encontrado) {
                $erro = 'Nenhum signo encontrado para essa data.';
            }
        }
    }
} else {
    $erro = 'Informe sua data de nascimento.';
}
?>

<body>
    <main class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card signo-card shadow-lg">
            <div class="card-body p-4 p-md-5 resultado-signo">

                <div class="simbolo-signo mb-3">✦</div>

                <?php if ($signo_encontrado): ?>

                    <p class="subtitulo mb-2">
                        Seu signo zodiacal é
                    </p>

                    <h1 class="nome-signo mb-4">
                        <?php
                        echo htmlspecialchars(
                            (string)$signo_encontrado->signoNome,
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </h1>

                    <p class="descricao-signo mb-4">
                        <?php
                        echo htmlspecialchars(
                            (string)$signo_encontrado->descricao,
                            ENT_QUOTES,
                            'UTF-8'
                        );
                        ?>
                    </p>

                <?php else: ?>

                    <h1 class="titulo-principal mb-3">
                        Não foi possível consultar
                    </h1>

                    <p class="subtitulo mb-4">
                        <?php echo htmlspecialchars($erro); ?>
                    </p>

                <?php endif; ?>

                <a href="index.php"
                   class="btn btn-signo btn-lg w-100">
                    Consultar outra data
                </a>

                <p class="rodape-card mt-4 mb-0">
                    Uma jornada pelas estrelas começa aqui.
                </p>

            </div>
        </div>
    </main>
</body>
</html>

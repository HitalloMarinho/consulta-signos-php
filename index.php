<?php include('layouts/header.php'); ?>
<body>
    <main class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="card signo-card shadow-lg">
            <div class="card-body p-4 p-md-5 text-center">

                <div class="simbolo-signo mb-3">✦</div>

                <h1 class="titulo-principal mb-3">
                    Descubra seu Signo
                </h1>

                <p class="subtitulo mb-4">
                    Descubra as características do seu signo
                    zodiacal através da sua data de nascimento.
                </p>

                <form id="signo-form"
                      method="POST"
                      action="show_zodiac_sign.php">

                    <div class="mb-4 text-start">
                        <label for="data_nascimento"
                               class="form-label">
                            Data de nascimento
                        </label>

                        <input
                            type="date"
                            class="form-control form-control-lg"
                            id="data_nascimento"
                            name="data_nascimento"
                            max="<?php echo date('Y-m-d'); ?>"
                            required
                        >
                    </div>

                    <button type="submit"
                            class="btn btn-signo btn-lg w-100">
                        Descobrir meu signo ✨
                    </button>
                </form>

                <p class="rodape-card mt-4 mb-0">
                    Uma jornada pelas estrelas começa aqui.
                </p>

            </div>
        </div>
    </main>
</body>
</html>

<?php
// Inicia a sessão PHP para armazenar as tarefas
session_start();

// Verifica se a variável de sessão 'tarefas' existe e, se não, a inicializa como um array vazio
if (!isset($_SESSION['tarefas'])) {
    $_SESSION['tarefas'] = array();
}

// Verifica se as informações do formulário foram submetidas e processa as tarefas
if (isset($_GET['nome_tarefa']) && isset($_GET['primeiro']) && isset($_GET['segundo']) && isset($_GET['terceiro'])) {
    // Cria uma nova tarefa com nome e valores inseridos
    $tarefa = array(
        'nome' => $_GET['nome_tarefa'],
        'valores' => array(
            $_GET['primeiro'],
            $_GET['segundo'],
            $_GET['terceiro']
        )
    );

    // Calcula a média dos valores inseridos
    $media = array_sum($tarefa['valores']) / count($tarefa['valores']);

    // Determina o status com base na média
    if ($media >= 60) {
        $status = "Aprovado";
    } elseif ($media >= 55 && $media <= 59) {
        $status = "Recuperação";
    } else {
        $status = "Reprovado";
    }

    // Adiciona a média e o status à tarefa
    $tarefa['media'] = number_format($media, 2); // Formata a média para exibir apenas 2 casas decimais
    $tarefa['status'] = $status;

    // Adiciona a tarefa à lista de tarefas na sessão
    array_push($_SESSION['tarefas'], $tarefa);
}

// Limpa todas as tarefas se a solicitação GET incluir o parâmetro 'clear'
if (isset($_GET['clear'])) {
    unset($_SESSION['tarefas']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gerenciador de Tarefas</title>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Gerenciador de Tarefas</h1>
    </div>
    <div class="form">
        <!-- Formulário para adicionar uma nova tarefa -->
        <form action="" method="get">
            <label for="nome_tarefa">Nome do Aluno:</label>
            <input type="text" name="nome_tarefa" placeholder="Nome do Aluno" required>
            <label for="primeiro">1º trimestre:</label>
            <input type="number" name="primeiro" placeholder="Primeiro Trimestre" required>
            <label for="segundo">2º trimestre:</label>
            <input type="number" name="segundo" placeholder="Segundo Trimestre" required>
            <label for="terceiro">3º trimestre:</label>
            <input type="number" name="terceiro" placeholder="Terceiro Trimestre" required>
            <button type="submit">Cadastrar</button>
        </form>
    </div>
    <div class="separator">
    </div>
    <div class="list-tasks">
        <!-- Lista de tarefas -->
        <?php
        // Verifica se existem tarefas na sessão
        if (isset($_SESSION['tarefas'])) {
            echo '<ul>';

            // Loop através de todas as tarefas e exibe seus detalhes
            foreach ($_SESSION['tarefas'] as $key => $tarefa) {
                echo "<li>";
                echo "<strong>{$tarefa['nome']}</strong>";
                echo "<br>";
                echo "Média: {$tarefa['media']} - Status: {$tarefa['status']}";
                echo "</li>";
            }

            echo '</ul>';
        }
        ?>
        <!-- Formulário para limpar todas as tarefas -->
        <form action="" method="get">
            <input type="hidden" name="clear" value="clear">
            <button type="submit" class="btn-clear">Limpar Tarefas</button>
        </form>
    </div>
    <div class="footer">
        <p>Desenvolvido por Ramon Inácio</p>
    </div>
</div>
</body>
</html>
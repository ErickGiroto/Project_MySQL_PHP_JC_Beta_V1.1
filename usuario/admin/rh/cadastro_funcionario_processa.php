<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /usuario/login_usuario.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Conexão com o banco de dados
$conn = new mysqli("localhost", "root", "root", "quitanda_bom_preco");

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Função para verificar duplicidade
function verificarDuplicidade($conn, $campo, $valor, $tabela) {
    $sql = "SELECT $campo FROM $tabela WHERE $campo = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erro na preparação da query: " . $conn->error);
    }
    $stmt->bind_param("s", $valor);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

// Coleta os dados do formulário
$cod = $_POST['cod'];
$nome_completo = $_POST['nome_completo'];
$nome_social = $_POST['nome_social'];
$nome_pai = $_POST['nome_pai'];
$nome_mae = $_POST['nome_mae'];
$pronome = $_POST['pronome'];
$sexo = $_POST['sexo'];
$data_de_nascimento = $_POST['data_de_nascimento'];
$estado_civil = $_POST['estado_civil'];
$cpf = $_POST['cpf'];
$rg = $_POST['rg'];
$cnh = $_POST['cnh'];
$telefone_1 = $_POST['telefone_1'];
$telefone_emergencia = $_POST['telefone_emergencia'];
$email = $_POST['email'];
$naturalidade = $_POST['naturalidade'];
$nacionalidade = $_POST['nacionalidade'];
$endereco = $_POST['endereco'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$estado = $_POST['estado'];
$num_casa = $_POST['num_casa'];
$usuario_registro = $_POST['usuario_registro'];
$nome_usuario = $_POST['nome_usuario'];

// Inicializa variáveis para filhos
$filho1 = $_POST['filho1'] ?? null;
$data_nascimento_filho1 = $_POST['data_nascimento_filho1'] ?? null;
$filho2 = $_POST['filho2'] ?? null;
$data_nascimento_filho2 = $_POST['data_nascimento_filho2'] ?? null;
$filho3 = $_POST['filho3'] ?? null;
$data_nascimento_filho3 = $_POST['data_nascimento_filho3'] ?? null;
$filho4 = $_POST['filho4'] ?? null;
$data_nascimento_filho4 = $_POST['data_nascimento_filho4'] ?? null;
$filho5 = $_POST['filho5'] ?? null;
$data_nascimento_filho5 = $_POST['data_nascimento_filho5'] ?? null;
$filho6 = $_POST['filho6'] ?? null;
$data_nascimento_filho6 = $_POST['data_nascimento_filho6'] ?? null;
$filho7 = $_POST['filho7'] ?? null;
$data_nascimento_filho7 = $_POST['data_nascimento_filho7'] ?? null;

// Verifica duplicidade em campos únicos
$campos_unicos = [
    'cod' => $cod,
    'cpf' => $cpf,
    'rg' => $rg,
    'cnh' => $cnh,
    'email' => $email,
    'telefone_1' => $telefone_1
];

$erro_duplicidade = null;
foreach ($campos_unicos as $campo => $valor) {
    if (verificarDuplicidade($conn, $campo, $valor, 'funcionario_registro')) {
        $erro_duplicidade = "Erro: O valor '$valor' já está em uso no campo '$campo'. Por favor, insira um valor único.";
        break;
    }
}

if ($erro_duplicidade) {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro</title>
            <style>
                .main-container {
                    text-align: center;
                    margin-top: 50px;
                    font-family: Arial, sans-serif;
                }
                .main-container h2 {
                    color: red;
                }
                .main-container p {
                    color: #333;
                }
                .main-container a {
                    color: #007BFF;
                    text-decoration: none;
                }
                .main-container a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro ao Cadastrar Funcionário</h2>
                <p>$erro_duplicidade</p>
                <a href='/usuario/admin/rh/cadastro_funcionario.php'>Voltar</a>
            </div>
        </body>
        </html>";
    exit;
}

// Prepara a query SQL para inserir na tabela funcionario_registro
$sql = "INSERT INTO funcionario_registro (
    cod, nome_completo, nome_social, nome_pai, nome_mae, pronome, sexo, data_de_nascimento, estado_civil, cpf, rg, cnh, telefone_1, telefone_emergencia, email, naturalidade, nacionalidade, endereco, bairro, cep, estado, num_casa, filho1, data_nascimento_filho1, filho2, data_nascimento_filho2, filho3, data_nascimento_filho3, filho4, data_nascimento_filho4, filho5, data_nascimento_filho5, filho6, data_nascimento_filho6, filho7, data_nascimento_filho7, usuario_registro, nome_usuario
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Erro na preparação da query: " . $conn->error);
}

// Bind dos parâmetros
$stmt->bind_param(
    "ssssssssssssssssssssssssssssssssssssss",
    $cod, $nome_completo, $nome_social, $nome_pai, $nome_mae, $pronome, $sexo, $data_de_nascimento, $estado_civil, $cpf, $rg, $cnh, $telefone_1, $telefone_emergencia, $email, $naturalidade, $nacionalidade, $endereco, $bairro, $cep, $estado, $num_casa,
    $filho1, $data_nascimento_filho1,
    $filho2, $data_nascimento_filho2,
    $filho3, $data_nascimento_filho3,
    $filho4, $data_nascimento_filho4,
    $filho5, $data_nascimento_filho5,
    $filho6, $data_nascimento_filho6,
    $filho7, $data_nascimento_filho7,
    $usuario_registro, $nome_usuario
);

try {
    if ($stmt->execute()) {
        // Se o funcionário foi cadastrado com sucesso, insere a imagem na tabela funcionario_imagens
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagem = file_get_contents($_FILES['imagem']['tmp_name']);

            // Prepara a query para inserir a imagem no banco de dados
            $stmt_imagem = $conn->prepare("INSERT INTO funcionario_imagens (cod, imagem, usuario_registro, nome_usuario) VALUES (?, ?, ?, ?)");
            $stmt_imagem->bind_param("ssss", $cod, $imagem, $usuario_registro, $nome_usuario);

            if ($stmt_imagem->execute()) {
                echo "<!DOCTYPE html>
                    <html lang='pt-br'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Sucesso</title>
                        <style>
                            .main-container {
                                text-align: center;
                                margin-top: 50px;
                                font-family: Arial, sans-serif;
                            }
                            .main-container h2 {
                                color: green;
                            }
                            .main-container a {
                                color: #007BFF;
                                text-decoration: none;
                            }
                            .main-container a:hover {
                                text-decoration: underline;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='main-container'>
                            <h2>Funcionário Cadastrado com Sucesso!</h2>
                            <a href='/usuario/admin/rh/cadastro_funcionario.php'>Voltar</a>
                        </div>
                    </body>
                    </html>";
            } else {
                throw new Exception("Erro ao cadastrar imagem do funcionário: " . $stmt_imagem->error);
            }

            $stmt_imagem->close();
        } else {
            throw new Exception("Erro no upload da imagem.");
        }
    } else {
        throw new Exception("Erro ao cadastrar funcionário: " . $stmt->error);
    }
} catch (mysqli_sql_exception $e) {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro</title>
            <style>
                .main-container {
                    text-align: center;
                    margin-top: 50px;
                    font-family: Arial, sans-serif;
                }
                .main-container h2 {
                    color: red;
                }
                .main-container p {
                    color: #333;
                }
                .main-container a {
                    color: #007BFF;
                    text-decoration: none;
                }
                .main-container a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro ao Cadastrar Funcionário</h2>
                <p>Erro: " . $e->getMessage() . "</p>
                <a href='/usuario/admin/rh/cadastro_funcionario.php'>Voltar</a>
            </div>
        </body>
        </html>";
} catch (Exception $e) {
    echo "<!DOCTYPE html>
        <html lang='pt-br'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Erro</title>
            <style>
                .main-container {
                    text-align: center;
                    margin-top: 50px;
                    font-family: Arial, sans-serif;
                }
                .main-container h2 {
                    color: red;
                }
                .main-container p {
                    color: #333;
                }
                .main-container a {
                    color: #007BFF;
                    text-decoration: none;
                }
                .main-container a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='main-container'>
                <h2>Erro ao Cadastrar Funcionário</h2>
                <p>Erro: " . $e->getMessage() . "</p>
                <a href='/usuario/admin/rh/cadastro_funcionario.php'>Voltar</a>
            </div>
        </body>
        </html>";
}

$stmt->close();
$conn->close();
?>
<?php
include('conexao.php');

if (isset($_POST['email']) || isset($_POST['senha'])) {
  $email = $mysqli->real_escape_string($_POST['email']);
  $senha = $mysqli->real_escape_string($_POST['senha']);
  $senhacript = base64_encode($_POST["senha"]);

  $sql_code = "SELECT * FROM tbl_user WHERE email = '$email' AND senha = '$senhacript'";
  $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

  $quantidade = $sql_query->num_rows;
  if ($quantidade == 1) {
    $tbl_user = $sql_query->fetch_assoc();
    if (!isset($_SESSION)) {
      session_start();
    }

    $_SESSION['id'] = $tbl_user['id'];
    $_SESSION['nome'] = $tbl_user['nome'];

    header("Location:./home.php");
  } else {
    echo "<style>
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');
  
        body {
            background-color: #d12525c2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        
        .error-message {
            width: 400px;
            background: #181a1e; 
            border-radius: 6px;
            text-align: center;
            padding: 30px;
            color: #fff;
        }

        .error-message img {
            max-width: 100%;
            height: auto;
        }

        .error-message h2 {
            font-size: 38px;
            font-weight: 700;
            margin: 30px 0 10px;
            font-family: poppins, sans-serif;
        }

        .error-message p {
            color: #dce1eb;
            font-weight: 500;
            font-family: poppins, sans-serif;
        }

        .error-message a {
            display: block;
            margin-top: 50px;
            padding: 10px 15px;
            background: #0fc78a;
            color: #fff;
            font-weight: 500;
            font-family: poppins, sans-serif;
            text-decoration: none;
            font-size: 18px;
            border-radius: 4px;
            cursor: pointer;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2);
        }
    </style>";

    echo "<div class='error-message'>";
    echo "<img src='./images/att.png'>";
    echo "<h2>Falha ao logar!</h2>";
    echo "<p>Este usuário não existe no banco de dados.</p>";
    echo "<a href='./logar.php'>Entrar</a>";
    echo "</div>";
    die();
  }
}

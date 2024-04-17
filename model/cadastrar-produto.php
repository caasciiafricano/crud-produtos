<?php

$bd = new PDO(
    "mysql:host=localhost;dbname=myproduto_db;charset=utf8",
    "root",
    "@CrackerCA2002@",
    array(PDO::ATTR_PERSISTENT)
);

$produto = array(
    ":id" => htmlspecialchars($_POST['txt_id_produto']),
    ":produto" => htmlspecialchars($_POST['txt_nome_produto']),
    ":quantidade" => htmlspecialchars($_POST['txt_quantidade_produto']),
    ":descricao" => htmlspecialchars($_POST['txt_descricao_produto']),
);

try {
    // Cadastrar informações do novo produto
    $cmd = $bd->prepare("INSERT INTO tb_produto(id,nome,quantidade,descricao,created_at,updated_at) 
                        VALUES(:id,:produto,:quantidade,:descricao,NOW(),NOW())");
    $cmd->execute($produto);

    // Resgatar last ultimo id registrado
    $resultado = $bd->query("SELECT COUNT(id) AS quant FROM tb_produto;");
    $resultado->execute();
    $ultimo_id = (int)$resultado->fetch(pdo::FETCH_ASSOC)['quant'];

    foreach ($_FILES as $item) {
        // Cadastrar informações sobre as imagens
        $cmd2 = $bd->prepare("INSERT INTO tb_imagem(id,imagem,created_at,updated_at,produto_id)
                              VALUES(0,:imagem,NOW(),NOW(),:id);
        ");

        $cmd2->bindParam(":id", $ultimo_id);
        $cmd2->bindParam(":imagem", $item['name']);
        $cmd2->execute();
        // fazer upload das imagens para o servidor
        move_uploaded_file($item['tmp_name'], "../public/uploads/" . $item['name']);
    }

    echo "Produto {$produto['produto']}, Cadastrado com sucesso!";
    
} catch (PDOException $e) {
    echo $e;
}


/* 

Array
(
    [txt_nome_produto] => Arca
    [txt_quantidade_produto] => 20
)
Array
(
    [file_imagem1_produto] => Array
        (
            [name] => Screenshot 2024-04-13 at 13-39-27 Facebook.png
            [full_path] => Screenshot 2024-04-13 at 13-39-27 Facebook.png
            [type] => image/png
            [tmp_name] => /tmp/phplDoLSW
            [error] => 0
            [size] => 85482
        )

    [file_imagem2_produto] => Array
        (
            [name] => Screenshot 2024-04-13 at 13-39-27 Facebook.png
            [full_path] => Screenshot 2024-04-13 at 13-39-27 Facebook.png
            [type] => image/png
            [tmp_name] => /tmp/phpIBFj0g
            [error] => 0
            [size] => 85482
        )

    [file_imagem3_produto] => Array
        (
            [name] => Screenshot 2024-04-13 at 13-39-27 Facebook.png
            [full_path] => Screenshot 2024-04-13 at 13-39-27 Facebook.png
            [type] => image/png
            [tmp_name] => /tmp/php1Zq3pt
            [error] => 0
            [size] => 85482
        )

)
*/
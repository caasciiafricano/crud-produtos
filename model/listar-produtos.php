<?php

$bd = new PDO(
    "mysql:host=localhost;dbname=myproduto_db;charset=utf8",
    "root",
    "@CrackerCA2002@",
    array(PDO::ATTR_PERSISTENT)
);


$resultado = $bd->query("SELECT * FROM tb_produto;");
$resultado->execute();

print_r($resultado->fetchAll(pdo::FETCH_ASSOC));

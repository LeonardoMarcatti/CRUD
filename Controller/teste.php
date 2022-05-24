<?php
    namespace Testes\Projetos\PHP\CRUD\Controller;

    if (file_exists('/var/www/html/programacao/testes/Projetos/PHP/CRUD/Model/TipoLogradouroDAO.php')) {
        echo 'ok';
    } else {
        echo 'n';
    };

    echo "<br>" . __DIR__ . "<br>";
        
    spl_autoload_register(
        function ($class)
        {
            $pathToClass = explode('\\', $class);
            $class = end($pathToClass);

            if (file_exists(str_replace('Controller', 'Model/', __DIR__) . $class . '.php')) {
                require_once str_replace('Controller', 'Model/', __DIR__) . $class . '.php';
            } else {
                require_once str_replace('Controller', 'Config/', __DIR__) . $class . '.php';
            };
        }
    );

    use Testes\Projetos\PHP\CRUD\Config\Connection;
    use Testes\Projetos\PHP\CRUD\Model\TipoLogradouroDAO;


    $connection = Connection::getConnection();
    $tipo_log = new TipoLogradouroDAO($connection);
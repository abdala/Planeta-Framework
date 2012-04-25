<?php
namespace Planeta\Banco;

use InvalidArgumentException;

class Banco
{
    private $conexao;

    public function definirConexao(\PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function pegarConexao()
    {
        return $this->conexao;
    }

    public function __construct($options = NULL)
    {
        if (count($options)) {
            if (count($options) != 5) {
                throw new InvalidArgumentException('Quantidade de opcoes erradas. Utilize as seguintes: driver, dbname, host, username and password.');
            }

            $dsn = sprintf('%s:dbname=%s;host=%s', $options['driver'], $options['dbname'], $options['host']);

            $this->conexao = new \PDO($dsn,
                                    $options['username'],
                                    $options['password'],
                                    array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
        }
    }
}
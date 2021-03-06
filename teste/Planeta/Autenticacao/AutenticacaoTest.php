<?php

namespace Planeta\Autenticacao;

/**
 * Test class for Autenticacao.
 * Generated by PHPUnit on 2012-04-25 at 09:57:49.
 */
class AutenticacaoTest extends \PHPUnit_Extensions_Database_TestCase {

    /**
     * @var Autenticacao
     */
    protected $autenticacao;

    /**
     * @var \PDO
     */
    protected $conexao;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @covers Planeta\Autenticacao\Autenticacao::__construct
     */
    protected function setUp() 
    {
        $this->conexao = new \PDO("sqlite::memory:");
        
        $this->conexao->exec(file_get_contents(PASTA_ACESSORIOS . '/usuario.sql'));
        
        $armazenamento = $this->getMockBuilder("Planeta\Autenticacao\Armazenamento\InterfaceArmazenamento")
                              ->setMethods(array('escrever','ler','limpar','estaVazio'))
                              ->getMock();
        $this->autenticacao = new Autenticacao($armazenamento);
        
        parent::setUp();
    }

    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        return $this->createDefaultDBConnection($this->conexao, ':memory:');
    }
    
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    public function getDataSet()
    {
        return $this->createFlatXMLDataSet(PASTA_ACESSORIOS . '/dados/usuario.xml');
    }
    
    /**
     * @covers Planeta\Autenticacao\Autenticacao::pegarArmazenamento
     */
    public function testPegarArmazemanento() 
    {
        $this->assertInstanceOf('Planeta\Autenticacao\Armazenamento\InterfaceArmazenamento', 
                                $this->autenticacao->pegarArmazenamento());
    }
    
    /**
     * @covers Planeta\Autenticacao\Autenticacao::definirArmazenamento
     */
    public function testDefinirArmazenamento() 
    {
        $armazenamento = $this->getMock("Planeta\Autenticacao\Armazenamento\InterfaceArmazenamento");
        $this->autenticacao->definirArmazenamento($armazenamento);
        
        $this->assertInstanceOf('Planeta\Autenticacao\Armazenamento\InterfaceArmazenamento', 
                                $this->autenticacao->pegarArmazenamento());
    }
    
    /**
     * @covers Planeta\Autenticacao\Autenticacao::autenticar
     */
    public function testAutenticar() 
    {
        $banco  = $this->getMock("Planeta\Banco\Banco");
        
        $banco->expects($this->any())
              ->method("pegarConexao")
              ->will($this->returnValue($this->conexao));
        
        $tabela = $this->getMockBuilder("Planeta\Banco\Tabela")
                       ->setConstructorArgs(array($banco, 'usuario', 'id'))
                       ->setMethods(array('pegarBanco'))
                       ->getMock();
        
        $tabela->expects($this->once())
               ->method("pegarBanco")
               ->will($this->returnValue($banco));
        
        $armazenamento = $this->autenticacao->pegarArmazenamento();
        
        $armazenamento->expects($this->once())
                      ->method("escrever")
                      ->with();
        
        $resultado = $this->autenticacao->autenticar($tabela, "email", "senha", "jose@gmail.com", "123");
        $this->assertTrue($resultado);
    }
    
    /**
     * @covers Planeta\Autenticacao\Autenticacao::autenticar
     */
    public function testAutenticarComUsuarioInvalido() 
    {
        $banco  = $this->getMock("Planeta\Banco\Banco");
        
        $banco->expects($this->any())
              ->method("pegarConexao")
              ->will($this->returnValue($this->conexao));
        
        $tabela = $this->getMockBuilder("Planeta\Banco\Tabela")
                       ->setConstructorArgs(array($banco, 'usuario', 'id'))
                       ->setMethods(array('pegarBanco'))
                       ->getMock();
        
        $tabela->expects($this->once())
               ->method("pegarBanco")
               ->will($this->returnValue($banco));
        
        
        $resultado = $this->autenticacao->autenticar($tabela, "email", "senha", "invalido@gmail.com", "123");
        $this->assertFalse($resultado);
    }

    /**
     * @covers Planeta\Autenticacao\Autenticacao::pegarDados
     */
    public function testPegarDados() 
    {
        $armazenamento = $this->autenticacao->pegarArmazenamento();
        $armazenamento->expects($this->once())
                      ->method("ler")
                      ->with();
        
        $this->autenticacao->pegarDados();
    }

    /**
     * @covers Planeta\Autenticacao\Autenticacao::estaAutenticado
     */
    public function testEstaAutenticado() 
    {
        $armazenamento = $this->autenticacao->pegarArmazenamento();
        $armazenamento->expects($this->once())
                      ->method("estaVazio")
                      ->with();
        
        $this->autenticacao->estaAutenticado();
    }

    /**
     * @covers Planeta\Autenticacao\Autenticacao::limpar
     */
    public function testLimpar()
    {
        $armazenamento = $this->autenticacao->pegarArmazenamento();
        $armazenamento->expects($this->once())
                      ->method("limpar")
                      ->with();
        
        $this->autenticacao->limpar();
    }
}
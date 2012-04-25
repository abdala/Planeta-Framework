<?php
namespace Planeta\Banco;

/**
 * @large
 */
class TabelaTest extends \PHPUnit_Extensions_Database_TestCase {

    /**
     * @var Tabela
     */
    protected $tabela;
    
    /**
     * @var \PDO
     */
    protected $conexao;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     * @covers Planeta\Banco\Tabela::__construct
     */
    protected function setUp() {
        $banco = $this->getMock("Planeta\Banco\Banco");
        $this->conexao = new \PDO("sqlite::memory:");
        
        $banco->expects($this->any())
              ->method("pegarConexao")
              ->will($this->returnValue($this->conexao));
        
        $this->tabela = new Tabela($banco, 'usuario', 'id');
        
        $this->conexao->exec(file_get_contents(PASTA_ACESSORIOS . '/usuario.sql'));
        
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
     * @covers Planeta\Banco\Tabela::pegarNome
     */
    public function testPegarNome() {
        $this->assertEquals('usuario', $this->tabela->pegarNome());
    }
    
    /**
     * @covers Planeta\Banco\Tabela::definirNome
     */
    public function testDefinirNome() {
        $this->tabela->definirNome('outroUsuario');
        $this->assertEquals('outroUsuario', $this->tabela->pegarNome());
    }
    
    /**
     * @covers Planeta\Banco\Tabela::pegarChave
     */
    public function testPegarChave() {
        $this->assertEquals('id', $this->tabela->pegarChave());
    }
    
    /**
     * @covers Planeta\Banco\Tabela::definirChave
     */
    public function testDefinirChave() {
        $this->tabela->definirChave('outroId');
        $this->assertEquals('outroId', $this->tabela->pegarChave());
    }

    /**
     * @covers Planeta\Banco\Tabela::pegarBanco
     */
    public function testPegarBanco() {
        $this->assertInstanceOf("Planeta\Banco\Banco", $this->tabela->pegarBanco());
    }

    /**
     * @covers Planeta\Banco\Tabela::definirBanco
     */
    public function testDefinirBanco() {
        $banco = $this->getMock("Planeta\Banco\Banco");
        
        $this->tabela->definirBanco($banco);
        
        $this->assertInstanceOf("Planeta\Banco\Banco", $this->tabela->pegarBanco());
    }
    
    /**
     * @covers Planeta\Banco\Tabela::inserir
     */
    public function testInserir() {
        $this->assertEquals(2, $this->getConnection()->getRowCount('usuario'), "Condicao previa");
        
        $this->tabela->inserir(array('id' => '3', 
                                     'nome' => 'Pedro',
                                     'email' => 'pedro@gmail.com',
                                     'senha' => '789',
                                     'perfil' => 'admin'));
        
        $this->assertEquals(3, $this->getConnection()->getRowCount('usuario'), "Falha ao inserir");
        $this->assertDataSetsEqual(
            $this->createFlatXMLDataSet(PASTA_ACESSORIOS . '/dados/usuario-inserido.xml'),
            $this->getConnection()->createDataSet()
        );
    }

    /**
     * @covers Planeta\Banco\Tabela::atualizar
     */
    public function testAtualizar() {
        $this->assertEquals(2, $this->getConnection()->getRowCount('usuario'));
        $this->tabela->atualizar(array('id' => '2', 
                                       'nome' => 'Joao da Silva',
                                       'email' => 'joao.silva@gmail.com',
                                       'senha' => '789',
                                       'perfil' => 'admin'));
        
        $this->assertEquals(2, $this->getConnection()->getRowCount('usuario'));
        
        $this->assertDataSetsEqual(
            $this->createFlatXMLDataSet(PASTA_ACESSORIOS . '/dados/usuario-alterado.xml'),
            $this->getConnection()->createDataSet()
        );
    }

    /**
     * @covers Planeta\Banco\Tabela::excluir
     */
    public function testExcluir() {
        $this->assertEquals(2, $this->getConnection()->getRowCount('usuario'));
        
        $this->tabela->excluir(2);
        
        $this->assertEquals(1, $this->getConnection()->getRowCount('usuario'));
        
        $this->assertDataSetsEqual(
            $this->createFlatXMLDataSet(PASTA_ACESSORIOS . '/dados/usuario-removido.xml'),
            $this->getConnection()->createDataSet()
        );
    }
    
    /**
     * @covers Planeta\Banco\Tabela::buscarTodos
     */
    public function testBuscarTodos() {
        $dados = $this->tabela->buscarTodos();
        
        $this->assertInternalType("array", $dados);
        $this->assertCount(2, $dados);
    }

    /**
     * @covers Planeta\Banco\Tabela::buscar
     * @todo Implement testBuscar().
     */
    public function testBuscar() {
        $dados = $this->tabela->buscar(1);
        
        $this->assertInternalType("array", $dados);
        $this->assertCount(10, $dados);
        
        $this->assertArrayHasKey('id', $dados);
        $this->assertArrayHasKey('nome', $dados);
        $this->assertArrayHasKey('email', $dados);
        $this->assertArrayHasKey('senha', $dados);
        $this->assertArrayHasKey('perfil', $dados);
        
        $this->assertEquals(1, $dados['id']);
        $this->assertEquals('Jose', $dados['nome']);
        $this->assertEquals('jose@gmail.com', $dados['email']);
        $this->assertEquals('123', $dados['senha']);
        $this->assertEquals('admin', $dados['perfil']);
    }
}
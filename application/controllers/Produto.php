<?php

class Produto extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model("LoginModel");
        $this->load->model("ProdutoModel");
        $this->load->model("TipoModel");
    }

    private $alteraExclui = false;

    private $usuario = "";

    public function index()
    {

        if (isset($_SESSION["tesi2022"])) {
            $this->alteraExclui = true;

            $this->usuario = $this->LoginModel->buscarUsuario($_SESSION["tesi2022"]['email'])[0]->usuario;
        }

        $formatter = new NumberFormatter('pt_BR',  NumberFormatter::CURRENCY);

        $textoConfirmacao = 'return confirm("Tem certeza?")';

        $produtos = $this->ProdutoModel->selecionarTodos();
        $tabela = "";

        foreach ($produtos as $item) {

            $tabela = $tabela . "
                    <tr>";

            if (isset($_SESSION["tesi2022"])) {

                $tabela .= "
                        <td style='text-align: left;'>
                            <a href='/produto/alterar?codigo=" . $item->id . "' style='text-decoration: none;'>✏️</a> 
                        </td>
                        <td style='text-align: left;'>
                            <a onclick='" . $textoConfirmacao . "'href='/produto/excluir?codigo=" . $item->id . "' style='text-decoration: none;' id='excluir'>❌
                            </a>
                        </td>";
            } 

            $tabela .= "<td>" . $item->nome . "</td>
                        <td>" . $item->perecivel . "</td>
                        <td>" . $formatter->formatCurrency($item->valor, 'BRL') . "</td>
                        <td>" . $item->nome_tipo . "</td>
                        <td> <img src=' " . $item->imagem . " ' style='width:150px'/>
                        </td>
                    </tr>
                    ";
        }

        $variavel = array(
            "lista_produtos" => $produtos,
            "tabela" => $tabela,
            "titulo" => "Padaria do Barba",
            "usuarioLogado" => $this->alteraExclui,
            "usuario" => $this->usuario,
            "sucesso" => "Produto registrado com sucesso",
            "erro" => "Houve um erro no processo, tente novamente"
        );

        $this->template->load("templates/adminTemp", "/produto/index", $variavel);
    }

    //Alteração de produto
    public function alterar()
    {
        
        $this->load->library('form_validation');

        $config = array(
            array(
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required'
            ),
            array(
                'field' => 'perecivel',
                'label' => 'Perecível',
                'rules' => 'required'
            ),
            array(
                'field' => 'valor',
                'label' => 'Valor',
                'rules' => 'required'
            ),
            array(
                'field' => 'imagem',
                'label' => 'Imagem',
                'rules' => 'required'
            ),
        );

        $this->form_validation->set_rules($config);

        if(isset($_POST["tipo_produto"]) && $_POST["tipo_produto"] == 0){
            $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        }

        if (isset($_SESSION["tesi2022"])) {
            $this->alteraExclui = true;

            $this->load->model("LoginModel");

            $this->usuario = $this->LoginModel->buscarUsuario($_SESSION["tesi2022"]['email'])[0]->usuario;
        }
        else {
            header("location: /admin");
        }


        $id = isset($_GET["codigo"]) ? $_GET["codigo"] : 0;

        $retorno = $this->ProdutoModel->buscarId($id);

        $comboTipos = $this->montarComboTipos($retorno[0]);

        $organizar = array(
            "titulo" => "Alteração de produtos",
            "produto" => isset($retorno[0]) ? $retorno[0] : null,
            "opcoesTipos" => $comboTipos,
            "usuario" => $this->usuario,
            "usuarioLogado" => $this->alteraExclui
        );

        if ($this->form_validation->run() == FALSE)
        {
            $this->template->load("templates/adminTemp", "/produto/formAlterar", $organizar);
        }
        else
        {
            $this->salvarAlteracao($organizar);
        }        
    }

    //Salva os produtos atualizados 
    public function salvarAlteracao($organizar)
    { 

        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $perecivel = $_POST["perecivel"];
        $valor = $_POST["valor"];
        $tipo_produto = $_POST["tipo_produto"];
        $imagem = $_POST["imagem"];

        $retorno = $this->ProdutoModel->salvarAlteracao(
            $id,
            $nome,
            $perecivel,
            $valor,
            $tipo_produto,
            $imagem
        );

        if ($retorno == true) {
            $this->template->load('templates/adminTemp', '/produto/sucessoAlteracao', $organizar);
        } else {
            echo "Ocorreu um erro";
        }
    }

    public function formNovo()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_message('field', '{field} é obrigatório');

        $config = array(
            array(
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'required'
            ),
            array(
                'field' => 'perecivel',
                'label' => 'Perecível',
                'rules' => 'required'
            ),
            array(
                'field' => 'valor',
                'label' => 'Valor',
                'rules' => 'required'
            ),
            array(
                'field' => 'imagem',
                'label' => 'Imagem',
                'rules' => 'required'
        ),
        );

        $this->form_validation->set_rules($config);

        if(isset($_POST["tipo_produto"]) && $_POST["tipo_produto"] == 0){
            $this->form_validation->set_rules('tipo', 'Tipo', 'required');
        }

        $comboTipos = $this->montarComboTipos(null);

        if (isset($_SESSION["tesi2022"])) {
            $this->alteraExclui = true;

            $this->load->model("LoginModel");

            $this->usuario = $this->LoginModel->buscarUsuario($_SESSION["tesi2022"]['email'])[0]->usuario;
        }
        else {
            header("location: /admin");
        }
        
        $data = array(
            "opcoesTipos" => $comboTipos,
            "usuario" => $this->usuario,
            "usuarioLogado" => $this->alteraExclui
        );

        if ($this->form_validation->run() == FALSE)
        {
            $this->template->load("templates/adminTemp", "/produto/formNovo", $data);
        }
        else
        {
            $this->salvarNovo($data);
        }
    }

    //Salvar novo produto
    public function salvarNovo($data)
    {

        $nome = $_POST["nome"];
        $perecivel = $_POST["perecivel"];
        $valor = $_POST["valor"];
        $tipo_produto = intval($_POST["tipo_produto"]);
        $imagem = $_POST["imagem"];

        $nomeExiste = $this->ProdutoModel->buscarNome($nome);

        if ($nomeExiste[0]->total > 0) {
            echo "Não pode incluir, já existe um total de " . $nomeExiste[0]->total;
        } else {
            $this->ProdutoModel->salvarNovo(
                $nome,
                $perecivel,
                $valor,
                $tipo_produto,
                $imagem
            );

            $this->template->load('templates/adminTemp', '/produto/sucessoNovo', $data);
        }
    }

    //Excluir 
    public function excluir()
    {
        $alteraExclui = false;

        if (isset($_SESSION["tesi2022"])) {
            $alteraExclui = true;
        }

        if(!$alteraExclui) {
            header("location: /admin");
        }

        

        $id = $_GET["codigo"];

        $this->ProdutoModel->excluir($id);

        header("location: /produto");
    }

    private function montarComboTipos($tipoSetado)
    {

        $listaTipos = $this->TipoModel->selecionarTodos();

        $option = "";

        foreach ($listaTipos as $tipo) {

            if($tipoSetado != null){
                $selected = $tipo->id == $tipoSetado->tipo_produto ? "selected" : "";
                $option .= 
                "<option value='" . $tipo->id . "' ' . 
                $selected . '>
                " . $tipo->nome_tipo . "
                </option>";
            } 
            else
            {
                $option .= "<option value='" . $tipo->id . "'>" . $tipo->nome_tipo . "</option>";
            } 
        }

        return $option;
    }

    public function buscarProduto() {
        
    }
}

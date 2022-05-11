<?php
    class Admin extends CI_Controller {

        private $qqur = "JIOSAJFIOAsafjasoifasjifasfasmfoisa samiosmaiomgaosmgis";

        public function __construct(){
            parent::__construct();

            $this->load->model("loginmodel");
        }

        public function index() {
            //if (isset($_SESSION["tesi2022"])){
            //    header("location: /produto");
            //}

            $this->template->load('templates/adminLogin', 'login/login');
        }

        public function salvarRegistro() {

            $data = array(
                "email" => $_POST["email"],
                "usuario" => $_POST["usuario"],
                "senha" => md5($_POST["senha"] . $this->qqur)
            );

            $retorno = $this->loginmodel->registrar($data);

            if($retorno)
                echo "Cadastro realizado com Sucesso. Clique aqui para fazer o login <a href='/admin'>Login</a>";
            else
                echo "Erro ao criar usuário";
        }

        public function registro() {
            $this->template->load('templates/adminRegistro', '/admin/register');
        }

        //Apenas chama o form
        public function registrarSenha() {
            $this->load->view('admin/registrarsenha');
        }

        // Alteração de senha
        public function alterarSenha() {
            $email = $_POST["email"];
            $senha = md5($_POST["senha"] . $this->qqur);
            $chave = $_POST["chave"];

            $retorno = $this->loginmodel->criarSenha($email, $senha, $chave);

            if($retorno){
                echo "Senha cadastrada com sucesso";
            }
            else{
                echo "Senha não pôde ser cadastrada";
            }
        }

        public function validaLogin() {

            $email = $_POST["email"];
            $senha = md5($_POST["senha"] . $this->qqur);

            $retorno = $this->loginmodel->validaLogin($email, $senha);

            if($retorno) {
                $_SESSION["tesi2022"] = array(
                    "email" => $email,
                    "admin" => true,
                    "logado" => true
                );

                echo "Login executado com sucesso";
                header("location: /produto");
            } 
            else {
                echo "E-mail ou senha inválidos";

                session_unset();
            }
        }

        public function deslogar() {
            session_unset();
            header("location: /admin");
        }
    }
 ?>
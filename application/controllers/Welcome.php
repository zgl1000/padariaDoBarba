<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
		$usuario = "";
		
		$alteraExclui = false;

		if (isset($_SESSION["tesi2022"])) {
            $alteraExclui = true;

            $this->load->model("LoginModel");

            $usuario = $this->LoginModel->buscarUsuario($_SESSION["tesi2022"]['email'])[0]->usuario;
        }
		
		$data = array(
			"usuarioLogado" => $alteraExclui,
			"usuario" => $usuario
		);

		//$this->load->view('welcome_message');
		$this->template->load('templates/adminTemp', 'welcome_message', $data);
	}

	public function teste() {
		echo "Chegou";
	}

	public function jose() {
		echo "Jose Guilherme";
	}
}

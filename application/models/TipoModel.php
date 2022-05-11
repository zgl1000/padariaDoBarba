<?php 
    class TipoModel extends CI_Model {
        public function selecionarTodos() {
            $retorno = $this->db->query("SELECT * FROM tipo_produto ORDER BY nome_tipo")->result();

            return $retorno;
        }

        public function inserir($dados) {
            try {
                $this->db->insert('cor', $dados);

                return true;
            }
            catch(Exception $ex){
                return false;
            }
        }
    }
?>
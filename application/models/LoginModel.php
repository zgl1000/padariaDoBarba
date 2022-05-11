<?php

    class LoginModel extends CI_Model {
        
        //Registro
            //Validação de e-mail
            //Pré registro -> dados, chave
        
        //Login
        //Esqueci senha

        //Alterar senha
        //Alterar nome
        //Alterar admin
        //Inativar usuário

        public function registrar($data) {
            
            try {
                if($this->validaEmail($data["email"])){
                    $this->db->insert('usuario', $data);
                    return true;
                }

                return false;
            }
            catch(Exception $ex) {
                return false;
            }
        }

        public function validaEmail($email) {
            $sql = "SELECT count(1) as total
                    FROM usuario
                    WHERE email = '$email'";
            
            $retorno = $this->db->query($sql)->result();

            if($retorno[0]->total == 0)
                return true;
            

            return false;
        }

        public function validaLogin($email, $senha) {
            $sql = "SELECT COUNT(1) as total FROM usuario
                    WHERE email = '$email'
                    AND senha = '$senha'
                    ";
            
            $retorno = $this->db->query($sql)->result();
            
            if($retorno[0]->total == 0) {
                return false;
            }

            return true;
        }

        public function buscarUsuario($email) {
            $sql = "SELECT usuario FROM usuario WHERE email = '$email'";

            $retorno = $this->db->query($sql)->result();

            return $retorno;
        }
    }
?>
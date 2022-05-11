<?php

    class ProdutoModel extends CI_Model {
        public function selecionarTodos() {
            $retorno = $this->db->query("
                SELECT p.*, tp.nome_tipo FROM produto p
                INNER JOIN tipo_produto tp
                ON p.tipo_produto = tp.id");

            return $retorno->result();
        }

        public function buscarId( $id ) {
            $retorno = $this->db->query( "
                        SELECT p.*, tp.nome_tipo FROM produto p
                        INNER JOIN tipo_produto tp
                        ON p.tipo_produto = tp.id
                        WHERE p.id=" . $id );

            return $retorno->result();
        }

        public function buscarNome( $nome_produto ) {
            $sql = "SELECT COUNT(1) as total FROM produto WHERE nome = '" . $nome_produto . "'";

            $retorno = $this->db->query( $sql )->result();

            return $retorno;
        }

        //Salvar alterações no produto
        public function salvarAlteracao( $id, $nome, $perecivel, $valor, $tipo_produto, $imagem) {
            $sql = "UPDATE produto
                    SET
                        nome = '" . $nome . "',
                        perecivel = '" . $perecivel. "',
                        valor = " . $valor . ",
                        tipo_produto = '" . $tipo_produto. "',
                        imagem = '" . $imagem. "'
                    WHERE id= " . $id . "
                ";
            $this->db->query( $sql );

            return true;
        }

        public function salvarNovo( $nome, $perecivel, $valor, $tipo_produto, $imagem) {
            $sql = "INSERT INTO produto 
                    (nome, perecivel, valor, tipo_produto, imagem)
                    VALUES
                    ('" .$nome. "', '" . $perecivel ."', " . $valor . ", '" . $tipo_produto . "', '" . $imagem . "')
                ";

            $this->db->query( $sql );

            return true;
        }

        public function excluir($id) {
            $sql="DELETE FROM produto WHERE id=" . $id;
            $this->db->query( $sql );
            return true;
        }
    }
?>
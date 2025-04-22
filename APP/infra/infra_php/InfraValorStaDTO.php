<?php
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 09/10/2019 - criado por MGA
 *
 * @package infra_php
 */

class InfraValorStaDTO extends InfraDTO
{

    public function getStrNomeTabela()
    {
        return null;
    }

    public function montar()
    {
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaValor');
        $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'Descricao');
    }
}

<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 07/08/2009 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.27.1
 *
 * Vers�o no CVS: $Id$
 */

//require_once 'Infra.php';

class InfraSequenciaINT extends InfraINT
{

    public static function montarSelectNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado)
    {
        $objInfraSequenciaDTO = new InfraSequenciaDTO();
        $objInfraSequenciaDTO->retStrNome();
        $objInfraSequenciaDTO->retStrNome();

        $objInfraSequenciaDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

        $objInfraSequenciaRN = new InfraSequenciaRN();
        $arrObjInfraSequenciaDTO = $objInfraSequenciaRN->listar($objInfraSequenciaDTO);

        return parent::montarSelectArrInfraDTO(
            $strPrimeiroItemValor,
            $strPrimeiroItemDescricao,
            $strValorItemSelecionado,
            $arrObjInfraSequenciaDTO,
            'Nome',
            'Nome'
        );
    }
}

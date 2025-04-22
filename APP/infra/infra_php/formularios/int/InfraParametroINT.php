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

class InfraParametroINT extends InfraINT
{

    public static function montarSelectNome($strPrimeiroItemValor, $strPrimeiroItemDescricao, $strValorItemSelecionado)
    {
        $objInfraParametroDTO = new InfraParametroDTO();
        $objInfraParametroDTO->retStrNome();
        $objInfraParametroDTO->retStrNome();

        $objInfraParametroDTO->setOrdStrNome(InfraDTO::$TIPO_ORDENACAO_ASC);

        $objInfraParametroRN = new InfraParametroRN();
        $arrObjInfraParametroDTO = $objInfraParametroRN->listar($objInfraParametroDTO);

        return parent::montarSelectArrInfraDTO(
            $strPrimeiroItemValor,
            $strPrimeiroItemDescricao,
            $strValorItemSelecionado,
            $arrObjInfraParametroDTO,
            'Nome',
            'Nome'
        );
    }
}

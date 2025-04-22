<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 05/04/2013 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.27.1
 *
 * Vers�o no CVS: $Id$
 */

//require_once 'Infra.php';

class InfraComparacaoBancoINT extends InfraINT
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

    public static function montarSelectTipoBancoDados(
        $strPrimeiroItemValor,
        $strPrimeiroItemDescricao,
        $strValorItemSelecionado
    ) {
        return parent::montarSelectArray(
            $strPrimeiroItemValor,
            $strPrimeiroItemDescricao,
            $strValorItemSelecionado,
            array(
                InfraComparacaoBancoRN::$TBD_MYSQL => 'MySql',
                InfraComparacaoBancoRN::$TBD_ORACLE => 'Oracle',
                InfraComparacaoBancoRN::$TBD_POSTGRESQL => 'PostgreSql',
                InfraComparacaoBancoRN::$TBD_SQLSERVER => 'SqlServer'
            )
        );
    }
}

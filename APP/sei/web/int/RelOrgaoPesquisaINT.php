<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 21/09/2022 - criado por cas84
*
* Vers�o do Gerador de C�digo: 1.43.1
*/

require_once dirname(__FILE__).'/../SEI.php';

class RelOrgaoPesquisaINT extends InfraINT {
  public static function montarSelectOrgao(RelOrgaoPesquisaDTO $objRelOrgaoPesquisaDTO){

    $objRelOrgaoPesquisaRN = new RelOrgaoPesquisaRN();
    $arrOrgaosPesquisa = $objRelOrgaoPesquisaRN->listar($objRelOrgaoPesquisaDTO);

    return parent::montarSelectArrInfraDTO(null,null,null,$arrOrgaosPesquisa, 'IdOrgao2', 'SiglaOrgao2');
  }
  public static function montarSelectOrgaoSessao(RelOrgaoPesquisaDTO $objRelOrgaoPesquisaDTO){
    $objOrgaoDTO = new OrgaoDTO();
    $objOrgaoDTO->retNumIdOrgao();
    $objOrgaoDTO->retStrSigla();
    $objOrgaoDTO->setNumIdOrgao($objRelOrgaoPesquisaDTO->getNumIdOrgao1());

    $objOrgaoRN = new OrgaoRN();
    $arrOrgaosPesquisa = array();
    $arrOrgaosPesquisa[] = $objOrgaoRN->consultarRN1352($objOrgaoDTO);

    return parent::montarSelectArrInfraDTO(null,null,null,$arrOrgaosPesquisa, 'IdOrgao', 'Sigla');
  }
}

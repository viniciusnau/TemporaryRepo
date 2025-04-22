<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 12/06/2014 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.33.1
 *
 * Vers�o no CVS: $Id$
 */

require_once dirname(__FILE__) . '/../Sip.php';

class RelOrgaoAutenticacaoINT extends InfraINT {

  public static function montarSelectServidoresAutenticacao($numIdOrgao) {
    $objRelOrgaoAutenticacaoDTO = new RelOrgaoAutenticacaoDTO();
    $objRelOrgaoAutenticacaoDTO->retNumIdServidorAutenticacao();
    $objRelOrgaoAutenticacaoDTO->retStrNomeServidorAutenticacao();
    $objRelOrgaoAutenticacaoDTO->retStrEnderecoServidorAutenticacao();
    $objRelOrgaoAutenticacaoDTO->retNumSequencia();
    $objRelOrgaoAutenticacaoDTO->setNumIdOrgao($numIdOrgao);
    $objRelOrgaoAutenticacaoDTO->setOrdNumSequencia(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelOrgaoAutenticacaoRN = new RelOrgaoAutenticacaoRN();
    $arrObjRelOrgaoAutenticacaoDTO = $objRelOrgaoAutenticacaoRN->listar($objRelOrgaoAutenticacaoDTO);

    foreach ($arrObjRelOrgaoAutenticacaoDTO as $objRelOrgaoAutenticacaoDTO) {
      $objRelOrgaoAutenticacaoDTO->setStrNomeServidorAutenticacao(ServidorAutenticacaoINT::formatarIdentificacao($objRelOrgaoAutenticacaoDTO->getStrNomeServidorAutenticacao(),
        $objRelOrgaoAutenticacaoDTO->getStrEnderecoServidorAutenticacao()));
    }

    return parent::montarSelectArrInfraDTO(null, null, null, $arrObjRelOrgaoAutenticacaoDTO, 'IdServidorAutenticacao', 'NomeServidorAutenticacao');
  }
}

?>
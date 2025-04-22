<?php
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 02/01/2023 - criado por mgb29
 *
 * Vers�o do Gerador de C�digo: 1.44
 **/

require_once dirname(__FILE__) . '/../../SEI.php';

class RelSeriePlanoTrabalhoINT extends InfraINT {

  public static function montarSelectSerie($numIdPlanoTrabalho) {
    $objRelSeriePlanoTrabalhoDTO = new RelSeriePlanoTrabalhoDTO();
    $objRelSeriePlanoTrabalhoDTO->retNumIdSerie();
    $objRelSeriePlanoTrabalhoDTO->retStrNomeSerie();
    $objRelSeriePlanoTrabalhoDTO->setNumIdPlanoTrabalho($numIdPlanoTrabalho);
    $objRelSeriePlanoTrabalhoDTO->setOrdStrNomeSerie(InfraDTO::$TIPO_ORDENACAO_ASC);

    $objRelSeriePlanoTrabalhoRN = new RelSeriePlanoTrabalhoRN();
    $arrObjRelSeriePlanoTrabalhoDTO = $objRelSeriePlanoTrabalhoRN->listar($objRelSeriePlanoTrabalhoDTO);

    return parent::montarSelectArrInfraDTO(null, null, null, $arrObjRelSeriePlanoTrabalhoDTO, 'IdSerie', 'NomeSerie');
  }

}

<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 12/12/2007 - criado por fbv
*
* Vers�o do Gerador de C�digo: 1.10.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class ObservacaoINT extends InfraINT {

  public static function tabelaObservacoesOutrasUnidades($dblIdProtocolo){
    
    $objObservacaoDTO = new ObservacaoDTO();
    $objObservacaoDTO->retStrSiglaUnidade();
    $objObservacaoDTO->retStrDescricaoUnidade();
    $objObservacaoDTO->retStrDescricao();
    
    $objObservacaoDTO->setDblIdProtocolo($dblIdProtocolo);
    $objObservacaoDTO->setNumIdUnidade(SessaoSEI::getInstance()->getNumIdUnidadeAtual(),InfraDTO::$OPER_DIFERENTE);
    
    $objObservacaoDTO->setOrdStrSiglaUnidade(InfraDTO::$TIPO_ORDENACAO_ASC);


    $objObservacaoRN = new ObservacaoRN();
    $arrObjObservacaoDTO = $objObservacaoRN->listarRN0219($objObservacaoDTO);

    $numRegistros = count($arrObjObservacaoDTO);
    $strResultado = '';
    
    if ($numRegistros > 0){
    
      $strSumarioTabela = 'Tabela de observa��es de outras unidades.';
      $strCaptionTabela = 'observa��es de outras unidades';
        
      $strResultado = '';
      $strResultado .= '<table width="85%" class="infraTable" summary="'.$strSumarioTabela.'">'."\n";
      $strResultado .= '<caption class="infraCaption">'.PaginaSEI::getInstance()->gerarCaptionTabela($strCaptionTabela,$numRegistros).'</caption>';
      $strResultado .= '<tr>';
      $strResultado .= '<th class="infraTh" width="25%">Unidade</th>'."\n";
      $strResultado .= '<th class="infraTh">Observa��o</th>'."\n";
      $strResultado .= '</tr>';
      
      $strCssTr = '';
      foreach ($arrObjObservacaoDTO as $objObservacaoDTO){
        $strCssTr = ($strCssTr=='<tr class="infraTrClara">')?'<tr class="infraTrEscura">':'<tr class="infraTrClara">';
        $strResultado .= $strCssTr;
        $strResultado .= '<td valign="top" align="center"><a alt="'.PaginaSEI::tratarHTML($objObservacaoDTO->getStrDescricaoUnidade()).'" title="'.PaginaSEI::tratarHTML($objObservacaoDTO->getStrDescricaoUnidade()).'" class="ancoraSigla">'.PaginaSEI::tratarHTML($objObservacaoDTO->getStrSiglaUnidade()).'</a></td>';
        $strResultado .= '<td>'.nl2br(PaginaSEI::tratarHTML($objObservacaoDTO->getStrDescricao())).'</td>';
        $strResultado .= '</tr>';
      }
      
      $strResultado .= '</table>';
    }
    
    return $strResultado;
    
  }
}
?>
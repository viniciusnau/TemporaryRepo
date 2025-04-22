<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 05/11/2010 - criado por jonatas_db
* 15/06/2018 - cjy - �cone de acompanhamento no controle de processos*
*
* Vers�o do Gerador de C�digo: 1.30.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AcompanhamentoINT extends InfraINT {

  public static function montarIconeAcompanhamento($bolAcaoCadastrarAcompanhamento, $dblIdProtocolo, $strParametros = ''){

    $ret  = '';

    if ($bolAcaoCadastrarAcompanhamento) {
      $strLink = SessaoSEI::getInstance()->assinarLink('controlador.php?acao=acompanhamento_gerenciar&acao_origem=' . $_GET['acao'] . '&acao_retorno=' . $_GET['acao'] . '&id_procedimento='.$dblIdProtocolo );
    }else{
      $strLink = 'javascript:void(0);';
    }

    $ret = '<a href="'.$strLink.'" ' . PaginaSEI::montarTitleTooltip('Acompanhamento Especial') . '><img src="'.Icone::ACOMPANHAMENTO_ESPECIAL.'" class="imagemStatus" /></a>';

    return $ret;
  }

  public static function montarTDsGrupoObservacao($arrObjAcompanhamentoDTO, $numAcompanhamentos, $i, $strAtributos = ''){
    $ret =  '';

    $ret .= '<td '.$strAtributos.' align="center">';
    if ($numAcompanhamentos == 0) {
      $ret .= '&nbsp;';
    } else {
      $ret .= PaginaSEI::tratarHTML(substr($arrObjAcompanhamentoDTO[$i]->getDthAlteracao(),0,16));
    }
    $ret .= '</td>'."\n";

    $ret .= '<td '.$strAtributos.' align="center">';
    if ($numAcompanhamentos == 0) {
      $ret .= '&nbsp;';
    } else {
      $ret .= '<a alt="'.PaginaSEI::tratarHTML($arrObjAcompanhamentoDTO[$i]->getStrNomeUsuario()).'" title="'.PaginaSEI::tratarHTML($arrObjAcompanhamentoDTO[$i]->getStrNomeUsuario()).'" class="ancoraSigla textoLegenda">'.PaginaSEI::tratarHTML($arrObjAcompanhamentoDTO[$i]->getStrSiglaUsuario()).'</a>';
    }
    $ret .= '</td>'."\n";

    $ret .= '<td '.$strAtributos.' align="center">';
    if ($numAcompanhamentos == 0 || $arrObjAcompanhamentoDTO[$i]->getStrNomeGrupo() == null) {
      $ret .= '&nbsp;';
    } else {
      $ret .= PaginaSEI::tratarHTML($arrObjAcompanhamentoDTO[$i]->getStrNomeGrupo());
    }
    $ret .= '</td>'."\n";

    $ret .= '<td '.$strAtributos.'>';
    if ($numAcompanhamentos == 0 || $arrObjAcompanhamentoDTO[$i]->getStrObservacao() == null) {
      $ret .= '&nbsp;';
    } else {
      $ret .= nl2br(PaginaSEI::tratarHTML($arrObjAcompanhamentoDTO[$i]->getStrObservacao()));
    }
    $ret .= '</td>';

    return $ret;
  }
}
?>
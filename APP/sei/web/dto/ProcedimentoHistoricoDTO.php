<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 31/01/2008 - criado por marcio_db
 *
 * Vers�o do Gerador de C�digo: 1.13.1
 *
 * Vers�o no CVS: $Id$
 */

require_once dirname(__FILE__) . '/../SEI.php';

class ProcedimentoHistoricoDTO extends InfraDTO {

  public function getStrNomeTabela() {
    return null;
  }

  public function montar() {
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL, 'IdProcedimento');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL, 'IdProcedimentoAnexado');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_DBL, 'IdDocumento');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdTarefa');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'IdTarefaModulo');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_NUM, 'IdAtividade');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'StaHistorico');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinGerarLinksHistorico');
    $this->adicionarAtributo(InfraDTO::$PREFIXO_STR, 'SinRetornarAtributos');
  }
}

?>
<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 29/04/2013 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.17.0
 *
 * Vers�o no CVS: $Id$
 */

require_once dirname(__FILE__) . '/../Sip.php';

class AgendamentoBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco) {
    parent::__construct($objInfraIBanco);
  }

  public function removerDadosLogin() {
    try {
      $objInfraParametro = new InfraParametro(BancoSip::getInstance());
      $numDiasHistoricoAcessos = $objInfraParametro->getValor('SIP_TEMPO_DIAS_HISTORICO_ACESSOS');

      $sql = 'delete from login where dth_login <= ' . $this->getObjInfraIBanco()->formatarGravacaoDth(InfraData::calcularData($numDiasHistoricoAcessos, InfraData::$UNIDADE_DIAS, InfraData::$SENTIDO_ATRAS,
          InfraData::getStrDataHoraAtual()));

      return $this->getObjInfraIBanco()->executarSql($sql);
    } catch (Exception $e) {
      throw new InfraException('Erro removendo dados de login.', $e);
    }
  }
}

?>
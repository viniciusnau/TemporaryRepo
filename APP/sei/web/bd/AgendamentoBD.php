<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 26/04/2013 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.17.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AgendamentoBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco){
  	 parent::__construct($objInfraIBanco);
  }
  
  public function removerDadosEstatisticas(){

    try{
      
      $sql = 'delete from estatisticas where dth_snapshot <= '.$this->getObjInfraIBanco()->formatarGravacaoDth(InfraData::calcularData(1, InfraData::$UNIDADE_DIAS, InfraData::$SENTIDO_ATRAS, InfraData::getStrDataHoraAtual()));

      return $this->getObjInfraIBanco()->executarSql($sql);
      
    }catch(Exception $e){
      throw new InfraException('Erro removendo dados de estat�sticas.',$e);
    }
  }

  public function removerDadosControleUnidade(){

    try{

      $sql = 'delete from controle_unidade where dth_snapshot <= '.$this->getObjInfraIBanco()->formatarGravacaoDth(InfraData::calcularData(1, InfraData::$UNIDADE_DIAS, InfraData::$SENTIDO_ATRAS, InfraData::getStrDataHoraAtual()));

      return $this->getObjInfraIBanco()->executarSql($sql);

    }catch(Exception $e){
      throw new InfraException('Erro removendo dados de controle de unidade.',$e);
    }
  }

  public function removerDadosTemporariosAuditoria(){

    try{
      
      $sql = 'delete from auditoria_protocolo where dta_auditoria <= '.$this->getObjInfraIBanco()->formatarGravacaoDta(InfraData::calcularData(1, InfraData::$UNIDADE_DIAS, InfraData::$SENTIDO_ATRAS, InfraData::getStrDataAtual()));
      
      return $this->getObjInfraIBanco()->executarSql($sql);
      
    }catch(Exception $e){
      throw new InfraException('Erro removendo dados tempor�rios de auditoria.',$e);
    }
  }
  
}
?>
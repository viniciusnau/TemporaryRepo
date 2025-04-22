<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 02/05/2011 - criado por mga
*
* Vers�o do Gerador de C�digo: 1.31.0
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class AcessoBD extends InfraBD {

  public function __construct(InfraIBanco $objInfraIBanco){
  	 parent::__construct($objInfraIBanco);
  }

  public function excluirControleInterno(AcessoDTO $objAcessoDTO){
    try{

      $this->getObjInfraIBanco()->executarSql('delete from acesso where id_controle_interno='.$this->getObjInfraIBanco()->formatarGravacaoNum($objAcessoDTO->getNumIdControleInterno()));

    }catch(Exception $e){
      throw new InfraException('Erro excluindo acessos de controle interno.',$e);
    }
  }
}
?>
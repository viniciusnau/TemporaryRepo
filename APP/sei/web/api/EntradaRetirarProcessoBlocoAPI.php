<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 17/07/2014 - criado por mga
*
*/

class EntradaRetirarProcessoBlocoAPI {
  private $IdBloco;
  private $IdProcedimento;
  private $ProtocoloProcedimento;
  
  /**
   * @return mixed
   */
  public function getIdBloco()
  {
    return $this->IdBloco;
  }

  /**
   * @param mixed $IdBloco
   */
  public function setIdBloco($IdBloco)
  {
    $this->IdBloco = $IdBloco;
  }

  /**
   * @return mixed
   */
  public function getIdProcedimento()
  {
    return $this->IdProcedimento;
  }

  /**
   * @param mixed $IdProcedimento
   */
  public function setIdProcedimento($IdProcedimento)
  {
    $this->IdProcedimento = $IdProcedimento;
  }

  /**
   * @return mixed
   */
  public function getProtocoloProcedimento()
  {
    return $this->ProtocoloProcedimento;
  }

  /**
   * @param mixed $ProtocoloProcedimento
   */
  public function setProtocoloProcedimento($ProtocoloProcedimento)
  {
    $this->ProtocoloProcedimento = $ProtocoloProcedimento;
  }

}
?>
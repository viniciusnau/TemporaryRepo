<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 10/03/2015 - criado por mga
*
*/

class EntradaConsultarBlocoAPI {

  private $IdBloco;
  private $SinRetornarProtocolos;

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
  public function getSinRetornarProtocolos()
  {
    return $this->SinRetornarProtocolos;
  }

  /**
   * @param mixed $SinRetornarProtocolos
   */
  public function setSinRetornarProtocolos($SinRetornarProtocolos)
  {
    $this->SinRetornarProtocolos = $SinRetornarProtocolos;
  }

}
?>
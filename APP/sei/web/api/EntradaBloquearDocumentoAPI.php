<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 11/09/2018 - criado por mga
*
*/

class EntradaBloquearDocumentoAPI {
  private $IdDocumento;
  private $ProtocoloDocumento;

  /**
   * @return mixed
   */
  public function getIdDocumento()
  {
    return $this->IdDocumento;
  }

  /**
   * @param mixed $IdDocumento
   */
  public function setIdDocumento($IdDocumento)
  {
    $this->IdDocumento = $IdDocumento;
  }

  /**
   * @return mixed
   */
  public function getProtocoloDocumento()
  {
    return $this->ProtocoloDocumento;
  }

  /**
   * @param mixed $ProtocoloDocumento
   */
  public function setProtocoloDocumento($ProtocoloDocumento)
  {
    $this->ProtocoloDocumento = $ProtocoloDocumento;
  }

}
?>
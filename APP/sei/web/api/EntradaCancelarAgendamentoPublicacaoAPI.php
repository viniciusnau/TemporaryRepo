<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4ª REGIÃO
*
*/

class EntradaCancelarAgendamentoPublicacaoAPI {
  private $IdPublicacao;
  private $IdDocumento;
  private $ProtocoloDocumento;

  /**
   * @return mixed
   */
  public function getIdPublicacao()
  {
    return $this->IdPublicacao;
  }

  /**
   * @param mixed $IdPublicacao
   */
  public function setIdPublicacao($IdPublicacao)
  {
    $this->IdPublicacao = $IdPublicacao;
  }

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
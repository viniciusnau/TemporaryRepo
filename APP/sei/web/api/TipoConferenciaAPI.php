<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 11/08/2016 - criado por mga
 *
 */

class TipoConferenciaAPI {
  private $IdTipoConferencia;
  private $Descricao;

  /**
   * @return mixed
   */
  public function getIdTipoConferencia()
  {
    return $this->IdTipoConferencia;
  }

  /**
   * @param mixed $IdTipoConferencia
   */
  public function setIdTipoConferencia($IdTipoConferencia)
  {
    $this->IdTipoConferencia = $IdTipoConferencia;
  }

  /**
   * @return mixed
   */
  public function getDescricao()
  {
    return $this->Descricao;
  }

  /**
   * @param mixed $Descricao
   */
  public function setDescricao($Descricao)
  {
    $this->Descricao = $Descricao;
  }
}
?>
<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 05/10/2015 - criado por mga
 *
 */

class EntradaListarHipotesesLegaisAPI {
  private $NivelAcesso;

  /**
   * @return mixed
   */
  public function getNivelAcesso()
  {
    return $this->NivelAcesso;
  }

  /**
   * @param mixed $NivelAcesso
   */
  public function setNivelAcesso($NivelAcesso)
  {
    $this->NivelAcesso = $NivelAcesso;
  }
}
?>
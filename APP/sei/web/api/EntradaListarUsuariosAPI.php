<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 07/08/2014 - criado por mga
*
*/

class EntradaListarUsuariosAPI {
  private $IdUsuario;

  /**
   * @return mixed
   */
  public function getIdUsuario()
  {
    return $this->IdUsuario;
  }

  /**
   * @param mixed $IdUsuario
   */
  public function setIdUsuario($IdUsuario)
  {
    $this->IdUsuario = $IdUsuario;
  }
}
?>
<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 06/09/2018 - criado por mga
 *
 */

class FeriadoAPI {
  private $Descricao;
  private $Data;

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

  /**
   * @return mixed
   */
  public function getData()
  {
    return $this->Data;
  }

  /**
   * @param mixed $Data
   */
  public function setData($Data)
  {
    $this->Data = $Data;
  }
}
?>
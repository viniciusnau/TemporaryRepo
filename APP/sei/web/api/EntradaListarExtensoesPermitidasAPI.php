<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 05/08/2014 - criado por mga
*
*/

class EntradaListarExtensoesPermitidasAPI{

  private $IdArquivoExtensao;

  /**
   * @return mixed
   */
  public function getIdArquivoExtensao()
  {
    return $this->IdArquivoExtensao;
  }

  /**
   * @param mixed $IdArquivoExtensao
   */
  public function setIdArquivoExtensao($IdArquivoExtensao)
  {
    $this->IdArquivoExtensao = $IdArquivoExtensao;
  }

}
?>
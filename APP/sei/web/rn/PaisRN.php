<?
/**
* TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
*
* 01/03/2012 - criado por bcu
* 12/06/2018 - cjy - insercao de estado e cidade textualmente, para paises estrangeiros
*
* Vers�o do Gerador de C�digo: 1.32.1
*
* Vers�o no CVS: $Id$
*/

require_once dirname(__FILE__).'/../SEI.php';

class PaisRN extends InfraRN {

  public function __construct(){
    parent::__construct();
  }

  protected function inicializarObjInfraIBanco(){
    return BancoSEI::getInstance();
  }

  private function validarStrNome(PaisDTO $objPaisDTO, InfraException $objInfraException){
    if (InfraString::isBolVazia($objPaisDTO->getStrNome())){
      $objInfraException->adicionarValidacao('Pa�s n�o informado.');
    }else{
      $objPaisDTO->setStrNome(trim($objPaisDTO->getStrNome()));

      if (strlen($objPaisDTO->getStrNome())>50){
        $objInfraException->adicionarValidacao('Pa�s possui tamanho superior a 50 caracteres.');
      }
    }
  }

  protected function cadastrarControlado(PaisDTO $objPaisDTO) {
    try{

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('pais_cadastrar',__METHOD__,$objPaisDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $this->validarStrNome($objPaisDTO, $objInfraException);

      $objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      $ret = $objPaisBD->cadastrar($objPaisDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro cadastrando Pa�s.',$e);
    }
  }

  protected function alterarControlado(PaisDTO $objPaisDTO){
    try {

      //Valida Permissao
  	   SessaoSEI::getInstance()->validarAuditarPermissao('pais_alterar',__METHOD__,$objPaisDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      if ($objPaisDTO->isSetStrNome()){
        $this->validarStrNome($objPaisDTO, $objInfraException);
      }

      $objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      $objPaisBD->alterar($objPaisDTO);

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro alterando Pa�s.',$e);
    }
  }

  protected function excluirControlado($arrObjPaisDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('pais_excluir',__METHOD__,$arrObjPaisDTO);

      //Regras de Negocio
      $objInfraException = new InfraException();

      $contatoRN = new ContatoRN();

      $arrIdPais = InfraArray::converterArrInfraDTO($arrObjPaisDTO, 'IdPais');
      if (count($arrIdPais)) {

        $paisDto = new PaisDTO();
        $paisDto->setBolExclusaoLogica(false);
        $paisDto->setNumIdPais($arrIdPais, InfraDTO::$OPER_IN);
        $paisDto->retStrNome();
        $paisDto->retNumIdPais();
        $arrObjContatoDTOConsulta = InfraArray::indexarArrInfraDTO($this->listarConectado($paisDto), 'IdPais');

        foreach ($arrIdPais as $numIdPais) {
          $strNome = $arrObjContatoDTOConsulta[$numIdPais]->getStrNome();

          $objContatoDTO = new ContatoDTO();
          $objContatoDTO->setNumIdPais($numIdPais);

          $numContatos = $contatoRN->contarRN0327($objContatoDTO);
          if ($numContatos) {
            if ($numContatos == 1) {
              $objInfraException->adicionarValidacao('Existe 1 Contato utilizando o Pa�s ' . $strNome . '.');
            } else {
              $objInfraException->adicionarValidacao('Existem ' . $numContatos . ' Contatos utilizando o Pa�s ' . $strNome . '.');
            }
          }
        }
      }


      $objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjPaisDTO);$i++){
        $objPaisBD->excluir($arrObjPaisDTO[$i]);
      }
      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro excluindo Pa�s.',$e);
    }
  }

  protected function consultarConectado(PaisDTO $objPaisDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('pais_consultar',__METHOD__,$objPaisDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      $ret = $objPaisBD->consultar($objPaisDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro consultando Pa�s.',$e);
    }
  }

  protected function listarConectado(PaisDTO $objPaisDTO) {
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('pais_listar',__METHOD__,$objPaisDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      $ret = $objPaisBD->listar($objPaisDTO);

      //Auditoria

      return $ret;

    }catch(Exception $e){
      throw new InfraException('Erro listando Pa�ses.',$e);
    }
  }

  protected function contarConectado(PaisDTO $objPaisDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('pais_listar',__METHOD__,$objPaisDTO);

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      $ret = $objPaisBD->contar($objPaisDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro contando Pa�ses.',$e);
    }
  }
/* 
  protected function desativarControlado($arrObjPaisDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('pais_desativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjPaisDTO);$i++){
        $objPaisBD->desativar($arrObjPaisDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro desativando Pa�s.',$e);
    }
  }

  protected function reativarControlado($arrObjPaisDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('pais_reativar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      for($i=0;$i<count($arrObjPaisDTO);$i++){
        $objPaisBD->reativar($arrObjPaisDTO[$i]);
      }

      //Auditoria

    }catch(Exception $e){
      throw new InfraException('Erro reativando Pa�s.',$e);
    }
  }

  protected function bloquearControlado(PaisDTO $objPaisDTO){
    try {

      //Valida Permissao
      SessaoSEI::getInstance()->validarAuditarPermissao('pais_consultar');

      //Regras de Negocio
      //$objInfraException = new InfraException();

      //$objInfraException->lancarValidacoes();

      $objPaisBD = new PaisBD($this->getObjInfraIBanco());
      $ret = $objPaisBD->bloquear($objPaisDTO);

      //Auditoria

      return $ret;
    }catch(Exception $e){
      throw new InfraException('Erro bloqueando Pa�s.',$e);
    }
  }

 */
}
?>
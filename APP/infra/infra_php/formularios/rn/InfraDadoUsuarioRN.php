<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 02/08/2018 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.41.0
 */

//require_once dirname(__FILE__).'/../Infra.php';

class InfraDadoUsuarioRN extends InfraRN
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function inicializarObjInfraIBanco()
    {
        return BancoInfra::getInstance();
    }

    private function validarStrValor(InfraDadoUsuarioDTO $objInfraDadoUsuarioDTO, InfraException $objInfraException)
    {
        if (InfraString::isBolVazia($objInfraDadoUsuarioDTO->getStrValor())) {
            $objInfraDadoUsuarioDTO->setStrValor(null);
        } else {
            $objInfraDadoUsuarioDTO->setStrValor(trim($objInfraDadoUsuarioDTO->getStrValor()));

            if (strlen($objInfraDadoUsuarioDTO->getStrValor()) > 4096) {
                $objInfraException->adicionarValidacao('Valor possui tamanho superior a 4096 caracteres.');
            }
        }
    }

    protected function cadastrarControlado(InfraDadoUsuarioDTO $objInfraDadoUsuarioDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_cadastrar');

            //Regras de Negocio
            $objInfraException = new InfraException();

            $this->validarStrValor($objInfraDadoUsuarioDTO, $objInfraException);

            $objInfraException->lancarValidacoes();

            $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
            $ret = $objInfraDadoUsuarioBD->cadastrar($objInfraDadoUsuarioDTO);

            //Auditoria

            return $ret;
        } catch (Exception $e) {
            throw new InfraException('Erro cadastrando Dado do Usu�rio.', $e);
        }
    }

    protected function alterarControlado(InfraDadoUsuarioDTO $objInfraDadoUsuarioDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_alterar');

            //Regras de Negocio
            $objInfraException = new InfraException();

            if ($objInfraDadoUsuarioDTO->isSetStrValor()) {
                $this->validarStrValor($objInfraDadoUsuarioDTO, $objInfraException);
            }

            $objInfraException->lancarValidacoes();

            $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
            $objInfraDadoUsuarioBD->alterar($objInfraDadoUsuarioDTO);
            //Auditoria

        } catch (Exception $e) {
            throw new InfraException('Erro alterando Dado do Usu�rio.', $e);
        }
    }

    protected function excluirControlado($arrObjInfraDadoUsuarioDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_excluir');

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
            for ($i = 0; $i < count($arrObjInfraDadoUsuarioDTO); $i++) {
                $objInfraDadoUsuarioBD->excluir($arrObjInfraDadoUsuarioDTO[$i]);
            }
            //Auditoria

        } catch (Exception $e) {
            throw new InfraException('Erro excluindo Dado do Usu�rio.', $e);
        }
    }

    protected function consultarConectado(InfraDadoUsuarioDTO $objInfraDadoUsuarioDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_consultar');

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
            $ret = $objInfraDadoUsuarioBD->consultar($objInfraDadoUsuarioDTO);

            //Auditoria

            return $ret;
        } catch (Exception $e) {
            throw new InfraException('Erro consultando Dado do Usu�rio.', $e);
        }
    }

    protected function listarConectado(InfraDadoUsuarioDTO $objInfraDadoUsuarioDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_listar');

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
            $ret = $objInfraDadoUsuarioBD->listar($objInfraDadoUsuarioDTO);

            //Auditoria

            return $ret;
        } catch (Exception $e) {
            throw new InfraException('Erro listando Dados do Usu�rio.', $e);
        }
    }

    protected function contarConectado(InfraDadoUsuarioDTO $objInfraDadoUsuarioDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_listar');

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
            $ret = $objInfraDadoUsuarioBD->contar($objInfraDadoUsuarioDTO);

            //Auditoria

            return $ret;
        } catch (Exception $e) {
            throw new InfraException('Erro contando Dados do Usu�rio.', $e);
        }
    }
    /*
      protected function desativarControlado($arrObjInfraDadoUsuarioDTO){
        try {

          //Valida Permissao
          SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_desativar');

          //Regras de Negocio
          //$objInfraException = new InfraException();

          //$objInfraException->lancarValidacoes();

          $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
          for($i=0;$i<count($arrObjInfraDadoUsuarioDTO);$i++){
            $objInfraDadoUsuarioBD->desativar($arrObjInfraDadoUsuarioDTO[$i]);
          }

          //Auditoria

        }catch(Exception $e){
          throw new InfraException('Erro desativando Dado do Usu�rio.',$e);
        }
      }

      protected function reativarControlado($arrObjInfraDadoUsuarioDTO){
        try {

          //Valida Permissao
          SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_reativar');

          //Regras de Negocio
          //$objInfraException = new InfraException();

          //$objInfraException->lancarValidacoes();

          $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
          for($i=0;$i<count($arrObjInfraDadoUsuarioDTO);$i++){
            $objInfraDadoUsuarioBD->reativar($arrObjInfraDadoUsuarioDTO[$i]);
          }

          //Auditoria

        }catch(Exception $e){
          throw new InfraException('Erro reativando Dado do Usu�rio.',$e);
        }
      }

      protected function bloquearControlado(InfraDadoUsuarioDTO $objInfraDadoUsuarioDTO){
        try {

          //Valida Permissao
          SessaoInfra::getInstance()->validarPermissao('infra_dado_usuario_consultar');

          //Regras de Negocio
          //$objInfraException = new InfraException();

          //$objInfraException->lancarValidacoes();

          $objInfraDadoUsuarioBD = new InfraDadoUsuarioBD($this->getObjInfraIBanco());
          $ret = $objInfraDadoUsuarioBD->bloquear($objInfraDadoUsuarioDTO);

          //Auditoria

          return $ret;
        }catch(Exception $e){
          throw new InfraException('Erro bloqueando Dado do Usu�rio.',$e);
        }
      }

     */
}

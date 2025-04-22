<?
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 07/08/2009 - criado por mga
 *
 * Vers�o do Gerador de C�digo: 1.27.1
 *
 * Vers�o no CVS: $Id$
 */

//require_once 'Infra.php';

class InfraParametroRN extends InfraRN
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function inicializarObjInfraIBanco()
    {
        return BancoInfra::getInstance();
    }

    private function validarStrNome(InfraParametroDTO $objInfraParametroDTO, InfraException $objInfraException)
    {
        if (InfraString::isBolVazia($objInfraParametroDTO->getStrNome())) {
            throw new InfraException('Nome do par�metro n�o informado.');
        } else {
            $objInfraParametroDTO->setStrNome(trim($objInfraParametroDTO->getStrNome()));

            if (strlen($objInfraParametroDTO->getStrNome()) > 100) {
                throw new InfraException('Nome do par�metro possui tamanho superior a 100 caracteres.');
            }

            $dto = new InfraParametroDTO();
            $dto->setStrNome($objInfraParametroDTO->getStrNome());
            if ($this->contar($dto) > 0) {
                $objInfraException->adicionarValidacao('J� existe um par�metro com este nome.');
            }
        }
    }

    private function validarStrValor(InfraParametroDTO $objInfraParametroDTO, InfraException $objInfraException)
    {
        if (InfraString::isBolVazia($objInfraParametroDTO->getStrValor())) {
            $objInfraParametroDTO->setStrValor(null);
        } else {
            $objInfraParametroDTO->setStrValor(trim($objInfraParametroDTO->getStrValor()));
        }
    }

    protected function cadastrarControlado(InfraParametroDTO $objInfraParametroDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_parametro_cadastrar');

            //Regras de Negocio
            $objInfraException = new InfraException();

            $this->validarStrNome($objInfraParametroDTO, $objInfraException);
            $this->validarStrValor($objInfraParametroDTO, $objInfraException);

            $objInfraException->lancarValidacoes();

            $objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
            $ret = $objInfraParametroBD->cadastrar($objInfraParametroDTO);

            //Auditoria

            return $ret;
        } catch (Exception $e) {
            throw new InfraException('Erro cadastrando Par�metro.', $e);
        }
    }

    protected function alterarControlado(InfraParametroDTO $objInfraParametroDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_parametro_alterar');

            //Regras de Negocio
            $objInfraException = new InfraException();

            if ($objInfraParametroDTO->isSetStrValor()) {
                $this->validarStrValor($objInfraParametroDTO, $objInfraException);
            }

            $objInfraException->lancarValidacoes();

            $objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
            $objInfraParametroBD->alterar($objInfraParametroDTO);
            //Auditoria

        } catch (Exception $e) {
            throw new InfraException('Erro alterando Par�metro.', $e);
        }
    }

    protected function excluirControlado($arrObjInfraParametroDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_parametro_excluir');

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
            for ($i = 0; $i < count($arrObjInfraParametroDTO); $i++) {
                $objInfraParametroBD->excluir($arrObjInfraParametroDTO[$i]);
            }
            //Auditoria

        } catch (Exception $e) {
            throw new InfraException('Erro excluindo Par�metro.', $e);
        }
    }

    protected function consultarConectado(InfraParametroDTO $objInfraParametroDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_parametro_consultar');

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
            $ret = $objInfraParametroBD->consultar($objInfraParametroDTO);

            //Auditoria

            return $ret;
        } catch (Exception $e) {
            throw new InfraException('Erro consultando Par�metro.', $e);
        }
    }

    protected function listarConectado(InfraParametroDTO $objInfraParametroDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_parametro_listar');

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
            $ret = $objInfraParametroBD->listar($objInfraParametroDTO);

            //Auditoria

            return $ret;
        } catch (Exception $e) {
            throw new InfraException('Erro listando Par�metros.', $e);
        }
    }

    protected function contarConectado(InfraParametroDTO $objInfraParametroDTO)
    {
        try {
            //Valida Permissao
            //SessaoInfra::getInstance()->validarPermissao('infra_parametro_listar');

            //Regras de Negocio
            //$objInfraException = new InfraException();

            //$objInfraException->lancarValidacoes();

            $objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
            $ret = $objInfraParametroBD->contar($objInfraParametroDTO);

            //Auditoria

            return $ret;
        } catch (Exception $e) {
            throw new InfraException('Erro contando Par�metros.', $e);
        }
    }
    /*
      protected function desativarControlado($arrObjInfraParametroDTO){
        try {

          //Valida Permissao
          SessaoInfra::getInstance()->validarPermissao('infra_parametro_desativar');

          //Regras de Negocio
          //$objInfraException = new InfraException();

          //$objInfraException->lancarValidacoes();

          $objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
          for($i=0;$i<count($arrObjInfraParametroDTO);$i++){
            $objInfraParametroBD->desativar($arrObjInfraParametroDTO[$i]);
          }

          //Auditoria

        }catch(Exception $e){
          throw new InfraException('Erro desativando Par�metro.',$e);
        }
      }

      protected function reativarControlado($arrObjInfraParametroDTO){
        try {

          //Valida Permissao
          SessaoInfra::getInstance()->validarPermissao('infra_parametro_reativar');

          //Regras de Negocio
          //$objInfraException = new InfraException();

          //$objInfraException->lancarValidacoes();

          $objInfraParametroBD = new InfraParametroBD($this->getObjInfraIBanco());
          for($i=0;$i<count($arrObjInfraParametroDTO);$i++){
            $objInfraParametroBD->reativar($arrObjInfraParametroDTO[$i]);
          }

          //Auditoria

        }catch(Exception $e){
          throw new InfraException('Erro reativando Par�metro.',$e);
        }
      }

     */
}


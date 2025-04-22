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

try {
    //require_once 'Infra.php';

    session_start();

    //////////////////////////////////////////////////////////////////////////////
    //InfraDebug::getInstance()->setBolLigado(false);
    //InfraDebug::getInstance()->setBolDebugInfra(true);
    //InfraDebug::getInstance()->limpar();
    //////////////////////////////////////////////////////////////////////////////

    SessaoInfra::getInstance()->validarLink();

    PaginaInfra::getInstance()->verificarSelecao('infra_parametro_selecionar');

    SessaoInfra::getInstance()->validarPermissao($_GET['acao']);

    $objInfraParametroDTO = new InfraParametroDTO();

    $strDesabilitar = '';

    $arrComandos = array();

    switch ($_GET['acao']) {
        case 'infra_parametro_cadastrar':
            $strTitulo = 'Novo Par�metro';
            $arrComandos[] = '<button type="submit" accesskey="S" name="sbmCadastrarInfraParametro" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
            $arrComandos[] = '<button type="button" accesskey="C" name="btnCancelar" id="btnCancelar" value="Cancelar" onclick="location.href=\'' . SessaoInfra::getInstance(
                )->assinarLink(
                    'controlador.php?acao=' . PaginaInfra::getInstance()->getAcaoRetorno(
                    ) . '&acao_origem=' . $_GET['acao']
                ) . '\';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>';

            $objInfraParametroDTO->setStrNome($_POST['txtNome']);
            $objInfraParametroDTO->setStrValor($_POST['txtValor']);

            if (isset($_POST['sbmCadastrarInfraParametro'])) {
                try {
                    $objInfraParametroRN = new InfraParametroRN();
                    $objInfraParametroDTO = $objInfraParametroRN->cadastrar($objInfraParametroDTO);
                    PaginaInfra::getInstance()->setStrMensagem(
                        'Par�metro "' . $objInfraParametroDTO->getStrNome() . '" cadastrado com sucesso.'
                    );
                    header(
                        'Location: ' . SessaoInfra::getInstance()->assinarLink(
                            'controlador.php?acao=' . PaginaInfra::getInstance()->getAcaoRetorno(
                            ) . '&acao_origem=' . $_GET['acao'] . '&nome=' . $objInfraParametroDTO->getStrNome(
                            ) . PaginaInfra::getInstance()->montarAncora($objInfraParametroDTO->getStrNome())
                        )
                    );
                    die;
                } catch (Exception $e) {
                    PaginaInfra::getInstance()->processarExcecao($e);
                }
            }
            break;

        case 'infra_parametro_alterar':
            $strTitulo = 'Alterar Par�metro';
            $arrComandos[] = '<button type="submit" accesskey="S" name="sbmAlterarInfraParametro" value="Salvar" class="infraButton"><span class="infraTeclaAtalho">S</span>alvar</button>';
            $strDesabilitar = 'disabled="disabled"';

            if (isset($_GET['nome'])) {
                $objInfraParametroDTO->setStrNome($_GET['nome']);
                $objInfraParametroDTO->retTodos();
                $objInfraParametroRN = new InfraParametroRN();
                $objInfraParametroDTO = $objInfraParametroRN->consultar($objInfraParametroDTO);
                if ($objInfraParametroDTO == null) {
                    throw new InfraException("Registro n�o encontrado.");
                }
            } else {
                $objInfraParametroDTO->setStrNome($_POST['hdnNome']);
                $objInfraParametroDTO->setStrValor($_POST['txtValor']);
            }

            $arrComandos[] = '<button type="button" accesskey="C" name="btnCancelar" id="btnCancelar" value="Cancelar" onclick="location.href=\'' . SessaoInfra::getInstance(
                )->assinarLink(
                    'controlador.php?acao=' . PaginaInfra::getInstance()->getAcaoRetorno(
                    ) . '&acao_origem=' . $_GET['acao'] . PaginaInfra::getInstance()->montarAncora(
                        $objInfraParametroDTO->getStrNome()
                    )
                ) . '\';" class="infraButton"><span class="infraTeclaAtalho">C</span>ancelar</button>';

            if (isset($_POST['sbmAlterarInfraParametro'])) {
                try {
                    $objInfraParametroRN = new InfraParametroRN();
                    $objInfraParametroRN->alterar($objInfraParametroDTO);
                    PaginaInfra::getInstance()->setStrMensagem(
                        'Par�metro "' . $objInfraParametroDTO->getStrNome() . '" alterado com sucesso.'
                    );
                    header(
                        'Location: ' . SessaoInfra::getInstance()->assinarLink(
                            'controlador.php?acao=' . PaginaInfra::getInstance()->getAcaoRetorno(
                            ) . '&acao_origem=' . $_GET['acao'] . PaginaInfra::getInstance()->montarAncora(
                                $objInfraParametroDTO->getStrNome()
                            )
                        )
                    );
                    die;
                } catch (Exception $e) {
                    PaginaInfra::getInstance()->processarExcecao($e);
                }
            }
            break;

        case 'infra_parametro_consultar':
            $strTitulo = 'Consultar Par�metro';
            $arrComandos[] = '<button type="button" accesskey="F" name="btnFechar" value="Fechar" onclick="location.href=\'' . SessaoInfra::getInstance(
                )->assinarLink(
                    'controlador.php?acao=' . PaginaInfra::getInstance()->getAcaoRetorno(
                    ) . '&acao_origem=' . $_GET['acao'] . PaginaInfra::getInstance()->montarAncora($_GET['nome'])
                ) . '\';" class="infraButton"><span class="infraTeclaAtalho">F</span>echar</button>';
            $objInfraParametroDTO->setStrNome($_GET['nome']);
            $objInfraParametroDTO->setBolExclusaoLogica(false);
            $objInfraParametroDTO->retTodos();
            $objInfraParametroRN = new InfraParametroRN();
            $objInfraParametroDTO = $objInfraParametroRN->consultar($objInfraParametroDTO);
            if ($objInfraParametroDTO === null) {
                throw new InfraException("Registro n�o encontrado.");
            }
            break;

        default:
            throw new InfraException("A��o '" . $_GET['acao'] . "' n�o reconhecida.");
    }
} catch (Exception $e) {
    PaginaInfra::getInstance()->processarExcecao($e);
}

PaginaInfra::getInstance()->montarDocType();
PaginaInfra::getInstance()->abrirHtml();
PaginaInfra::getInstance()->abrirHead();
PaginaInfra::getInstance()->montarMeta();
PaginaInfra::getInstance()->montarTitle(PaginaInfra::getInstance()->getStrNomeSistema() . ' - ' . $strTitulo);
PaginaInfra::getInstance()->montarStyle();
PaginaInfra::getInstance()->abrirStyle();
?>
    #lblNome {position:absolute;left:0%;top:0%;width:40%;}
    #txtNome {position:absolute;left:0%;top:6%;width:40%;}

    #lblValor {position:absolute;left:0%;top:16%;width:60%;}
    #txtValor {position:absolute;left:0%;top:22%;width:60%;}

<?
PaginaInfra::getInstance()->fecharStyle();
PaginaInfra::getInstance()->montarJavaScript();
PaginaInfra::getInstance()->abrirJavaScript();
?>
    function inicializar(){
    if ('<?= $_GET['acao'] ?>'=='infra_parametro_cadastrar'){
    document.getElementById('txtNome').focus();
    } elseif ('<?= $_GET['acao'] ?>'=='infra_parametro_alterar'){
    document.getElementById('txtValor').focus();
    } elseif ('<?= $_GET['acao'] ?>'=='infra_parametro_consultar'){
    infraDesabilitarCamposAreaDados();
    }else{
    document.getElementById('btnCancelar').focus();
    }
    infraEfeitoImagens();
    infraEfeitoTabelas();
    }

    function validarCadastro() {

    if (infraTrim(document.getElementById('txtNome').value)==''){
    alert('Informe o Nome.');
    document.getElementById('txtNome').focus();
    return false;
    }

    return true;
    }

    function OnSubmitForm() {
    return validarCadastro();
    }

<?
PaginaInfra::getInstance()->fecharJavaScript();
PaginaInfra::getInstance()->fecharHead();
PaginaInfra::getInstance()->abrirBody($strTitulo, 'onload="inicializar();"');
?>
    <form id="frmInfraParametroCadastro" method="post" onsubmit="return OnSubmitForm();"
          action="<?= SessaoInfra::getInstance()->assinarLink(
              'controlador.php?acao=' . $_GET['acao'] . '&acao_origem=' . $_GET['acao']
          ) ?>">
        <?
        PaginaInfra::getInstance()->montarBarraComandosSuperior($arrComandos);
        //PaginaInfra::getInstance()->montarAreaValidacao();
        PaginaInfra::getInstance()->abrirAreaDados('30em');
        ?>
        <label id="lblNome" for="txtNome" accesskey="N" class="infraLabelObrigatorio"><span
                class="infraTeclaAtalho">N</span>ome:</label>
        <input type="text" id="txtNome" name="txtNome" class="infraText"
               value="<?= PaginaInfra::getInstance()->tratarHTML($objInfraParametroDTO->getStrNome()); ?>"
               onkeypress="return infraMascaraTexto(this,event);"
               tabindex="<?= PaginaInfra::getInstance()->getProxTabDados() ?>" maxlength="100" <?= $strDesabilitar ?> />

        <label id="lblValor" for="txtValor" accesskey="V" class="infraLabelOpcional"><span
                class="infraTeclaAtalho">V</span>alor:</label>
        <input type="text" id="txtValor" name="txtValor" class="infraText"
               value="<?= PaginaInfra::getInstance()->tratarHTML($objInfraParametroDTO->getStrValor()); ?>"
               onkeypress="return infraMascaraTexto(this,event);"
               tabindex="<?= PaginaInfra::getInstance()->getProxTabDados() ?>"/>

        <input type="hidden" id="hdnNome" name="hdnNome"
               value="<?= PaginaInfra::getInstance()->tratarHTML($objInfraParametroDTO->getStrNome()); ?>"/>
        <?
        PaginaInfra::getInstance()->fecharAreaDados();
        //PaginaInfra::getInstance()->montarAreaDebug();
        //PaginaInfra::getInstance()->montarBarraComandosInferior($arrComandos);
        ?>
    </form>
<?
PaginaInfra::getInstance()->fecharBody();
PaginaInfra::getInstance()->fecharHtml();

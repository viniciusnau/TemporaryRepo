<?php
/**
 * TRIBUNAL REGIONAL FEDERAL DA 4� REGI�O
 *
 * 28/06/2006 - criado por MGA
 *
 * @package infra_php
 */


abstract class InfraMenu
{

    public abstract function getStrSiglaSistema();

    public function __construct()
    {
    }

    public function montar($strNome)
    {
        if (!isset($_SESSION['INFRA_MENU'])) {
            throw new InfraException('Menu n�o foi carregado na sess�o.');
        }

        if (!is_array($_SESSION['INFRA_MENU'])) {
            throw new InfraException('Menu da sess�o n�o � um array.');
        }

        if (!isset($_SESSION['INFRA_MENU'][$this->getStrSiglaSistema()])) {
            throw new InfraException('Menu do sistema n�o foi carregado na sess�o.');
        }

        if (!is_array($_SESSION['INFRA_MENU'][$this->getStrSiglaSistema()])) {
            throw new InfraException('Menu do sistema na sess�o n�o � um array.');
        }

        if (!isset($_SESSION['INFRA_MENU'][$this->getStrSiglaSistema()][$strNome])) {
            throw new InfraException('Menu ' . $strNome . ' n�o foi carregado na sess�o.');
        }

        if (!is_array($_SESSION['INFRA_MENU'][$this->getStrSiglaSistema()][$strNome])) {
            throw new InfraException('Menu ' . $strNome . ' na sess�o n�o � um array.');
        }

        return $this->montarMenu($_SESSION['INFRA_MENU'][$this->getStrSiglaSistema()][$strNome]);
    }

    //MENU BASEADO NO VETOR
    private function montarMenu($arrMenu)
    {
        $numLimite = InfraArray::contar($arrMenu);
        for ($i = 0; $i < $numLimite; $i++) {
            $strLinhaAtual = explode("^", $arrMenu[$i]);
            $strProximaLinha = explode("^", $arrMenu[$i + 1]);
            //MONTA O LINK DE ACORDO COM O IN�CIO DA URL DO MENU
            if (substr($strLinhaAtual[1], 0, 4) == "java") {
                echo "<li><a href=\"" . $strLinhaAtual[1] . "\" title=\"" . $strLinhaAtual[2] . "\">";
            } elseif ((substr($strLinhaAtual[1], 0, 4) == "http") || (substr($strLinhaAtual[1], 0, 4) == "mail")) {
                echo "<li><a href=\"" . $strLinhaAtual[1] . "\" title=\"" . $strLinhaAtual[2] . "\" target=\"_blank\">";
            } else {
                echo "<li><a href=\"" . $this->strURL . $strLinhaAtual[1] . "\" title=\"" . $strLinhaAtual[2] . "\">";
            }
            echo $strLinhaAtual[3] . "</a>";
            if (strlen($strLinhaAtual[0]) == strlen($strProximaLinha[0])) {
                echo "</li>\n";
            }
            if (strlen($strLinhaAtual[0]) < strlen($strProximaLinha[0])) {
                echo "<ul>\n";
            }
            if (strlen($strLinhaAtual[0]) > strlen($strProximaLinha[0])) {
                echo "</li>\n";
                //CASO O N�VEL POSTERIOR TENHA MAIS DE UM N�VEL EM RELA��O AO ATUAL (PODE SER UM for{})
                if ((strlen($strLinhaAtual[0]) - strlen($strProximaLinha[0])) == 2) {
                    echo "</ul>\n</li>\n";
                }
                if ((strlen($strLinhaAtual[0]) - strlen($strProximaLinha[0])) == 3) {
                    echo "</ul>\n</li>\n</ul>\n</li>\n";
                }
                if ((strlen($strLinhaAtual[0]) - strlen($strProximaLinha[0])) == 4) {
                    echo "</ul>\n</li>\n</ul>\n</li>\n</ul>\n</li>\n";
                }
                //N�O COLOCAR NO �LTIMO ITEM DO MENU
                if ($i < $numLimite - 1) {
                    echo "</ul>\n</li>";
                }
            }
        }
    }
}

?>

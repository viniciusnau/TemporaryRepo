<?php


class IPAreaPaginacaoInfra extends AbstractIPAreaPaginacao
{

    public function render()
    {
        $strTipo = $this->strTipo;
        $strSelecao = $this->strSelecao;
        $strCustomCallbackJs = $this->strCustomCallbackJs;
        $paginaAtual0Indexed = $this->paginaAtual0Indexed;
        $objInfraPagina = $this->objInfraPagina;


        $ret = '<div id="div' . $strSelecao . 'AreaPaginacao' . $strTipo . '" class="infraAreaPaginacao">' . "\n";

        if ($this->hasMaisDeUmaPagina()) {
            $numPaginas = $this->numPaginas;

            if (!$this->isPrimeiraPagina) {
                if ($numPaginas > 2) {
                    $ret .= $this->criarBotaoPaginacao(
                            '=',
                            '0',
                            'Primeira P�gina',
                            'PrimeiraPagina',
                            $objInfraPagina->getIconePaginacaoPrimeira()
                        ) . "&nbsp;&nbsp;\n";
                } else {
                    $ret .= str_repeat('&nbsp;', 7);
                }
                $ret .= $this->criarBotaoPaginacao(
                        '-',
                        '0',
                        'P�gina Anterior',
                        'PaginaAnterior',
                        $objInfraPagina->getIconePaginacaoAnterior()
                    ) . "&nbsp;&nbsp;\n";
            } else {
                $ret .= str_repeat('&nbsp;', 14);
            }

            if ($numPaginas > 2) {
                $strTabIndex = '';
                if ($this->varTabIndex === true) {
                    $strTabIndex = ' tabindex="' . (($strTipo == 'Superior') ? 1001 : 32700) . '"';
                } elseif ($this->varTabIndex !== false && is_numeric($this->varTabIndex)) {
                    $strTabIndex = ' tabindex="' . $this->varTabIndex . '"';
                }

                $ret .= '<select id="sel' . $strSelecao . 'Paginacao' . $strTipo . '" name="sel' . $strSelecao . 'Paginacao' . $strTipo . '" onchange="infraAcaoPaginar(\'=\',this.value,\'' . $strSelecao . '\', ' . $strCustomCallbackJs . ');" class="infraSelect"' . $strTabIndex . ' aria-label="Escolher P�gina" style="display:inline;">' . "\n";
                for ($i = 0; $i < $numPaginas; $i++) {
                    $ret .= '<option value="' . $i . '"';
                    if ($i == $paginaAtual0Indexed) {
                        $ret .= ' selected="selected" ';
                    }
                    $ret .= '>' . ($i + 1) . '</option>' . "\n";
                }
                $ret .= '</select>&nbsp;&nbsp;' . "\n";
            }

            //Se n�o esta na �ltima p�gina
            if (!$this->isUltimaPagina) {
                $ret .= $this->criarBotaoPaginacao(
                        '+',
                        '0',
                        'Pr�xima P�gina',
                        'ProximaPagina',
                        $objInfraPagina->getIconePaginacaoProxima()
                    ) . "&nbsp;&nbsp;\n\n";
                $ret .= '&nbsp;';
                if ($numPaginas > 2) {
                    $ret .= $this->criarBotaoPaginacao(
                        '=',
                        $this->numUltimaPagina,
                        '�ltima P�gina',
                        'UltimaPagina',
                        $objInfraPagina->getIconePaginacaoUltima()
                    );
                }
            }
        }
        $ret .= '</div>' . "\n";

        return $ret;
    }

    protected function criarBotaoPaginacao($jsTipo, $jsPag, $title, $idParcial, $img)
    {
        $onclick = $this->criarJsOnclick($jsTipo, $jsPag);
        $strSelecao = $this->strSelecao;
        $strTipo = $this->strTipo;

        $strTabIndex = '';
        if ($this->varTabIndex === true) {
            $strTabIndex = ' tabindex="' . (($strTipo == 'Superior') ? 1001 : 32700) . '"';
        } elseif ($this->varTabIndex !== false && is_numeric($this->varTabIndex)) {
            $strTabIndex = ' tabindex="' . $this->varTabIndex . '"';
        }


        return <<<html
                    <a id="lnk{$strSelecao}{$idParcial}{$strTipo}" 
                        href="javascript:void(0);" 
                        onclick="$onclick" 
                        title="$title" 
                        $strTabIndex><img src="$img" 
                            title="$title" 
                            alt="$title" 
                            class="infraImg"/></a>
html;
    }
}
<?php

/**
 * @package infra_php
 *
 */
class InfraPosicionarCampos
{
    //os campos conforme foram informados no lan�amento
    private static $POS_ID_CAMPO_SUPERIOR = 0;
    private static $POS_ID_CAMPO_INFERIOR = 1;
    private static $POS_BOL_VISIVEL_SUPERIOR = 2;
    private static $POS_BOL_VISIVEL_INFERIOR = 3;
    private static $POS_CSS_ADICIONAL_SUPERIOR = 4;
    private static $POS_CSS_ADICIONAL_INFERIOR = 5;
    private static $POS_PERCENTUAL_HORIZONTAL_SUPERIOR = 6;
    private static $POS_PERCENTUAL_HORIZONTAL_INFERIOR = 7;
    private static $POS_ID_CAMPO_COMPLEMENTAR_SUPERIOR = 8;
    private static $POS_ID_CAMPO_COMPLEMENTAR_INFERIOR = 9;
    private static $POS_BOL_FORCAR_NOVA_LINHA = 10;
    private static $POS_LINHAS_BRANCAS_ABAIXO = 11;
    private static $POS_DISTANCIA_VERTICAL_INFERIOR = 12;
    private static $POS_BOL_LINHA_SIMPLES = 13;

    private $dblPercentualHorizontalMaximo; //qual a ocupa��o m�xima (percentual) da DIV permitida
    private $dblPercentualHorizontalDefault; //o percentual horizontal default da tela ocupado por cada campo (pode mudar em cada caso)
    private $dblPercentualVerticalLocalCampoInferiorDefault; //o percentual da linha a partir do qual deve ser posicionado o campo inferior (0 = sobre o campo superior, 100 = na linha de baixo)
    private $dblPercentualEspacoEntreCampos; //o percentual da linha que fica de espa�o entre os campos
    private $dblQuantidadeLinhas; //a quantidade de linhas armazenadas dentro do objeto (atualizado quando � executado o m�todo "obterTabelaEstruturada")

    private $arrCamposEstrutura; //array de pares de campos (todos os informados, na ordem em que foram informados)
    private $arrLinhasSimples; //marca��o de quais linhas s�o simples e quais s�o duplas (linha simples conta como "meia linha" , pois o padr�o � que sejam duplas
    private $arrCamposExtra; //arrayd e campos que n�o est�o na estrutura, mas ter�o seu CSS definido por aqui; formato: array(id_campo1=>CSS1, id_campo2=>CSS2...)


    public function __construct()
    {
        $this->dblPercentualHorizontalMaximo = 95;
        $this->dblPercentualHorizontalDefault = 25;
        $this->dblPercentualVerticalLocalCampoInferiorDefault = 40;
        $this->dblPercentualEspacoEntreCampos = 3;
        $this->dblQuantidadeLinhas = 0;

        $this->arrCamposEstrutura = array();
        $this->arrLinhasSimples = array();
        $this->arrCamposExtra = array();
    }

    public function getDblQuantidadeLinhas()
    {
        $this->obterTabelaEstruturada(
        ); //roda a an�lise estrutural apenas para atualizar a quantidade de linhas no objeto
        return $this->dblQuantidadeLinhas;
    }

    public function getDblPercentualHorizontalDefault()
    {
        return $this->dblPercentualHorizontalDefault;
    }

    public function setDblPercentualHorizontalDefault($dblPercentualHorizontalDefault)
    {
        $this->dblPercentualHorizontalDefault = $dblPercentualHorizontalDefault;
    }

    public function getDblPercentualEspacoEntreCampos()
    {
        return $this->dblPercentualEspacoEntreCampos;
    }

    public function setDblPercentualEspacoEntreCampos($dblPercentualEspacoEntreCampos)
    {
        $this->dblPercentualEspacoEntreCampos = $dblPercentualEspacoEntreCampos;
    }

    /**
     * Devolve tabela estruturada com base nos atributos de cada campo
     * A estrutura consiste na posi��o de cada par de campos dentro da linha, bem como na inser��o das linhas em branco necess�rias
     * IMPORTANTE: os campos invis�veis ser�o colocados junto nessa estrutura. Caso o par inteiro seja invis�vel, ele apenas n�o influenciar� na an�lise horizontal da linha (e ser� tratado no momento adequado)
     * IMPORTANTE: este m�todo � que atualiza a quantidade de linhas dentro do objeto
     * @param boolean $bolRetornarCssAdicional - se o c�digo retornado deve incluir o CSS adicional ou apenas a parte relativa ao posicionamento
     * @return array - tabela estruturada contendo os campos em suas posi��es finais e as linhas em branco
     */
    private function obterTabelaEstruturada()
    {
        //DESCOBRE A QUANTIDADE TOTAL DE LINHAS E MONTA ESTRUTURA B�SICA
        $numLinhasEmBranco = 0; //a quantidade de linhas em branco que devem ser acrescentadas depois que a pr�xima linha terminar
        $dblEspacoDisponivel = $this->dblPercentualHorizontalMaximo;

        $arrTabelaEstruturada = array(); //o resultado final
        $arrCamposLinha = array();

        //ADICIONA CAMPOS PROGRESSIVAMENTE
        foreach ($this->arrCamposEstrutura as $arrAtributos) {
            //descobre o espa�o horizontal necess�rio para os campos
            $dblEspacoNecessario = bccomp(
                $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR],
                $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR],
                2
            ) > 0 ? $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR] : $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR];

            //verifica se � poss�vel adicionar linha na tabela estruturada
            if (bccomp($dblEspacoDisponivel, $dblEspacoNecessario, 2) >= 0) { //se h� espa�o dispon�vel, faz
                //ADICIONA CAMPOS NA LINHA CORRENTE
                //diminui o espa�o dispon�vel na linha (desconta campo e espa�o entre campos)
                $dblEspacoDisponivel = bcsub($dblEspacoDisponivel, $dblEspacoNecessario, 2);
                $dblEspacoDisponivel = bcsub($dblEspacoDisponivel, $this->dblPercentualEspacoEntreCampos, 2);

                //adiciona os campos
                $arrCamposLinha[] = $arrAtributos;

                //atualiza a quantidade de linhas brancas adicionais (se necess�rio)
                $numLinhasEmBranco = max($numLinhasEmBranco, $arrAtributos[self::$POS_LINHAS_BRANCAS_ABAIXO]);
            } else { //sen�o, fecha a linha atual e inicia outra
                //ADICIONA A LINHA ANTIGA
                //adiciona linha na tabela estruturada
                $arrTabelaEstruturada[] = $arrCamposLinha;

                //adiciona linhas em branco
                for ($i = $numLinhasEmBranco; $i--; $i > 0) {
                    $arrTabelaEstruturada[] = array();
                }

                //reseta espa�o dispon�vel
                $dblEspacoDisponivel = $this->dblPercentualHorizontalMaximo;

                //ADICIONA CAMPOS NA NOVA LINHA
                //zera linha
                $arrCamposLinha = array();

                //adiciona os campos
                $arrCamposLinha[] = $arrAtributos;

                //diminui o espa�o dispon�vel na linha (desconta campo e espa�o entre campos)
                $dblEspacoDisponivel = bcsub($dblEspacoDisponivel, $dblEspacoNecessario, 2);
                $dblEspacoDisponivel = bcsub($dblEspacoDisponivel, $this->dblPercentualEspacoEntreCampos, 2);

                //atualiza a quantidade de linhas brancas adicionais (se necess�rio)
                $numLinhasEmBranco = $arrAtributos[self::$POS_LINHAS_BRANCAS_ABAIXO];
            }

            //se marcado para encerrar a linha, zera espa�o dispon�vel (vai adicionar efetivamente na pr�xima itera��o)
            if ($arrAtributos[self::$POS_BOL_FORCAR_NOVA_LINHA]) {
                $dblEspacoDisponivel = 0;
            }
        }

        //INSERE OS �LTIMOS CAMPOS E LINHAS EM BRANCO
        //adiciona linha na tabela estruturada
        $arrTabelaEstruturada[] = $arrCamposLinha;

        //adiciona linhas em branco
        for ($i = $numLinhasEmBranco; $i--; $i > 0) {
            $arrTabelaEstruturada[] = array();
        }

        //SETA A QUANTIDADE DE LINHAS DA ESTRUTURA
        //descobre as linhas simples
        $this->dblQuantidadeLinhas = 0; //inicializa quantidade de linhas
        $this->arrLinhasSimples = array(); //inicializa controle de linhas simples
        foreach ($arrTabelaEstruturada as $numLinha => $arrCamposLinha) {
            if (count($arrCamposLinha) == 0) { //se for linha em branco, � dupla
                $this->dblQuantidadeLinhas = bcadd($this->dblQuantidadeLinhas, 1, 1); //adiciona linha como dupla
                $this->arrLinhasSimples[$numLinha] = false;
                continue;
            } else { //se n�o for linha em branco, faz
                foreach ($arrCamposLinha as $arrAtributosCampo) {
                    if (!$arrAtributosCampo[self::$POS_BOL_LINHA_SIMPLES]) { //encontrou um elemento de linha dupla
                        $this->arrLinhasSimples[$numLinha] = false;
                        $this->dblQuantidadeLinhas = bcadd(
                            $this->dblQuantidadeLinhas,
                            1,
                            1
                        ); //adiciona linha como dupla
                        break;
                    }
                }
                if (!isset($this->arrLinhasSimples[$numLinha])) {
                    $this->arrLinhasSimples[$numLinha] = true; //se n�o setou como dupla, ent�o � simples
                    $this->dblQuantidadeLinhas = bcadd(
                        $this->dblQuantidadeLinhas,
                        0.5,
                        1
                    ); //adiciona linha como simples
                }
            }
        }

        return $arrTabelaEstruturada;
    }

    /**
     * Analisa a estrutura de campos e devolve uma listagem contendo a posi��o de cada campo, bem como a largura e os demais atributos
     * Depois analisa os campos-extra (fora da estrutura) e adiciona-os na estrutura
     * @param boolean $bolRetornarCssAdicional - se o c�digo retornado deve incluir o CSS adicional ou apenas a parte relativa ao posicionamento
     * @return array - lista contendo o nome do campo como chave e os atributos a serem setados como valores; formato = array(campo1 => array(nome_atributo1 => valor_atributo1, nome_atributo2 => valor_atributo2 ...), campo2 => array(...))
     */
    private function listarValoresCampos()
    {
        $arrResultado = array(); //o resultado final (uma lista de campos e seus atributos finais)

        //obt�m estrutura a ser analisada
        $arrTabelaEstruturada = $this->obterTabelaEstruturada();

        //descobre o percentual adequado a cada linha (default)
        $dblPercentuaTamanholLinhaDupla = bcdiv('100', $this->dblQuantidadeLinhas, 2); //100% / quantidade de linhas
        $dblPercentuaTamanholLinhaSimples = bcdiv(
            $dblPercentuaTamanholLinhaDupla,
            2,
            2
        ); //(100% / quantidade de linhas) / 2

        //a descida vertical acumulada (i.e., o in�cio do campo na vertical)
        $dblInicioVertical = 0;

        //ANALISA CADA LINHA
        foreach ($arrTabelaEstruturada as $numLinha => $arrCamposLinha) {
            //define o tamanho percentual desta linha a partir da an�lise se � dupla ou simples
            $dblPercentuaTamanholLinha = ($this->arrLinhasSimples[$numLinha]) ? $dblPercentuaTamanholLinhaSimples : $dblPercentuaTamanholLinhaDupla;
            $dblInicioHorizontal = 0; //o in�cio horizontal dos pr�ximos campos

            foreach ($arrCamposLinha as $arrAtributosCampo) {
                //ANALISA O CAMPO SUPERIOR
                if (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_SUPERIOR])) { //se foi setado o campo superior, faz
                    if (!$arrAtributosCampo[self::$POS_BOL_VISIVEL_SUPERIOR]) { //se for invis�vel
                        $arrResultado[$arrAtributosCampo[self::$POS_ID_CAMPO_SUPERIOR]] = array('display' => 'none');
                        //se possui elemento complementar, torna-o invis�vel
                        if (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_SUPERIOR])) {
                            $arrResultado[$arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_SUPERIOR]] = array('display' => 'none');
                        }
                    } else { //se for vis�vel
                        //acumula atributos CSS do campo
                        $arrResultadoAtributosCssCampo = array();

                        //lan�a posi��es, largura e visibilidade
                        $arrResultadoAtributosCssCampo['display'] = 'block';
                        $arrResultadoAtributosCssCampo['left'] = $dblInicioHorizontal . '%';
                        $arrResultadoAtributosCssCampo['top'] = $dblInicioVertical . '%';

                        $strLargura = (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_SUPERIOR])) ? bcsub(
                            $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR],
                            2,
                            2
                        ) : $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR];

                        $arrResultadoAtributosCssCampo['width'] = $strLargura . '%';

                        //lan�a CSS complementar no array de atributos CSS do campo (faz por �ltimo, para poder sobrescrever um atributo calculado, se quiser)
                        if (!InfraString::isBolVazia(trim($arrAtributosCampo[self::$POS_CSS_ADICIONAL_SUPERIOR]))) {
                            $arrAtributosCssCampo = explode(
                                ';',
                                trim($arrAtributosCampo[self::$POS_CSS_ADICIONAL_SUPERIOR])
                            );
                            foreach ($arrAtributosCssCampo as $strAtributoCssCampo) {
                                $arrDadosAtributoCssCampo = explode(':', trim($strAtributoCssCampo));
                                $arrResultadoAtributosCssCampo[trim(
                                    $arrDadosAtributoCssCampo[0]
                                )] = $arrDadosAtributoCssCampo[1];
                            }
                        }

                        //adiciona na lista de resultados
                        $arrResultado[$arrAtributosCampo[self::$POS_ID_CAMPO_SUPERIOR]] = $arrResultadoAtributosCssCampo;

                        //se houver campo complementar, faz
                        if (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_SUPERIOR])) {
                            //descobre o inicio horizontal do complemento
                            $dblInicioHorizontalComplemento = bcadd(
                                $dblInicioHorizontal,
                                $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR],
                                2
                            );
                            $dblInicioHorizontalComplemento = bcsub($dblInicioHorizontalComplemento, 1, 2);

                            $arrResultadoAtributosCssCampo = array();
                            $arrResultadoAtributosCssCampo['display'] = 'block';
                            $arrResultadoAtributosCssCampo['left'] = $dblInicioHorizontalComplemento . '%'; //posi��o + largura do original - 1%
                            $arrResultadoAtributosCssCampo['top'] = $dblInicioVertical . '%';
                            $arrResultadoAtributosCssCampo['position'] = 'absolute';

                            //adiciona na lista de resultados
                            $arrResultado[$arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_SUPERIOR]] = $arrResultadoAtributosCssCampo;
                        }
                    }
                }

                //ANALISA O CAMPO INFERIOR
                if (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_INFERIOR])) { //se foi setado o campo superior, faz
                    if (!$arrAtributosCampo[self::$POS_BOL_VISIVEL_INFERIOR]) { //se for invis�vel
                        $arrResultado[$arrAtributosCampo[self::$POS_ID_CAMPO_INFERIOR]] = array('display' => 'none');
                        //se possui elemento complementar, torna-o invis�vel
                        if (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_INFERIOR])) {
                            $arrResultado[$arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_INFERIOR]] = array('display' => 'none');
                        }
                    } else { //se for vis�vel
                        //acumula atributos CSS do campo
                        $arrResultadoAtributosCssCampo = array();

                        //lan�a posi��es, largura e visibilidade
                        $arrResultadoAtributosCssCampo['display'] = 'block';
                        $arrResultadoAtributosCssCampo['left'] = $dblInicioHorizontal . '%';

                        $dblAjusteVertical = bcdiv(
                            $arrAtributosCampo[self::$POS_DISTANCIA_VERTICAL_INFERIOR],
                            100,
                            2
                        ); //transforma "60%" em "0,6"
                        $dblAjusteVertical = bcmul(
                            $dblPercentuaTamanholLinha,
                            $dblAjusteVertical,
                            2
                        ); //descobre quanto � o percentual em rela��o ao tamanho da linha
                        $arrResultadoAtributosCssCampo['top'] = bcadd(
                                $dblInicioVertical,
                                $dblAjusteVertical,
                                2
                            ) . '%'; //adiciona o ajuste sobre o top original (in�cio da linha)

                        $strLargura = (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_INFERIOR])) ? bcsub(
                            $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR],
                            2,
                            2
                        ) : $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR];
                        $strLargura = (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_INFERIOR])) ? bcsub(
                            $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR],
                            2,
                            2
                        ) : $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR];
                        $arrResultadoAtributosCssCampo['width'] = $strLargura . '%';

                        //lan�a CSS complementar no array de atributos CSS do campo
                        if (!InfraString::isBolVazia(trim($arrAtributosCampo[self::$POS_CSS_ADICIONAL_INFERIOR]))) {
                            $arrAtributosCssCampo = explode(
                                ';',
                                trim($arrAtributosCampo[self::$POS_CSS_ADICIONAL_INFERIOR])
                            );

                            foreach ($arrAtributosCssCampo as $strAtributoCssCampo) {
                                $arrDadosAtributoCssCampo = explode(':', trim($strAtributoCssCampo));
                                $arrResultadoAtributosCssCampo[trim(
                                    $arrDadosAtributoCssCampo[0]
                                )] = $arrDadosAtributoCssCampo[1];
                            }
                        }

                        //adiciona na lista de resultados
                        $arrResultado[$arrAtributosCampo[self::$POS_ID_CAMPO_INFERIOR]] = $arrResultadoAtributosCssCampo;

                        //se houver campo complementar, faz
                        if (!empty($arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_INFERIOR])) {
                            //descobre o inicio horizontal do complemento
                            $dblInicioHorizontalComplemento = bcadd(
                                $dblInicioHorizontal,
                                $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR],
                                2
                            );
                            $dblInicioHorizontalComplemento = bcsub($dblInicioHorizontalComplemento, 1, 2);

                            $arrResultadoAtributosCssCampo = array();
                            $arrResultadoAtributosCssCampo['display'] = 'block';
                            $arrResultadoAtributosCssCampo['left'] = $dblInicioHorizontalComplemento . '%'; //posi��o + largura do original - 1%
                            $arrResultadoAtributosCssCampo['top'] = bcadd(
                                    $dblInicioVertical,
                                    $dblAjusteVertical,
                                    2
                                ) . '%'; //adiciona o ajuste sobre o top original (in�cio da linha)
                            $arrResultadoAtributosCssCampo['position'] = 'absolute';

                            //adiciona na lista de resultados
                            $arrResultado[$arrAtributosCampo[self::$POS_ID_CAMPO_COMPLEMENTAR_INFERIOR]] = $arrResultadoAtributosCssCampo;
                        }
                    }
                }

                //ajusta o in�cio horizontal
                $dblMaiorLargura = bccomp(
                    $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR],
                    $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR],
                    2
                ) > 0 ? $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR] : $arrAtributosCampo[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR];
                if (bccomp($dblMaiorLargura, 0, 2) > 0) { //se algum dos campos era vis�vel (largura > 0), faz
                    $dblInicioHorizontal = bcadd($dblInicioHorizontal, $dblMaiorLargura);
                    $dblInicioHorizontal = bcadd($dblInicioHorizontal, $this->dblPercentualEspacoEntreCampos);
                }
            }

            //terminou de inserir linha ajusta o in�cio vertical para a pr�xima (somando o tamanho da linha atual no total percorrido)
            $dblInicioVertical = bcadd($dblInicioVertical, $dblPercentuaTamanholLinha, 2);
        }

        //PROCESSA CAMPOS-EXTRA (FORA DA ESTRUTURA)
        foreach ($this->arrCamposExtra as $strIdCampo => $strCssCampo) {
            $arrAtributosCssCampo = explode(';', trim($strCssCampo));
            $arrResultadoAtributosCssCampo = array();
            foreach ($arrAtributosCssCampo as $strAtributoCssCampo) {
                $arrDadosAtributoCssCampo = explode(':', trim($strAtributoCssCampo));
                $arrResultadoAtributosCssCampo[trim($arrDadosAtributoCssCampo[0])] = $arrDadosAtributoCssCampo[1];
            }
            $arrResultado[$strIdCampo] = $arrResultadoAtributosCssCampo;
        }

        return $arrResultado;
    }

    /**
     * Imprime o c�digo relativo ao CSS resultante da estrutura��o dos campos armazenados
     * @return string
     */
    public function obterCss()
    {
        //busca campos e atributos (inclui os da extrutura e os extra, fora da estrutura)
        $arrCamposAtributos = $this->listarValoresCampos();

        //cria resultado CSS dos campos da estrutura
        $strResultado = '';
        foreach ($arrCamposAtributos as $strIdCampo => $arrAtributosCampo) {
            //consolida pares de atributos
            $arrStrParesAtributos = array();
            foreach ($arrAtributosCampo as $strChave => $strValor) {
                $arrStrParesAtributos[] = $strChave . ':' . $strValor;
            }
            //associa campo e atributos
            $strResultado .= '     #' . $strIdCampo . ' {' . implode('; ', $arrStrParesAtributos) . '}' . "\r\n";
        }

        //retorna resultado
        return $strResultado;
    }

    /**
     * Imprime o c�digo relativo aos comandos jQuery que resultam na estrutura��o dos campos armazenados (e aplica��o do CSS complementar)
     * @return string
     */
    public function obterJquery()
    {
        //busca campos e atributos (inclui os da extrutura e os extra, fora da estrutura)
        $arrCamposAtributos = $this->listarValoresCampos();

        //cria resultado jQuery
        $strResultado = '';
        foreach ($arrCamposAtributos as $strIdCampo => $arrAtributosCampo) {
            //consolida pares de atributos
            $arrStrParesAtributos = array();
            foreach ($arrAtributosCampo as $strChave => $strValor) {
                $arrStrParesAtributos[] = '\'' . $strChave . '\':\'' . $strValor . '\'';
            }
            //associa campo e atributos
            $strResultado .= '     $("#' . $strIdCampo . '").css({' . implode(
                    ', ',
                    $arrStrParesAtributos
                ) . '});' . "\r\n";
        }

        //retorna resultado
        return $strResultado;
    }

    /**
     * Adiciona campo na estrutura
     * @param string $strIdCampoSuperior - o nome do campo (html) que ser� adicionado na estrutura na parte SUPERIOR da linha (opcional)
     * @param string $strIdCampoInferior - o nome do campo (html) que ser� adicionado na estrutura na parte INFERIOR da linha (opcional)
     * @param boolean $bolVisivelCampoSuperior - se o campo SUPERIOR deve ficar vis�vel ou invis�vel (opcional; default = true = vis�vel)
     * @param boolean $bolVisivelCampoInferior - se o campo INFERIOR deve ficar vis�vel ou invis�vel (opcional; default = true = vis�vel)
     * @param double $dblPercentualHorizontalCampoSuperior - o percentual horizontal que deve ser reservado ao campo SUPERIOR (opcional; default = $this->dblPercentualHorizontalBase <== ser� aplicado o valor definido no momento da adi��o do campo [pode mudar ser redefinido a qualquer tempo]); PS1: se houver campo complementar SUPERIOR, ele diminuir� 2% do espa�o horizontal deste campo;
     * @param double $dblPercentualHorizontalCampoInferior - o percentual horizontal que deve ser reservado ao campo INFERIOR (opcional; default = $this->dblPercentualHorizontalBase <== ser� aplicado o valor definido no momento da adi��o do campo [pode mudar ser redefinido a qualquer tempo]); PS1: se houver campo complementar INFERIOR, ele diminuir� 2% do espa�o horizontal deste campo
     * @param boolean $bolForcarNovaLinha - interrompe a composi��o da linha e come�a abaixo  (opcional)
     * @param string $strIdCampoComplementarCampoSuperior - define um campo (de imagem) complementar: tooltip (ajuda)/calend�rio/a��o; ocupar� os 2% finais do espa�o destinado ao campo SUPERIOR (opcional)
     * @param string $strIdCampoComplementarCampoInferior - define um campo (de imagem) complementar: tooltip (ajuda)/calend�rio/a��o; ocupar� os 2% finais do espa�o destinado ao campo INFERIOR (opcional)
     * @param string $strCssAdicionalCampoSuperior - seta outros par�metros CSS do campo SUPERIOR quando o campo est�/fica vis�vel (opcional; default = "position:absolute"); permite sobrescrever os par�metros calculados automaticamente (top, left e width)
     * @param string $strCssAdicionalCampoInferior - seta outros par�metros CSS do campo INFERIOR quando o campo est�/fica vis�vel (opcional; default = "position:absolute"); permite sobrescrever os par�metros calculados automaticamente (top, left e width)
     * @param int $numLinhasEmBrancoAbaixo - quando a linha corrente for interrompida (por esgotamento horizontal ou uso do $bolForcarNovaLinha), adicionar� linhas em branco  (opcional; default = 0)
     * @param double $dblDistanciaVerticalCampoInferior - o percentual horizontal que deve ser reservado ao campo SUPERIOR (opcional; default = $this->dblPercentualVerticalLocalCampoInferiorDefault)
     * @param boolean $bolLinhaSimples - se a linha, que costuma ser dupla, deve ser simples (opcional; default = false); se houver algum elemento na linha que tenha $bolLinhaSimples = false, ela ser� dupla; se uma linha � marcada como simples, o elemento inferior ser� marcado como invis�vel
     * @return void
     */
    public function adicionarCampoEstrutura(
        $strIdCampoSuperior = null,
        $strIdCampoInferior = null,
        $bolVisivelCampoSuperior = true,
        $bolVisivelCampoInferior = true,
        $dblPercentualHorizontalCampoSuperior = null,
        $dblPercentualHorizontalCampoInferior = null,
        $bolForcarNovaLinha = false,
        $strIdCampoComplementarCampoSuperior = null,
        $strIdCampoComplementarCampoInferior = null,
        $strCssAdicionalCampoSuperior = 'position:absolute',
        $strCssAdicionalCampoInferior = 'position:absolute',
        $numLinhasEmBrancoAbaixo = 0,
        $dblDistanciaVerticalCampoInferior = null,
        $bolLinhaSimples = false
    ) {
        //seta atributos
        $arrAtributos = array();
        $arrAtributos[self::$POS_ID_CAMPO_SUPERIOR] = $strIdCampoSuperior;
        $arrAtributos[self::$POS_ID_CAMPO_INFERIOR] = $strIdCampoInferior;
        $arrAtributos[self::$POS_BOL_VISIVEL_SUPERIOR] = InfraString::isBolVazia(
            $arrAtributos[self::$POS_ID_CAMPO_SUPERIOR]
        ) ? false : $bolVisivelCampoSuperior;
        $arrAtributos[self::$POS_BOL_VISIVEL_INFERIOR] = InfraString::isBolVazia(
            $arrAtributos[self::$POS_ID_CAMPO_INFERIOR]
        ) ? false : $bolVisivelCampoInferior;
        $arrAtributos[self::$POS_CSS_ADICIONAL_SUPERIOR] = $strCssAdicionalCampoSuperior;
        $arrAtributos[self::$POS_CSS_ADICIONAL_INFERIOR] = $strCssAdicionalCampoInferior;

        if ($arrAtributos[self::$POS_BOL_VISIVEL_SUPERIOR]) { //se o campo SUPERIOR est� vis�vel, seta o percentual horizontal ocupado
            $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR] = InfraString::isBolVazia(
                $dblPercentualHorizontalCampoSuperior
            ) ? $this->getDblPercentualHorizontalDefault() : $dblPercentualHorizontalCampoSuperior;
            //garante que o valor n�o extrapola o limite m�ximo
            $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR] = bccomp(
                $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR],
                $this->dblPercentualHorizontalMaximo,
                2
            ) > 0 ? $this->dblPercentualHorizontalMaximo : $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR];
        } else { //se o campo SUPERIOR est� invis�vel, o percentual horizontal ser� 0
            $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_SUPERIOR] = 0;
        }

        $arrAtributos[self::$POS_BOL_LINHA_SIMPLES] = $bolLinhaSimples;
        if ($bolLinhaSimples) { //se a linha � simples, o campo de baixo necessariamente � invis�vel
            $arrAtributos[self::$POS_BOL_VISIVEL_INFERIOR] = false;
        }

        if ($arrAtributos[self::$POS_BOL_VISIVEL_INFERIOR]) { //se o campo INFERIOR est� vis�vel, seta o percentual horizontal ocupado
            $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR] = InfraString::isBolVazia(
                $dblPercentualHorizontalCampoInferior
            ) ? $this->getDblPercentualHorizontalDefault() : $dblPercentualHorizontalCampoInferior;
            //garante que o valor n�o extrapola o limite m�ximo
            $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR] = bccomp(
                $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR],
                $this->dblPercentualHorizontalMaximo,
                2
            ) > 0 ? $this->dblPercentualHorizontalMaximo : $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR];
        } else { //se o campo INFERIOR est� invis�vel, o percentual horizontal ser� 0
            $arrAtributos[self::$POS_PERCENTUAL_HORIZONTAL_INFERIOR] = 0;
        }

        $arrAtributos[self::$POS_ID_CAMPO_COMPLEMENTAR_SUPERIOR] = $strIdCampoComplementarCampoSuperior;
        $arrAtributos[self::$POS_ID_CAMPO_COMPLEMENTAR_INFERIOR] = $strIdCampoComplementarCampoInferior;
        $arrAtributos[self::$POS_BOL_FORCAR_NOVA_LINHA] = $bolForcarNovaLinha;
        $arrAtributos[self::$POS_LINHAS_BRANCAS_ABAIXO] = $numLinhasEmBrancoAbaixo;
        if ($arrAtributos[self::$POS_BOL_VISIVEL_INFERIOR]) { //se o campo INFERIOR est� vis�vel, seta o percentual vertical de in�cio
            $arrAtributos[self::$POS_DISTANCIA_VERTICAL_INFERIOR] = InfraString::isBolVazia(
                $dblDistanciaVerticalCampoInferior
            ) ? $this->dblPercentualVerticalLocalCampoInferiorDefault : $dblDistanciaVerticalCampoInferior;
        } else { //se o campo INFERIOR est� invis�vel, o percentual vertical ser� 0
            $arrAtributos[self::$POS_DISTANCIA_VERTICAL_INFERIOR] = 0;
        }

        //acumula na estrutura
        $this->arrCamposEstrutura[] = $arrAtributos;
    }

    /**
     * Adiciona campo-extra (um campo que n�o participa da estrutura sendo mondada, mas que deve ser inclu�do no CSS/jQuery
     * @param string $strIdCampo - o nome do campo-extra (html)
     * @param string $strCss - seta os par�metros CSS do campo-extra
     * @return void
     */
    public function adicionarCampoExtra($strIdCampo, $strCss)
    {
        $this->arrCamposExtra[$strIdCampo] = $strCss;
    }
}
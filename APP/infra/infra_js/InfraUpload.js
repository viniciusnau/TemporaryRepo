var bolJQuery = typeof jQuery != "undefined";
var infraUploadProgresso = function () {
    var ifr = null;
    var startTime = null;
    var id = null;
    var count = 0;
    var upd = null;
    var inputFile = null;

    return {
        start: function (ifr, inputFile, id) {
            this.ifr = ifr;
            this.id = id;
            this.inputFile = inputFile;
            startTime = new Date();
            count = 0;
            if (bolJQuery && $(this.inputFile).hasClass("infraInputFile")) {
                $(this.inputFile).nextAll('.infraSpanNomeArquivo').first().css("display", 'none');
                $(this.inputFile).prevAll('.infraLabelInputFile').first().css("display", 'none');
            } else {
                this.inputFile.style.display = 'none';
            }
            this.requestInfo();
        },
        clear: function () {
            this.ifr.src = "";
            if (bolJQuery && $(this.inputFile).hasClass("infraInputFile")) {
                $(this.inputFile).prevAll('.infraLabelInputFile').first().css("display", '');
                $(this.inputFile).nextAll('.infraSpanNomeArquivo').first().css("display", 'block');
            } else {
                this.inputFile.style.display = 'block';
            }

        },
        stop: function () {
            startTime = null;
            window.clearTimeout(upd);
            this.requestInfo();
            window.setTimeout("infraUploadProgresso.clear()", 500);
        },
        requestInfo: function () {
            this.ifr.src = INFRA_PATH_JS + "/infra_upload_progresso.php?ID=" + this.id + "&CNT=" + count + "&DT=" + new Date();
            count++;
        },
        updateInfo: function () {
            if (startTime) {
                upd = window.setTimeout("infraUploadProgresso.requestInfo()", 1000);
            }
        }
    }
}()


function infraUpload(form, url, debug) {

    var me = this;
    if (typeof (form) === "object") {
        this.frm = form;
    } else {
        this.frm = document.getElementById(form);
    }
    this.url = url;
    this.debug = debug;
    this.ifr = document.getElementById('ifr' + form);
    this.ifrProgresso = document.getElementById('ifrProgresso' + form);
    this.idProgresso = Math.floor(Math.random() * 999999);
    this.inputFile = null;
    this.bolExecutando = false;

    if (this.ifr == null) {

        this.ifr = document.createElement("iframe");
        this.ifr.setAttribute("id", "ifr" + this.frm.id);
        this.ifr.setAttribute("name", "ifr" + this.frm.id);
        this.ifr.setAttribute("width", "0");
        this.ifr.setAttribute("height", "0");
        this.ifr.setAttribute("border", "0");
        this.ifr.setAttribute("style", "width:0;height:0;border:none;");
        //this.frm.parentNode.appendChild(this.ifr);
        this.frm.appendChild(this.ifr);
        window.frames['ifr' + form].name = "ifr" + this.frm.id;

        infraAdicionarEvento(this.ifr, 'load',
            function () {
                if (typeof (me.finalizou) == 'function') {

                    if (INFRA_IE == 0) {
                        ret = this.contentWindow.document.body.innerHTML;
                    } else {
                        ret = window.frames['ifr' + me.frm.id].document.body.innerHTML;
                    }

                    var arr = null;

                    if (me.bolExecutando) {

                        arr = ret.split("#");

                        //infraOcultarAviso()
                        infraUploadProgresso.stop();
                        setTimeout(function () {
                            me.btnUploadCancelar.style.display = "none";

                        }, 300)
                        if (arr.length != 2 && arr.length != 6) {
                            //alert(ret);
                            if (me.debug == true) {
                                alert('Erro desconhecido realizando upload de arquivo:\n' + ret);
                            } else {
                                alert('Erro desconhecido realizando upload de arquivo.');
                            }
                        } else {
                            if (arr[0] == 'ERRO') {
                                alert(arr[1]);
                            } else {
                                var ret = Array();
                                ret['nome_upload'] = arr[0].infraReplaceAll('\\\'', '');
                                ret['nome'] = arr[1].infraReplaceAll('\\\'', '');
                                if (bolJQuery && $('#spnInfraNomeArquivo' + me.frm.id).length != 0) {
                                    $('#spnInfraNomeArquivo' + me.frm.id).html(ret['nome']);
                                }
                                ret['tipo'] = arr[2];
                                ret['tamanho'] = arr[3];
                                ret['data_hora'] = arr[4];
                                me.finalizou(ret);
                            }
                        }

                        if (INFRA_IE > 0) {
                            window.status = 'Finalizado.';
                        }

                        me.bolExecutando = false;
                    }
                }
            }
        );

        //setando propriedades do form
        this.frm.setAttribute("target", "ifr" + this.frm.id);
        this.frm.setAttribute("method", "post");
        this.frm.setAttribute("enctype", "multipart/form-data");
        this.frm.setAttribute("encoding", "multipart/form-data");
        this.frm.setAttribute("action", me.url);

        //criando input do UploadProgress
        var input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", "UPLOAD_IDENTIFIER");
        input.setAttribute("value", this.idProgresso);
        this.frm.insertBefore(input, this.frm.firstChild);

        var nlist = this.frm.getElementsByTagName('input');
        for (var i = 0; i < nlist.length; i++) {
            var node = nlist[i];
            if (node.getAttribute('type') == 'file') {
                this.inputFile = node;
                break;
            }
        }

        this.ifrProgresso = document.createElement("iframe");
        this.ifrProgresso.setAttribute("id", "ifrProgresso" + this.frm.id);
        this.ifrProgresso.setAttribute("name", "ifrProgresso" + this.frm.id);
        this.ifrProgresso.setAttribute("frameBorder", "none");
        this.ifrProgresso.setAttribute("overflow", "hidden");
        this.ifrProgresso.setAttribute("scrolling", "no");
        this.ifrProgresso.setAttribute("height", "25px");
        this.ifrProgresso.tabIndex = -1;
        this.ifrProgresso.style.zIndex = "-1";

        if (bolJQuery && $(this.inputFile).hasClass("infraInputFile")) {
            this.ifrProgresso.setAttribute("style", "position:absolute;border:none;padding:0;margin-top:6px;z-index:-1");
            this.ifrProgresso.setAttribute("width", "80%");
            var labelFile = $(this.inputFile).prevAll('.infraLabelInputFile').first();
            this.ifrProgresso.style.top = labelFile.css("top");
            $(labelFile).keypress(function (event) {
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if (keycode == '13') {
                    me.inputFile.click();
                }
            });
        } else {
            this.ifrProgresso.setAttribute("style", "position:absolute;border:none;padding:0;z-index:-1");
            this.ifrProgresso.setAttribute("width", this.inputFile.offsetWidth - 80 + "px");
            this.ifrProgresso.style.top = this.inputFile.offsetTop + "px";
            this.ifrProgresso.style.left = this.inputFile.offsetLeft + "px";
            this.inputFile.parentNode.appendChild(this.ifrProgresso);
        }

        this.btnUploadCancelar = document.createElement("button");
        this.btnUploadCancelar.setAttribute("id", "btnUploadCancelar" + this.frm.id);
        this.btnUploadCancelar.setAttribute("name", "btnUploadCancelar" + this.frm.id);
        this.btnUploadCancelar.setAttribute("class", "infraButton");
        this.btnUploadCancelar.setAttribute("value", "Cancelar");
        this.btnUploadCancelar.setAttribute("style", "position:absolute;font-size:1em;");
        this.btnUploadCancelar.style.display = 'none';
        this.btnUploadCancelar.textContent = "Cancelar";
        this.btnUploadCancelar.tabIndex = this.inputFile.tabIndex;

        if (INFRA_IE > 0) {
            this.btnUploadCancelar.innerText = "Cancelar";
        }
        this.btnUploadCancelar.onclick = function () {
            //history.go(0);
            infraUploadProgresso.stop();
            infraUploadProgresso.clear();
            me.btnUploadCancelar.style.display = "none";
        }
        if (bolJQuery && $(this.inputFile).hasClass("infraInputFile")) {

            var labels = document.getElementsByClassName('infraLabelInputFile')
            if (labels.length) {

                labels[0].tabIndex = this.inputFile.tabIndex;

                label = $(labels[0]);

                this.btnUploadCancelar.style.top = label.css("top");
                this.inputFile.parentNode.appendChild(this.btnUploadCancelar);
                this.ifrProgresso.style.left = $(this.btnUploadCancelar).width() + 30 + "px";
                this.inputFile.parentNode.appendChild(this.ifrProgresso);

                var spanNomeArquivo = document.createElement("span");
                spanNomeArquivo.setAttribute("style", "position:absolute;font-size:1.2em;display:none;");
                spanNomeArquivo.style.top = label.css("top");
                spanNomeArquivo.style.paddingTop = (label.height()) / 2 - 3 + "px";
                if (label.css("top") != "auto") {
                    spanNomeArquivo.style.top = label.css("top");
                } else {
                    spanNomeArquivo.style.top = "0px";
                }
                spanNomeArquivo.style.left = label.width() + 30 + "px";
                spanNomeArquivo.setAttribute("id", "spnInfraNomeArquivo" + this.frm.id);
                spanNomeArquivo.setAttribute("class", "infraSpanNomeArquivo");
                this.inputFile.parentNode.appendChild(spanNomeArquivo);
            }
        } else {
            this.btnUploadCancelar.style.top = this.inputFile.offsetTop + "px";
            this.btnUploadCancelar.style.left = this.inputFile.offsetLeft + this.inputFile.offsetWidth - 60 + "px";
            this.inputFile.parentNode.appendChild(this.btnUploadCancelar);
        }
    }

    this.executar = function () {

        if (typeof (me.validar) == 'function') {
            if (!me.validar()) {
                return;
            }
        }

        //infraExibirAviso();

        infraUploadProgresso.start(me.ifrProgresso, me.inputFile, me.idProgresso);
        me.btnUploadCancelar.style.display = "";
        me.bolExecutando = true;

        //submetendo
        me.frm.submit();
    }

    if (window.attachEvent) { //Limpar as refer�ncias do IE
        window.attachEvent("onunload", function () {
            me.ifr = null;
            me.ifrProgresso = null;
            me.frm = null;
            me = null;
        });
    }
}
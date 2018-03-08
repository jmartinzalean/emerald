<div class="panel panel-default panel-table">
    <div class="panel-body resultados">
        <div class="well well-sm">
            <div class="row text-weight">
                <div class="col col-sm-1"></div>
                <div class="col col-sm-4">Jugador&nbsp;&nbsp;&nbsp;
                    <select id="username" name="username" class="select2" placeholder="Escriba las tres primeras letras..."><option></option></select>
                </div>
                <div class="col col-sm-4 text-center">Campo&nbsp;&nbsp;&nbsp;
                    <select id="campo_resultado" name="campo_resultado" class="select2"></select>
                </div>
                <div class="col col-sm-3"><button type="button" class="btn btn-primary btn-sm buscar" data-region="search_button">Buscar</button></div>
            </div>
        </div>
        <div class="well well-sm resultados">
            <form id="resultado" class="campo_form hidden" name="resultado" data-region="result">
                <input type="hidden" name="id_user" value="" data-region="user">
                <input type="hidden" name="id_campo" value="" data-region="camp">
                <input type="hidden" name="id_egr" value="0" data-region="id_egr">
                <input type="hidden" name="id_result" value="0" data-region="id_result">                
                <div class="row search_head">
                    <div class="col col-sm-2"><span id="selected_user" data-region="selected_user"></span></div>
                    <div class="col col-sm-1"><input type="text" data-region="license_user" value="" name="license_user" id="license_user" placeholder="Licencia"></div>
                    <div class="col col-sm-3 text-center"><span id="selected_campo" data-region="selected_camp"></span></div>
                    <div class="col col-sm-2"><input type="text" data-region="handicap_user" value="" name="handicap" id="handicap_user" placeholder="Handicap"></div>
                    <div class="col col-sm-2">
                        <select name="category" data-region="category" multiple="multiple" class="form-control">
                            <option value="1" data-value="0">Menos 13,4</option>
                            <option value="2" data-value="0">Más 13.5</option>
                            <option value="3" data-value="0">Senior</option>
                        </select>
                    </div>
                    <div class="col col-sm-2 text-center">
                        <button type="button" class="btn btn-primary btn-sm puntuar" data-toggle="collapse" href="#collapse_resultados">Puntuar</button>
                    </div>
                </div>

                <div id="collapse_resultados" class="panel-collapse collapse">
                
                    <div class="panel-body panel-campo success">
                        <div class="row">
                            <div class="col col-sm-1">
                                <span class="label label-default">HOYOS</span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                        <?php for($i=1;$i<10;$i++){ ?>
                                            <td><?php echo $i; ?></td>
                                        <?php } ?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-1 text-center">
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                        <?php for($i=10;$i<19;$i++){ ?>
                                            <td><?php echo $i; ?></td>
                                        <?php } ?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-1 text-center">
                            </div>
                            <div class="col col-sm-1 text-center">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-1">
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span class="label label-default">SUBTOTAL</span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span class="label label-default">SUBTOTAL</span>
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span class="label label-default">TOTAL</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-1">
                                <span class="label label-default">RESULTADO<br>BRUTO</span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                            <?php for($i=1;$i<10;$i++){ ?>
                                            <td class="handicap">
                                                <select class="form-control" name="hole_<?php echo $i; ?>" data-subtotal="subtotal1">
                                                    <option value="0">-</option>
                                                    <?php for($e=1;$e<9;$e++){ ?>
                                                        <option value="<?php echo $e; ?>"><?php echo $e; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span id="subtotal1" class="subtotal1" data-value="0">0</span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                            <?php for($i=10;$i<19;$i++){ ?>
                                            <td class="handicap">
                                                <select class="form-control" name="hole_<?php echo $i; ?>" data-subtotal="subtotal2">
                                                    <option value="0">-</option>
                                                    <?php for($e=1;$e<9;$e++){ ?>
                                                        <option value="<?php echo $e; ?>"><?php echo $e; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </td>
                                            <?php } ?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span id="subtotal2" class="subtotal2" data-value="0">0</span>
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span id="total" class="total" data-value="0">0</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-10"></div>
                            <div class="col col-sm-2 text-center">
                                <button type="button" class="btn btn-primary btn-sm guardar" data-region="save_button">Guardar</button>
                                <button type="button" class="btn btn-primary btn-sm borrar" >Borrar</button>
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>
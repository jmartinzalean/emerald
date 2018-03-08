<div class="panel panel-default panel-table">
    <div class="panel-body campos">
        <div class="well well-sm">
            <div class="row text-weight">
                <div class="col col-sm-3">Nombre del campo</div>
                <div class="col col-sm-2">Provincia</div>
                <div class="col col-sm-2 text-center">Teléfono</div>
                <div class="col col-sm-1 text-center">Tarjeta</div>
                <div class="col col-sm-4 text-center"></div>
            </div>
        </div>
    <?php if(count($camps)>0){
        foreach($camps as $camp){
            $total = 0;
            $subtotal1 = 0;
            $subtotal2 = 0;
    ?>
        <div class="well well-sm campos">
            <form id="campo<?php echo $camp->id;?>" class="campo_form" name="campo<?php echo $camp->id;?>">
                <input type="hidden" class="id_camp" name="id_camp" value="<?php echo $camp->id;?>" />
                <div class="row">
                    <div class="col col-sm-3 uppercase"><?php echo $camp->name;?></div>
                    <div class="col col-sm-2"><?php echo $camp->state;?></div>
                    <div class="col col-sm-2 text-center"><?php echo $camp->phone;?></div>
                    <div class="col col-sm-1 text-center">
                        <?php if(!$camp->holes){?>
                            <?php for($h=1;$h<=18;$h++){?>
                                <input type="hidden" class="id_card" name="id_card<?php echo $h;?>" value="0" />
                            <?php }?>
                        <div class="btn btn-danger btn-circle"></div>
                        <?php }else{?>
                            <?php foreach($camp->holes as $key=>$hole){?>
                                <input type="hidden" class="id_card" name="id_card<?php echo $key;?>" value="<?php echo $camp->holes[$key]->id_card;?>" />
                            <?php }?>
                        <div class="btn btn-success btn-circle"></div>
                        <?php }?>
                    </div>
                    <div class="col col-sm-4 text-center">
                        <button type="button" class="btn btn-primary btn-sm crear <?php if($camp->holes){echo'hidden';}?>" data-toggle="collapse" href="#collapse<?php echo $camp->id;?>">Crear</button>
                        <button type="button" class="btn btn-primary btn-sm modificar <?php if(!$camp->holes){echo'hidden';}?>" data-toggle="collapse" href="#collapse<?php echo $camp->id;?>">Modificar</button>
                    </div>
                </div>

                <div id="collapse<?php echo $camp->id;?>" class="panel-collapse collapse">
                    <div class="panel-body panel-campo<?php if(!$camp->holes){echo ' danger';}else{echo ' success';}?>">
                        
                        <div class="row">
                            <div class="col col-sm-1">
                                <span class="label label-default">HOYOS</span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                        <?php for($hoyo=1;$hoyo<=9;$hoyo++){?>
                                            <td class="td_label">
                                                <?php echo $hoyo;?>
                                            </td>
                                        <?php }?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span class="label label-default">SUBTOTAL</span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                        <?php for($hoyo=10;$hoyo<=18;$hoyo++){?>
                                            <td>
                                                <?php echo $hoyo;?>
                                            </td>
                                        <?php }?>
                                        </tr>
                                    </table>
                                </span>
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
                                <span class="label label-default">PAR</span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                        <?php if($camp->holes){ $i = 0;?>
                                            <?php foreach($camp->holes as $hole){$i++?>
                                                <?php if($i<=9){
                                                    $subtotal1 = $subtotal1 + $hole->par;
                                                ?>
                                                    <td class="par">
                                                        <select class="form-control" name="par<?php echo $i;?>">
                                                        <?php
                                                        for($a=3;$a<=5;$a++){
                                                            echo '<option value="'.$a.'"';
                                                            if($hole->par==$a){
                                                                echo ' selected';
                                                            }
                                                            echo '>'.$a.'</option>';
                                                        }
                                                        ?>
                                                        </select>
                                                    </td>
                                                <?php }?>
                                            <?php }?>
                                        <?php }else{?>
                                            <?php for($par=1;$par<=9;$par++){?>
                                                <td class="par">
                                                    <select class="form-control" name="par<?php echo $par;?>">
                                                        <option value="0">0</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </td>
                                            <?php }?>
                                        <?php }?>
                                        <?php $total = $total + $subtotal1;?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span id="subtotal1_<?php echo $camp->id;?>" class="subtotal1"><?php if(!$camp->holes){echo'0';}else{echo $subtotal1;}?></span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                        <?php if($camp->holes){ $i = 0;?>
                                            <?php foreach($camp->holes as $hole){$i++?>
                                                <?php if($i>=10){
                                                    $subtotal2 = $subtotal2 + $hole->par;
                                                ?>
                                                    <td class="par">
                                                        <select class="form-control" name="par<?php echo $i;?>">
                                                        <?php
                                                        for($a=3;$a<=5;$a++){
                                                            echo '<option value="'.$a.'"';
                                                            if($hole->par==$a){
                                                                echo ' selected';
                                                            }
                                                            echo '>'.$a.'</option>';
                                                        }
                                                        ?>
                                                        </select>
                                                    </td>
                                                <?php }?>
                                            <?php }?>
                                        <?php }else{?>
                                            <?php for($par=10;$par<=18;$par++){?>
                                                <td class="par">
                                                    <select class="form-control" name="par<?php echo $par;?>">
                                                        <option value="0">0</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </td>
                                            <?php }?>
                                        <?php }?>
                                        <?php $total = $total + $subtotal2;?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span id="subtotal2_<?php echo $camp->id;?>" class="subtotal2"><?php if(!$camp->holes){echo'0';}else{echo $subtotal2;}?></span>
                            </div>
                            <div class="col col-sm-1 text-center">
                                <span id="total<?php echo $camp->id;?>" class="total"><?php if(!$camp->holes){echo'0';}else{echo $total;}?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-1">
                                <span class="label label-default">HANDICAP</span>
                            </div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                        <?php if($camp->holes){ $i = 0;?>
                                            <?php foreach($camp->holes as $hole){$i++?>
                                                <?php if($i<=9){?>
                                                <td class="handicap">
                                                    <input type="text" class="form-control" name="handicap<?php echo $i;?>" value="<?php echo $hole->handicap; ?>">
                                                </td>
                                                <?php }?>
                                            <?php }?>
                                        <?php }else{?>
                                            <?php for($par=1;$par<=9;$par++){?>
                                                <td class="handicap">
                                                    <input type="text" class="form-control" name="handicap<?php echo $par;?>" value="<?php echo 0; ?>">
                                                </td>
                                            <?php }?>
                                        <?php }?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-1 text-center"></div>
                            <div class="col col-sm-4 text-center hoyos">
                                <span class="label label-default">
                                    <table class="table">
                                        <tr>
                                        <?php if($camp->holes){ $i = 0;?>
                                            <?php foreach($camp->holes as $hole){$i++?>
                                                <?php if($i>=10){?>
                                                <td class="handicap">
                                                    <input type="text" class="form-control" name="handicap<?php echo $i;?>" value="<?php echo $hole->handicap; ?>">
                                                </td>
                                                <?php }?>
                                            <?php }?>
                                        <?php }else{?>
                                            <?php for($par=10;$par<=18;$par++){?>
                                                <td class="handicap">
                                                    <input type="text" class="form-control" name="handicap<?php echo $par;?>" value="<?php echo 0; ?>">
                                                </td>
                                            <?php }?>
                                        <?php }?>
                                        </tr>
                                    </table>
                                </span>
                            </div>
                            <div class="col col-sm-2 text-center">
                                <button type="button" class="btn btn-primary btn-sm borrar <?php if(!$camp->holes){echo'hidden';}?>">Borrar</button>
                                <button type="button" class="btn btn-primary btn-sm guardar" data-toggle="collapse" href="#collapse<?php echo $camp->id;?>">Guardar</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    <?php
        }
    }
    ?>
    </div>
</div>
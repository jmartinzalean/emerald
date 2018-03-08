<?php
// JUAN, esto es un boceto, llevar a clases


global $wpdb;


$results = $wpdb->get_results("SELECT r.*, g.id_user, ca.`name` AS 'campo', ca.id as 'id_camp', egr.id_event as 'id_event', 
c.`name` as 'name_category', c.id as 'id_category', egr.handicap_game
FROM wp_ttg_events_gamers_results egr
LEFT JOIN wp_ttg_events_gamers_results_category egrc ON egrc.id_event_gamers_result=egr.id
LEFT JOIN wp_ttg_category c ON egrc.id_category=c.id
LEFT JOIN wp_ttg_gamers g ON egr.id_gamer=g.id
LEFT JOIN wp_users u ON g.id_user=u.ID
LEFT JOIN wp_ttg_events e ON egr.id_event = e.id
LEFT JOIN wp_ttg_results r ON r.id = egr.id_result
LEFT JOIN wp_ttg_camps ca ON e.id_camp=ca.id");

$gamers=array();
$allgamers=array();
foreach ($results as $value) {
   $gamers[$value->name_category][$value->id_user]=array('',0,0); 
   $allgamers[$value->id_user]=array('',0,0); 
}

$pars=array();
$strikes=array();
$points=array();
$category=array();
$arrayend=array();

$categories=$wpdb->get_results("SELECT c.`name` AS 'name', c.id AS 'id' FROM wp_ttg_category c WHERE c.state=1");
foreach ($categories as $value) {
    $points[$value->name]= $gamers[$value->name];
    $category[$value->id]=$value->name;
}

$points['Scracth']=$allgamers;

foreach ($results as $result) {
    $card=$wpdb->get_results("SELECT c.hole, c.par, c.handicap_hole FROM wp_ttg_cards c WHERE c.id_camp =".$result->id_camp);
    $pars = preparecard($card);
    if(round($result->handicap_game)>0){
        $handicapcamp= preparehandicap(round($result->handicap_game));    
    }else{
        $handicapcamp= preparehandicapless(round($result->handicap_game));
    }
    $strikes = completestrike($result);
    $user = get_user_meta( $result->id_user );
    $sumpoints = sumpoints($strikes, $pars);
    $cardhandicap= cardwithhandicap($card, $handicapcamp);
    $parshandicap= preparecard($cardhandicap);
    $sumpointshandicap = sumpoints($strikes, $parshandicap);
    $points[$result->name_category][$result->id_user]=array($user['first_name'][0].' '.$user['last_name'][0],
        $sumpointshandicap+$points[$result->name_category][$result->id_user][1],$points[$result->name_category][$result->id_user][2]+1);
    if($result->id_category!=3){
        $points['Scracth'][$result->id_user]=array($user['first_name'][0].' '.$user['last_name'][0],
            $sumpoints+$points['Scracth'][$result->id_user][1],$points['Scracth'][$result->id_user][2]+1);
    }
}



foreach ($category as $value) {
    usort($points[$value],"orderbypoints");
    $arrayend[$value]=$points[$value];
}
usort($points['Scracth'], "orderbypoints");
$arrayend['Scracth']=$points['Scracth'];

//var_dump($points);
  
function orderbypoints($a,$b){
    return ($a[1] <= $b[1]) ? 1 : -1;
}

function sumpoints($strikes,$pars){
    $points=0;
    for($i=1;$i<19;$i++){
        $points=$points+comparestrikepar($strikes[$i], $pars[$i]);
    }
    return $points;
}

function comparestrikepar($strike,$pars) {
    if($strike==0){
        $strike=10;
    }
    switch ($strike-$pars){
        case 1:
            return 1;
            break;
        case 0:
            return 2;
            break;
        case -1:
            return 3;
            break;
        case -2:
            return 4;
            break;
        case -3:
            return 5;
            break;
        case -4:
            return 6;
            break;
        default :
            return 0;
            break;
    }
}

function preparecard($cards){
    $pars=array();
    foreach ($cards as $card) {
        $pars[$card->hole]=$card->par;
    }
    return $pars;
}

function preparehandicap($handicap){
    $result=array();
    for($i=1;$i<19;$i++){
        $result[$i]=0;
    }
    $e=1;
    for($i=1;$i<$handicap+1;$i++){
        $result[$e]++;
        if($i==18 || $i==36 || $i==54){
            $e=1;
        }else{
            $e++;
        }
    }
    return $result;
}

function preparehandicapless($handicap){
    $result=array();
    for($i=1;$i<19;$i++){
        $result[$i]=0;
    }
    $e=18;
    while($handicap!=0){
        $result[$e]--;
        $handicap++;
        if($e==1){
            $e=18;
        }else{
            $e--;
        }
    }
    return $result;
}

function cardwithhandicap($cards,$handicaps){
    $data = $cards;
    foreach ($cards as $key => $card) {
        $data[$key]->par=$card->par+$handicaps[$card->handicap_hole];
    }
    return $data;
}

//preparamos los holes
function completestrike($hole){
    return array(
        1=>$hole->hole_1,
        2=>$hole->hole_2,
        3=>$hole->hole_3,
        4=>$hole->hole_4,
        5=>$hole->hole_5,
        6=>$hole->hole_6,
        7=>$hole->hole_7,
        8=>$hole->hole_8,
        9=>$hole->hole_9,
        10=>$hole->hole_10,
        11=>$hole->hole_11,
        12=>$hole->hole_12,
        13=>$hole->hole_13,
        14=>$hole->hole_14,
        15=>$hole->hole_15,
        16=>$hole->hole_16,
        17=>$hole->hole_17,
        18=>$hole->hole_18
    );
}
?>

<div id="main-container" class="container">
<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
	<div class="row main_row">
		<div class="col-sm-12 col-md-4">
			<div class="col-sm-12">
				<figure class="xxx">
					<div data-thumg="<?php echo $image[0];?>" class="">
						<img src="<?php echo $image[0];?>" class="xxx" alt="" data-src="<?php echo $image[0];?>" />
					</div>
				</figure>
			</div>
		</div>
		<div class="col-sm-12 col-md-8">
			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
			<?php $i=0; foreach($arrayend as $category=>$ranking){ $i++?>
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="heading_<?php echo $i;?>">
						<h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $i;?>" aria-expanded="<?php if($i<2){echo'true';}else{echo 'false';}?>" aria-controls="collapse_<?php echo $i;?>">
								<strong>Categoría:</strong> <?php echo $category;?>
							</a>
						</h4>
					</div>
					<div id="collapse_<?php echo $i;?>" class="panel-collapse collapse <?php if($i<2){echo'in';}?>" role="tabpanel" aria-labelledby="heading_<?php echo $i;?>">
						<div class="panel-body">
							<table class="table">
								<thead>
									<tr>
										<th>Posición</th>
										<th>Jugador</th>
										<th>Puntos Stableford</th>
                                                                                <th>Pruebas Jugadas</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($ranking as $position=>$row){?>
									<tr>
										<td><?php echo $position+1;?></td>
                                                                                <td class="name_row"><?php echo $row[0];?></td>
										<td><?php echo $row[1];?></td>
                                                                                <td><?php echo $row[2];?></td>
									</tr>
								<?php }?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php }?>
			</div>
		</div>
	</div>
</div>
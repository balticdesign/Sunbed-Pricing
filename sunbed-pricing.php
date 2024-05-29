<?php

function saving_percentage( $payg, $comp  ) {
	if (is_numeric($payg) && $payg > 0) {
    $saving = $payg - $comp;
    $percentage = round(($saving / $payg) * 100);
    $saving_html = '<span class="orange">Saving '.$percentage.'% compared to Pay As You Go</span>';
return $saving_html;
	}
}

function bd_sunbed_pricing() { 
    $sbedhtml = '';
if( have_rows('sunbeds_prices') ):
$i = 0;
$sbedhtml .= '<div class="suntabs">';
    // Loop through rows.
while( have_rows('sunbeds_prices') ) : the_row();

    $i++;    
    $stcf = get_sub_field('stc_from');
    $stct = get_sub_field('stc_to');     
    $payg = get_sub_field('payg_price'); 
    $unlim = get_sub_field('mbr_price'); 
    $sun_img = get_sub_field('sunbed_image');
    $sbname = get_sub_field('sunbed_name');
    $sbdesc = get_sub_field('sunbed_description');
    $sbtype = get_sub_field('sunbed_type');
    $p60min = get_sub_field('60_min_price'); 
    $p75min = get_sub_field('75_min_price'); 
    $p90min = get_sub_field('90_min_price'); 
    $p100min = get_sub_field('100_min_price'); 
    $p120min = get_sub_field('120_min_price'); 
    $p150min = get_sub_field('150_min_price');		
    $sesh5 = get_sub_field('5_session_package');
    $sesh10 = get_sub_field('10_session_package'); 

    $price = array();
    $session = array();
    //Create an array of prices to find the cheapest
    if (($p60min) && (is_numeric($p60min)))     $price[] = number_format(($p60min/60), 2);
    if (($p75min) && (is_numeric($p75min)))     $price[] = number_format(($p75min/75), 2);
    if (($p90min) && (is_numeric($p90min)))     $price[] = number_format(($p90min/90), 2);
    if (($p100min) && (is_numeric($p100min)))   $price[] = number_format(($p100min/100), 2);
    if (($p120min) && (is_numeric($p120min)))   $price[] = number_format(($p120min/120), 2);
    if (($p150min) && (is_numeric($p150min)))   $price[] = number_format(($p150min/150), 2);

    //Create an array of Sessions to find the cheapest
    if (($sesh5) && (is_numeric($sesh5)))   $session[] = number_format(($sesh5/5), 2);
    if (($sesh10) && (is_numeric($sesh10)))   $session[] = number_format(($sesh10/10), 2);

    $TITLE = '<h3 style="margin-top:10px" class="orange">'.$sbname.' ('.$sbtype.')</h3>';
    $CSL = (($stcf) && ($stct)) ? '<em>'.$stcf.' - '.$stct.' Minute Session (Subject to consultation)</em><br>' : '';
    $MBR = ($unlim) ? 'Monthly Unlimited Membership £'.$unlim.'<br>' : '' ;
    $MIN60 = ($p60min) ? '60 Minute Package £'.$p60min.' <strong>(ONLY £'.number_format(($p60min/60), 2).'/MIN) '.saving_percentage($payg, ($p60min/60)).'</strong><br>'  : ''; 
    $MIN75 = ($p75min) ? '75 Minute Package £'.$p75min.' <strong>(ONLY £'.number_format(($p75min/75), 2).'/MIN) '.saving_percentage($payg, ($p75min/75)).'</strong><br>'  : '';
    $MIN90 = ($p90min) ? '90 Minute Package £'.$p90min.' <strong>(ONLY £'.number_format(($p90min/90), 2).'/MIN) '.saving_percentage($payg, ($p90min/90)).'</strong><br>'  : '';
    $MIN100 = ($p100min) ? '100 Minute Package £'.$p100min.' <strong>(ONLY £'.number_format(($p100min/100), 2).'/MIN) '.saving_percentage($payg, ($p100min/100)).'</strong><br>'  : '';
    $MIN120 = ($p120min) ? '120 Minute Package £'.$p120min.' <strong>(ONLY £'.number_format(($p120min/120), 2).'/MIN) '.saving_percentage($payg, ($p120min/120)).'</strong><br>'  : '';
    $MIN150 = ($p150min) ? '150 Minute Package £'.$p150min.' <strong>(ONLY £'.number_format(($p150min/150), 2).'/MIN) '.saving_percentage($payg, ($p150min/150)).'</strong><br>'  : '';
    $PAYG1 = '';

if ($payg) {

if ($payg <= 5 && is_numeric($payg)) $price[] = $payg;
if ($payg > 5 && is_numeric($payg)) $session[] = $payg;
if (!empty($price)) {
    $lowest = min(array_filter($price));
}
$TITLE = '<h3 style="margin-top:10px" class="orange">'.$sbname.' ('.$sbtype.') From £'.$lowest.' per '.(($payg > 5) ? 'session' : 'minute').'</h3>';
$PAYG1 = ($payg > 5) ? '£'.number_format($payg, 2).' Per Session </strong><br><br>' : 'Pay As You Go <strong>ONLY £'.number_format($payg, 2).'/MIN</strong><br><br>';
}  
if ($session) {
$lowest = min(array_filter($session));
$TITLE = '<h3 style="margin-top:10px" class="orange">'.$sbname.' ('.$sbtype.') From £'.$lowest.' per session</h3>';
}


$S5 = ($sesh5) ? '5 Session Package £'.number_format($sesh5, 2).'<br>' : '';
$S10 = ($sesh10) ? '10 Session Package £'.number_format($sesh10, 2).'<br>' : '';
$pack13to20 = get_sub_field('13to20_mins'); 
$pack6to12 = get_sub_field('6to12_mins');

if ($pack13to20) { 
$PK13_20 = (is_numeric($pack13to20)) ?  '13 – 20 Minutes £'.number_format($pack13to20, 2).' per session<br>' : '£'.$pack13to20.'<br>';
} else { 
$PK13_20 = ''; 
}
         
if ($pack6to12) { 
$PK6_12 = (is_numeric($pack6to12)) ? '6 – 12 Minutes £'.number_format($pack6to12, 2).' per minute<br>' : '£'.$pack6to12.'<br>';
} else { 
$PK6_12 = ''; 
}
if ($i == 1) { $checked = 'checked'; } else { $checked = ''; }
        // Create HTML
        $sbedhtml .= '<input type="radio" class="suntabs__radio" name="tabs-sunbed" id="tab'.$i.'"'.$checked.'>';
        $sbedhtml .= '<label for="tab'.$i.'" class="suntabs__label">'.get_sub_field('sunbed_name').' ('.get_sub_field('sunbed_type').')</label>';
        $sbedhtml .= '<div class="suntabs__content">';
        $sbedhtml .= '<img style="width:350px; height:auto;"src="'.$sun_img.'" />';
        $sbedhtml .= $TITLE;
        $sbedhtml .= $CSL;
        $sbedhtml .= $MBR;
        $sbedhtml .= $MIN60;
        $sbedhtml .= $MIN75;
        $sbedhtml .= $MIN90;	
        $sbedhtml .= $MIN100;
        $sbedhtml .= $MIN120;
        $sbedhtml .= $MIN150;
        $sbedhtml .= $PAYG1;
        $sbedhtml .= $S5;
        $sbedhtml .= $S10;
        $sbedhtml .= $PK13_20;
        $sbedhtml .= $PK6_12;
        $sbedhtml .= '<span>'.$sbdesc.'</span>';
        $sbedhtml .= '</div>';
        // 
    // End loop.
    endwhile;
$sbedhtml .= '</div>';
// No value 
endif;
return $sbedhtml;
}
add_shortcode('sunbed_pricing', 'bd_sunbed_pricing');
?>
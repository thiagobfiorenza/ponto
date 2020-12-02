<?php

$dtInicio = '2020-11-09 00:00:00';
$dtFim = '2021-01-01 00:00:00';

$feriados = [
    '2020-09-07',
    '2020-10-12',
	'2020-11-02',	
	'2020-11-15',
	'2020-11-30', //dia do evangélico
	'2020-12-25' // natal
];

$horasExtras = [
    strtotime('2020-09-16') => ['H' => '5', 'i' => '20'],
    strtotime('2020-09-21') => ['H' => '0', 'i' => '30'],
    strtotime('2020-09-23') => ['H' => '2', 'i' => '40'],
    strtotime('2020-10-28') => ['H' => '0', 'i' => '50'],
    strtotime('2020-11-03') => ['H' => '0', 'i' => '50'],
];

$tsInicio = strtotime($dtInicio);
$tsFim = strtotime($dtFim);

echo '<strong>Pontos semanais:</strong><br />';

while ($tsInicio < $tsFim) {
    $horaLimite1Ini = mktime (8, 50, 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));
    $horaLimite1Fim = mktime (9, 10, 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));

    $horaLimite2Ini = mktime (11, 50, 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));
    $horaLimite2Fim = mktime (12, 10, 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));

    $horaLimite3Fim = mktime (13, 10, 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));

    $sHora1 = mt_rand($horaLimite1Ini, $horaLimite1Fim);
    $sHora1 = mktime(date('H', $sHora1), date('i', $sHora1), 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));
    
    $sHora2 = mt_rand($horaLimite2Ini, $horaLimite2Fim);
    $sHora2 = mktime(date('H', $sHora2), date('i', $sHora2), 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));
    
    $sHora3 = mktime(date('H', $sHora2) + 1, date('i', $sHora2), 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));
    $sHora3 = mt_rand($sHora3, $horaLimite3Fim);
    $sHora3 = mktime(date('H', $sHora3), date('i', $sHora3), 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));
    
    $oitoHoras = mktime(8, 0, 0, date('m', $tsInicio), date('d', $tsInicio), date('Y', $tsInicio));
    $sDiaSemana = date('D', $tsInicio);
    $diaIgualFinalSemana = ($sDiaSemana === 'Sat' || $sDiaSemana === 'Sun');
    $diaIgualFeriado = (count($feriados) && in_array(date('Y-m-d', $tsInicio), $feriados));

    $diferenca1 = $sHora2 - $sHora1;
    $diferenca2 = ($oitoHoras - ($tsInicio + $diferenca1)) . '<br>';

    $sHora4 = (int)$sHora3 + (int)$diferenca2 ;

    if (!$diaIgualFinalSemana && !$diaIgualFeriado) {
        echo ($sDiaSemana == 'Mon' ? '<br />' : '') . date('d/m/Y', $tsInicio) . ' - ' .
            date('H:i', $sHora1) . ' até ' . date('H:i', $sHora2) . ' e ' .
            date('H:i', $sHora3) . ' até ' . date('H:i', $sHora4) .
            (isset($horasExtras[$tsInicio]) ? ' (' . $horasExtras[$tsInicio]['H'] . ':' . $horasExtras[$tsInicio]['i'] . ' extra)' : '') . '<br />';
    } elseif (!$diaIgualFinalSemana && $diaIgualFeriado) {
        echo ($sDiaSemana == 'Mon' ? '<br />' : '') . date('d/m/Y', $tsInicio) . ' - ' .
            'FERIADO' . '<br />';
    }

    $tsInicio += 86400; // 86400 quantidade de segundos em um dia
}

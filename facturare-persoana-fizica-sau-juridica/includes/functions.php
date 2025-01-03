<?php
/* https://github.com/cristian-datu/CNP/blob/master/cnp.php */
function av_validare_cnp( $cnp ) {
    // CNP must have 13 characters
    if( strlen( $cnp ) != 13 ) {
        return false;
    }

    if ( '0000000000000' == $cnp ) {
        return true;
    }

    if ( $cnp != (int)$cnp ) {
    	return false;
    }



    $cnp = str_split($cnp);

    $hashTable = array( 2 , 7 , 9 , 1 , 4 , 6 , 3 , 5 , 8 , 2 , 7 , 9 );
    $hashResult = 0;

    // All characters must be numeric
    for( $i=0 ; $i<12 ; $i++ ) {
        $hashResult += (int)$cnp[$i] * $hashTable[$i];
    }

    $hashResult = $hashResult % 11;
    if( $hashResult == 10 ) {
        $hashResult = 1;
    }

    if ( $cnp[12] != $hashResult ) {
    	return false;
    }

    // Check Year
    $year = ($cnp[1] * 10) + $cnp[2];
    switch( $cnp[0] ) {
        case 1  : case 2 : { $year += 1900; } break; // cetateni romani nascuti intre 1 ian 1900 si 31 dec 1999
        case 3  : case 4 : { $year += 1800; } break; // cetateni romani nascuti intre 1 ian 1800 si 31 dec 1899
        case 5  : case 6 : { $year += 2000; } break; // cetateni romani nascuti intre 1 ian 2000 si 31 dec 2099
        case 7  : case 8 : case 9 : {                // rezidenti si Cetateni Straini
            $year += 2000;
            if($year > (int)date('Y')-14) {
                $year -= 100;
            }
        } break;
        default : {
            return false;
        } break;
    }

    if ( $year > 1800 && $year < 2099 ) {
    	return true;
    }

    return false;

}

/* https://stackoverflow.com/questions/20983339/validate-iban-php */
function av_validare_iban( $iban ) {

    $iban = strtolower( str_replace( ' ', '' , $iban ) );
    $countries = array(
    	'al'=>28,
    	'ad'=>24,
    	'at'=>20,
    	'az'=>28,
    	'bh'=>22,
    	'be'=>16,
    	'ba'=>20,
    	'br'=>29,
    	'bg'=>22,
    	'cr'=>21,
    	'hr'=>21,
    	'cy'=>28,
    	'cz'=>24,
    	'dk'=>18,
    	'do'=>28,
    	'ee'=>20,
    	'fo'=>18,
    	'fi'=>18,
    	'fr'=>27,
    	'ge'=>22,
    	'de'=>22,
    	'gi'=>23,
    	'gr'=>27,
    	'gl'=>18,
    	'gt'=>28,
    	'hu'=>28,
    	'is'=>26,
    	'ie'=>22,
    	'il'=>23,
    	'it'=>27,
    	'jo'=>30,
    	'kz'=>20,
    	'kw'=>30,
    	'lv'=>21,
    	'lb'=>28,
    	'li'=>21,
    	'lt'=>20,
    	'lu'=>20,
    	'mk'=>19,
    	'mt'=>31,
    	'mr'=>27,
    	'mu'=>30,
    	'mc'=>27,
    	'md'=>24,
    	'me'=>22,
    	'nl'=>18,
    	'no'=>15,
    	'pk'=>24,
    	'ps'=>29,
    	'pl'=>28,
    	'pt'=>25,
    	'qa'=>29,
    	'ro'=>24,
    	'sm'=>27,
    	'sa'=>24,
    	'rs'=>22,
    	'sk'=>24,
    	'si'=>19,
    	'es'=>24,
    	'se'=>24,
    	'ch'=>21,
    	'tn'=>24,
    	'tr'=>26,
    	'ae'=>23,
    	'gb'=>22,
    	'vg'=>24
    );

    $chars = array(
    	'a'=>10,
    	'b'=>11,
    	'c'=>12,
    	'd'=>13,
    	'e'=>14,
    	'f'=>15,
    	'g'=>16,
    	'h'=>17,
    	'i'=>18,
    	'j'=>19,
    	'k'=>20,
    	'l'=>21,
    	'm'=>22,
    	'n'=>23,
    	'o'=>24,
    	'p'=>25,
    	'q'=>26,
    	'r'=>27,
    	's'=>28,
    	't'=>29,
    	'u'=>30,
    	'v'=>31,
    	'w'=>32,
    	'x'=>33,
    	'y'=>34,
    	'z'=>35
    );

    if( strlen($iban) == $countries[ substr( $iban,0,2 ) ] ) {

        $MovedChar      = substr($iban, 4).substr($iban,0,4);
        $MovedCharArray = str_split($MovedChar);
        $NewString      = "";

        foreach( $MovedCharArray AS $key => $value ){
            if( ! is_numeric( $MovedCharArray[ $key ] ) ){
                $MovedCharArray[ $key ] = $chars[ $MovedCharArray[ $key ] ];
            }
            $NewString .= $MovedCharArray[ $key ];
        }

        if( bcmod($NewString, '97') == 1 ) {
            return true;
        }
    }
    return false;
}

/* https://ro.wikipedia.org/wiki/Cod_de_Identificare_Fiscal%C4%83 */
function av_validare_cif( $cif ){
 	// Daca este string, elimina atributul fiscal si spatiile
 	if(!is_int($cif)){
 		$cif = strtoupper($cif);
 		if(strpos($cif, 'RO') === 0){
 			$cif = substr($cif, 2);
 		}
 		$cif = (int) trim($cif);
 	}
 	
 	// daca are mai mult de 10 cifre sau mai putin de 2, nu-i valid
 	if(strlen($cif) > 10 || strlen($cif) < 2){
 		return false;
 	}
 	// numarul de control
 	$v = 753217532;
 	
 	// extrage cifra de control
 	$c1 = $cif % 10;
 	$cif = (int) ($cif / 10);
 	
 	// executa operatiile pe cifre
 	$t = 0;
 	while($cif > 0){
 		$t += ($cif % 10) * ($v % 10);
 		$cif = (int) ($cif / 10);
 		$v = (int) ($v / 10);
 	}
 	
 	// aplica inmultirea cu 10 si afla modulo 11
 	$c2 = $t * 10 % 11;
 	
 	// daca modulo 11 este 10, atunci cifra de control este 0
 	if($c2 == 10){
 		$c2 = 0;
 	}
 	return $c1 === $c2;
}
<?php
require_once dirname( __FILE__ ) . '/../class-ntw-india.php';
$ntw = new ntwIndia\NTW_India();
var_dump( 1234567890, $ntw->num_to_word( 1234567890 ) );
var_dump( 65876.80, $ntw->num_to_word( 65876.80 ) );
var_dump( 465970, $ntw->num_to_word( 465970 ) );
var_dump( 108000, $ntw->num_to_word( 108000 ) );
var_dump( 7805087, $ntw->num_to_word( 7805087 ) );
var_dump( 9223372036854775807, $ntw->num_to_word( 9223372036854775807 ) );
var_dump( 0, $ntw->num_to_word( 0 ) );
var_dump( 180000, $ntw->num_to_word( 180000 ) );

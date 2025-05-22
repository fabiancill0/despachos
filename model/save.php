<?php
include 'connections.php';
include 'functions.php';
include 'encdec.php';

$functions = new Functions();
$conn = new Connections();

$query_enca = "INSERT INTO despafrigoen
(plde_codigo, defe_numero, clie_codigo, defe_fecdes, defe_cantar, defe_tiposa, puer_codigo, defe_guides, defe_cantaj,
defe_horade, defe_canpal, tran_codigo, tica_codigo, embq_codigo, defe_patent, defe_pataco, defe_chofer, defe_plasag,
defe_fecact, defe_horact, defe_tpcont, defe_nrcont, tran_fechat, defe_espmul, defe_especi, defe_chfrut, defe_celcho,
defe_nrosps, defe_ctlter, defe_fecdig) VALUES 
()";

$query_deta = "INSERT INTO despafrigode
(plde_codigo, defe_numero, clie_codigo, paen_numero, defe_termog, defe_tempe1, defe_tempe2, defe_ladoes, defe_filaes,
tran_fechat, tema_codigo) VALUES 
()";

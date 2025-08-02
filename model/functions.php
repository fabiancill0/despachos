<?php
class Functions
{
  public function getClientesCod($conn)
  {
    $query = "SELECT clie_codigo, clie_nombre FROM dba.clientesprod ORDER BY clie_codigo";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);
      if ($row['clie_codigo'] == 15) {
      } else {
?>
        <option value="<?= $row['clie_codigo'] ?>"><?= $row['clie_codigo'] . ' - ' . $row['clie_nombre'] ?></option>
      <?php
      }
    }
  }
  public function getCompradoresCod($conn)
  {
    $query = "SELECT clpr_rut, clpr_nombre FROM dba.clienprove ORDER BY clpr_rut";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);
      ?>
      <option value="<?= $row['clpr_rut'] ?>"><?= $row['clpr_nombre'] ?></option>
    <?php

    }
  }
  public function getTransportistasCod($conn)
  {
    $query = "SELECT tran_codigo, tran_nombre FROM dba.transportista ORDER BY tran_codigo";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);
    ?>
      <option value="<?= $row['tran_codigo'] ?>"><?= $row['tran_nombre'] ?></option>
    <?php

    }
  }
  public function getCamiones($conn)
  {
    $query = "SELECT tica_codigo, tica_nombre FROM dba.tipocamion ORDER BY tica_codigo";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);

    ?>
      <option value="<?= $row['tica_codigo'] ?>"><?= $row['tica_codigo'] . ' - ' . $row['tica_nombre'] ?></option>
    <?php

    }
  }
  public function getEspeciesCod($conn)
  {
    $query = "SELECT espe_codigo, espe_nombre FROM dba.especies ORDER BY espe_codigo";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);
    ?>
      <option value="<?= $row['espe_codigo'] ?>"><?= $row['espe_nombre'] ?></option>
    <?php
    }
  }
  public function getTipoMov($conn)
  {
    $query = "SELECT tisa_codigo, tisa_descri FROM dba.tiposalidas ORDER BY tisa_codigo";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);
    ?>
      <option value="<?= $row['tisa_codigo'] ?>"><?= $row['tisa_codigo'] . ' - ' . $row['tisa_descri'] ?></option>
    <?php

    }
  }
  public function getTermografo($conn)
  {
    $query = "SELECT tema_codigo, tema_descri FROM dba.Termografo_marcas ORDER BY tema_codigo";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);
    ?>
      <option value="<?= $row['tema_codigo'] ?>"><?= $row['tema_descri'] ?></option>
      <?php

    }
  }
  public function getPlantaDesp($conn)
  {
    $query = "SELECT plde_codigo, plde_nombre FROM dba.plantadesp ORDER BY plde_codigo";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);
      if ($row['plde_codigo'] == 31) {
      ?>
        <option value="<?= $row['plde_codigo'] ?>" selected><?= $row['plde_codigo'] . ' - ' . $row['plde_nombre'] ?></option>
      <?php
      } else {
      ?>
        <option value="<?= $row['plde_codigo'] ?>"><?= $row['plde_codigo'] . ' - ' . $row['plde_nombre'] ?></option>
      <?php
      }
    }
  }
  public function getConsignatarios($conn)
  {
    $query = "SELECT reci_codigo, reci_nombre FROM DBA.recibidores ORDER BY reci_codigo";
    $result = odbc_exec($conn, $query);
    while ($row = odbc_fetch_array($result)) {
      $row = array_map("utf8_encode", $row);
      if ($row['reci_codigo'] == 31) {
      ?>
        <option value="<?= $row['reci_codigo'] ?>" selected><?= $row['reci_codigo'] . ' - ' . $row['reci_nombre'] ?></option>
      <?php
      } else {
      ?>
        <option value="<?= $row['reci_codigo'] ?>"><?= $row['reci_codigo'] . ' - ' . $row['reci_nombre'] ?></option>
      <?php
      }
    }
  }
  function getNombreProductor($conex, $codigo)
  {
    $query = "SELECT prod_nombre FROM DBA.productores WHERE prod_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['prod_nombre']);
  }

  function getCSG($conex, $codigoProd, $codigo)
  {
    $query = "SELECT prpr_prepro FROM DBA.spro_prodpredio WHERE prod_codigo = $codigoProd AND prpr_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return $nombre['prpr_prepro'];
  }

  function getSDP($conex, $codigoProd, $codigoPred, $codigo)
  {
    $query = "SELECT prcc_cuapro FROM DBA.spro_prodcuarteles WHERE prpr_codigo = $codigoPred AND prod_codigo = $codigoProd AND prcc_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return $nombre['prcc_cuapro'];
  }

  function getNombreVariedad($conex, $codigoVari, $codigoEspe)
  {
    $query = "SELECT vari_nombre FROM DBA.variedades WHERE espe_codigo = $codigoEspe AND vari_codigo = $codigoVari";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['vari_nombre']);
  }

  function getNombreEtiqueta($conex, $codigo)
  {
    $query = "SELECT etiq_nombre FROM DBA.etiquetas WHERE etiq_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['etiq_nombre']);
  }
  function getNombreCliente($conex, $codigo)
  {
    $query = "SELECT clie_nombre FROM DBA.clientesprod WHERE clie_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['clie_nombre']);
  }
  function getNombreClienteAbreviado($conex, $codigo)
  {
    $query = "SELECT clie_abrevi FROM DBA.clientesprod WHERE clie_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['clie_abrevi']);
  }
  function getNombreEspecie($conex, $codigo)
  {
    $query = "SELECT espe_nombre FROM DBA.especies WHERE espe_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['espe_nombre']);
  }
  function getNombreCategoria($conex, $codigo)
  {
    $query = "SELECT cate_nombre FROM DBA.categorias WHERE cate_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['cate_nombre']);
  }
  function getNombreStatus($conex, $codigo)
  {
    $query = "SELECT stat_nombre FROM DBA.status WHERE stat_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['stat_nombre']);
  }
  function getInstructivo($cliente)
  {
    $query = "SELECT embq_codigo FROM DBA.embarqueprod WHERE clie_codigo = $cliente ORDER BY embq_fzarpe DESC";
    return $query;
  }
  function getUltimoDespacho()
  {
    $query = "SELECT TOP 1 defe_numero FROM DBA.despafrigoen ORDER BY defe_numero DESC";
    return $query;
  }
  function getEncaEmbarque($cliente)
  {
    $query = "SELECT embq_bookin, embq_codigo, clie_codigo, reci_codigo, embq_fitosa, embq_nomnav, embq_ptoori, embq_descar, embc_codigo, nave_codigo FROM DBA.embarqueprod WHERE clie_codigo = $cliente";
    return $query;
  }
  function getEncaEmbarqueByCod($embarque, $cliente)
  {
    $query = "SELECT embq_codigo, nave_codigo, reci_codigo, embq_nomnav, embq_descar, embq_numdus FROM DBA.embarqueprod WHERE clie_codigo = $cliente AND embq_codigo = '$embarque'";
    return $query;
  }
  function getDetaPalletDespacho($folio)
  {
    $query = "SELECT enca.clie_codigo, enca.paen_numero,deta.pafr_varrot,enca.emba_codigo,enca.etiq_codigo,deta.pafr_calrot,enca.paen_ccajas,enca.paen_tipopa,enca.stat_codigo,enca.espe_codigo
              FROM dba.palletencab AS enca join DBA.palletfruta as deta on enca.paen_numero = deta.paen_numero and enca.clie_codigo = deta.clie_codigo where enca.paen_numero = $folio
              group by enca.clie_codigo, enca.paen_numero,deta.pafr_varrot,deta.pafr_calrot,enca.paen_tipopa,enca.stat_codigo,enca.emba_codigo,enca.paen_ccajas,enca.etiq_codigo,enca.espe_codigo";
    return $query;
  }
  function getDetaPalletDespachoGranel($folio)
  {
    $query = "SELECT enca.clie_codigo, enca.cate_codigo, enca.paen_numero,deta.pafr_varrot,deta.emba_codigo,enca.etiq_codigo,deta.pafr_calrot,enca.paen_ccajas,enca.paen_tipopa,enca.espe_codigo
              FROM dba.spro_palletencab AS enca join DBA.spro_palletfruta as deta on enca.paen_numero = deta.paen_numero and enca.clie_codigo = deta.clie_codigo where enca.paen_numero = $folio
              group by enca.clie_codigo,enca.cate_codigo, enca.paen_numero,deta.pafr_varrot,deta.pafr_calrot,enca.paen_tipopa,deta.emba_codigo,enca.paen_ccajas,enca.etiq_codigo,enca.espe_codigo";
    return $query;
  }
  function getDetaPallet($folio)
  {
    $query = "SELECT emba_codigo,vari_codigo,pafr_varrot,pafr_calibr,pafr_calrot,prod_codigo,pafr_prdrot,pafr_copack,pafr_fecemb,PAFR_HUERT1,PAFR_CUART1,sum(pafr_ccajas) as pafr_ccajas 
    FROM DBA.palletfruta WHERE paen_numero = $folio group by emba_codigo,vari_codigo,pafr_varrot,pafr_calibr,pafr_calrot,prod_codigo,pafr_prdrot,pafr_copack,pafr_fecemb,PAFR_HUERT1,PAFR_CUART1";
    return $query;
  }
  function getDetaPalletGranel($folio)
  {
    $query = "SELECT emba_codigo,cate_codigo,vari_codigo,vari_codrot,pafr_calibr,pafr_calrot,prod_codigo,prod_codrot,pafr_copack,pafr_fecemb,pafr_huert1,pafr_cuart1,sum(pafr_ccajas) as pafr_ccajas 
    FROM DBA.spro_palletfruta WHERE paen_numero = $folio group by emba_codigo,cate_codigo,vari_codigo,vari_codrot,pafr_calibr,pafr_calrot,prod_codigo,prod_codrot,pafr_copack,pafr_fecemb,pafr_huert1,pafr_cuart1";
    return $query;
  }
  function getEncaPallet($folio)
  {
    $query = "SELECT clie_codigo,paen_tipopa,vari_codigo,cate_codigo,stat_codigo,emba_codigo,cond_codigo,paen_ccajas,etiq_codigo,espe_codigo,paen_estado FROM dba.palletencab WHERE paen_numero = $folio";
    return $query;
  }
  function getEncaPalletGranel($folio)
  {
    $query = "SELECT enca.clie_codigo,enca.paen_tipopa,enca.vari_codigo,enca.cate_codigo,deta.emba_codigo,enca.paen_ccajas,enca.etiq_codigo,enca.espe_codigo,enca.paen_estado FROM dba.spro_palletencab AS enca 
join DBA.spro_palletfruta as deta on enca.paen_numero = deta.paen_numero WHERE enca.paen_numero = $folio
group by enca.clie_codigo,enca.paen_tipopa,enca.vari_codigo,enca.cate_codigo,deta.emba_codigo,enca.paen_ccajas,enca.etiq_codigo,enca.espe_codigo,enca.paen_estado";
    return $query;
  }
  function getEncaEmbarqueByCliente($cliente)
  {
    $query = "SELECT embq_codigo, reci_codigo, oper_codigo, embq_nomnav, embq_fzarpe, embc_codigo, embq_ptoori, dest_codigo, embq_descar, embq_tipova FROM DBA.embarqueprod WHERE clie_codigo = $cliente
    GROUP BY embq_codigo, reci_codigo, oper_codigo, embq_nomnav, embq_fzarpe, embc_codigo, embq_ptoori, dest_codigo, embq_descar, embq_tipova ORDER BY embq_codigo DESC";
    return $query;
  }
  function getEncaDespachoAux($instructivo)
  {
    $query = "SELECT embq_codigo, defe_guides FROM DBA.despafrigoen WHERE embq_codigo = '$instructivo'";
    return $query;
  }
  function getEncaDespacho($instructivo, $guia)
  {
    $query = "SELECT defe_fecdes, defe_cantar, defe_numero, plde_codigo, defe_especi, defe_nrcont, defe_guides, defe_cancaj, defe_patent, defe_pataco, defe_chofer, defe_nrosps, defe_chfrut, defe_celcho, defe_setpoi, defe_ventil, YEAR(defe_fecfab) AS defe_fecfab, defe_selcon, defe_taraco, defe_traser, tica_codigo, defe_tiposa, defe_plasag FROM DBA.despafrigoen WHERE embq_codigo = '$instructivo' AND defe_guides = $guia";
    return $query;
  }
  function getEncaDespachoByCliente($cliente)
  {
    $query = "SELECT enca.defe_numero, enca.defe_fecdes, emba.reci_codigo, enca.defe_tiposa, enca.puer_codigo, enca.defe_plades, enca.defe_guides, enca.embq_codigo
FROM DBA.despafrigoen as enca JOIN dba.embarqueprod as emba on enca.embq_codigo = emba.embq_codigo WHERE enca.clie_codigo = $cliente ORDER BY defe_numero DESC";
    return $query;
  }
  function getEncaDespachoByClienteGranel($cliente)
  {
    $query = "SELECT defe_numero, defe_fecdes,  defe_tiposa, tran_codigo, clpr_rut, defe_plades, defe_guides
FROM DBA.despafrigoen WHERE clie_codigo = $cliente and defe_tiposa = 16 ORDER BY defe_numero DESC";
    return $query;
  }
  function getEncaDespachoByNumero($despacho)
  {
    $query = "SELECT enca.defe_ctlter, enca.defe_cantar, enca.defe_numdus, emba.nave_codigo, emba.embq_nomnav, enca.plde_codigo, enca.defe_nrosps,enca.defe_patent, enca.defe_cancaj,
    enca.clie_codigo,enca.defe_numero, enca.defe_fecdes, enca.defe_horade, emba.reci_codigo, enca.defe_tiposa, enca.puer_codigo,
    enca.defe_guides, enca.embq_codigo
FROM DBA.despafrigoen as enca JOIN dba.embarqueprod as emba on enca.embq_codigo = emba.embq_codigo WHERE enca.defe_numero = $despacho";
    return $query;
  }
  function getEncaDespachoByNumeroGranel($despacho)
  {
    $query = "SELECT defe_cantar, plde_codigo, defe_patent, defe_cancaj, tran_codigo, clpr_rut, tica_codigo,defe_chofer,defe_pataco,
    clie_codigo,defe_numero, defe_fecdes, defe_horade, defe_tiposa, defe_guides
FROM DBA.despafrigoen WHERE defe_numero = $despacho";
    return $query;
  }
  function getDetaDespacho($id)
  {
    $query = "SELECT clie_codigo, paen_numero, defe_tempe1, defe_tempe2, defe_ladoes, defe_termog, tema_codigo FROM DBA.despafrigode WHERE defe_numero = $id ORDER BY defe_ladoes, defe_filaes";
    return $query;
  }
  function getDetaDespachoGranel($id)
  {
    $query = "SELECT clie_codigo, paen_numero, defe_ladoes FROM DBA.despafrigode WHERE defe_numero = $id ORDER BY defe_ladoes, defe_filaes";
    return $query;
  }
  function getEncaTraspasoByCliente($cliente)
  {
    $query = "SELECT clie_codigo, plde_codigo, mfge_numero, espe_codigo, mfge_fecmov, mfge_observ, mfge_tpneto, mfge_totbul, refg_horasa
FROM DBA.spro_movtofrutagranenca WHERE clie_codigo = $cliente AND tpmv_codigo = 23 ORDER BY mfge_numero DESC";
    return $query;
  }
  function getEncaTraspasoByNumero($mov)
  {
    $query = "SELECT clie_codigo, plde_codigo, mfge_numero, espe_codigo, mfge_fecmov, mfge_observ, mfge_tpneto, mfge_totbul, refg_horasa, mfge_guisii
FROM DBA.spro_movtofrutagranenca WHERE mfge_numero = $mov AND tpmv_codigo = 23";
    return $query;
  }
  function getDetaTraspaso($cliente, $id)
  {
    $query = "SELECT deta_tarjas.plde_codigo, deta_tarjas.fgmb_nrotar, deta_tarjas.fgmb_canbul, pesa.lote_espcod, pesa.lote_codigo, sum(pesa.mfgp_pesore - bins.enva_pesone) as kilos, prod.prod_codigo
FROM DBA.spro_movtofrutagrandeta_tarjas as deta_tarjas join dba.spro_movtofrutagranpesa as pesa on deta_tarjas.fgmb_nrotar = pesa.fgmb_nrotar 
join dba.spro_lotesfrutagranel as prod on pesa.lote_codigo = prod.lote_codigo and pesa.lote_espcod = prod.lote_espcod
join (SELECT enva.enva_pesone, bin.bins_numero from dba.spro_bins as bin join dba.envases as enva on bin.enva_tipoen = enva.enva_tipoen 
and bin.enva_codigo = enva.enva_codigo where bin.clie_codigo = $cliente) as bins on bins.bins_numero = pesa.bins_numero where deta_tarjas.mfge_numero = $id and deta_tarjas.tpmv_codigo = 23 group by
deta_tarjas.plde_codigo, deta_tarjas.fgmb_nrotar, deta_tarjas.fgmb_canbul, pesa.lote_espcod, pesa.lote_codigo, prod.prod_codigo";
    return $query;
  }
  function getEncaTarja($cliente, $folio)
  {
    $query = "SELECT lote_deta.lote_codigo, lote_deta.vari_codigo, lote_deta.lote_espcod, lote_deta.prod_codigo, sum(pesa.mfgp_canbul) as bultos, sum(pesa.mfgp_pesore - bins.enva_pesone) as kilos FROM dba.spro_lotesfrutagranel as lote_deta 
join dba.spro_movtofrutagranpesa as pesa on lote_deta.lote_codigo = pesa.lote_codigo and lote_deta.lote_espcod = pesa.lote_espcod join (SELECT enva.enva_pesone, bin.bins_numero from dba.spro_bins as bin join dba.envases as enva on bin.enva_tipoen = enva.enva_tipoen 
and bin.enva_codigo = enva.enva_codigo where bin.clie_codigo = $cliente) as bins on bins.bins_numero = pesa.bins_numero where pesa.fgmb_nrotar = $folio
group by lote_deta.lote_espcod, lote_deta.lote_codigo, lote_deta.vari_codigo, lote_deta.prod_codigo";
    return $query;
  }
  function getUltimoTraspaso()
  {
    $query = "SELECT TOP 1 mfge_numero FROM DBA.spro_movtofrutagranenca WHERE tpmv_codigo = 36 ORDER BY mfge_numero DESC";
    return $query;
  }
  function getNombrePlanta($conex, $codigo)
  {
    $query = "SELECT plde_nombre FROM DBA.plantadesp WHERE plde_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['plde_nombre']);
  }
  function getNombreRecibidor($conex, $codigo)
  {
    $query = "SELECT reci_nombre FROM DBA.recibidores WHERE reci_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['reci_nombre']);
  }
  function getNombreRecibidorRK($conex, $codigo)
  {
    $query = "SELECT reci_nombre FROM DBA.recibidores WHERE reci_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['reci_nombre']);
  }
  function getNombrePuertos($conex, $codigo)
  {
    $query = "SELECT puer_nombre FROM DBA.puertos WHERE puer_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['puer_nombre']);
  }
  function getNombreEmbarcador($conex, $codigo)
  {
    $query = "SELECT embc_nombre FROM DBA.embarcadores WHERE embc_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['embc_nombre']);
  }
  function getNombreTransportista($conex, $codigo)
  {
    $query = "SELECT tran_nombre FROM DBA.transportista WHERE tran_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['tran_nombre']);
  }
  function getNombreComprador($conex, $codigo)
  {
    $query = "SELECT clpr_nombre FROM DBA.clienprove WHERE clpr_rut = '$codigo'";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['clpr_nombre']);
  }
  function getNombreTipoSalida($conex, $codigo)
  {
    $query = "SELECT tisa_descri FROM DBA.tiposalidas WHERE tisa_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['tisa_descri']);
  }
  function getUbicacionSello($conex, $codigo)
  {
    $query = "SELECT sell_abrevi FROM DBA.Sagubicacionsello WHERE sell_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper($nombre['sell_abrevi']);
  }
  function getNombreCondicion($conex, $codigo)
  {
    $query = "SELECT cond_nombre FROM DBA.condicion WHERE cond_codigo = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $nombre = odbc_fetch_array($resultQuery);
    return strtoupper(mb_convert_encoding($nombre['cond_nombre'], 'UTF-8', 'ISO-8859-1'));
  }
  function getSelloSag($conex, $codigo)
  {
    $query = "SELECT sell_numero, sell_codigo FROM DBA.Despafrigosellos WHERE defe_plasag = $codigo";
    $resultQuery = odbc_exec($conex, $query);
    $sellos = [];
    while ($row = odbc_fetch_array($resultQuery)) {
      $sellos[$row['sell_codigo']] = $row['sell_numero'];
    }
    return $sellos;
  }
  function getPaises($conex)
  {
    $query = "SELECT DISTINCT dest_nombre FROM DBA.destinos WHERE dest_nombre NOT IN('   ','OTRO') ORDER BY dest_nombre ASC";
    $resultQuery = odbc_exec($conex, $query);
    while ($row = odbc_fetch_array($resultQuery)) {
      ?>
      <option value="<?= $row['dest_nombre'] ?>"><?= $row['dest_nombre'] ?></option>
<?php
    }
  }
}

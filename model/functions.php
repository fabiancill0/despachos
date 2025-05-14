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
  function getEncaEmbarque($cliente)
  {
    $query = "SELECT embq_bookin, embq_codigo, clie_codigo, reci_codigo, embq_fitosa, embq_nomnav, embq_ptoori, embq_descar, embc_codigo FROM DBA.embarqueprod WHERE clie_codigo = $cliente";
    return $query;
  }
  function getEncaEmbarqueByCliente($cliente)
  {
    $query = "SELECT embq_codigo, reci_codigo, oper_codigo, embq_nomnav, embq_fzarpe, embc_codigo, embq_ptoori, dest_codigo, embq_descar, embq_tipova FROM DBA.embarqueprod WHERE clie_codigo = $cliente";
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
  function getDetaDespacho($id)
  {
    $query = "SELECT paen_numero, defe_tempe1, defe_tempe2, defe_ladoes, defe_termog FROM DBA.despafrigode WHERE defe_numero = $id ORDER BY defe_ladoes, defe_filaes";
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

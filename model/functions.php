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
    $query = "CALL dba.Movil_instuctivo($cliente)";
    return $query;
  }
  function getUltimoDespacho()
  {
    $query = "SELECT dba.Movil_UltimoDespacho() as defe_numero";
    return $query;
  }
  function getEncaEmbarque($cliente)
  {
    $query = "CALL dba.Movil_EncaEmbarque($cliente)";
    return $query;
  }
  function getEncaEmbarqueByCod($embarque, $cliente)
  {
    $query = "CALL dba.Movil_EncaEmbarqueByCod('$embarque', $cliente)";
    return $query;
  }
  function getDetaPalletDespacho($folio)
  {
    $query = "CALL dba.Movil_DetaPalletDespacho($folio)";
    return $query;
  }
  function getDetaPalletDespachoGranel($folio)
  {
    $query = "CALL dba.Movil_DetaPalletDespachoGranel($folio)";
    return $query;
  }
  function getDetaPallet($folio)
  {
    $query = "CALL dba.Movil_DetallePallet($folio)";
    return $query;
  }
  function getDetaPalletGranel($folio)
  {
    $query = "CALL dba.Movil_DetaPalletGranel($folio)";
    return $query;
  }
  function getEncaPallet($folio)
  {
    $query = "CALL dba.Movil_EncaPallet($folio)";
    return $query;
  }
  function getEncaPalletGranel($folio)
  {
    $query = "CALL dba.Movil_EncaPalletGranel($folio)";
    return $query;
  }
  function getEncaEmbarqueByCliente($cliente)
  {
    $query = "CALL dba.Movil_EncaEmbarqueByCliente($cliente)";
    return $query;
  }
  function getEncaDespachoAux($instructivo)
  {
    $query = "CALL dba.Movil_EncaDespachoAux($instructivo)";
    return $query;
  }
  function getEncaDespacho($instructivo, $guia)
  {
    $query = "CALL dba.Movil_EncaDespacho($instructivo, $guia)";
    return $query;
  }
  function getEncaDespachoByCliente($cliente)
  {
    $query = "CALL dba.Movil_EncaDespachoByCliente($cliente)";
    return $query;
  }
  function getEncaDespachoByClienteGranel($cliente)
  {
    $query = "CALL dba.Movil_EncaDespachoByClienteGranel($cliente)";
    return $query;
  }
  function getEncaDespachoByNumero($despacho)
  {
    $query = "CALL dba.Movil_EncaDespachoByNumero($despacho)";
    return $query;
  }
  function getEncaDespachoByNumeroGranel($despacho)
  {
    $query = "CALL dba.Movil_EncaDespachoByNumeroGranel($despacho)";
    return $query;
  }
  function getDetaDespacho($id)
  {
    $query = "CALL dba.Movil_DetaDespacho($id)";
    return $query;
  }
  function getDetaDespachoGranel($id)
  {
    $query = "CALL dba.Movil_DetaDespachoGranel($id)";
    return $query;
  }
  function getEncaTraspasoByCliente($cliente)
  {
    $query = "CALL dba.Movil_EncaTraspasoByCliente($cliente)";
    return $query;
  }
  function getEncaTraspasoByNumero($mov)
  {
    $query = "CALL dba.Movil_EncaTraspasoByNumero($mov)";
    return $query;
  }
  function getDetaTraspaso($id)
  {
    $query = "CALL dba.Movil_DetaTraspaso($id)";
    return $query;
  }
  function getEncaTarja($folio)
  {
    $query = "CALL dba.Movil_EncaTarja($folio)";
    return $query;
  }
  function getUltimoTraspaso()
  {
    $query = "SELECT dba.Movil_UltimoTraspaso() as mfge_numero";
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

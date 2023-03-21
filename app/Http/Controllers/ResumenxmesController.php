<?php

namespace App\Http\Controllers;

use App\resumenxmes;
use Illuminate\Http\Request;
use DB;
use mysqli;
use DateTime;
use Illuminate\Support\Arr;
use PhpParser\Node\Stmt\Return_;

class ResumenxmesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function __construct()
  {
    $this->middleware('auth');
  }
  public function index()
  {
    //return "desde index";
    return view('reports.resumenxmes');
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $fini = date("d/m/Y", strtotime($request->fini));
    $ffin = date("d/m/Y", strtotime($request->ffin));
    $ff1 = $ffin;
    // $fdia=date("d", strtotime($request->fhoy));
    $fmes = date("d/m/Y", strtotime($request->fhoy));
    $mesini = "";
    $totalGT1 = '0';
    $totalGT2 = '0';
    $totalGT3 = '0';
    $totalGT4 = '0';
    $totalGT5 = '0';
    $totalGT6 = '0';
    $totalGT7 = '0';
    $totalGT8 = '0';
    $totalGT9 = '0';
    $totalGT10 = '0';
    $totalGT11 = '0';
    $totalGT12 = '0';

    $totalGTAnual = '0';

    $tarray1 = [];
    $tarray2 = [];
    $tarray3 = [];
    $tarray4 = [];
    $tarray5 = [];
    $tarray6 = [];
    $tarray7 = [];
    $tarray8 = [];
    $tarray9 = [];
    $tarray10 = [];
    $tarray11 = [];
    $tarray12 = [];

    $tarrayAnual = [];

    $resumeTT = [];

    //variables de meses
    $fx1 = "";
    $fx2 = "";
    $fx3 = "";
    $fx4 = "";
    $fx5 = "";
    $fx6 = "";
    $fx7 = "";
    $fx8 = "";
    $fx9 = "";
    $fx10 = "";
    $fx11 = "";
    $fx12 = "";
    //variables de arrays x mes
    $farray1 = $farray2 = $farray3 = $farray4 = $farray5 = $farray6 = $farray7 = $farray8 = $farray9 = $farray10 = $farray11 = $farray12 = [];
    $fxmes = $request->options; // dato enviado desde la pagina de inicio <==========

    // variables para caso 2

    $bandera = 0;

    $arrayAnios = array("ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE");

    $arrayDiasF = array("31/01/202", "28/02/202", "31/03/202", "30/04/202", "31/05/202", "30/06/202", "31/07/202", "31/08/202", "30/09/202", "31/10/202", "30/11/202", "31/12/202");
    if (empty($fxmes) && $bandera == 0) {
      return dd("no se puede mandar datos nulos o vacios");
      $bandera = 1;
    }

    if (sizeof($fxmes) >= 1 && $bandera == 0) {
      $cc = 1;
      for ($i = 0; $i < sizeof($arrayAnios); $i++) {
        if ($arrayAnios[$i] == $fxmes[0]) {
          $cc = $i + $cc;
          $mesini = date("01/" . "$cc" . "/2021");
          $bandera = 1;
          break;
        }
      }
    }
    $fmesfin = $fxmes[sizeof($fxmes) - 1];
    for ($i = 0; $i < sizeof($arrayAnios); $i++) {
      if ($arrayAnios[$i] == $fmesfin) {
        $fmesfin = $arrayDiasF[$i];
      }
    }
    //return dd($fmesfin);


    for ($ff = 0; $ff < sizeof($fxmes); $ff++) {
      if ($fxmes[$ff] == "ENERO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/01/2021');
            $ffin = date('31/01/2021');
          }
          if ($contador == 2) {
            $fini = date('01/01/2022');
            $ffin = date('31/01/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $totalGT1 =
            "SELECT 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
                AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY mon
            ORDER BY mon";

          $totalGT1 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT1));
          if (empty($totalGT1)) {
            $tarray1[$contador] = 0;
          } else {
            $tarray1[$contador] = $totalGT1[0]->Total;
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "FEBRERO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/02/2021');
            $ffin = date('28/02/2021');
          }
          if ($contador == 2) {
            $fini = date('01/02/2022');
            $ffin = date('28/02/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $totalGT2 =
            "SELECT 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
                AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY mon
            ORDER BY mon";

          $totalGT2 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT2));
          if (empty($totalGT2)) {
            $tarray2[$contador] = 0;
          } else {
            $tarray2[$contador] = $totalGT2[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "MARZO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/03/2021');
            $ffin = date('31/03/2021');
          }
          if ($contador == 2) {
            $fini = date('01/03/2022');
            $ffin = date('31/03/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $totalGT3 =
            "SELECT 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
                AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY mon
            ORDER BY mon";

          $totalGT3 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT3));
          if (empty($totalGT3)) {
            $tarray3[$contador] = 0;
          } else {
            $tarray3[$contador] = $totalGT3[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "ABRIL") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/04/2021');
            $ffin = date('30/04/2021');
          }
          if ($contador == 2) {
            $fini = date('01/04/2022');
            $ffin = date('30/04/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $totalGT4 =
            "SELECT 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
                AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY mon
            ORDER BY mon";

          $totalGT4 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT4));
          if (empty($totalGT4)) {
            $tarray4[$contador] = 0;
          } else {
            $tarray4[$contador] = $totalGT4[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "MAYO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/05/2021');
            $ffin = date('31/05/2021');
          }
          if ($contador == 2) {
            $fini = date('01/05/2022');
            $ffin = date('31/05/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $totalGT5 =
            "SELECT 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
                AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY mon
            ORDER BY mon";

          $totalGT5 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT5));
          if (empty($totalGT5)) {
            $tarray5[$contador] = 0;
          } else {
            $tarray5[$contador] = $totalGT5[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "JUNIO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/06/2021');
            $ffin = date('30/06/2021');
          }
          if ($contador == 2) {
            $fini = date('01/06/2022');
            $ffin = date('30/06/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $totalGT6 =
            "SELECT 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
                AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY mon
            ORDER BY mon";

          $totalGT6 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT6));
          if (empty($totalGT6)) {
            $tarray6[$contador] = 0;
          } else {
            $tarray6[$contador] = $totalGT6[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "JULIO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/07/2021');
            $ffin = date('31/07/2021');
          }
          if ($contador == 2) {
            $fini = date('01/07/2022');
            $ffin = date('31/07/2022');
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";



          $totalGT7 =
            "SELECT 
                CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
                FROM
                (
                    SELECT 
                    cptraFtra as 'Fec', 
                    adusrNomb as 'Usr',
                    inlocNomb as 'Loc',
                    vtvtaTotT as 'tot', 
                    admonAbrv as 'mon', 
                    cptraCajS as 'efe', 
                    cptraBanS as 'ban', 
                    cptraCxcS as 'cxc',
                    cptraTarS as 'tar', 
                    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                    FROM cptra
                    JOIN vtVta ON vtvtaNtra = cptraNtrI
                    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                    join inloc ON inlocCloc = vtvtaCloc
                    WHERE 
                    cptraMdel = 0 AND cptraTtra = 21
                    AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
                ) as venta
                WHERE (fec BETWEEN @fini AND @ffin)
                GROUP BY mon
                ORDER BY mon";
          $totalGT7 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT7));





          if (empty($totalGT7)) {
            $tarray7[$contador] = "0";
          } else {
            $tarray7[$contador] = $totalGT7[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "AGOSTO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/08/2021');
            $ffin = date('31/08/2021');
          }
          if ($contador == 2) {
            $fini = date('01/08/2022');
            $ffin = date('31/08/2022');
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";



          $totalGT8 =
            "SELECT 
                CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
                FROM
                (
                    SELECT 
                    cptraFtra as 'Fec', 
                    adusrNomb as 'Usr',
                    inlocNomb as 'Loc',
                    vtvtaTotT as 'tot', 
                    admonAbrv as 'mon', 
                    cptraCajS as 'efe', 
                    cptraBanS as 'ban', 
                    cptraCxcS as 'cxc',
                    cptraTarS as 'tar', 
                    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                    FROM cptra
                    JOIN vtVta ON vtvtaNtra = cptraNtrI
                    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                    join inloc ON inlocCloc = vtvtaCloc
                    WHERE 
                    cptraMdel = 0 AND cptraTtra = 21
                    AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
                ) as venta
                WHERE (fec BETWEEN @fini AND @ffin)
                GROUP BY mon
                ORDER BY mon";
          $totalGT8 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT8));





          if (empty($totalGT8)) {
            $tarray8[$contador] = "0";
          } else {
            $tarray8[$contador] = $totalGT8[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "SEPTIEMBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/09/2021');
            $ffin = date('30/09/2021');
          }
          if ($contador == 2) {
            $fini = date('01/09/2022');
            $ffin = date('30/09/2022');
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";



          $totalGT9 =
            "SELECT 
                CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
                FROM
                (
                    SELECT 
                    cptraFtra as 'Fec', 
                    adusrNomb as 'Usr',
                    inlocNomb as 'Loc',
                    vtvtaTotT as 'tot', 
                    admonAbrv as 'mon', 
                    cptraCajS as 'efe', 
                    cptraBanS as 'ban', 
                    cptraCxcS as 'cxc',
                    cptraTarS as 'tar', 
                    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                    FROM cptra
                    JOIN vtVta ON vtvtaNtra = cptraNtrI
                    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                    join inloc ON inlocCloc = vtvtaCloc
                    WHERE 
                    cptraMdel = 0 AND cptraTtra = 21
                    AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
                ) as venta
                WHERE (fec BETWEEN @fini AND @ffin)
                GROUP BY mon
                ORDER BY mon";
          $totalGT9 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT9));





          if (empty($totalGT9)) {
            $tarray9[$contador] = "0";
          } else {
            $tarray9[$contador] = $totalGT9[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "AGOSTO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/08/2021');
            $ffin = date('31/08/2021');
          }
          if ($contador == 2) {
            $fini = date('01/08/2022');
            $ffin = date('31/08/2022');
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";



          $totalGT8 =
            "SELECT 
                CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
                FROM
                (
                    SELECT 
                    cptraFtra as 'Fec', 
                    adusrNomb as 'Usr',
                    inlocNomb as 'Loc',
                    vtvtaTotT as 'tot', 
                    admonAbrv as 'mon', 
                    cptraCajS as 'efe', 
                    cptraBanS as 'ban', 
                    cptraCxcS as 'cxc',
                    cptraTarS as 'tar', 
                    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                    FROM cptra
                    JOIN vtVta ON vtvtaNtra = cptraNtrI
                    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                    join inloc ON inlocCloc = vtvtaCloc
                    WHERE 
                    cptraMdel = 0 AND cptraTtra = 21
                    AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
                ) as venta
                WHERE (fec BETWEEN @fini AND @ffin)
                GROUP BY mon
                ORDER BY mon";
          $totalGT8 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT8));





          if (empty($totalGT8)) {
            $tarray8[$contador] = "0";
          } else {
            $tarray8[$contador] = $totalGT8[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "SEPTIEMBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/09/2021');
            $ffin = date('30/09/2021');
          }
          if ($contador == 2) {
            $fini = date('01/09/2022');
            $ffin = date('30/09/2022');
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";



          $totalGT9 =
            "SELECT 
                CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
                FROM
                (
                    SELECT 
                    cptraFtra as 'Fec', 
                    adusrNomb as 'Usr',
                    inlocNomb as 'Loc',
                    vtvtaTotT as 'tot', 
                    admonAbrv as 'mon', 
                    cptraCajS as 'efe', 
                    cptraBanS as 'ban', 
                    cptraCxcS as 'cxc',
                    cptraTarS as 'tar', 
                    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                    FROM cptra
                    JOIN vtVta ON vtvtaNtra = cptraNtrI
                    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                    join inloc ON inlocCloc = vtvtaCloc
                    WHERE 
                    cptraMdel = 0 AND cptraTtra = 21
                    AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
                ) as venta
                WHERE (fec BETWEEN @fini AND @ffin)
                GROUP BY mon
                ORDER BY mon";
          $totalGT9 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT9));





          if (empty($totalGT9)) {
            $tarray9[$contador] = "0";
          } else {
            $tarray9[$contador] = $totalGT9[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "OCTUBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/10/2021');
            $ffin = date('31/10/2021');
          }
          if ($contador == 2) {
            $fini = date('01/10/2022');
            $ffin = date('31/10/2022');
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";



          $totalGT10 =
            "SELECT 
                CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
                FROM
                (
                    SELECT 
                    cptraFtra as 'Fec', 
                    adusrNomb as 'Usr',
                    inlocNomb as 'Loc',
                    vtvtaTotT as 'tot', 
                    admonAbrv as 'mon', 
                    cptraCajS as 'efe', 
                    cptraBanS as 'ban', 
                    cptraCxcS as 'cxc',
                    cptraTarS as 'tar', 
                    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                    FROM cptra
                    JOIN vtVta ON vtvtaNtra = cptraNtrI
                    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                    join inloc ON inlocCloc = vtvtaCloc
                    WHERE 
                    cptraMdel = 0 AND cptraTtra = 21
                    AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
                ) as venta
                WHERE (fec BETWEEN @fini AND @ffin)
                GROUP BY mon
                ORDER BY mon";
          $totalGT10 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT10));





          if (empty($totalGT10)) {
            $tarray10[$contador] = "0";
          } else {
            $tarray10[$contador] = $totalGT10[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "NOVIEMBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/11/2021');
            $ffin = date('30/11/2021');
          }
          if ($contador == 2) {
            $fini = date('01/11/2022');
            $ffin = date('30/11/2022');
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";



          $totalGT11
            =
            "SELECT 
                CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
                FROM
                (
                    SELECT 
                    cptraFtra as 'Fec', 
                    adusrNomb as 'Usr',
                    inlocNomb as 'Loc',
                    vtvtaTotT as 'tot', 
                    admonAbrv as 'mon', 
                    cptraCajS as 'efe', 
                    cptraBanS as 'ban', 
                    cptraCxcS as 'cxc',
                    cptraTarS as 'tar', 
                    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                    FROM cptra
                    JOIN vtVta ON vtvtaNtra = cptraNtrI
                    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                    join inloc ON inlocCloc = vtvtaCloc
                    WHERE 
                    cptraMdel = 0 AND cptraTtra = 21
                    AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
                ) as venta
                WHERE (fec BETWEEN @fini AND @ffin)
                GROUP BY mon
                ORDER BY mon";
          $totalGT11 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT11));





          if (empty($totalGT11)) {
            $tarray11[$contador] = "0";
          } else {
            $tarray11[$contador] = $totalGT11[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "DICIEMBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/12/2021');
            $ffin = date('31/12/2021');
          }
          if ($contador == 2) {
            $fini = date('01/12/2022');
            $ffin = date('31/12/2022');
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
                SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";



          $totalGT12 =
            "SELECT 
                CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
                FROM
                (
                    SELECT 
                    cptraFtra as 'Fec', 
                    adusrNomb as 'Usr',
                    inlocNomb as 'Loc',
                    vtvtaTotT as 'tot', 
                    admonAbrv as 'mon', 
                    cptraCajS as 'efe', 
                    cptraBanS as 'ban', 
                    cptraCxcS as 'cxc',
                    cptraTarS as 'tar', 
                    cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                    FROM cptra
                    JOIN vtVta ON vtvtaNtra = cptraNtrI
                    JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                    JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                    join inloc ON inlocCloc = vtvtaCloc
                    WHERE 
                    cptraMdel = 0 AND cptraTtra = 21
                    AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
                ) as venta
                WHERE (fec BETWEEN @fini AND @ffin)
                GROUP BY mon
                ORDER BY mon";
          $totalGT12 = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGT12));





          if (empty($totalGT12)) {
            $tarray12[$contador] = "0";
          } else {
            $tarray12[$contador] = $totalGT12[0]->Total;
          }

          $contador = $contador + 1;
        }
      }
    }

    //comparativo anul<----------------------------------------      


    $contador = 1;
    while ($contador <= 2) {
      if ($contador == 1) {
        $fini = date('01/01/2021');
        $ffin = date('31/12/2021');
      }
      if ($contador == 2) {
        $fini = date('01/01/2022');
        $ffin = date('31/12/2022');
      }
      $vari = "DECLARE @fini DATE, @ffin DATE
            SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
      $totalGTAnual =
        "SELECT 
        CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
            AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY mon
        ORDER BY mon";

      $totalGTAnual = DB::connection('sqlsrv')->select(DB::raw($vari . $totalGTAnual));
      if (empty($totalGTAnual)) {
        $tarrayAnual[$contador] = 0;
      } else {
        $tarrayAnual[$contador] = $totalGTAnual[0]->Total;
      }

      $contador = $contador + 1;
    }


<<<<<<< HEAD
//-----------NOMBRES DE SUCURSALES POR MES--------------------
      $compa=[];
      $ii1=0;
      $ii2=0;
      $contar=0;
      $contar2=0;
      $contar3=0;
      $su1=[];
      $compaSubL=[];
      $compaSubTi=[];
      $compaSubTo=[];
      $compaSubTo2=[];
      $compaSubTo3=[];
      $compaSubTo4=[];
      $datoFalso1=0;
      $datoFalso2=0;
        
      for ($ff=0; $ff <sizeof($fxmes); $ff++) { 
        if ($fxmes[$ff]=="ENERO"){
          $contador=1;
          $contador2=1;
          while($contador<=2){
              if ($contador==1) {
              $fini = date('01/01/2021');
              $ffin = date('31/01/2021');
              }
              if ($contador==2) {
              $fini = date('01/01/2022');
              $ffin = date('31/01/2022');
              }
              // llenado de vectores-----
              if ($datoFalso1==0) {
                $vari = "DECLARE @fini DATE, @ffin DATE
              SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
              $query=
              "SELECT 
=======
    //-----------NOMBRES DE SUCURSALES POR MES--------------------
    $compa = [];
    $contar = 0;
    $su1 = [];

    for ($ff = 0; $ff < sizeof($fxmes); $ff++) {
      if ($fxmes[$ff] == "ENERO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/01/2021');
            $ffin = date('31/01/2021');
          }
          if ($contador == 2) {
            $fini = date('01/01/2022');
            $ffin = date('31/01/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
              SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
>>>>>>> 643e8981c630da182b5f2619cb5528a00986af04
              loc as 'Local', 
              CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
              FROM
              (
                  SELECT 
                  cptraFtra as 'Fec', 
                  adusrNomb as 'Usr',
                  inlocNomb as 'Loc',
                  vtvtaTotT as 'tot', 
                  admonAbrv as 'mon', 
                  cptraCajS as 'efe', 
                  cptraBanS as 'ban', 
                  cptraCxcS as 'cxc',
                  cptraTarS as 'tar', 
                  cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                  FROM cptra
                  JOIN vtVta ON vtvtaNtra = cptraNtrI
                  JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                  JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                  join inloc ON inlocCloc = vtvtaCloc
                  WHERE 
                  cptraMdel = 0 AND cptraTtra = 21
                 AND adusrCusr NOT IN (9,65)--NO VENDEN
              ) as venta
              WHERE (fec BETWEEN @fini AND @ffin)
              GROUP BY loc, mon
              ORDER BY loc, mon";
<<<<<<< HEAD
           
           $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
                
                  for ($j=0; $j <sizeof($pp) ; $j++) { 
                    if (empty($pp)) {
                      $compa[$contar]=0;
                      $contar=$contar+1;
                     }
                     else{
                      $compa[$contar]=$pp[$j]->Local;
                      $contar=$contar+1;
                     }
                }
              }
              if ($datoFalso2==0) {
                $vari = "DECLARE @fini DATE, @ffin DATE
              SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
              $query=
              "SELECT 
              loc as 'Local', 
              tip as 'Tipo', 
              CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
             
              FROM
              (
                  SELECT 
                  cptraFtra as 'Fec', 
                  adusrNomb as 'Usr',
                  inlocNomb as 'Loc',
                  CASE         
                  WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
                  WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
                  WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
                  WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
                  WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
                  WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
                  WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
                  WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
                  --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
                  ELSE adusrNomb             
                  END as Tip,
                  vtvtaTotT as 'tot', 
                  admonAbrv as 'mon', 
                  cptraCajS as 'efe', 
                  cptraBanS as 'ban', 
                  cptraCxcS as 'cxc',
                  cptraTarS as 'tar', 
                  cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                  FROM cptra
                  JOIN vtVta ON vtvtaNtra = cptraNtrI
                  JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                  JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                  join inloc ON inlocCloc = vtvtaCloc
                  WHERE 
                  cptraMdel = 0 AND cptraTtra = 21
                  AND adusrCusr NOT IN (9,65)--NO VENDEN
              ) as venta
              WHERE (fec BETWEEN @fini AND @ffin)
              GROUP BY loc, tip, mon
              ORDER BY loc, tip, mon";
     $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
          
     if ($contador==1) {
      for ($j=0; $j <sizeof($pp) ; $j++) { 
        if (empty($pp)){
         $compaSubTo[$ii1]=0;
          $ii1=$ii1+1;
         }
         else{
          $compaSubTo[$ii1]=$pp[$j]->Total;
                 $ii1=$ii1+1;
         }
      }
     }


     if ($contador==2) {
      for ($j=0; $j <sizeof($pp) ; $j++) { 
        if (empty($pp)){
         $compaSubTo2[$ii2]=0;
          $ii2=$ii2+1;
         }
         else{
          $compaSubTo2[$ii2]=$pp[$j]->Total;
                 $ii2=$ii2+1;
         }
      }
     }
               for ($j=0; $j <sizeof($pp) ; $j++) { 
                  
                    if (empty($pp)){
                      $compaSubL[$contar2]=0;
                      $compaSubTi[$contar2]=0;
                     
                      $contar2=$contar2+1;
                     }
                     else{
                      $compaSubL[$contar2]=$pp[$j]->Local;
                      $compaSubTi[$contar2]=$pp[$j]->Tipo;
                     
                      $contar2=$contar2+1;
                     }
                }
              
                 
              }
              
  
                $contador=$contador+1;  
    }
  }  
    
  if ($fxmes[$ff]=="FEBRERO"){
    $contador=1;
    $contador2=1;
    while($contador<=2){
        if ($contador==1) {
        $fini = date('01/02/2021');
        $ffin = date('28/02/2021');
        }
        if ($contador==2) {
        $fini = date('01/02/2022');
        $ffin = date('28/02/2022');
        }
        // llenado de vectores-----
        if ($datoFalso1==0) {
          $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
        $query=
        "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
           AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";
     
     $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
          
            for ($j=0; $j <sizeof($pp) ; $j++) { 
              if (empty($pp)) {
                $compa[$contar]=0;
                $contar=$contar+1;
               }
               else{
                $compa[$contar]=$pp[$j]->Local;
                $contar=$contar+1;
               }
          }
        }
        if ($datoFalso2==0) {
          $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
        $query=
        "SELECT 
        loc as 'Local', 
        tip as 'Tipo', 
        CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
       
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            CASE         
            WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
            WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
            WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
            WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
            WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
            WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
            WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
            WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
            --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
            ELSE adusrNomb             
            END as Tip,
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
            AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, tip, mon
        ORDER BY loc, tip, mon";

        
     
     $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
    
     if ($contador==1) {
      for ($j=0; $j <sizeof($pp) ; $j++) { 
        if (empty($pp)){
         $compaSubTo[$ii1]=0;
          $ii1=$ii1+1;
         }
         else{
          $compaSubTo[$ii1]=$pp[$j]->Total;
                 $ii1=$ii1+1;
         }
      }
     }


     if ($contador==2) {
      for ($j=0; $j <sizeof($pp) ; $j++) { 
        if (empty($pp)){
         $compaSubTo2[$ii2]=0;
          $ii2=$ii2+1;
         }
         else{
          $compaSubTo2[$ii2]=$pp[$j]->Total;
                 $ii2=$ii2+1;
         }
      }
     }
               for ($j=0; $j <sizeof($pp) ; $j++) { 
                  
                    if (empty($pp)){
                      $compaSubL[$contar2]=0;
                      $compaSubTi[$contar2]=0;
                     
                      $contar2=$contar2+1;
                     }
                     else{
                      $compaSubL[$contar2]=$pp[$j]->Local;
                      $compaSubTi[$contar2]=$pp[$j]->Tipo;
                     
                      $contar2=$contar2+1;
                     }
                }
        }

        
      
          $contador=$contador+1;  
}
}  

if ($fxmes[$ff]=="MARZO"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/03/2021');
      $ffin = date('31/03/2021');
      }
      if ($contador==2) {
      $fini = date('01/03/2022');
      $ffin = date('31/03/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
}  
if ($fxmes[$ff]=="ABRIL"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/04/2021');
      $ffin = date('30/04/2021');
      }
      if ($contador==2) {
      $fini = date('01/04/2022');
      $ffin = date('30/04/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
} 

if ($fxmes[$ff]=="MAYO"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/05/2021');
      $ffin = date('31/05/2021');
      }
      if ($contador==2) {
      $fini = date('01/05/2022');
      $ffin = date('31/05/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
} 
if ($fxmes[$ff]=="JUNIO"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/06/2021');
      $ffin = date('30/06/2021');
      }
      if ($contador==2) {
      $fini = date('01/06/2022');
      $ffin = date('30/06/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
}

if ($fxmes[$ff]=="JULIO"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/07/2021');
      $ffin = date('31/07/2021');
      }
      if ($contador==2) {
      $fini = date('01/07/2022');
      $ffin = date('31/07/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
}

if ($fxmes[$ff]=="AGOSTO"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/08/2021');
      $ffin = date('31/08/2021');
      }
      if ($contador==2) {
      $fini = date('01/08/2022');
      $ffin = date('31/08/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
}
  
if ($fxmes[$ff]=="SEPTIEMBRE"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/09/2021');
      $ffin = date('30/09/2021');
      }
      if ($contador==2) {
      $fini = date('01/09/2022');
      $ffin = date('30/09/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
}
  
if ($fxmes[$ff]=="OCTUBRE"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/10/2021');
      $ffin = date('31/10/2021');
      }
      if ($contador==2) {
      $fini = date('01/10/2022');
      $ffin = date('31/10/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
}  
if ($fxmes[$ff]=="NOVIEMBRE"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/11/2021');
      $ffin = date('30/11/2021');
      }
      if ($contador==2) {
      $fini = date('01/11/2022');
      $ffin = date('30/11/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
}  
if ($fxmes[$ff]=="DICIEMBRE"){
  $contador=1;
  $contador2=1;
  while($contador<=2){
      if ($contador==1) {
      $fini = date('01/12/2021');
      $ffin = date('31/12/2021');
      }
      if ($contador==2) {
      $fini = date('01/12/2022');
      $ffin = date('31/12/2022');
      }
      // llenado de vectores-----
      if ($datoFalso1==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
        
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compa[$contar]=0;
              $contar=$contar+1;
             }
             else{
              $compa[$contar]=$pp[$j]->Local;
              $contar=$contar+1;
             }
        }
      }
      if ($datoFalso2==0) {
        $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
      $query=
      "SELECT 
      loc as 'Local', 
      tip as 'Tipo', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
     
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          CASE         
          WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
          WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
          WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
          WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
          WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
          WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
          WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
          WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
          --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
          ELSE adusrNomb             
          END as Tip,
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
          AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, tip, mon
      ORDER BY loc, tip, mon";

      
   
   $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
  
          for ($j=0; $j <sizeof($pp) ; $j++) { 
            if (empty($pp)) {
              $compaSubL[$contar2]=0;
              $compaSubTi[$contar2]=0;
              $compaSubTo[$contar2]=0;
              $contar2=$contar2+1;
             }
             else{
              $compaSubL[$contar2]=$pp[$j]->Local;
              $compaSubTi[$contar2]=$pp[$j]->Tipo;
              $compaSubTo[$contar2]=$pp[$j]->Total;
              $contar2=$contar2+1;
             }
        }
      }

      
    
        $contador=$contador+1;  
}
}  
}

asort($compaSubL);
$clonL=[];
foreach ($compaSubL as $key => $value) {
 array_push($clonL,$value); 
}

//return dd($clonL);
$vest=[];
//$compaSubTi=array_unique($compaSubTi);
foreach ($compaSubL as $key11 => $v11) {
  foreach ($compaSubTi as $key22 => $v22) {
      if ($key22==$key11) {
        array_push($vest,$v22);
      }

  }
}

$totalZ=[];
foreach ($compaSubL as $key11 => $v11) {
  foreach ($compaSubTo as $key22 => $v22) {
      if ($key22==$key11) {
        array_push($totalZ,$v22);
      }

  }
}
$totalZ2=[];
foreach ($compaSubL as $key11 => $v11) {
  foreach ($compaSubTo2 as $key22 => $v22) {
      if ($key22==$key11) {
        array_push($totalZ2,$v22);
      }

  }
}
//return dd($totalZ2);


$resp=$vest;
$resp=array_unique($resp);

$otroArray=[];
foreach ($resp as $key11 => $v11) {
  $cct=0;
  foreach ($vest as $key22 => $v22) {
      if ($v11==$v22) {
      
        if ($cct==0) {
          array_push($otroArray,$v22);
        $cct=1;   
        }else {
          array_push($otroArray,"0");
        }

      }
  }
}


$resp2=$totalZ;
$resp2=array_unique($resp2);
$resp3=$totalZ2;
$resp3=array_unique($resp3);

$otroArrayT=[];
foreach ($resp2 as $key11 => $v11) {
  $cct=0;
  foreach ($totalZ as $key22 => $v22) {
      if ($v11==$v22) {
      
        if ($cct==0) {
          array_push($otroArrayT,$v22);
        $cct=1;   
        }else {
          array_push($otroArrayT,"0");
        }

      }
  }
}
if (sizeof($otroArrayT)==0) {
  foreach ($clonL as $key => $value) {
    array_push($otroArrayT,"0");
  }
}
$otroArrayT2=[];
foreach ($resp3 as $key11 => $v11) {
  $cct=0;
  foreach ($totalZ2 as $key22 => $v22) {
      if ($v11==$v22) {
      
        if ($cct==0) {
          array_push($otroArrayT2,$v22);
        $cct=1;   
        }else {
          array_push($otroArrayT2,"0");
        }

      }
  }
}
if (sizeof($otroArrayT2)==0) {
  foreach ($clonL as $key => $value) {
    array_push($otroArrayT2,"0");
  }
}


$compa=array_unique($compa);
$compa=array_filter($compa);




//return dd(sizeof($compa));
////////////////////////TOTALES DE  SUCURSAL//////////////////////////////
$totalSt1=[];
$totalSt11=[];
$totalSt2=[];
$totalSt22=[];
$totalSt3=[];
$totalSt33=[];
$totalSt4=[];
$totalSt44=[];
$totalSt5=[];
$totalSt55=[];
$totalSt6=[];
$totalSt66=[];
$totalSt7=[];
$totalSt77=[];
$totalSt8=[];
$totalSt88=[];
$totalSt9=[];
$totalSt99=[];
$totalSt10=[];
$totalSt100=[];
$totalSt11=[];
$totalSt110=[];
$totalSt12=[];
$totalSt120=[];
////
$datosDeSu1=[];

for ($ff=0; $ff <sizeof($fxmes); $ff++) { 
  if ($fxmes[$ff]=="ENERO"){
    
    $contador=1;
    while($contador<=2){
        if ($contador==1) {
        $fini = date('01/01/2021');
        $ffin = date('31/01/2021');
        }
        if ($contador==2) {
        $fini = date('01/01/2022');
        $ffin = date('31/01/2022');
        }
        
        $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '".$fini."', @ffin = '".$ffin."'";
        $query=
        "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
           AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";
     
     $pp = DB::connection('sqlsrv')->select(DB::raw($vari.$query));
    
     
       if ($contador==1) {
      foreach ($compa as $key => $v) {
        foreach ($pp as $key2 => $v2) {
          if ($v==$v2->Local) {
            $totalSt1[$key]=$v2->Total;
          }
        }
        if(empty($totalSt1[$key])){
          $totalSt1[$key]=0; 
        }
      }
         
       }  
       if ($contador==2) {
        foreach ($compa as $key => $v) {
          foreach ($pp as $key2 => $v2) {
            if ($v==$v2->Local) {
              $totalSt11[$key]=$v2->Total;
=======

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
>>>>>>> 643e8981c630da182b5f2619cb5528a00986af04
            }
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "FEBRERO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/02/2021');
            $ffin = date('28/02/2021');
          }
          if ($contador == 2) {
            $fini = date('01/02/2022');
            $ffin = date('28/02/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
           AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }
          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "MARZO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/03/2021');
            $ffin = date('31/03/2021');
          }
          if ($contador == 2) {
            $fini = date('01/03/2022');
            $ffin = date('31/03/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "ABRIL") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/04/2021');
            $ffin = date('30/04/2021');
          }
          if ($contador == 2) {
            $fini = date('01/04/2022');
            $ffin = date('30/04/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }

      if ($fxmes[$ff] == "MAYO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/05/2021');
            $ffin = date('31/05/2021');
          }
          if ($contador == 2) {
            $fini = date('01/05/2022');
            $ffin = date('31/05/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "JUNIO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/06/2021');
            $ffin = date('30/06/2021');
          }
          if ($contador == 2) {
            $fini = date('01/06/2022');
            $ffin = date('30/06/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }

      if ($fxmes[$ff] == "JULIO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/07/2021');
            $ffin = date('31/07/2021');
          }
          if ($contador == 2) {
            $fini = date('01/07/2022');
            $ffin = date('31/07/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "AGOSTO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/08/2021');
            $ffin = date('31/08/2021');
          }
          if ($contador == 2) {
            $fini = date('01/08/2022');
            $ffin = date('31/08/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }

      if ($fxmes[$ff] == "SEPTIEMBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/09/2021');
            $ffin = date('30/09/2021');
          }
          if ($contador == 2) {
            $fini = date('01/09/2022');
            $ffin = date('30/09/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "OCTUBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/10/2021');
            $ffin = date('31/10/2021');
          }
          if ($contador == 2) {
            $fini = date('01/10/2022');
            $ffin = date('31/10/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "NOVIEMBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/11/2021');
            $ffin = date('30/11/2021');
          }
          if ($contador == 2) {
            $fini = date('01/11/2022');
            $ffin = date('30/11/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "DICIEMBRE") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/12/2021');
            $ffin = date('31/12/2021');
          }
          if ($contador == 2) {
            $fini = date('01/12/2022');
            $ffin = date('31/12/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

          for ($j = 0; $j < sizeof($pp); $j++) {
            if (empty($pp)) {
              $compa[$$contar] = 0;
              $contar = $contar + 1;
            } else {
              $compa[$contar] = $pp[$j]->Local;
              $contar = $contar + 1;
            }
          }

          $contador = $contador + 1;
        }
      }
    }

    $compa = array_unique($compa);
    $compa = array_filter($compa);
    //return dd(sizeof($compa));
    ////////////////////////TOTALES DE  SUCURSAL//////////////////////////////
    $totalSt1 = [];
    $totalSt11 = [];
    $totalSt2 = [];
    $totalSt22 = [];
    $totalSt3 = [];
    $totalSt33 = [];
    $totalSt4 = [];
    $totalSt44 = [];
    $totalSt5 = [];
    $totalSt55 = [];
    $totalSt6 = [];
    $totalSt66 = [];
    $totalSt7 = [];
    $totalSt77 = [];
    $totalSt8 = [];
    $totalSt88 = [];
    $totalSt9 = [];
    $totalSt99 = [];
    $totalSt10 = [];
    $totalSt100 = [];
    $totalSt11 = [];
    $totalSt110 = [];
    $totalSt12 = [];
    $totalSt120 = [];
    ////
    $datosDeSu1 = [];

    for ($ff = 0; $ff < sizeof($fxmes); $ff++) {
      if ($fxmes[$ff] == "ENERO") {
        $datoN = 0;
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/01/2021');
            $ffin = date('31/01/2021');
          }
          if ($contador == 2) {
            $fini = date('01/01/2022');
            $ffin = date('31/01/2022');
          }
          if ($datoN == 0) {
            # code...
          }
          if ($datoN == 1) {
            # code...
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
           AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt1[$key] = $v2->Total;
                }
              }
              if (empty($totalSt1[$key])) {
                $totalSt1[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt11[$key] = $v2->Total;
                }
              }
              if (empty($totalSt11[$key])) {
                $totalSt11[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "FEBRERO") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/02/2021');
            $ffin = date('28/02/2021');
          }
          if ($contador == 2) {
            $fini = date('01/02/2022');
            $ffin = date('28/02/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt2[$key] = $v2->Total;
                }
              }
              if (empty($totalSt2[$key])) {
                $totalSt2[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt22[$key] = $v2->Total;
                }
              }
              if (empty($totalSt22[$key])) {
                $totalSt22[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "MARZO") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/03/2021');
            $ffin = date('31/03/2021');
          }
          if ($contador == 2) {
            $fini = date('01/03/2022');
            $ffin = date('31/03/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt3[$key] = $v2->Total;
                }
              }
              if (empty($totalSt3[$key])) {
                $totalSt3[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt33[$key] = $v2->Total;
                }
              }
              if (empty($totalSt33[$key])) {
                $totalSt33[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "ABRIL") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/04/2021');
            $ffin = date('30/04/2021');
          }
          if ($contador == 2) {
            $fini = date('01/04/2022');
            $ffin = date('30/04/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt4[$key] = $v2->Total;
                }
              }
              if (empty($totalSt4[$key])) {
                $totalSt4[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt44[$key] = $v2->Total;
                }
              }
              if (empty($totalSt44[$key])) {
                $totalSt44[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "MAYO") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/05/2021');
            $ffin = date('31/05/2021');
          }
          if ($contador == 2) {
            $fini = date('01/05/2022');
            $ffin = date('31/05/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt5[$key] = $v2->Total;
                }
              }
              if (empty($totalSt5[$key])) {
                $totalSt5[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt55[$key] = $v2->Total;
                }
              }
              if (empty($totalSt55[$key])) {
                $totalSt55[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }

      if ($fxmes[$ff] == "JUNIO") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/06/2021');
            $ffin = date('30/06/2021');
          }
          if ($contador == 2) {
            $fini = date('01/06/2022');
            $ffin = date('30/06/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt6[$key] = $v2->Total;
                }
              }
              if (empty($totalSt6[$key])) {
                $totalSt6[$key] = 0;
              }
            }
          }

          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt66[$key] = $v2->Total;
                }
              }
              if (empty($totalSt66[$key])) {
                $totalSt66[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }

      if ($fxmes[$ff] == "JULIO") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/07/2021');
            $ffin = date('31/07/2021');
          }
          if ($contador == 2) {
            $fini = date('01/07/2022');
            $ffin = date('31/07/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt7[$key] = $v2->Total;
                }
              }
              if (empty($totalSt7[$key])) {
                $totalSt7[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt77[$key] = $v2->Total;
                }
              }
              if (empty($totalSt77[$key])) {
                $totalSt77[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "AGOSTO") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/08/2021');
            $ffin = date('31/08/2021');
          }
          if ($contador == 2) {
            $fini = date('01/08/2022');
            $ffin = date('31/08/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt8[$key] = $v2->Total;
                }
              }
              if (empty($totalSt8[$key])) {
                $totalSt8[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt88[$key] = $v2->Total;
                }
              }
              if (empty($totalSt88[$key])) {
                $totalSt88[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "SEPTIEMBRE") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/09/2021');
            $ffin = date('30/09/2021');
          }
          if ($contador == 2) {
            $fini = date('01/09/2022');
            $ffin = date('30/09/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt9[$key] = $v2->Total;
                }
              }
              if (empty($totalSt9[$key])) {
                $totalSt9[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt99[$key] = $v2->Total;
                }
              }
              if (empty($totalSt99[$key])) {
                $totalSt99[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "OCTUBRE") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/10/2021');
            $ffin = date('31/10/2021');
          }
          if ($contador == 2) {
            $fini = date('01/10/2022');
            $ffin = date('31/10/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt10[$key] = $v2->Total;
                }
              }
              if (empty($totalSt10[$key])) {
                $totalSt10[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt100[$key] = $v2->Total;
                }
              }
              if (empty($totalSt100[$key])) {
                $totalSt100[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "NOVIEMBRE") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/11/2021');
            $ffin = date('30/11/2021');
          }
          if ($contador == 2) {
            $fini = date('01/11/2022');
            $ffin = date('30/11/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt11[$key] = $v2->Total;
                }
              }
              if (empty($totalSt11[$key])) {
                $totalSt11[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt110[$key] = $v2->Total;
                }
              }
              if (empty($totalSt110[$key])) {
                $totalSt110[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "DICIEMBRE") {

        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/12/2021');
            $ffin = date('31/12/2021');
          }
          if ($contador == 2) {
            $fini = date('01/12/2022');
            $ffin = date('31/12/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $pp = DB::connection('sqlsrv')->select(DB::raw($vari . $query));


          if ($contador == 1) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt12[$key] = $v2->Total;
                }
              }
              if (empty($totalSt12[$key])) {
                $totalSt12[$key] = 0;
              }
            }
          }
          if ($contador == 2) {
            foreach ($compa as $key => $v) {
              foreach ($pp as $key2 => $v2) {
                if ($v == $v2->Local) {
                  $totalSt120[$key] = $v2->Total;
                }
              }
              if (empty($totalSt120[$key])) {
                $totalSt120[$key] = 0;
              }
            }
          }


          $contador = $contador + 1;
        }
      }
    }



    ///////////////////////////////////////////////////////////
    //totales por sucursale --------------------------
    $fmesfin = $fmesfin . "1";
    //return dd($mesini.$fmesfin);
    $totalSursal1 = "";
    $totalSursal2 = "";
    $totalSursal3 = "";
    $arraySucursal1 = [];
    $arraySucursal2 = [];
    $arraySucursal3 = [];
    $arraySucursal33 = [];
    for ($ff = 0; $ff < sizeof($fxmes); $ff++) {
      if ($ff == 0) {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date($mesini);
            $ffin = date($fmesfin);
          }

          $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
        loc as 'Local', 
        
        CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
           AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";

          $totalSursal3 = DB::connection('sqlsrv')->select(DB::raw($vari . $query));
          if ($contador == 1) {
            for ($j = 0; $j < sizeof($totalSursal3); $j++) {
              if (empty($totalSursal3)) {
                $arraySucursal33[$j] = "";
              } else {
                $arraySucursal33[$j] = $totalSursal3[$j]->Local;
              }
            }
          }


          //return dd($arraySucursal3);


          $contador = $contador + 1;
        }
      }




      if ($fxmes[$ff] == "ENERO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/01/2021');
            $ffin = date('31/01/2021');
          }
          if ($contador == 2) {
            $fini = date('01/01/2022');
            $ffin = date('31/01/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
         SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
         loc as 'Local', 
         CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
         FROM
         (
             SELECT 
             cptraFtra as 'Fec', 
             adusrNomb as 'Usr',
             inlocNomb as 'Loc',
             vtvtaTotT as 'tot', 
             admonAbrv as 'mon', 
             cptraCajS as 'efe', 
             cptraBanS as 'ban', 
             cptraCxcS as 'cxc',
             cptraTarS as 'tar', 
             cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
             FROM cptra
             JOIN vtVta ON vtvtaNtra = cptraNtrI
             JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
             JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
             join inloc ON inlocCloc = vtvtaCloc
             WHERE 
             cptraMdel = 0 AND cptraTtra = 21
            AND adusrCusr NOT IN (9,65)--NO VENDEN
         ) as venta
         WHERE (fec BETWEEN @fini AND @ffin)
         GROUP BY loc, mon
         ORDER BY loc, mon";

          $totalSursal1 = DB::connection('sqlsrv')->select(DB::raw($vari . $query));
          if (empty($totalSursal1)) {
            $arraySucursal1[$contador] = 0;
          } else {
            $arraySucursal1[$contador] = $totalSursal1[0]->Total;
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "FEBRERO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/02/2021');
            $ffin = date('28/02/2021');
          }
          if ($contador == 2) {
            $fini = date('01/02/2022');
            $ffin = date('28/02/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
        loc as 'Local', 
        CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
           AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, mon
        ORDER BY loc, mon";

          $totalSursal2 = DB::connection('sqlsrv')->select(DB::raw($vari . $query));
          if (empty($totalSursal2)) {
            $arraySucursal2[$contador] = 0;
          } else {
            $arraySucursal2[$contador] = $totalSursal2[0]->Total;
          }


          $contador = $contador + 1;
        }
      }
      if ($fxmes[$ff] == "MARZO") {
        $contador = 1;
        while ($contador <= 2) {
          if ($contador == 1) {
            $fini = date('01/03/2021');
            $ffin = date('31/03/2021');
          }
          if ($contador == 2) {
            $fini = date('01/03/2022');
            $ffin = date('31/03/2022');
          }
          $vari = "DECLARE @fini DATE, @ffin DATE
      SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";
          $query =
            "SELECT 
      loc as 'Local', 
      CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
      FROM
      (
          SELECT 
          cptraFtra as 'Fec', 
          adusrNomb as 'Usr',
          inlocNomb as 'Loc',
          vtvtaTotT as 'tot', 
          admonAbrv as 'mon', 
          cptraCajS as 'efe', 
          cptraBanS as 'ban', 
          cptraCxcS as 'cxc',
          cptraTarS as 'tar', 
          cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
          FROM cptra
          JOIN vtVta ON vtvtaNtra = cptraNtrI
          JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
          JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
          join inloc ON inlocCloc = vtvtaCloc
          WHERE 
          cptraMdel = 0 AND cptraTtra = 21
         AND adusrCusr NOT IN (9,65)--NO VENDEN
      ) as venta
      WHERE (fec BETWEEN @fini AND @ffin)
      GROUP BY loc, mon
      ORDER BY loc, mon";

          $totalSursal3 = DB::connection('sqlsrv')->select(DB::raw($vari . $query));
          if ($contador == 1) {
            for ($j = 0; $j < sizeof($totalSursal3); $j++) {
              if (empty($totalSursal3)) {
                $arraySucursal3[$j] = 0;
              } else {
                $arraySucursal3[$j] = $totalSursal3[$j]->Total;
              }
            }
          }
          if ($contador == 2) {
            for ($j = 0; $j < sizeof($totalSursal3); $j++) {

              if (empty($totalSursal3)) {
                $arraySucursal3[$j] = 0;
              } else {
                $arraySucursal3[$j] = $totalSursal3[$j]->Total;
              }
            }
          }

          //return dd($arraySucursal3);


          $contador = $contador + 1;
        }
      }
    }

    //-------------------------------------------------


    ///////////////////////// resumen

    $vari = "DECLARE @fini DATE, @ffin DATE
    SELECT @fini = '" . $mesini . "', @ffin = '" . $ff1 . "'";
    $resumen2 = [];

    $query =
      "SELECT 
        loc as 'Local', 
        tip as 'Tipo', 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            CASE         
            WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
            WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
            WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
            WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
            WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
            WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
            WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
            WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
            --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
            ELSE adusrNomb             
            END as Tip,
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
            AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, tip, mon
        ORDER BY loc, tip, mon";
    $resum2 = DB::connection('sqlsrv')->select(DB::raw($vari . $query));
    //   return dd($resum2);
    $resumen2 = [];
    //datos --------------------------------- total
    $fini = date('01/03/2021');
    $ffin = date('31/03/2021');
    $vari = "DECLARE @fini DATE, @ffin DATE
    SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";


    $query =
      "SELECT 
        loc as 'Local', 
        tip as 'Tipo', 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
        FROM
        (
            SELECT 
            cptraFtra as 'Fec', 
            adusrNomb as 'Usr',
            inlocNomb as 'Loc',
            CASE         
            WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
            WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
            WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
            WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
            WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
            WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
            WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
            WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
            --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
            ELSE adusrNomb             
            END as Tip,
            vtvtaTotT as 'tot', 
            admonAbrv as 'mon', 
            cptraCajS as 'efe', 
            cptraBanS as 'ban', 
            cptraCxcS as 'cxc',
            cptraTarS as 'tar', 
            cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
            FROM cptra
            JOIN vtVta ON vtvtaNtra = cptraNtrI
            JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
            JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
            join inloc ON inlocCloc = vtvtaCloc
            WHERE 
            cptraMdel = 0 AND cptraTtra = 21
            AND adusrCusr NOT IN (9,65)--NO VENDEN
        ) as venta
        WHERE (fec BETWEEN @fini AND @ffin)
        GROUP BY loc, tip, mon
        ORDER BY loc, tip, mon";
    $resum2T = DB::connection('sqlsrv')->select(DB::raw($vari . $query));
    $resumen2T = [];

    $vari = "DECLARE @fini DATE, @ffin DATE
    SELECT @fini = '" . $mesini . "', @ffin = '" . $ff1 . "'";
    $total2 =
      "SELECT 
            loc as 'Local', 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
               AND adusrCusr NOT IN (9,65)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, mon
            ORDER BY loc, mon";
    $total2 = DB::connection('sqlsrv')->select(DB::raw($vari . $total2));


    foreach ($resum2 as $key => $value) {
      if (!array_key_exists($value->Local, $resumen2)) {
        $resumen2[$value->Local] = [$resum2[$key]];
      } else {
        array_push($resumen2[$value->Local], $resum2[$key]);
      }
    }
    foreach ($resum2T as $key => $value) {
      if (!array_key_exists($value->Local, $resumen2T)) {
        $resumen2T[$value->Local] = [$resum2T[$key]];
      } else {
        array_push($resumen2T[$value->Local], $resum2T[$key]);
      }
    }
    foreach ($total2 as $key => $value) {
      if (!array_key_exists($value->Local, $total2)) {
        $total2[$value->Local] = [$total2[$key]];
        unset($total2[$key]);
      } else {
        array_push($total2[$value->Local], $total2[$key]);
        unset($total2[$key]);
      }
    }

    //return dd($total2);

    ///////////////////////////////////////////////////////////////


    $fini = '01/03/2021';
    $ffin = '31/03/2021';

    $vari = "DECLARE @fini DATE, @ffin DATE
        SELECT @fini = '" . $fini . "', @ffin = '" . $ffin . "'";


    $query =
      "SELECT 
            loc as 'Local', 
            tip as 'Tipo', 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
           
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                CASE         
                WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
                WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
                WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
                WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
                WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
                WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
                WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
                WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
                --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
                ELSE adusrNomb             
                END as Tip,
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
                AND adusrCusr NOT IN (9,65)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, tip, mon
            ORDER BY loc, tip, mon";
    $resum = DB::connection('sqlsrv')->select(DB::raw($vari . $query));

    /////////////////////////////administrativos
    $admin = "SELECT 
            loc as 'Local', 
            tip as 'Tipo', 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total',  
            mon as 'Moneda', 
            CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
            CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
            CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
            CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
            CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
            CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                CASE         
                WHEN adusrCusr IN (22,23,24,49) THEN 'RETAIL BALLIVIAN'
                WHEN adusrCusr IN (41) THEN 'LIBROS BALLIVIAN'
                WHEN adusrCusr IN (25,26,27,50) THEN 'RETAIL HANDAL'
                WHEN adusrCusr IN (42) THEN 'LIBROS HANDAL' 
                WHEN adusrCusr IN (32,33,34,52) THEN 'RETAIL CALACOTO'
                WHEN adusrCusr IN (43) THEN 'LIBROS CALACOTO'      
                WHEN adusrCusr IN (35,36,38,51,67) THEN 'RETAIL MARISCAL'
                WHEN adusrCusr IN (44) THEN 'LIBROS MARISCAL'   
                --WHEN adusrCusr IN (46,29,39,40,16,39,18,19,20,21,55,28,17,37,57,58,62,63) THEN adusrNomb  
                ELSE adusrNomb             
                END as Tip,
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
              --  (cptraMdel = 0 AND cptraTtra = 21)
                 
                adusrCusr = 65
            --	or  adusrCusr = 4
            or  adusrCusr = 9
             --   or  adusrCusr = 3
            
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, tip, mon
            ORDER BY loc, tip, mon";

    $adminQ = DB::connection('sqlsrv')->select(DB::raw($vari . $admin));
    ////////////////////////////////////////////

    //------------total administrativos-------------------------//
    $totalQ =
      "SELECT 
            loc as 'Local', 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
               adusrCusr=65 or adusrCusr=9
               -- cptraMdel = 0 AND cptraTtra = 21
               AND adusrCusr NOT IN (22,23,24,49,41,25,26,27,50,42,32,33,34,52,43,35,36,38,51,67,44)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, mon
            ORDER BY loc, mon";
    $totalQ = DB::connection('sqlsrv')->select(DB::raw($vari . $totalQ));

    ////////////////////////////////////


    $total =
      "SELECT 
            loc as 'Local', 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total', 
            mon as 'Moneda', 
            CONVERT(VARCHAR, cast(SUM(efe) as money),1) as 'Efectivo', 
            CONVERT(VARCHAR, cast(SUM(ban) as money),1) as 'Banco', 
            CONVERT(VARCHAR, cast(SUM(cxc) as money),1) as 'CXC', 
            CONVERT(VARCHAR, cast(SUM(tar) as money),1) as 'Tarjeta', 
            CONVERT(VARCHAR, cast(SUM(mot) as money),1) as 'MotCont',
            CONVERT(VARCHAR, cast(SUM(otr) as money),1) as 'Otros'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
               AND adusrCusr NOT IN (9,65)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY loc, mon
            ORDER BY loc, mon";
    $total = DB::connection('sqlsrv')->select(DB::raw($vari . $total));
    $totalgen =
      "SELECT 
            CONVERT(VARCHAR, cast(SUM(tot) as money),1) as 'Total'
            FROM
            (
                SELECT 
                cptraFtra as 'Fec', 
                adusrNomb as 'Usr',
                inlocNomb as 'Loc',
                vtvtaTotT as 'tot', 
                admonAbrv as 'mon', 
                cptraCajS as 'efe', 
                cptraBanS as 'ban', 
                cptraCxcS as 'cxc',
                cptraTarS as 'tar', 
                cptraMcnS as 'Mot', cptraCheS+cptraCmpS+cptraOpPd as 'Otr'
                FROM cptra
                JOIN vtVta ON vtvtaNtra = cptraNtrI
                JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = vtvtaCusr
                JOIN bd_admOlimpia.dbo.admon ON admonCmon = vtvtaMtra 
                join inloc ON inlocCloc = vtvtaCloc
                WHERE 
                cptraMdel = 0 AND cptraTtra = 21
                AND adusrCusr NOT IN (2, 3, 4,5,6,7,8,9,10,11,12,13,14,15,47,54,56)--NO VENDEN
            ) as venta
            WHERE (fec BETWEEN @fini AND @ffin)
            GROUP BY mon
            ORDER BY mon";
<<<<<<< HEAD
            $totalgen = DB::connection('sqlsrv')->select(DB::raw($vari . $totalgen));
            $resumen= [];  
            $resumenAdmin=[];
            foreach ($resum as $key => $value) {
                if (!array_key_exists($value->Local, $resumen)) 
                {
                    $resumen[$value->Local] = [$resum[$key]];
                }
                else
                {
                    array_push($resumen[$value->Local], $resum[$key]);
                }
            }
            
            foreach ($adminQ as $key => $value) {
                if (!array_key_exists($value->Local, $resumenAdmin)) 
                {
                    $resumenAdmin[$value->Local] = [$adminQ[$key]];
                }
                else
                {
                    array_push($resumenAdmin[$value->Local], $adminQ[$key]);
                }
            }
            foreach ($total as $key => $value) {
                if (!array_key_exists($value->Local, $total)) 
                {
                    $total[$value->Local] = [$total[$key]];
                    unset($total[$key]);
                }
                else
                {
                    array_push($total[$value->Local], $total[$key]);
                    unset($total[$key]);
                }
            }
            foreach ($totalQ as $key => $value) {
                if (!array_key_exists($value->Local, $totalQ)) 
                {
                    $totalQ[$value->Local] = [$totalQ[$key]];
                    unset($totalQ[$key]);
                }
                else
                {
                    array_push($totalQ[$value->Local], $totalQ[$key]);
                    unset($totalQ[$key]);
                }
          
        }

            return view('reports.vista.resumenxmesvista', compact('compaSubL', 'vest','otroArray','clonL','otroArrayT','otroArrayT2',
            'totalSt12','totalSt120','totalSt11','totalSt110','totalSt10','totalSt100','totalSt9','totalSt99','totalSt8','totalSt88','totalSt7','totalSt77','totalSt6','totalSt66','totalSt5','totalSt55','totalSt4','totalSt44','totalSt3','totalSt33','totalSt2','totalSt22','totalSt1','totalSt11','compa','compaSubL','compaSubTi','compaSubTo','arraySucursal33','totalSursal3','arraySucursal1','arraySucursal2','arraySucursal3','tarrayAnual','fmes','resumen','total2','resumen2','resumen2T','fxmes','ffin','tarray1','tarray2','tarray3','tarray4','tarray5','tarray6','tarray7','tarray8','tarray9','tarray10','tarray11','tarray12','fini', 'total', 'totalgen','resumenAdmin','totalQ'));
        
       
    }
    



    /**
     * Display the specified resource.
     *
     * @param  \App\resumenxmes  $resumenxmes
     * @return \Illuminate\Http\Response
     */
    
    public function show(resumenxmes $resumenxmes)
    {
        //
=======
    $totalgen = DB::connection('sqlsrv')->select(DB::raw($vari . $totalgen));
    $resumen = [];
    $resumenAdmin = [];
    foreach ($resum as $key => $value) {
      if (!array_key_exists($value->Local, $resumen)) {
        $resumen[$value->Local] = [$resum[$key]];
      } else {
        array_push($resumen[$value->Local], $resum[$key]);
      }
>>>>>>> 643e8981c630da182b5f2619cb5528a00986af04
    }

    foreach ($adminQ as $key => $value) {
      if (!array_key_exists($value->Local, $resumenAdmin)) {
        $resumenAdmin[$value->Local] = [$adminQ[$key]];
      } else {
        array_push($resumenAdmin[$value->Local], $adminQ[$key]);
      }
    }
    foreach ($total as $key => $value) {
      if (!array_key_exists($value->Local, $total)) {
        $total[$value->Local] = [$total[$key]];
        unset($total[$key]);
      } else {
        array_push($total[$value->Local], $total[$key]);
        unset($total[$key]);
      }
    }
    foreach ($totalQ as $key => $value) {
      if (!array_key_exists($value->Local, $totalQ)) {
        $totalQ[$value->Local] = [$totalQ[$key]];
        unset($totalQ[$key]);
      } else {
        array_push($totalQ[$value->Local], $totalQ[$key]);
        unset($totalQ[$key]);
      }
    }

    return view('reports.vista.resumenxmesvista', compact('totalSt12', 'totalSt120', 'totalSt11', 'totalSt110', 'totalSt10', 'totalSt100', 'totalSt9', 'totalSt99', 'totalSt8', 'totalSt88', 'totalSt7', 'totalSt77', 'totalSt6', 'totalSt66', 'totalSt5', 'totalSt55', 'totalSt4', 'totalSt44', 'totalSt3', 'totalSt33', 'totalSt2', 'totalSt22', 'totalSt1', 'totalSt11', 'compa', 'arraySucursal33', 'totalSursal3', 'arraySucursal1', 'arraySucursal2', 'arraySucursal3', 'tarrayAnual', 'fmes', 'resumen', 'total2', 'resumen2', 'resumen2T', 'fxmes', 'ffin', 'tarray1', 'tarray2', 'tarray3', 'tarray4', 'tarray5', 'tarray6', 'tarray7', 'tarray8', 'tarray9', 'tarray10', 'tarray11', 'tarray12', 'fini', 'total', 'totalgen', 'resumenAdmin', 'totalQ'));
  }




  /**
   * Display the specified resource.
   *
   * @param  \App\resumenxmes  $resumenxmes
   * @return \Illuminate\Http\Response
   */

  public function show(resumenxmes $resumenxmes)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\resumenxmes  $resumenxmes
   * @return \Illuminate\Http\Response
   */
  public function edit(resumenxmes $resumenxmes)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\resumenxmes  $resumenxmes
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, resumenxmes $resumenxmes)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\resumenxmes  $resumenxmes
   * @return \Illuminate\Http\Response
   */
  public function destroy(resumenxmes $resumenxmes)
  {
    //
  }
}

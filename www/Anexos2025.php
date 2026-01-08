<?php

namespace App\Controllers;

use App\Libraries\Componente;
use App\Models\Generaldb;
use App\Libraries\Funciones;

class Anexos2025 extends BaseController
{
    public $cargado_datos;
    public $campos;
    public function __construct()
    {
        //$this->session = session();
        //$this->session->set(['log'=>false]);
        $this->cargado_datos = '<div class=\"text-center my-4\"><div class=\"spinner-border text-primary\" role=\"status\"></div> Cargando datos...</div>';
    }
    public function getAnexo1u()
    {
        $anexo = new Componente();
        echo $anexo->H4("ANEXO 1", "primary text-center");
        echo $anexo->H4("Propuesta de acciones para el V Bloque de las Semanas de Gestión 2025", "primary text-center");
        echo $anexo->H4("Programación de actividad para el V bloque de semanas de gestión 2025", "primary text-center");
        echo $anexo->Div("", "", "anexo1u_container");
        echo $anexo->Js("
            function getAnexo1uData() {
                $('#anexo1u_container').html('$this->cargado_datos');
                param={};
                ajax('/anexos2025/anexo1uData',param,function(data){
                    $('#anexo1u_container').html(data);
                    closeCargar();
                });
            }
            getAnexo1uData();
        ");
    }
    public function postAnexo1uData()
    {
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $usua_ide = session()->usua_ide;
        $datos = $general->selectSomeDataJoin(
            "
                s.a1us_ide,
                s.a1us_accion,
                s.a1us_actividad,
                s.a1us_producto,
                s.a1us_responsable,
                s.a1us_recurso,
                d.a1ud_a1um_ide,
                d.a1ud_a1uc_ide
            ",
            "2025_a1u_data d",
            false,
            false,
            false,
            false,
            array(
                array("2025_a1u_struct s", "d.a1ud_a1us_ide = s.a1us_ide AND d.a1ud_iiee_ide = $iiee_ide", 'RIGHT'),
            )
        );
        $anexo = new Componente();
        $modalidades = $general->selectSomeDataJoin(
            "a1um_ide as id, a1um_txt as nombre",
            "2025_a1u_modalidad"
        );
        $cronogramas = $general->selectSomeDataJoin(
            "a1uc_ide as id, a1uc_txt as nombre",
            "2025_a1u_cronograma"
        );

        echo "<form id='anexo1u_form' method='POST'>";
        echo "<div class='table-responsive-md'>";
        echo "<table class='table table-bordered table-striped table-hover table-dark' id='anexo1u_table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='text-white text-center'>Acción</th>";
        echo "<th class='text-white text-center'>Actividad</th>";
        echo "<th class='text-white text-center'>Producto</th>";
        echo "<th class='text-white text-center'>Responsable</th>";
        echo "<th class='text-white text-center'>Recurso</th>";
        echo "<th class='text-white text-center'>Modalidad</th>";
        echo "<th class='text-white text-center'>Cronograma</th>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($datos as $reg) {
            $modalidad = $anexo->Select(
                "moda_" . $reg->a1us_ide,
                "",
                $modalidades,
                "primary moda",
                true,
                $reg->a1ud_a1um_ide
            );
            $cronograma = $anexo->Select(
                "crono_" . $reg->a1us_ide,
                "",
                $cronogramas,
                "primary crono",
                true,
                $reg->a1ud_a1uc_ide
            );
            $struct_ide = $anexo->Input(
                "struct_" . $reg->a1us_ide,
                "hidden",
                $reg->a1us_ide,
                "",
                "primary struct",
                ""
            );
            echo "<tr>";
            echo "<td>" . $reg->a1us_accion . "</td>";
            echo "<td>" . $reg->a1us_actividad . "</td>";
            echo "<td>" . $reg->a1us_producto . "</td>";
            echo "<td>" . $reg->a1us_responsable . "</td>";
            echo "<td>" . $reg->a1us_recurso . "</td>";
            echo "<td>" . $modalidad . "</td>";
            echo "<td>" . $cronograma . $struct_ide . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        echo $anexo->Div($anexo->Boton("btn_guardar_anexo1u", "submit", "primary", "", "Guardar Cambios"), "text-end");
        echo $anexo->Br();
        echo $anexo->Br();

        echo "</div>";
        echo "</form>";

        echo $anexo->Js("
            $('#anexo1u_form').submit(function(e){
                e.preventDefault();
                structValues = []; $('input.struct').each(function () { structValues.push($(this).val()); });
                modaValues = []; $('select.moda').each(function () { modaValues.push($(this).val()); });
                cronoValues = []; $('select.crono').each(function () { cronoValues.push($(this).val()); });
                param={
                    stru:structValues,
                    moda:modaValues,
                    crono:cronoValues
                };
                ajax('/anexos2025/anexo1uGuardar',param,function(data){
                    getAnexo1uData();
                });
            });
        ");
    }
    public function postAnexo1uGuardar()
    {
        $general = new Generaldb();

        $stru = $this->request->getPost("stru");
        $moda = $this->request->getPost("moda");
        $cron = $this->request->getPost("crono");

        for ($i = 0; $i < count($stru); $i++) {
            $dataExiste = array(
                "a1ud_dres_ide" => session()->dres_ide,
                "a1ud_ugel_ide" => session()->ugel_ide,
                "a1ud_iiee_ide" => session()->iiee_ide,
                "a1ud_a1us_ide" => $stru[$i]
            );
            $registro = $general->selectSomeDataJoin(
                "*",
                "2025_a1u_data",
                $dataExiste
            );

            if (count($registro) == 0) {
                $dataInsert = array(
                    "a1ud_dres_ide" => session()->dres_ide,
                    "a1ud_ugel_ide" => session()->ugel_ide,
                    "a1ud_iiee_ide" => session()->iiee_ide,
                    "a1ud_usua_ide" => session()->usua_ide,

                    "a1ud_a1us_ide" => $stru[$i],
                    "a1ud_a1um_ide" => $moda[$i],
                    "a1ud_a1uc_ide" => $cron[$i],

                    "a1ud_created" => Funciones::get_ahora(),
                );
                $general->insertData("2025_a1u_data", $dataInsert);
            } else {
                $dataUpdate = array(
                    "a1ud_dres_ide" => session()->dres_ide,
                    "a1ud_ugel_ide" => session()->ugel_ide,
                    "a1ud_iiee_ide" => session()->iiee_ide,
                    "a1ud_usua_ide" => session()->usua_ide,

                    "a1ud_a1us_ide" => $stru[$i],
                    "a1ud_a1um_ide" => $moda[$i],
                    "a1ud_a1uc_ide" => $cron[$i],

                    "a1ud_updated" => Funciones::get_ahora(),
                );
                $general->updateData("2025_a1u_data", $dataUpdate, $dataExiste);
            }
        }
    }
    /**************************************************************************************** */
    public function getAnexo2a()
    {
        $anexo = new Componente();
        echo $anexo->H4("ANEXO 2a", "primary text-center");
        echo $anexo->H4("INFORME DE GESTION ANUAL 2025", "primary text-center");
        echo $anexo->Div("", "", "anexo2a_container");
        echo $anexo->Js("
            function getAnexo2aData() {
                $('#anexo2a_container').html('$this->cargado_datos');
                param={};
                ajax('/anexos2025/anexo2aData',param,function(data){
                    $('#anexo2a_container').html(data);
                    closeCargar();
                });
            }
            getAnexo2aData();
        ");
    }
    public function postAnexo2aData()
    {
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $usua_ide = session()->usua_ide;
        $datos = $general->selectSomeDataJoin(
            "
                s.a2as_ide,
                s.a2as_cge,
                s.a2as_compromisos,
                s.a2as_indicadores,
                d.a2ad_cantidad2024,
                d.a2ad_meta2025,
                d.a2ad_logrado_cuanti,
                d.a2ad_logrado_cuali,
                d.a2ad_dificultades,
                d.a2ad_acciones
            ",
            "2025_a2a_data d",
            false,
            false,
            false,
            false,
            array(
                array("2025_a2a_struct s", "d.a2ad_a2as_ide = s.a2as_ide AND d.a2ad_iiee_ide = $iiee_ide", 'RIGHT'),
            )
        );
        $anexo = new Componente();

        echo "<form id='anexo2a_form' method='POST'>";
        echo "<div class='table-responsive-md'>";
        echo "<table class='table table-bordered table-striped table-hover table-dark' id='anexo2a_table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th width='5%' class='text-white text-center'>CGE</th>";
        echo "<th width='10%' class='text-white text-center'>Compromisos</th>";
        echo "<th width='10%' class='text-white text-center'>Indicadores de seguimiento/prácticas de gestión</th>";
        echo "<th width='8%' class='text-white text-center'>Cantidad IE 2024</th>";
        echo "<th width='8%' class='text-white text-center'>Cantidad o meta propuesta IE 2025</th>";
        echo "<th width='8%' class='text-white text-center'>Meta lograda Cuantitativa</th>";
        echo "<th width='17%' class='text-white text-center'>Meta lograda Cualitativa</th>";
        echo "<th width='17%' class='text-white text-center'>Dificultades presentadas</th>";
        echo "<th width='17%' class='text-white text-center'>Acciones estratégicas de mejora</th>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($datos as $reg) {
            $cantidad2024 = $anexo->Input(
                "cantidad2024_" . $reg->a2as_ide,
                "number",
                $reg->a2ad_cantidad2024,
                "",
                "primary cantidad2024",
                ""
            );
            $meta2025 = $anexo->Input(
                "meta2025_" . $reg->a2as_ide,
                "number",
                $reg->a2ad_meta2025,
                "",
                "primary meta2025",
                ""
            );
            $logrado_cuanti = $anexo->Input(
                "logrado_cuanti_" . $reg->a2as_ide,
                "number",
                $reg->a2ad_logrado_cuanti,
                "",
                "primary logrado_cuanti",
                ""
            );
            $logrado_cuali = $anexo->Textarea(
                "logrado_cuali_" . $reg->a2as_ide,
                $reg->a2ad_logrado_cuali,
                "",
                "5",
                "primary logrado_cuali"
            );
            $dificultades = $anexo->Textarea(
                "dificultades" . $reg->a2as_ide,
                $reg->a2ad_dificultades,
                "",
                "5",
                "primary dificultades"
            );
            $acciones = $anexo->Textarea(
                "acciones" . $reg->a2as_ide,
                $reg->a2ad_acciones,
                "",
                "5",
                "primary acciones"
            );
            $struct_ide = $anexo->Input(
                "struct_" . $reg->a2as_ide,
                "hidden",
                $reg->a2as_ide,
                "",
                "primary struct",
                ""
            );

            echo "<tr>";
            echo "<td>" . $reg->a2as_cge . "</td>";
            echo "<td>" . $reg->a2as_compromisos . "</td>";
            echo "<td>" . $reg->a2as_indicadores . "</td>";
            echo "<td>" . $cantidad2024 . "</td>";
            echo "<td>" . $meta2025 . "</td>";
            echo "<td>" . $logrado_cuanti . "</td>";
            echo "<td>" . $logrado_cuali . "</td>";
            echo "<td>" . $dificultades . "</td>";
            echo "<td>" . $acciones . $struct_ide . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        echo $anexo->Div($anexo->Boton("btn_guardar_anexo2a", "submit", "primary", "", "Guardar Cambios"), "text-end");
        echo $anexo->Br();
        echo $anexo->Br();

        echo "</div>";
        echo "</form>";

        echo $anexo->Js("
            $('#anexo2a_form').submit(function(e){
                e.preventDefault();
                structValues = []; $('input.struct').each(function () { structValues.push($(this).val()); });
                cantidad2024Values = []; $('input.cantidad2024').each(function () { cantidad2024Values.push($(this).val()); });
                meta2025Values = []; $('input.meta2025').each(function () { meta2025Values.push($(this).val()); });
                cuantiValues = []; $('input.logrado_cuanti').each(function () { cuantiValues.push($(this).val()); });
                cualiValues = []; $('textarea.logrado_cuali').each(function () { cualiValues.push($(this).val()); });
                dificultadesValues = []; $('textarea.dificultades').each(function () { dificultadesValues.push($(this).val()); });
                accionesValues = []; $('textarea.acciones').each(function () { accionesValues.push($(this).val()); });
                param={
                    stru:structValues,
                    cantidad2024:cantidad2024Values,
                    meta2025:meta2025Values,
                    cuanti:cuantiValues,
                    cuali:cualiValues,
                    dificultades:dificultadesValues,
                    acciones:accionesValues
                };
                ajax('/anexos2025/anexo2aGuardar',param,function(data){
                    getAnexo2aData();
                });
            });
        ");
    }
    public function postAnexo2aGuardar()
    {
        $general = new Generaldb();

        $stru = $this->request->getPost("stru");
        $cantidad2024 = $this->request->getPost("cantidad2024");
        $meta2025 = $this->request->getPost("meta2025");
        $cuanti = $this->request->getPost("cuanti");
        $cuali = $this->request->getPost("cuali");
        $dificultades = $this->request->getPost("dificultades");
        $acciones = $this->request->getPost("acciones");

        for ($i = 0; $i < count($stru); $i++) {
            $dataExiste = array(
                "a2ad_dres_ide" => session()->dres_ide,
                "a2ad_ugel_ide" => session()->ugel_ide,
                "a2ad_iiee_ide" => session()->iiee_ide,
                "a2ad_a2as_ide" => $stru[$i]
            );
            $registro = $general->selectSomeDataJoin(
                "*",
                "2025_a2a_data",
                $dataExiste
            );
            if (count($registro) == 0) {
                $dataInsert = array(
                    "a2ad_dres_ide" => session()->dres_ide,
                    "a2ad_ugel_ide" => session()->ugel_ide,
                    "a2ad_iiee_ide" => session()->iiee_ide,
                    "a2ad_usua_ide" => session()->usua_ide,

                    "a2ad_a2as_ide" => $stru[$i],
                    "a2ad_cantidad2024" => $cantidad2024[$i],
                    "a2ad_meta2025" => $meta2025[$i],
                    "a2ad_logrado_cuanti" => $cuanti[$i],
                    "a2ad_logrado_cuali" => $cuali[$i],
                    "a2ad_dificultades" => $dificultades[$i],
                    "a2ad_acciones" => $acciones[$i],

                    "a2ad_created" => Funciones::get_ahora(),
                );
                $general->insertData("2025_a2a_data", $dataInsert);
            } else {
                $dataUpdate = array(
                    "a2ad_dres_ide" => session()->dres_ide,
                    "a2ad_ugel_ide" => session()->ugel_ide,
                    "a2ad_iiee_ide" => session()->iiee_ide,
                    "a2ad_usua_ide" => session()->usua_ide,

                    "a2ad_a2as_ide" => $stru[$i],
                    "a2ad_cantidad2024" => $cantidad2024[$i],
                    "a2ad_meta2025" => $meta2025[$i],
                    "a2ad_logrado_cuanti" => $cuanti[$i],
                    "a2ad_logrado_cuali" => $cuali[$i],
                    "a2ad_dificultades" => $dificultades[$i],
                    "a2ad_acciones" => $acciones[$i],

                    "a2ad_updated" => Funciones::get_ahora(),
                );
                $general->updateData("2025_a2a_data", $dataUpdate, $dataExiste);
            }
        }
    }
    /**************************************************************************************** */
    public function getAnexo3a()
    {
        $anexo = new Componente();
        echo $anexo->H4("ANEXO 3a", "primary text-center");
        echo $anexo->H4("INFORME CONSOLIDADO DE MONITOREO 2025", "primary text-center");
        echo $anexo->Div("", "", "anexo3a_container");
        echo $anexo->Js("
            function getAnexo3aData() {
                $('#anexo3a_container').html('$this->cargado_datos');
                param={};
                ajax('/anexos2025/anexo3aData',param,function(data){
                    $('#anexo3a_container').html(data);
                    closeCargar();
                });
            }
            getAnexo3aData();
        ");
    }
    public function postAnexo3aData()
    {
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $usua_ide = session()->usua_ide;
        $datos = $general->selectSomeDataJoin(
            "
                *
            ",
            "2025_a3a_data d",
            false,
            false,
            false,
            false,
            array(
                array("2025_a3a_struct s", "d.a3ad_a3as_ide = s.a3as_ide AND d.a3ad_iiee_ide = $iiee_ide", 'RIGHT'),
            )
        );
        $anexo = new Componente();

        echo "<form id='anexo3a_form' method='POST'>";
        echo "<div class='table-responsive-md'>";

        echo $anexo->Input(
            "total",
            "number",
            $datos[0]->a3ad_total_docentes,
            "CANTIDAD TOTAL DE DOCENTES NOMBRADOS Y CONTRATADOS",
            "primary",
            ""
        );

        echo $anexo->Input(
            "monitoreados",
            "number",
            $datos[0]->a3ad_docentes_monitoreados,
            "CANTIDAD TOTAL DE DOCENTES NOMBRADOS Y CONTRATADOS MONITOREADOS",
            "primary",
            ""
        );

        echo "<table class='table table-bordered table-striped table-hover table-dark' id='anexo3a_table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='text-white text-center' colspan=2>Rúbricas de desempeño docente</th>";
        echo "<th class='text-white text-center'>I</th>";
        echo "<th class='text-white text-center'>II</th>";
        echo "<th class='text-white text-center'>III</th>";
        echo "<th class='text-white text-center'>IV</th>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($datos as $reg) {
            $data1 = $anexo->Input(
                "data1_" . $reg->a3as_ide,
                "number",
                $reg->a3ad_data1,
                "",
                "primary data1",
                ""
            );
            $data2 = $anexo->Input(
                "data2_" . $reg->a3as_ide,
                "number",
                $reg->a3ad_data2,
                "",
                "primary data2",
                ""
            );
            $data3 = $anexo->Input(
                "data3_" . $reg->a3as_ide,
                "number",
                $reg->a3ad_data3,
                "",
                "primary data3",
                ""
            );
            $data4 = $anexo->Input(
                "data4_" . $reg->a3as_ide,
                "number",
                $reg->a3ad_data4,
                "",
                "primary data4",
                ""
            );

            $struct_ide = $anexo->Input(
                "struct_" . $reg->a3as_ide,
                "hidden",
                $reg->a3as_ide,
                "",
                "primary struct",
                ""
            );

            echo "<tr>";
            echo "<td>" . $reg->a3as_rubrica . "</td>";
            echo "<td>" . $reg->a3as_ubicados . "</td>";
            echo "<td>" . $data1 . "</td>";
            echo "<td>" . $data2 . "</td>";
            echo "<td>" . $data3 . "</td>";
            echo "<td>" . $data4 . $struct_ide . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        echo $anexo->Div($anexo->Boton("btn_guardar_anexo3a", "submit", "primary", "", "Guardar Cambios"), "text-end");
        echo $anexo->Br();
        echo $anexo->Br();

        echo "</div>";
        echo "</form>";

        echo $anexo->Js("
            $('#anexo3a_form').submit(function(e){
                e.preventDefault();
                structValues = []; $('input.struct').each(function () { structValues.push($(this).val()); });
                data1 = []; $('input.data1').each(function () { data1.push($(this).val()); });
                data2 = []; $('input.data2').each(function () { data2.push($(this).val()); });
                data3 = []; $('input.data3').each(function () { data3.push($(this).val()); });
                data4 = []; $('input.data4').each(function () { data4.push($(this).val()); });
                param={
                    total:$('#total').val(),
                    monitoreados:$('#monitoreados').val(),
                    stru:structValues,
                    data1:data1,
                    data2:data2,
                    data3:data3,
                    data4:data4
                };
                ajax('/anexos2025/anexo3aGuardar',param,function(data){
                    getAnexo3aData();
                });
            });
        ");
    }
    public function postAnexo3aGuardar()
    {
        $general = new Generaldb();

        $total = $this->request->getPost("total");
        $moni = $this->request->getPost("monitoreados");
        $stru = $this->request->getPost("stru");
        $data1 = $this->request->getPost("data1");
        $data2 = $this->request->getPost("data2");
        $data3 = $this->request->getPost("data3");
        $data4 = $this->request->getPost("data4");

        for ($i = 0; $i < count($stru); $i++) {
            $dataExiste = array(
                "a3ad_dres_ide" => session()->dres_ide,
                "a3ad_ugel_ide" => session()->ugel_ide,
                "a3ad_iiee_ide" => session()->iiee_ide,
                "a3ad_a3as_ide" => $stru[$i]
            );
            $registro = $general->selectSomeDataJoin(
                "*",
                "2025_a3a_data",
                $dataExiste
            );
            if (count($registro) == 0) {
                $dataInsert = array(
                    "a3ad_dres_ide" => session()->dres_ide,
                    "a3ad_ugel_ide" => session()->ugel_ide,
                    "a3ad_iiee_ide" => session()->iiee_ide,
                    "a3ad_usua_ide" => session()->usua_ide,

                    "a3ad_total_docentes" => $total,
                    "a3ad_docentes_monitoreados" => $moni,
                    "a3ad_a3as_ide" => $stru[$i],
                    "a3ad_data1" => $data1[$i],
                    "a3ad_data2" => $data2[$i],
                    "a3ad_data3" => $data3[$i],
                    "a3ad_data4" => $data4[$i],

                    "a3ad_created" => Funciones::get_ahora(),
                );
                $general->insertData("2025_a3a_data", $dataInsert);
            } else {
                $dataUpdate = array(
                    "a3ad_dres_ide" => session()->dres_ide,
                    "a3ad_ugel_ide" => session()->ugel_ide,
                    "a3ad_iiee_ide" => session()->iiee_ide,
                    "a3ad_usua_ide" => session()->usua_ide,

                    "a3ad_total_docentes" => $total,
                    "a3ad_docentes_monitoreados" => $moni,
                    "a3ad_a3as_ide" => $stru[$i],
                    "a3ad_data1" => $data1[$i],
                    "a3ad_data2" => $data2[$i],
                    "a3ad_data3" => $data3[$i],
                    "a3ad_data4" => $data4[$i],

                    "a3ad_updated" => Funciones::get_ahora(),
                );
                $general->updateData("2025_a3a_data", $dataUpdate, $dataExiste);
            }
        }
    }
    /**************************************************************************************** */
    public function getAnexo3b()
    {
        $anexo = new Componente();
        echo $anexo->H4("ANEXO 3b", "primary text-center");
        echo $anexo->H4("INFORME CONSOLIDADO DE MONITOREO 2025", "primary text-center");
        echo $anexo->Div("", "", "anexo3b_container");
        echo $anexo->Js("
            function getAnexo3bData() {
                $('#anexo3b_container').html('$this->cargado_datos');
                param={};
                ajax('/anexos2025/anexo3bData',param,function(data){
                    $('#anexo3b_container').html(data);
                    closeCargar();
                });
            }
            getAnexo3bData();
        ");
    }
    public function postAnexo3bData()
    {
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $usua_ide = session()->usua_ide;
        $datos = $general->selectSomeDataJoin(
            "
                *
            ",
            "2025_a3b_data d",
            false,
            false,
            false,
            false,
            array(
                array("2025_a3b_struct s", "d.a3bd_a3bs_ide = s.a3bs_ide AND d.a3bd_iiee_ide = $iiee_ide", 'RIGHT'),
            )
        );
        $anexo = new Componente();

        echo "<form id='anexo3b_form' method='POST'>";
        echo "<div class='table-responsive-md'>";

        echo "<table class='table table-bordered table-striped table-hover table-dark' id='anexo3b_table'>";
        echo "
            <colgroup>
                <col style='width:25%'>
                <col style='width:75%'>
            </colgroup>
        ";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='text-white text-center' colspan=2 style='width:25%'>DESCRIBA CADA ASPECTO EN REFERENCIA AL MONITOREO DESARROLLADO</th>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($datos as $reg) {
            $descripcion = $anexo->Textarea(
                "descripcion_" . $reg->a3bs_ide,
                $reg->a3bd_descripcion,
                "",
                "3",
                "primary descripcion"
            );

            $struct_ide = $anexo->Input(
                "struct_" . $reg->a3bs_ide,
                "hidden",
                $reg->a3bs_ide,
                "",
                "primary struct",
                ""
            );

            echo "<tr>";
            echo "<td>" . $reg->a3bs_aspecto . "</td>";
            echo "<td>" . $descripcion . $struct_ide . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        echo $anexo->Div($anexo->Boton("btn_guardar_anexo3b", "submit", "primary", "", "Guardar Cambios"), "text-end");
        echo $anexo->Br();
        echo $anexo->Br();

        echo "</div>";
        echo "</form>";

        echo $anexo->Js("
            $('#anexo3b_form').submit(function(e){
                e.preventDefault();
                structValues = []; $('input.struct').each(function () { structValues.push($(this).val()); });
                descripcionValues = []; $('textarea.descripcion').each(function () { descripcionValues.push($(this).val()); });
                param={
                    stru:structValues,
                    descripcion:descripcionValues
                };
                ajax('/anexos2025/anexo3bGuardar',param,function(data){
                    getAnexo3bData();
                });
            });
        ");
    }
    public function postAnexo3bGuardar()
    {
        /*echo "<pre>";
        print_r($_POST);
        return false;*/
        $general = new Generaldb();

        $stru = $this->request->getPost("stru");
        $descripcion = $this->request->getPost("descripcion");

        for ($i = 0; $i < count($stru); $i++) {
            $dataExiste = array(
                "a3bd_dres_ide" => session()->dres_ide,
                "a3bd_ugel_ide" => session()->ugel_ide,
                "a3bd_iiee_ide" => session()->iiee_ide,
                "a3bd_a3bs_ide" => $stru[$i]
            );
            $registro = $general->selectSomeDataJoin(
                "*",
                "2025_a3b_data",
                $dataExiste
            );
            if (count($registro) == 0) {
                $dataInsert = array(
                    "a3bd_dres_ide" => session()->dres_ide,
                    "a3bd_ugel_ide" => session()->ugel_ide,
                    "a3bd_iiee_ide" => session()->iiee_ide,
                    "a3bd_usua_ide" => session()->usua_ide,

                    "a3bd_a3bs_ide" => $stru[$i],
                    "a3bd_descripcion" => $descripcion[$i],

                    "a3bd_created" => Funciones::get_ahora(),
                );
                $general->insertData("2025_a3b_data", $dataInsert);
            } else {
                $dataUpdate = array(
                    "a3bd_dres_ide" => session()->dres_ide,
                    "a3bd_ugel_ide" => session()->ugel_ide,
                    "a3bd_iiee_ide" => session()->iiee_ide,
                    "a3bd_usua_ide" => session()->usua_ide,

                    "a3bd_a3bs_ide" => $stru[$i],
                    "a3bd_descripcion" => $descripcion[$i],

                    "a3bd_updated" => Funciones::get_ahora(),
                );
                $general->updateData("2025_a3b_data", $dataUpdate, $dataExiste);
            }
        }
    }
    /**************************************************************************************** */
    public function getAnexo7b()
    {
        $anexo = new Componente();
        echo $anexo->H4("ANEXO 7b", "primary text-center");
        echo $anexo->H4("INFORME DE LA IMPLEMENTACIÒN DE LA ESTRATEGIA DIGITAL EN LA INSTITUCIÓN EDUCATIVA", "primary text-center");
        echo $anexo->Div("", "", "anexo7b_container");
        echo $anexo->Js("
            function getAnexo7bData() {
                $('#anexo7b_container').html('$this->cargado_datos');
                param={};
                ajax('/anexos2025/anexo7bData',param,function(data){
                    $('#anexo7b_container').html(data);
                    closeCargar();
                });
            }
            getAnexo7bData();
        ");
    }
    public function postAnexo7bData()
    {
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $usua_ide = session()->usua_ide;
        $datos = $general->selectSomeDataJoin(
            "
                *
            ",
            "2025_a7b_data d",
            false,
            false,
            false,
            false,
            array(
                array("2025_a7b_preguntas p", "d.a7bd_a7bp_ide = p.a7bp_ide AND d.a7bd_iiee_ide = $iiee_ide", 'RIGHT'),
                array("2025_a7b_dimensiones di", "p.a7bp_a7bdi_ide = di.a7bdi_ide", 'RIGHT'),
            )
        );

        $estados = $general->selectSomeDataJoin(
            "a7be_ide as id, a7be_nombre as nombre",
            "2025_a7b_estados"
        );

        $anexo = new Componente();

        echo "<form id='anexo7b_form' method='POST'>";
        echo "<div class='table-responsive-md'>";

        echo "<table class='table table-bordered table-striped table-hover table-dark' id='anexo7b_table'>";
        /*echo "
            <colgroup>
                <col style='width:25%'>
                <col style='width:75%'>
            </colgroup>
        ";*/
        echo "<thead>";
        echo "<tr>";
        echo "<th class='text-white text-center' width='40%'>Dimensión</th>";
        echo "<th class='text-white text-center' width='40%'>Pregunta</th>";
        echo "<th class='text-white text-center' width='20%'>Estado</th>";
        echo "</thead>";
        echo "<tbody>";
        foreach ($datos as $reg) {
            $estado = $anexo->Select(
                "esta_" . $reg->a7bp_ide,
                "",
                $estados,
                "primary esta",
                true,
                $reg->a7bd_a7be_ide
            );

            $struct_ide = $anexo->Input(
                "struct_" . $reg->a7bp_ide,
                "hidden",
                $reg->a7bp_ide,
                "",
                "primary struct",
                ""
            );

            echo "<tr>";
            echo "<td>" . "<b>" . $reg->a7bdi_nro . ". DIMENSIÖN: </b>" . $reg->a7bdi_nombre . "</td>";
            echo "<td>" . $reg->a7bp_nombre . "</td>";
            echo "<td>" . $estado . $struct_ide . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        echo $anexo->Div($anexo->Boton("btn_guardar_anexo7b", "submit", "primary", "", "Guardar Cambios"), "text-end");
        echo $anexo->Br();
        echo $anexo->Br();

        echo "</div>";
        echo "</form>";

        echo $anexo->Js("
            $('#anexo7b_form').submit(function(e){
                e.preventDefault();
                structValues = []; $('input.struct').each(function () { structValues.push($(this).val()); });
                estadosValues = []; $('select.esta').each(function () { estadosValues.push($(this).val()); });
                param={
                    stru:structValues,
                    estados:estadosValues
                };
                ajax('/anexos2025/anexo7bGuardar',param,function(data){
                    getAnexo7bData();
                });
            });
        ");
    }
    public function postAnexo7bGuardar()
    {
        /*echo "<pre>";
        print_r($_POST);
        return false;*/
        $general = new Generaldb();

        $stru = $this->request->getPost("stru");
        $estados = $this->request->getPost("estados");

        for ($i = 0; $i < count($stru); $i++) {
            $dataExiste = array(
                "a7bd_dres_ide" => session()->dres_ide,
                "a7bd_ugel_ide" => session()->ugel_ide,
                "a7bd_iiee_ide" => session()->iiee_ide,
                "a7bd_a7bp_ide" => $stru[$i]
            );
            $registro = $general->selectSomeDataJoin(
                "*",
                "2025_a7b_data",
                $dataExiste
            );
            if (count($registro) == 0) {
                $dataInsert = array(
                    "a7bd_dres_ide" => session()->dres_ide,
                    "a7bd_ugel_ide" => session()->ugel_ide,
                    "a7bd_iiee_ide" => session()->iiee_ide,
                    "a7bd_usua_ide" => session()->usua_ide,

                    "a7bd_a7bp_ide" => $stru[$i],
                    "a7bd_a7be_ide" => $estados[$i],

                    "a7bd_created" => Funciones::get_ahora(),
                );
                $general->insertData("2025_a7b_data", $dataInsert);
            } else {
                $dataUpdate = array(
                    "a7bd_dres_ide" => session()->dres_ide,
                    "a7bd_ugel_ide" => session()->ugel_ide,
                    "a7bd_iiee_ide" => session()->iiee_ide,
                    "a7bd_usua_ide" => session()->usua_ide,

                    "a7bd_a7bp_ide" => $stru[$i],
                    "a7bd_a7be_ide" => $estados[$i],

                    "a7bd_updated" => Funciones::get_ahora(),
                );
                $general->updateData("2025_a7b_data", $dataUpdate, $dataExiste);
            }
        }
    }
    /************************************************************************************************************* */
    public function campo($campo, $tipo, $valor, $etiqueta, $col, $lista = array())
    {
        return array(
            "campo" => $campo,
            "tipo" => $tipo,
            "valor" => $valor,
            "etiqueta" => $etiqueta,
            "col" => $col,
            "lista" => $lista
        );
    }
    public function postGuardarData($tabla, $sufijo)
    {
        $general = new Generaldb();
        $ide = $sufijo . "_ide";
        if ($this->request->getPost($ide) == 0) {
            $data = $this->request->getPost();
            unset($data[$ide]);
            $data[$sufijo . "_dres_ide"] = session()->dres_ide;
            $data[$sufijo . "_ugel_ide"] = session()->ugel_ide;
            $data[$sufijo . "_iiee_ide"] = session()->iiee_ide;
            $data[$sufijo . "_usua_ide"] = session()->usua_ide;
            $data[$sufijo . "_created"] = Funciones::get_ahora();
            $general->insertData($tabla, $data);
        } else {
            echo "Update...";
            $where = array();
            $where[$sufijo . "_ide"] = $this->request->getPost($ide);
            $where[$sufijo . "_dres_ide"] = session()->dres_ide;
            $where[$sufijo . "_ugel_ide"] = session()->ugel_ide;
            $where[$sufijo . "_iiee_ide"] = session()->iiee_ide;
            $data = $this->request->getPost();
            $data[$sufijo . "_updated"] = Funciones::get_ahora();
            $general->updateData($tabla, $data, $where);
            print_r($where);
            print_r($data);
        }
        //print_r($_POST);
    }
    public function formulario($modalId, $titulo, $modalSize, $campos, $tabla, $id, $js)
    {
        $mapeado = array();
        foreach ($campos as $reg) {
            $mapeado[$reg["campo"]] = $reg;
        }
        $compo = new Componente;
        foreach ($mapeado as $reg) {
            $col = "col-12 col-sm-6 col-lg-" . $reg["col"];
            $c = "";
            if ($reg["tipo"] == "number" or $reg["tipo"] == "text" or $reg["tipo"] == "hidden" or $reg["tipo"] == "email") {
                $c = $compo->Input($reg["campo"], $reg["tipo"], $reg["valor"], $reg["etiqueta"], "primary");
            } else if ($reg["tipo"] == "select") {
                $c = $compo->Select($reg["campo"], $reg["etiqueta"], $reg["lista"], "primary", true, $reg["valor"]);
            } else if ($reg["tipo"] == "textarea") {
                $c = $compo->TextArea($reg["campo"], $reg["valor"], $reg["etiqueta"], "3", "primary");
            }
            $compo->agregar($compo->Col($col, $c));
        }
        $btnGuardar = $compo->Boton("modalBtnGuaradar-" . $modalId, "submit", "primary w-100", "ti-check", "Guardar cambios");
        $compo->agregar($compo->Col("col-12", $btnGuardar));

        $listaC = array();
        foreach ($mapeado as $reg) {
            $listaC[] = $reg["campo"];
        }
        $listaCampos = implode(",", $listaC);
        $compo->agregar($compo->Div("" . $listaCampos, "d-none", "listaCampos-$modalId"));

        $formulario = $compo->get("form", "row", "id='form$modalId'");
        $modalForm = $compo->Modal($modalId, $titulo, $formulario, "", $modalSize);



        echo $compo->Div($compo->Boton("modalBtn-" . $modalId, "button", "primary", "ti-plus", "Agregar nuevo"), "text-end", "");
        echo $modalForm;
        echo $compo->Js("
            $('#modalBtn-$modalId').click(function(){
                $('#$modalId').modal('show');
            });
            $('#form$modalId').submit(function(e){
                e.preventDefault();
                ajax('/anexos2025/guardarData/$tabla/$id',$(this).serialize(),function(data){
                    closeCargar();
                    $('#$modalId').modal('hide');
                    $('#form$modalId')[0].reset();
                    $js
                });
            });
        ");
        //echo "<pre>";
        //print_r($mapeado);
        //$compo->agregar();
    }
    public function mostrarRegistros($data, $campos, $modalId, $tabla, $sufijo)
    {
        echo "<div class='table-responsive-md mt-3'>";
        echo "<table class='table table-bordered table-striped table-hover table-dark' id='anexo1u_table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='text-white text-center'>Nro</th>";
        foreach ($campos as $reg) {
            if ($reg["mostrar"] == "si") {
                echo "<th class='text-white $reg[clase]'>$reg[col]</th>";
            }
        }
        echo "<th class='text-white text-center'>Op.</th>";
        echo "</tr>";
        echo "</thead>";

        echo "<tbody>";
        $compo = new Componente();
        $data2 = array_map(function ($item) {
            return (array) $item;
        }, $data);
        $c = 1;
        foreach ($data2 as $reg) {
            echo "<tr>";
            echo "<td class='text-center'>" . ($c++) . "</td>";
            foreach ($campos as $re) {
                if ($re["mostrar"] == "si") {
                    echo "<td class='$re[clase]'>" . $reg[$re["valor"]] . "</td>";
                }
            }
            $editar = $compo->Boton("editar-" . $reg[$sufijo . "_ide"], "button", "xs btn-success editarReg", "ti-pencil", "");
            $eliminar = $compo->Boton("eliminar-" . $reg[$sufijo . "_ide"], "button", "xs btn-danger eliminarReg", "ti-trash", "");
            echo "<td class=text-center'>$editar $eliminar</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        $anexo = str_replace("modal", "", $modalId); //dsaasdadssda

        echo $compo->Js("
            $('.editarReg').click(function(){
                param={
                    edit1:$(this).attr('id'),
                    edit2:$('#listaCampos-$modalId').html()
                };
                ajax('/anexos2025/getData/$tabla/$sufijo',param,function(data){
                    closeCargar();
                    $('#$modalId').modal('show');
                    data=JSON.parse(data);
                    for(i=0;i<data.length;i++){
                        $('#'+data[i]['campo']).val(data[i]['valor'])
                    }
                });
            });

            $('.eliminarReg').click(function(){
                if(!confirm('¿Está seguro de eliminar este registro?'))
                    return false;
                param={
                    edit1:$(this).attr('id')
                };
                ajax('/anexos2025/deleteData/$tabla/$sufijo',param,function(data){
                    closeCargar();
                    getData$anexo();
                });
            });
        ");
    }
    public function postGetData($tabla, $sufijo)
    {
        $ide = explode("-", $this->request->getPost("edit1"))[1];
        $general = new Generaldb();
        $registro = $general->selectSomeDataJoin("*", $tabla, "$sufijo" . "_ide = $ide");
        $registro2 = array_map(function ($item) {
            return (array) $item;
        }, $registro);
        $listaCampos = explode(",", $this->request->getPost("edit2"));
        $data = array();
        foreach ($listaCampos as $reg) {
            $data[] = array(
                "campo" => $reg,
                "valor" => $registro2[0][$reg]
            );
        }
        echo json_encode($data);
    }
    public function postDeleteData($tabla, $sufijo)
    {
        $ide = explode("-", $this->request->getPost("edit1"))[1];
        $general = new Generaldb();
        $where = array(
            "$sufijo" . "_ide" => $ide,
            "$sufijo" . "_dres_ide" => session()->dres_ide,
            "$sufijo" . "_ugel_ide" => session()->ugel_ide,
            "$sufijo" . "_iiee_ide" => session()->iiee_ide
        );
        $general->deleteData($tabla, $where);
    }
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */
    /************************************************************************************************************* */

    public function getAnexo2b()
    {
        /***************************************************************************** */
        $compo = new Componente();
        echo $compo->H4("ANEXO 2b", "primary text-center");
        echo $compo->H4("INFORME DE GESTIÓN ANUAL 2025", "primary text-center");
        /***************************************************************************** */
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $iiee = $general->selectSomeDataJoin("*", "iiee", "iiee_ide = $iiee_ide");
        $nive_ide = $iiee[0]->iiee_nive_ide;
        $grados = $general->selectSomeDataJoin("grad_ide as id,grad_nombre as nombre", "grados", "grad_nive_ide = $nive_ide");
        $arcus = $general->selectSomeDataJoin("arcu_ide as id,arcu_nombre as nombre", "areas_curriculares");
        $competencias = $general->selectSomeDataJoin("comp_ide as id,comp_nombre as nombre", "competencias", "comp_esta_ide = 1", "comp_nombre");
        $this->campos = [
            $this->campo("a2bd_ide", "hidden", "0", "", "12"),
            $this->campo("a2bd_grad_ide", "select", "", "Grado", "4", $grados),
            $this->campo("a2bd_arcu_ide", "select", "", "Area curricular", "4", $arcus),
            $this->campo("a2bd_comp_ide", "select", "", "Competencia", "4", $competencias),
            $this->campo("a2bd_inicio", "number", "",  "Inicio", "3"),
            $this->campo("a2bd_proceso", "number", "",  "Proceso", "3"),
            $this->campo("a2bd_esperado", "number", "",  "Esperado", "3"),
            $this->campo("a2bd_destacado", "number", "",  "Destacado", "3"),
            $this->campo("a2bd_logros", "textarea", "",   "Logros", "12"),
            $this->campo("a2bd_dificultades", "textarea", "",  "Dificultades", "12"),
            $this->campo("a2bd_acciones", "textarea", "",  "Acciones", "12")
        ];
        $anexo = "Anexo2b";
        $modalId = "modal$anexo";
        echo $compo->Js("
            function getData$anexo(){
                param={
                    modalId:'$modalId'
                };
                ajax('/anexos2025/anexo2bData',param,function(data){
                    $('#container$anexo').html(data);
                });
            }
            getData$anexo();
        ");
        $js = "getData$anexo();";
        $this->formulario($modalId, "Anexo 2B", "modal-xl", $this->campos, "2025_a2b_data", "a2bd", $js);
        echo $compo->Div("", "", "container$anexo");
    }
    public function postAnexo2bData()
    {
        $general = new Generaldb();;
        $data = $general->selectSomeDataJoin(
            "*",
            "2025_a2b_data d",
            "a2bd_iiee_ide = " . session()->iiee_ide,
            "d.a2bd_grad_ide,d.a2bd_arcu_ide,d.a2bd_comp_ide",
            false,
            false,
            array(
                array("grados g", "d.a2bd_grad_ide = g.grad_ide", 'LEFT'),
                array("areas_curriculares ac", "d.a2bd_arcu_ide = ac.arcu_ide", 'LEFT'),
                array("competencias c", "d.a2bd_comp_ide = c.comp_ide", 'LEFT'),
            )
        );
        $campos = array(
            array("col" => "Ide", "valor" => "a2bd_ide", "clase" => "text-center", "mostrar" => "no"),
            array("col" => "Ciclo", "valor" => "grad_ciclo", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Grado", "valor" => "grad_nombre", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Area curricular", "valor" => "arcu_nombre", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Competencia", "valor" => "comp_nombre", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Inicio", "valor" => "a2bd_inicio", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Proceso", "valor" => "a2bd_proceso", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Esperado", "valor" => "a2bd_esperado", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Destacado", "valor" => "a2bd_destacado", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Logros", "valor" => "a2bd_logros", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Dificultades", "valor" => "a2bd_dificultades", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Acciones", "valor" => "a2bd_acciones", "clase" => "text-center", "mostrar" => "si")
        );
        $sufijo = "a2bd";
        $modalId = $this->request->getPost("modalId");
        $this->mostrarRegistros($data, $campos, $modalId, "2025_a2b_data", $sufijo);
    }


    /************************************************************************************************************* */

    public function getAnexo4()
    {
        /***************************************************************************** */
        $compo = new Componente();
        echo $compo->H4("ANEXO 4", "primary text-center");
        echo $compo->H4("LISTADO DE ESTUDIANTES ATENDIDOS POR EL SAANEE ", "primary text-center");
        /***************************************************************************** */
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $iiee = $general->selectSomeDataJoin("*", "iiee", "iiee_ide = $iiee_ide");
        $nive_ide = $iiee[0]->iiee_nive_ide;
        $grados = $general->selectSomeDataJoin("grad_ide as id,grad_nombre as nombre", "grados", "grad_nive_ide = $nive_ide");
        $discapacidades = $general->selectSomeDataJoin("a4udi_ide as id,a4udi_nombre as nombre", "2025_a4u_discapacidades", false, "a4udi_nombre");
        $this->campos = [
            $this->campo("a4ud_ide", "hidden", "0", "", "12"),
            $this->campo("a4ud_datos", "text", "", "Apellidos/Nombres", "12"),
            $this->campo("a4ud_dni", "text", "", "DNI", "3"),
            $this->campo("a4ud_edad", "text", "", "Edad", "3"),
            $this->campo("a4ud_a4udi_ide", "select", "", "Discapacidades", "3", $discapacidades),
            $this->campo("a4ud_grad_ide", "select", "", "Grado", "3", $grados),
        ];
        $anexo = "Anexo4";
        $modalId = "modal$anexo";
        echo $compo->Js("
            function getData$anexo(){
                param={
                    modalId:'$modalId'
                };
                ajax('/anexos2025/anexo4Data',param,function(data){
                    $('#container$anexo').html(data);
                });
            }
            getData$anexo();
        ");
        $js = "getData$anexo();";
        $this->formulario($modalId, "Anexo 4", "modal-xl", $this->campos, "2025_a4u_data", "a4ud", $js);
        echo $compo->Div("", "", "container$anexo");
    }
    public function postAnexo4Data()
    {
        $general = new Generaldb();
        $data = $general->selectSomeDataJoin(
            "*",
            "2025_a4u_data d",
            "a4ud_iiee_ide = " . session()->iiee_ide,
            "d.a4ud_grad_ide",
            false,
            false,
            array(
                array("grados g", "d.a4ud_grad_ide = g.grad_ide", 'LEFT'),
                array("2025_a4u_discapacidades a", "d.a4ud_a4udi_ide = a.a4udi_ide", 'LEFT'),
            )
        );
        $campos = array(
            array("col" => "Ide", "valor" => "a4ud_ide", "clase" => "text-center", "mostrar" => "no"),
            array("col" => "Apellidos/Nombres", "valor" => "a4ud_datos", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "DNI", "valor" => "a4ud_dni", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Edad (Años)", "valor" => "a4ud_edad", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Tipo de discapacidad", "valor" => "a4udi_nombre", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Ciclo", "valor" => "grad_ciclo", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Grado", "valor" => "grad_nombre", "clase" => "text-center", "mostrar" => "si"),
        );
        $sufijo = "a4ud";
        $modalId = $this->request->getPost("modalId");
        $this->mostrarRegistros($data, $campos, $modalId, "2025_a4u_data", $sufijo);
    }


    /************************************************************************************************************* */

    public function getAnexo5()
    {
        /***************************************************************************** */
        $compo = new Componente();
        echo $compo->H4("ANEXO 5", "primary text-center");
        echo $compo->H4("INFORME ESTADÍSTICO DE ESTUDIANTES MATRICULADOS, ASISTENTES, NO ASISTENTES Y TRASLADADOS - 2025", "primary text-center");
        /***************************************************************************** */
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $iiee = $general->selectSomeDataJoin("*", "iiee", "iiee_ide = $iiee_ide");
        $nive_ide = $iiee[0]->iiee_nive_ide;
        $grados = $general->selectSomeDataJoin("grad_ide as id,grad_nombre as nombre", "grados", "grad_nive_ide = $nive_ide");

        $this->campos = [
            $this->campo("a5ud_ide", "hidden", "0", "", "12"),
            $this->campo("a5ud_grad_ide", "select", "", "Grado", "4", $grados),
            $this->campo("a5ud_matriculados", "number", "", "Matriculados", "2"),
            $this->campo("a5ud_asistentes", "number", "", "Asistentes", "2"),
            $this->campo("a5ud_no_asistentes", "number", "", "No Asistentes", "2"),
            $this->campo("a5ud_trasladados", "number", "", "Trasladados", "2"),
        ];
        $anexo = "Anexo5";
        $modalId = "modal$anexo";
        echo $compo->Js("
            function getData$anexo(){
                param={
                    modalId:'$modalId'
                };
                ajax('/anexos2025/anexo5Data',param,function(data){
                    $('#container$anexo').html(data);
                });
            }
            getData$anexo();
        ");
        $js = "getData$anexo();";
        $this->formulario($modalId, "Anexo 5", "modal-xl", $this->campos, "2025_a5u_data", "a5ud", $js);
        echo $compo->Div("", "", "container$anexo");
    }
    public function postAnexo5Data()
    {
        $general = new Generaldb();
        $data = $general->selectSomeDataJoin(
            "*",
            "2025_a5u_data d",
            "a5ud_iiee_ide = " . session()->iiee_ide,
            "d.a5ud_grad_ide",
            false,
            false,
            array(
                array("grados g", "d.a5ud_grad_ide = g.grad_ide", 'LEFT')
            )
        );
        $campos = array(
            array("col" => "Ide", "valor" => "a5ud_ide", "clase" => "text-center", "mostrar" => "no"),
            array("col" => "Grado", "valor" => "grad_nombre", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Estudiantes Matriculados", "valor" => "a5ud_matriculados", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Estudiantes Asistentes", "valor" => "a5ud_asistentes", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Estudiantes No Asistentes", "valor" => "a5ud_no_asistentes", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Estudiantes Trasladados", "valor" => "a5ud_trasladados", "clase" => "text-center", "mostrar" => "si"),
        );
        $sufijo = "a5ud";
        $modalId = $this->request->getPost("modalId");
        $this->mostrarRegistros($data, $campos, $modalId, "2025_a5u_data", $sufijo);
    }


    /************************************************************************************************************* */

    public function getAnexo6()
    {
        /***************************************************************************** */
        $compo = new Componente();
        echo $compo->H4("ANEXO 6", "primary text-center");
        echo $compo->H4("SOBRE LA REINSERCIÓN Y CONTINUIDAD EDUCATIVA", "primary text-center");
        /***************************************************************************** */
        $general = new Generaldb();
        $iiee_ide = session()->iiee_ide;
        $iiee = $general->selectSomeDataJoin("*", "iiee", "iiee_ide = $iiee_ide");
        $nive_ide = $iiee[0]->iiee_nive_ide;
        $grados = $general->selectSomeDataJoin("grad_ide as id,grad_nombre as nombre", "grados", "grad_nive_ide = $nive_ide");

        $this->campos = [
            $this->campo("a6ud_ide", "hidden", "0", "", "12"),
            $this->campo("a6ud_grad_ide", "select", "", "Grado", "4", $grados),
            $this->campo("a6ud_estrategias", "textarea", "", "Estrategias implementadas", "8"),
            $this->campo("a6ud_reincorporados", "number", "", "Logros/Reincorporados(Cantidad)", "4"),
            $this->campo("a6ud_cualitativos", "textarea", "", "Logros/Cualitativos", "8"),
            $this->campo("a6ud_dificultades", "textarea", "", "Dificultades", "12"),
            $this->campo("a6ud_propuestas", "textarea", "", "Propuestas de Mejora", "12"),
        ];
        $anexo = "Anexo6";
        $modalId = "modal$anexo";
        echo $compo->Js("
            function getData$anexo(){
                param={
                    modalId:'$modalId'
                };
                ajax('/anexos2025/anexo6Data',param,function(data){
                    $('#container$anexo').html(data);
                });
            }
            getData$anexo();
        ");
        $js = "getData$anexo();";
        $this->formulario($modalId, "Anexo 6", "modal-xl", $this->campos, "2025_a6u_data", "a6ud", $js);
        echo $compo->Div("", "", "container$anexo");
    }
    public function postAnexo6Data()
    {
        $general = new Generaldb();
        $data = $general->selectSomeDataJoin(
            "*",
            "2025_a6u_data d",
            "a6ud_iiee_ide = " . session()->iiee_ide,
            "d.a6ud_grad_ide",
            false,
            false,
            array(
                array("grados g", "d.a6ud_grad_ide = g.grad_ide", 'LEFT')
            )
        );
        $campos = array(
            array("col" => "Ide", "valor" => "a6ud_ide", "clase" => "text-center", "mostrar" => "no"),
            array("col" => "Grado", "valor" => "grad_nombre", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Estrategias implementadas", "valor" => "a6ud_estrategias", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Logros/Reincorporados(Cantidad)", "valor" => "a6ud_reincorporados", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Logros/Cualitativos", "valor" => "a6ud_cualitativos", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Dificultades", "valor" => "a6ud_dificultades", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Propuestas de Mejora", "valor" => "a6ud_propuestas", "clase" => "text-center", "mostrar" => "si"),
        );
        $sufijo = "a6ud";
        $modalId = $this->request->getPost("modalId");
        $this->mostrarRegistros($data, $campos, $modalId, "2025_a6u_data", $sufijo);
    }

    /************************************************************************************************************* */

    public function getAnexo7a()
    {
        /***************************************************************************** */
        $compo = new Componente();
        echo $compo->H4("ANEXO 7a", "primary text-center");
        echo $compo->H4("INFORME DE LA IMPLEMENTACIÒN DE LA ESTRATEGIA DIGITAL EN LA INSTITUCIÓN EDUCATIVA", "primary text-center");
        /***************************************************************************** */
        $general = new Generaldb();
        $condiciones = $general->selectSomeDataJoin("a7ac_ide as id,a7ac_nombre as nombre", "2025_a7a_condiciones");

        $this->campos = [
            $this->campo("a7ad_ide", "hidden", "0", "", "12"),
            $this->campo("a7ad_a7ac_ide", "select", "", "Condicion", "4", $condiciones),
            $this->campo("a7ad_pip", "text", "", "Apellidos/Nombres del PIP", "8"),
            $this->campo("a7ad_dni", "number", "", "DNI", "4"),
            $this->campo("a7ad_email", "email", "", "Email", "4"),
            $this->campo("a7ad_celular", "number", "", "Celular", "4"),

        ];
        $anexo = "Anexo7a";
        $modalId = "modal$anexo";
        echo $compo->Js("
            function getData$anexo(){
                param={
                    modalId:'$modalId'
                };
                ajax('/anexos2025/anexo7aData',param,function(data){
                    $('#container$anexo').html(data);
                });
            }
            getData$anexo();
        ");
        $js = "getData$anexo();";
        $this->formulario($modalId, "Anexo 7", "modal-xl", $this->campos, "2025_a7a_data", "a7ad", $js);
        echo $compo->Div("", "", "container$anexo");
    }
    public function postAnexo7aData()
    {
        $general = new Generaldb();
        $data = $general->selectSomeDataJoin(
            "*",
            "2025_a7a_data d",
            "a7ad_iiee_ide = " . session()->iiee_ide,
            "d.a7ad_ide",
            false,
            false,
            array(
                array("2025_a7a_condiciones c", "d.a7ad_a7ac_ide = c.a7ac_ide", 'LEFT')
            )
        );
        $campos = array(
            array("col" => "Ide", "valor" => "a7ad_ide", "clase" => "text-center", "mostrar" => "no"),
            array("col" => "Apellidos/Nombres del PIP", "valor" => "a7ad_pip", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "DNI", "valor" => "a7ad_dni", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Email", "valor" => "a7ad_email", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Celular", "valor" => "a7ad_celular", "clase" => "text-center", "mostrar" => "si"),
            array("col" => "Condicion", "valor" => "a7ac_nombre", "clase" => "text-center", "mostrar" => "si"),
        );
        $sufijo = "a7ad";
        $modalId = $this->request->getPost("modalId");
        $this->mostrarRegistros($data, $campos, $modalId, "2025_a7a_data", $sufijo);
    }
}

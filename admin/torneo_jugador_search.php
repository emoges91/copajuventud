<?php

include('conexiones/conec_cookies.php');
include('sec/inc.system.php');
include 'module/personas/personas.php';
include 'module/equipos/equipos.php';
include 'module/equipos/jugadores.php';

$oPersona = new personas();
$oEquipo = new equipos();

$nPersonaID = (isset($_GET['per_id'])) ? $_GET['per_id'] : 0;
$nEquiID = (isset($_GET['id'])) ? $_GET['id'] : 0;
$sSearchName = (isset($_POST['search_name'])) ? preg_replace("/[^A-Za-z0-9]/", " ", $_POST['search_name']) : '';

$aPersonas = $oPersona->getByName($sSearchName, $sTorVerID);


/* * **********************************************
  Search Functionality
 * ********************************************** */

// Define Output HTML Formating
$html = '';
$html .= '<li class="result per_search_item">';
$html .= '<input type="hidden" class="PersonaID" value="PersonaIDValue" />';
$html .= '<input type="hidden" class="PersonaCED" value="PersonaCEDValue" />';
$html .= '<input type="hidden" class="PersonaName" value="PersonaNameValue" />';
$html .= '<input type="hidden" class="PersonaLastName1" value="PerLName1Value" />';
$html .= '<input type="hidden" class="PersonaLastName2" value="PerLName2Value" />';
$html .= '<input type="hidden" class="PersonaJug" value="PersonaJugValue" />';
$html .= '<input type="hidden" class="PersonaDT" value="PersonaDTValue" />';
$html .= '<input type="hidden" class="PersonaDTA" value="PersonaDTAValue" />';
$html .= '<input type="hidden" class="PersonaRep" value="PersonaRepValue" />';
$html .= '<input type="hidden" class="PersonaSup" value="PersonaSupValue" />';
$html .= '<h4>LN1, LN2, FirstName1</h4>';
$html .= '<h5>CedString</h5>';
$html .= '</li>';

if (strlen($sSearchName) >= 1 && $sSearchName !== ' ') {
    // Check If We Have Results
    if (isset($aPersonas)) {
        foreach ($aPersonas as $result) {

            // Format Output Strings And Hightlight Matches
            $sLastName1 = "<b class='highlight'>" . $result['APELLIDO1'] . "</b>";
            $sLastName2 = "<b class='highlight'>" . $result['APELLIDO2'] . "</b>";
            $sName1 = "<b class='highlight'>" . $result['NOMBRE'] . "</b>";
            $sCed = "<b class='highlight'>" . $result['CED'] . "</b>";

            // Insert data
            $output = str_replace('LN1', $sLastName1, $html);
            $output = str_replace('LN2', $sLastName2, $output);
            $output = str_replace('FirstName1', $sName1, $output);
            $output = str_replace('CedString', $sCed, $output);
            $output = str_replace('PersonaIDValue', $result['ID'], $output);
            $output = str_replace('PerLName1Value', $result['APELLIDO1'], $output);
            $output = str_replace('PerLName2Value', $result['APELLIDO2'], $output);
            $output = str_replace('PersonaNameValue', $result['NOMBRE'], $output);
            $output = str_replace('PersonaCEDValue', $result['CED'], $output);
            //
            $output = str_replace('PersonaJugValue', $result['JUG'], $output);
            $output = str_replace('PersonaDTValue', $result['DT'], $output);
            $output = str_replace('PersonaDTAValue', $result['DT_ASIS'], $output);
            $output = str_replace('PersonaRepValue', $result['REP'], $output);
            $output = str_replace('PersonaSupValue', $result['REP_SUP'], $output);
            // Output
            echo($output);
        }
    } else {

        // Format No Results Output
        $output = str_replace('LastName1, LastName2, FirstName1', '<b>No Results Found.</b>', $output);
        $output = str_replace('CedString', 'Sorry :(', $output);

        // Output
        echo($output);
    }
}
?>
<?php

$this->idioma["noDefinido"]='No definido';
$this->idioma['cerrarProceso']='Cerrar el proceso de consulta';
$this->idioma['botonCerrarProceso']='Cerrar';

$this->idioma['mostrarResultados']='Resultados del proceso.';
$this->idioma['botonMostrarResultados']='Calcular Resultados';

$this->idioma['cierreRealizado']='La jornada de participación esta cerrada.';

$this->idioma['fraseSecreta']='Frase secreta:';
$this->idioma['botonDecodificarVotacion']='Decodificar';

$this->idioma['observacion']='Ingrese una observación adicional';
$this->idioma['botonPDF']='Generar PDF';

$this->idioma["fechaFinExpirada"]="No puede cerrar el proceso en este momento!!!";
$this->idioma["botonGenerarActa"]="Generar Acta";


if(isset($argumentos) && is_array($argumentos)){

	switch($argumentos['tipo']){

		case 'conVotosCodificados':
			$this->idioma["conVotosCodificados"]='Imposible realizar la acción si ya existen votos decodificados.';
			break;
		case 'sinFraseSeguridad':
			$this->idioma["sinFraseSeguridad"]='Debe proveer una frase de seguridad.';
			break;

		case 'sinLlavePrivada':
			$this->idioma["sinLlavePrivada"]='No se pudo rescatar la llave privada. Por favor revise la frase secreta.';
			break;
				
		case 'datosDecodificados':
			$this->idioma["datosDecodificados"]='Se han decodificado '.$argumentos['total']. ' registros de un total de '.$argumentos['totalVotos'].' de votos registrados';
			break;
                    
		case 'nohayvotos':
			$this->idioma["nohayvotos"]='No se encontraron registros de votaciones para esta elección';
			break;
                    
                case 'resultados':    
                        $this->idioma["textoActaCierre"]='<p class=MsoNormal align=center style=\'text-align:center\'><a
                        name="OLE_LINK1"><span style=\'mso-bookmark:OLE_LINK2\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:16.0pt; \'>ACTA
                        DE CIERRE <o:p></o:p></span></b></span></a></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:13.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>PROCESO ELECTORAL<o:p></o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>ELECCIÓN DEL REPRESENTANTE DE ANTE EL
                        CONSEJO SUPERIOR UNIVERSITARIO DE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE
                        CALDAS.<o:p></o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>XX de XXXXX de 201X<o:p></o:p></span></b></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></span></span></p>

                        <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                        mso-bidi-font-size:10.0pt; \'>En Bogotá D.C., a
                        los XXXXX (XX) días del mes de XXXXXX de 2013, mediante el sistema de voto
                        electrónico y de urna y tarjetón virtual en la modalidad no presencial; siendo
                        las <span style=\'color:red\'>XX:XX XX</span>, se llevó a cabo </span></span></span><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                        lang=ES-TRAD style=\'font-size:12.0pt; \'>la jornada
                        de votación, conforme a lo determinado en la Normatividad Electoral establecida
                        para estos procesos electorales, <b style=\'mso-bidi-font-weight:normal\'><u>CIERRAN</u>
                        </b>la votación y de inmediato se procede a realizar el escrutinio ante los
                        testigos electorales acreditados, con los siguientes resultados:<o:p></o:p></span></span></span></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span
                        style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                        style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></span></span></p>

                        <div align=center>

                        <table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0 width=560
                         style=\'width:420.05pt;border-collapse:collapse;border:none;mso-border-alt:
                         solid windowtext .5pt;mso-yfti-tbllook:480;mso-padding-alt:0cm 5.4pt 0cm 5.4pt\'>
                         <tr style=\'mso-yfti-irow:0;mso-yfti-firstrow:yes\'>
                          <td width=560 colspan=3 valign=top style=\'width:420.05pt;border:solid windowtext 1.0pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:11.0pt; ;
                          color:red\'>CANDIDATOS ELECCIÓN DEL REPRESENTANTE DE LOS EGRESADOS ANTE EL CONSEJO
                          SUPERIOR UNIVERSITARIO DE LA UNIVERSIDAD DISTRITAL FRANCISCO JOSE DE CALDAS.<o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                         <tr style=\'mso-yfti-irow:1;height:17.45pt\'>
                          <td width=287 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>APELLIDOS
                          Y NOMBRES <o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=132 style=\'width:98.7pt;border-top:none;border-left:none;
                          border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-shading:windowtext;
                          mso-pattern:gray-15 auto;padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'>N º EN
                          EL TARJETÓN</span></b></span></span><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'><b style=\'mso-bidi-font-weight:normal\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'><o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=141 style=\'width:105.8pt;border-top:none;border-left:none;
                          border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-shading:windowtext;
                          mso-pattern:gray-15 auto;padding:0cm 5.4pt 0cm 5.4pt;height:17.45pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                          style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:8.0pt;
                           \'>CANTIDAD DE VOTOS<o:p></o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                         <tr style=\'mso-yfti-irow:2;height:14.15pt\'>
                          <td width=287 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:9.0pt;
                           ;color:black;mso-bidi-font-weight:bold\'><o:p>&nbsp;</o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=132 style=\'width:98.7pt;border-top:none;border-left:none;
                          border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:12.0pt; \'>01<o:p></o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=141 valign=top style=\'width:105.8pt;border-top:none;border-left:
                          none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:14.15pt\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'><o:p>&nbsp;</o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                         <tr style=\'mso-yfti-irow:3;height:13.7pt\'>
                          <td width=287 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:13.7pt\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:9.0pt;
                           ;color:black;mso-bidi-font-weight:bold\'><o:p>&nbsp;</o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=132 style=\'width:98.7pt;border-top:none;border-left:none;
                          border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-shading:windowtext;
                          mso-pattern:gray-15 auto;padding:0cm 5.4pt 0cm 5.4pt;height:13.7pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:12.0pt; \'>02<o:p></o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=141 valign=top style=\'width:105.8pt;border-top:none;border-left:
                          none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-shading:windowtext;
                          mso-pattern:gray-15 auto;padding:0cm 5.4pt 0cm 5.4pt;height:13.7pt\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'><o:p>&nbsp;</o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                         <tr style=\'mso-yfti-irow:4;height:9.0pt\'>
                          <td width=287 style=\'width:215.55pt;border:solid windowtext 1.0pt;border-top:
                          none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          padding:0cm 5.4pt 0cm 5.4pt;height:9.0pt\'>
                          <p class=MsoNormal><span style=\'mso-bookmark:OLE_LINK1\'><span
                          style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:9.0pt;
                           ;color:black;mso-bidi-font-weight:bold\'>VOTOS<span
                          style=\'mso-spacerun:yes\'>  </span>EN<span style=\'mso-spacerun:yes\'> 
                          </span>BLANCO<o:p></o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=132 valign=top style=\'width:98.7pt;border-top:none;border-left:
                          none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:9.0pt\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:12.0pt; \'><o:p>&nbsp;</o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=141 valign=top style=\'width:105.8pt;border-top:none;border-left:
                          none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;padding:0cm 5.4pt 0cm 5.4pt;height:9.0pt\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'><o:p>&nbsp;</o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                         <tr style=\'mso-yfti-irow:5;mso-yfti-lastrow:yes;height:11.95pt\'>
                          <td width=419 colspan=2 style=\'width:314.25pt;border:solid windowtext 1.0pt;
                          border-top:none;mso-border-top-alt:solid windowtext .5pt;mso-border-alt:solid windowtext .5pt;
                          background:#D9D9D9;mso-shading:windowtext;mso-pattern:gray-15 auto;
                          padding:0cm 5.4pt 0cm 5.4pt;height:11.95pt\'>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                          style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:9.0pt;
                           \'>TOTAL<span style=\'mso-spacerun:yes\'> 
                          </span>DE<span style=\'mso-spacerun:yes\'>  </span>VOTOS</span></b></span></span><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><span
                          lang=ES-TRAD style=\'font-size:8.0pt; \'><o:p></o:p></span></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <td width=141 valign=top style=\'width:105.8pt;border-top:none;border-left:
                          none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
                          mso-border-top-alt:solid windowtext .5pt;mso-border-left-alt:solid windowtext .5pt;
                          mso-border-alt:solid windowtext .5pt;background:#D9D9D9;mso-shading:windowtext;
                          mso-pattern:gray-15 auto;padding:0cm 5.4pt 0cm 5.4pt;height:11.95pt\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                          <p class=MsoNormal align=center style=\'text-align:center\'><span
                          style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'><b
                          style=\'mso-bidi-font-weight:normal\'><span lang=ES-TRAD style=\'font-size:8.0pt;
                           \'><o:p>&nbsp;</o:p></span></b></span></span></p>
                          </td>
                          <span style=\'mso-bookmark:OLE_LINK1\'><span style=\'mso-bookmark:OLE_LINK2\'></span></span>
                         </tr>
                        </table>

                        </div>

                        <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:5.0pt;
                         \'><o:p>&nbsp;</o:p></span></span></span></p>

                        <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:12.0pt;
                         \'>En constancia de lo anterior, siendo las <span
                        style=\'color:red\'>XX: XX </span>p.m., a los XXXXXX (XX) días del mes de XXXXXX de
                        201X, la presente acta se firma por quienes en ella intervinieron.<o:p></o:p></span></span></span></p>

                        <p class=MsoNormal style=\'text-align:justify\'><span style=\'mso-bookmark:OLE_LINK1\'><span
                        style=\'mso-bookmark:OLE_LINK2\'><span lang=ES-TRAD style=\'font-size:5.0pt;
                         \'><o:p>&nbsp;</o:p></span></span></span></p>

                        <span style=\'mso-bookmark:OLE_LINK2\'></span><span style=\'mso-bookmark:OLE_LINK1\'></span>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Jurado. Nombre: ________________________ <span
                        style=\'mso-tab-count:1\'>        </span>Firma: ________________<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Jurado. Nombre: ________________________ <span
                        style=\'mso-tab-count:1\'>        </span>Firma: ________________<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delgado. Nombre: _________________________<span
                        style=\'mso-tab-count:1\'>    </span>Firma: ________________<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delgado. Nombre: _________________________<span
                        style=\'mso-tab-count:1\'>    </span>Firma: ________________<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Secretario del Consejo Participación
                        Universitaria Provisional<o:p></o:p></span></b></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><span lang=ES-TRAD
                        style=\'font-size:5.0pt; \'><o:p>&nbsp;</o:p></span></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Nombre: _________________________________ <span
                        style=\'mso-tab-count:1\'>   </span>Firma: ________________ <o:p></o:p></span></b></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></p>

                        <p class=MsoNormal align=center style=\'text-align:center\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Delegado del Consejo Participación
                        Universitaria Provisional<o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'>Nombre: _________________________________ <span
                        style=\'mso-tab-count:1\'>   </span>Firma: ________________ <o:p></o:p></span></b></p>

                        <p class=MsoNormal style=\'text-align:justify\'><b style=\'mso-bidi-font-weight:
                        normal\'><span lang=ES-TRAD style=\'font-size:12.0pt;mso-bidi-font-size:10.0pt;
                         \'><o:p>&nbsp;</o:p></span></b></p>
                        ';
                        break;

	}
}
?>
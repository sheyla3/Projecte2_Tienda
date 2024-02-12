<?php
echo "
<div class='admin-panel-content-container'>
<div class='admin-panel-title-container'>
<ul class='tituloMenu'>
	<li><h1 class='admin-panel-title'>Firma Administrador</h1></li>
</ul>
<div class='blue-line'></div>

</div>";

?>
<br><br><br>
    <canvas id="signatureCanvas" width="400" height="200" style="border:1px solid #000;"></canvas>
    <br>
    <a class='admin-panel-submit-link' onclick="startDrawing()">Dibujar</a>
    <br>
    <a class='admin-panel-submit-link' onclick="startErasing()">Goma de Borrar</a>
    <br>
    <a class='admin-panel-submit-link'onclick="saveSignature()">Guardar Firma</a>

    <script src="./././scriptDibujar.js"></script>
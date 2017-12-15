<?php
function marcadeagua($img_original, $img_marcadeagua, $img_nueva, $calidad)
{
  // obtener datos de la fotografia 
  $info_original = getimagesize($img_original);
  $anchura_original = $info_original[0];
  $altura_original = $info_original[1];
  // obtener datos de la "marca de agua" 
  $info_marcadeagua = getimagesize($img_marcadeagua);
  $anchura_marcadeagua = $info_marcadeagua[0];
  $altura_marcadeagua = $info_marcadeagua[1];
  // calcular la posición donde debe copiarse la "marca de agua" en la fotografia 
  $horizmargen = ($anchura_original - $anchura_marcadeagua)/2;
  $vertmargen = ($altura_original - $altura_marcadeagua)/2;
  // crear imagen desde el original 
  $original = ImageCreateFromJPEG($img_original);
  ImageAlphaBlending($original, true);
  // crear nueva imagen desde la marca de agua 
  $marcadeagua = ImageCreateFromPNG($img_marcadeagua);
  // copiar la "marca de agua" en la fotografia 
  ImageCopy($original, $marcadeagua, $horizmargen, $vertmargen, 0, 0, $anchura_marcadeagua, $altura_marcadeagua);
  // guardar la nueva imagen 
  ImageJPEG($original, $img_nueva, $calidad);
  // cerrar las imágenes 
  ImageDestroy($original);
  ImageDestroy($marcadeagua);
}
?>
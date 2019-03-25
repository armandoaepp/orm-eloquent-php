<?php
class RenderTemplate{

    /**
     * $path: ruta absolute del archivo
     * $ext: extension del archivo
     * return[ contenido html del archivo]
     */
    public static function getTemplate($path, $ext = 'html') {
      # exit->hnd->ww
      $file = $path.".".$ext;
      $template = file_get_contents($file);
      return $template;
    }

    public static function render($html, $data) {
      foreach ($data as $clave=>$valor)
      {
        $html = str_replace('{'.$clave.'}', $valor, $html);
      }
      return $html;
    }


}
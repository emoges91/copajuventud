<?

/**
 * Clase que crea una copia de una imagen, de un tamaño distinto, a través de distintos métodos
 * Ejemplo de uso:
 * <code>
 * $o=new ImageResize($imagen_origen);
 * $o->resizeWidth(100);
 * $o->save($imagen_destino);
 * </code>
 * TODO: 
 * - Definir de manera automática el formato de salida.
 * - Definir otros tipos de formato de entrada, aparte de gif, jpg y png
 */
class ImageResize {

    var $file_s = "";
    var $gd_s;
    var $gd_d;
    var $width_s;
    var $height_s;
    var $width_d;
    var $height_d;
    var $aCreateFunctions = array(
        IMAGETYPE_GIF => 'imagecreatefromgif',
        IMAGETYPE_JPG => 'imagecreatefromjpg',
        IMAGETYPE_JPEG => 'imagecreatefromjpeg',
        IMAGETYPE_PNG => 'imagecreatefrompng',
    );

    /**
     * @param    string  Nombre del archivo
     */
    function ImageResize($source) {
        $this->file_s = $source;
        list($this->width_s, $this->height_s, $type, $attr) = getimagesize($source, $info2);
        $createFunc = $this->aCreateFunctions[$type];
        if ($createFunc) {
            $this->gd_s = $createFunc($source);
        }
    }

    /**
     * Redimensiona la imagen de forma proporcional, a partir del ancho
     * @param    int     ancho en pixel
     */
    function resizeWidth($width_d) {
        $height_d = floor(($width_d * $this->height_s) / $this->width_s);
        $this->resizeWidthHeight($width_d, $height_d);
    }

    /**
     * Redimensiona la imagen de forma proporcional, a partir del alto
     * @param    int     alto en pixel
     */
    function resizeHeight($height_d) {
        $width_d = floor(($height_d * $this->width_s) / $this->height_s);
        $this->resizeWidthHeight($width_d, $height_d);
    }

    /**
     * Redimensiona la imagen de forma proporcional, a partir del porcentaje del área
     * @param    int     porcentaje de área
     */
    function resizeArea($perc) {
        $factor = sqrt($perc / 100);
        $this->resizeWidthHeight($this->width_s * $factor, $this->height_s * $factor);
    }

    /**
     * Redimensiona la imagen, a partir de un ancho y alto determinado
     * @param    int     porcentaje de área
     */
    function resizeWidthHeight($width_d, $height_d) {
        $this->gd_d = imagecreatetruecolor($width_d, $height_d);
        // desactivo el procesamiento automatico de alpha
        imagealphablending($this->gd_d, false);
        // hago que el alpha original se grabe en el archivo destino
        imagesavealpha($this->gd_d, true);
        imagecopyresampled($this->gd_d, $this->gd_s, 0, 0, 0, 0, $width_d, $height_d, $this->width_s, $this->height_s);
    }

    /**
     * Graba la imagen a un archivo de destino
     * @param    string  Nombre del archivo de salida
     */
    function save($file_d) {
        imagepng($this->gd_d, $file_d);
        imagedestroy($this->gd_d);
    }

}

?>

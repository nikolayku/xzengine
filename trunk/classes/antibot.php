<?php
///////////////////////////////////////////////////////
// создаёт картинку
// $_GET[id] зашифрованное число с картинки
///////////////////////////////////////////////////////

class genrandomimage
{
  var $lenght = 4; // Длина строки
  var $string = ''; // Результирующая строка

  # Генерация строки
  function genstring()
    {
      $chars = array ('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
      $result_string = '';

      for($i = 0; $i < $this -> lenght; $i++)
        {
          $random_char = mt_rand( 0, ( count ( $chars ) - 1 ) );
          $result_string .= $chars[$random_char];
        }
      $this -> string = $result_string;
    }

  # Генерация изображения
  function genimage()
    {
      $im = imagecreate( 10 * $this -> lenght + 5, 20 );

      $gray = imagecolorallocate( $im, 228, 228, 228 );
      $black_1 = imagecolorallocate( $im, 150, 150, 150 );
      $black = imagecolorallocate( $im, 0, 0, 0 );
      $white = imagecolorallocate( $im , 255, 255, 255 );
      $string = imagecolorallocate( $im, 90, 90, 90 );

      /* Генерация шума */
      /*for($i = -2; $i < ceil ( ( 10 * $this -> lenght ) / 5 ); $i++)
        {
          imageline( $im, $i * 5, 20, $i * 5 + 20, 0, $black_1 );
        }
      for($i = -2; $i < ceil ( (10 * $this -> lenght) / 5 ); $i++)
        {
          imageline( $im, $i * 5+20, 20, $i * 5 , 0, $white );
        }*/
      /* Конец генерации шума */

      # Рисуем строку на картинке
      imagestring( $im, 5, 6, 2, $this -> string, $string );

      # Рамка
      /*imageline( $im, 0, 0,  10*$this -> lenght + 5, 0, $black );
      imageline( $im, 0, 19,  10*$this -> lenght + 5, 19, $black );
      imageline( $im, 0, 0,  0, 20, $black );
      imageline( $im, 10*$this -> lenght + 4, 0,  10*$this -> lenght + 4, 20, $black );*/

      header('Content-type: image/png');
      imagepng($im);
    }

}

// сохраняем в сессии 
@session_start();

$im = new genrandomimage ();
$im->genstring();

$_SESSION['image_from_pic'] = $im->string;

$im->genimage();




?>

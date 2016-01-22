<?php
// vim: set ts=4 sw=4 sts=4 et:

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    Qualiteam software Ltd <info@x-cart.com>
 * @copyright Copyright (c) 2011-2015 Qualiteam software Ltd <info@x-cart.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\XC\PitneyBowes\Logic\Barcode;

/**
 * Controller for generating barcode images
 */
class Printer
{
    const ORIENTATION_HORIZONTAL = 'horizontal';

    const CODE_128  = 'code128';
    const CODE_39   = 'code39';

    /**
     * Get array of the char codes for the "Code128" algorithm
     *
     * @return array
     */
    protected function getCodeArrayCode128()
    {
        // Must not change order of array elements as the checksum depends on the array's key to validate final code
        $codeArray = array(
            ' ' => '212222', '!' => '222122', '\"' => '222221', '#' => '121223',
            '$' => '121322', '%' => '131222', '&' => '122213', '"' => '122312',
            '(' => '132212', ')' => '221213', '*' => '221312', '+' => '231212',
            ',' => '112232', '-' => '122132', '.' => '122231', '/' => '113222',
            '0' => '123122', '1' => '123221', '2' => '223211', '3' => '221132',
            '4' => '221231', '5' => '213212', '6' => '223112', '7' => '312131',
            '8' => '311222', '9' => '321122', ':' => '321221', ';' => '312212',
            '<' => '322112', '=' => '322211', '>' => '212123', '?' => '212321',
            '@' => '232121', 'A' => '111323', 'B' => '131123', 'C' => '131321',
            'D' => '112313', 'E' => '132113', 'F' => '132311', 'G' => '211313',
            'H' => '231113', 'I' => '231311', 'J' => '112133', 'K' => '112331',
            'L' => '132131', 'M' => '113123', 'N' => '113321', 'O' => '133121',
            'P' => '313121', 'Q' => '211331', 'R' => '231131', 'S' => '213113',
            'T' => '213311', 'U' => '213131', 'V' => '311123', 'W' => '311321',
            'X' => '331121', 'Y' => '312113', 'Z' => '312311', '[' => '332111',
            '\\' => '314111', ']' => '221411', '^' => '431111', '_' => '111224',
            '\`' => '111422', 'a' => '121124', 'b' => '121421', 'c' => '141122',
            'd' => '141221', 'e' => '112214', 'f' => '112412', 'g' => '122114',
            'h' => '122411', 'i' => '142112', 'j' => '142211', 'k' => '241211',
            'l' => '221114', 'm' => '413111', 'n' => '241112', 'o' => '134111',
            'p' => '111242', 'q' => '121142', 'r' => '121241', 's' => '114212',
            't' => '124112', 'u' => '124211', 'v' => '411212', 'w' => '421112',
            'x' => '421211', 'y' => '212141', 'z' => '214121', '{' => '412121',
            '|' => '111143', '}' => '111341', '~' => '131141', 'DEL' => '114113',
            'FNC 3' => '114311', 'FNC 2' => '411113', 'SHIFT' => '411311', 'CODE C' => '113141',
            'FNC 4' => '114131', 'CODE A' => '311141', 'FNC 1' => '411131', 'Start A' => '211412',
            'Start B' => '211214', 'Start C' => '211232', 'Stop' => '2331112'
        );

        return $codeArray;
    }

    /**
     * Get array of the char codes for the "Code39" algorithm
     *
     * @return array
     */
    protected function getCodeArrayCode39()
    {
        $codeArray = array(
            '0' => '111221211', '1' => '211211112', '2' => '112211112', '3' => '212211111',
            '4' => '111221112', '5' => '211221111', '6' => '112221111', '7' => '111211212',
            '8' => '211211211', '9' => '112211211', 'A' => '211112112', 'B' => '112112112',
            'C' => '212112111', 'D' => '111122112', 'E' => '211122111', 'F' => '112122111',
            'G' => '111112212', 'H' => '211112211', 'I' => '112112211', 'J' => '111122211',
            'K' => '211111122', 'L' => '112111122', 'M' => '212111121', 'N' => '111121122',
            'O' => '211121121', 'P' => '112121121', 'Q' => '111111222', 'R' => '211111221',
            'S' => '112111221', 'T' => '111121221', 'U' => '221111112', 'V' => '122111112',
            'W' => '222111111', 'X' => '121121112', 'Y' => '221121111', 'Z' => '122121111',
            '-' => '121111212', '.' => '221111211', ' ' => '122111211', '$' => '121212111',
            '/' => '121211121', '+' => '121112121', '%' => '111212121', '*' => '121121211'
        );

        return $codeArray;
    }

    /**
     * Generate barcode string by "Code128" algorithm
     *
     * @return string
     */
    protected function generateBarcodeStringCode128($text)
    {
        $codeString = '';
        $chksum = 104;

        $codeArray = $this->getCodeArrayCode128();

        $codeKeys = array_keys($codeArray);
        $codeValues = array_flip($codeKeys);
        $textLen = strlen($text);

        for ($i = 1; $i <= $textLen; $i++) {
            $activeKey = substr($text, ($i - 1), 1);
            $codeString .= $codeArray[$activeKey];
            $chksum = ($chksum + ($codeValues[$activeKey] * $i));
        }

        $codeString .= $codeArray[$codeKeys[($chksum - (intval($chksum / 103) * 103))]];

        $codeString = '211214' . $codeString . '2331112';

        return $codeString;
    }

    /**
     * Generate barcode string by "Code39" algorithm
     *
     * @return string
     */
    protected function generateBarcodeStringCode39($text)
    {
        $codeString = '';

        $codeArray = $this->getCodeArrayCode39();

        // Convert to uppercase
        $upperText = strtoupper($text);
        $upperTextLen = strlen($upperText);

        for ($i = 1; $i <= $upperTextLen; $i++) {
            $codeString .= $codeArray[substr($upperText, ($i - 1), 1)] . '1';
        }

        $codeString = '1211212111' . $codeString . '121121211';

        return $codeString;
    }

    /**
     * Translate $text into barcode string
     *
     * @return string
     */
    protected function translateTextToBarcodeString($text, $codeType)
    {
        $codeString = '';

        switch ($codeType) {
            case static::CODE_39:
                $codeString = $this->generateBarcodeStringCode39($text);

                break;

            default:
                // Use code128 algorithm
                $codeString = $this->generateBarcodeStringCode128($text);

                break;
        }

        return $codeString;
    }

    /**
     * Draw barcode
     *
     * @return string
     */
    public function getBarcode($params = array())
    {
        $text = (isset($params['text']) ? $params['text'] : 'testText');
        $size = (isset($params['size']) ? $params['size'] : '60');
        $widthScale = (isset($params['width_scale']) ? $params['width_scale'] : 1.0);
        $orientation = strtolower(isset($params['orientation']) ? $params['orientation'] : static::ORIENTATION_HORIZONTAL);
        $code = (isset($params['code_type']) ? $params['code_type'] : static::CODE_128);

        $codeString = $this->translateTextToBarcodeString(strtoupper($text), $code);

        // Pad the edges of the barcode
        $codeLength = 10;
        $codeStringLen = strlen($codeString);

        for ($i = 1; $i <= $codeStringLen; $i++) {
            $codeLength = $codeLength + intval(substr($codeString, ($i - 1), 1));
        }

        if (static::ORIENTATION_HORIZONTAL == $orientation) {
            $imgWidth = $codeLength * $widthScale;
            $imgHeight = $size;
        } else {
            $imgWidth = $size;
            $imgHeight = $codeLength * $widthScale;
        }

        $image = imagecreate($imgWidth, $imgHeight);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $white);

        $location = 5;

        $codeStringLen = strlen($codeString);

        for ($position = 1; $position <= $codeStringLen; $position++) {
            $curSize = $location + (substr($codeString, ($position - 1), 1));

            if (static::ORIENTATION_HORIZONTAL == $orientation) {
                imagefilledrectangle(
                    $image, $location * $widthScale, 0,
                    $curSize * $widthScale, $imgHeight, (($position % 2 == 0) ? $white : $black)
                );
            } else {
                imagefilledrectangle(
                    $image, 0, $location * $widthScale,
                    $imgWidth, $curSize * $widthScale, (($position % 2 == 0) ? $white : $black)
                );
            }

            $location = $curSize;
        }

        ob_start();
        {
            imagepng($image);
            imagedestroy($image);
        }
        $barcode = ob_get_contents();
        ob_end_clean();

        return $barcode;
    }
}

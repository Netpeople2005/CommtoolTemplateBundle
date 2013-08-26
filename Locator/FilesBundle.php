<?php

namespace Optime\Commtool\TemplateBundle\Locator;

/**
 * Description of Bundles
 *
 * @author maguirre
 */
class FilesBundle
{

    public static function getFiles($path, $bundle)
    {
        $files = array();
        $path = rtrim($path, '/');
        if (is_dir($path)) {
            $dir = scandir($path);
            foreach ($dir as $file) {
                if (strpos($file, '.') === 0) {
                    continue;
                } elseif (is_file("$path/$file")) {

                    $view = "$path/$file";
                    $view = substr($view, strpos($view, '/Resources/views/') + 17);
                    if (strpos($view, '/')) {
                        $view = preg_replace('/(.+?)(\/)(.+)/', '$1:$3', $view, 1);
                    }
                    $files[] = $bundle . $view;
                    continue;
                }
                foreach (self::getFiles("$path/$file", $bundle) as $f) {
                    $files[] = $f;
                }
            }
        }
        return $files;
    }

}

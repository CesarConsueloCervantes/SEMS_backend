<?php

function include_routes_dir($directory)
{
    if (is_dir($directory)) {
        $scan = scandir($directory);
        unset($scan[0], $scan[1]);
        foreach ($scan as $file) {
            if (is_dir($directory . '/' . $file)) {
                include_routes_dir($directory . '/' . $file);
            } else {
                if (strpos($file, '.php') !== false) {
                    require $directory . '/' . $file;
                }
            }
        }
    }
}

<?php

function listage($path)
{
    $tab_images = array();
    
    $dos = opendir($path);  
    
    while (($image = readdir($dos)) !== FALSE)
    {
        if ($image != '.' && $image != '..' 
        && preg_match("/image/",mime_content_type($path.'/'.$image))
        && ( preg_match("/.+(.png?)/", $image) 
        || preg_match("/.+(.jpeg?)/", $image) 
        || preg_match("/.+(.jpg?)/", $image) 
        || preg_match("/.+(.bmp?)/", $image))) 

        {
            $tab_images[] = $path.'/'.$image;
        }
    }
    
    closedir($dos);

    return $tab_images;
}

function recursive($path)
{
    $tab_images = array(); 
    
    $dos = opendir($path); 
    
    while (($image = readdir($dos)) !== FALSE) 
    {
        if ($image != '.' && $image != '..' && is_dir($path.'/'.$image))
        {
            $tab_images = array_merge($tab_images, recursive($path.'/'.$image));
        }

        elseif ($image != '.' && $image != '..' 
        && preg_match("/image/",mime_content_type($path.'/'.$image))
        && ( preg_match("/.+(.png?)/", $image) 
        || preg_match("/.+(.jpeg?)/", $image)  
        || preg_match("/.+(.jpg?)/", $image)
        || preg_match("/.+(.bmp?)/", $image)))

        {
            $tab_images[] = $path.'/'.$image;
        }
    }
    
    closedir($dos);   
    
    return $tab_images;   
}

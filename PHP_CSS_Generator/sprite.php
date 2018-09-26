<?php


function image_size($tab_images, &$w_max, &$h_max)
{
    $num_img = count($tab_images);
    
    $h_max;
    
    for ($i = 0 ; $i < $num_img ; $i++) 
    {
        $image = $tab_images[$i];
        
        if (preg_match("/.+(.png?)/", $image) ) 
        {
            $image = imagecreatefrompng($image);
        }
        
        elseif(preg_match("/.+(.jpeg?)/", $image)  || preg_match("/.+(.jpg?)/", $image)  )
        { 
            $image = imagecreatefromjpeg($image);
        }
        
        elseif(preg_match("/.+(.bmp?)/", $image))
        { 
            $image = imagecreatefrombmp($image);
        }
        
        $w = imagesx($image);
        $h = imagesy($image); 
        
        $w_max += $w;
        
        if($h_max < $h)
        {
            $h_max = $h;
        } 
    }
}


function sprite($tab_images, $sprite_name = "sprite.png", $marge, $new_w=NULL, $new_h=NULL)
{
    $w_max;
    $h_max;
    
    image_size($tab_images,$w_max,$h_max);
    
    $num_img = count($tab_images);

    
    if($new_w!==NULL && $new_h!==NULL)
    {
        $sprite = imagecreatetruecolor(($new_w * $num_img) + ($marge * $num_img), $new_h);
        $alpha_channel = imagecolorallocatealpha($sprite, 0, 0, 0, 127);
        imagefill($sprite, 0, 0, $alpha_channel);
        imagesavealpha($sprite, true);
    }
    else
    {
        $sprite = imagecreatetruecolor($w_max + ($marge * $num_img), $h_max);
        $alpha_channel = imagecolorallocatealpha($sprite, 0, 0, 0, 127);
        imagefill($sprite, 0, 0, $alpha_channel);
        imagesavealpha($sprite, true);
    }

    $x = 0;
    
    for ($i = 0 ; $i < $num_img ; $i++) 
    {
        $image = $tab_images[$i];
        
        if (preg_match("/.+(.png?)/", $image) ) 
        {
            $image = imagecreatefrompng($image);
        }
        
        elseif(preg_match("/.+(.jpeg?)/", $image) || preg_match("/.+(.jpg?)/", $image)  )
        { 
            $image = imagecreatefromjpeg($image);
        }
        
        elseif(preg_match("/.+(.bmp?)/", $image))
        { 
            $image = imagecreatefrombmp($image);
        }

        $w = imagesx($image);
        $h = imagesy($image);

        if($new_w!==NULL && $new_h!==NULL)
        {
            imagecopyresized($sprite, $image, $x, 0, 0, 0, $new_w,$new_h, $w, $h);
            $x += $new_w + $marge;
        }
        else
        {
            imagecopy($sprite,$image, $x, 0, 0, 0, $w, $h);
            $x += $w + $marge; 
        }

        
    }
    imagepng($sprite,$sprite_name);
}


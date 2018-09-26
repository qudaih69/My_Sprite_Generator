<?php 


function css_gener($tab_images,$css_name,$sprite_name, $marge, $new_w, $new_h)
{
    $num_img = count($tab_images);
    
    $css = NULL;
    
    $x = 0;

    $new_w=$new_w+$marge;
    
    for ($i = 0 ; $i < $num_img ; $i++) 
    {   
        $image = $tab_images[$i];
        
        $nom_image = basename($tab_images[$i],".png").'_img_'.$i;
        
        if (preg_match("/.+(.png?)/", $image) ) 
        {
            $image = imagecreatefrompng($image);
        }
        
        elseif(preg_match("/.+(.jpeg?)/", $image)  || preg_match("/.+(.jpg?)/", $image))
        { 
            $image = imagecreatefromjpeg($image);
        }
        
        elseif(preg_match("/.+(.bmp?)/", $image))
        { 
            $image = imagecreatefrombmp($image);
        }
        
        $w = imagesx($image)+$marge;
        $h = imagesy($image);
        
        if($css == NULL)
        {
            file_put_contents($css_name,".sprite {
            background-image: url($sprite_name);
            background-repeat: no-repeat;
            display: block;
        }\n\n");

            file_put_contents($css_name, "#sprite { 
            display: flex; 
        }\n\n",FILE_APPEND);

            }
            
            $css++;
            
            if($new_w!==NULL && $new_h!==NULL)
            {
                file_put_contents($css_name,"\n.sprite-$nom_image {\n\twidth:".$new_w."px;\n\theight:".$new_h."px;\n\tbackground-position: -".$x."px 0px;\n}\n",FILE_APPEND);
                $x += $new_w;
            }
            else
            {
                file_put_contents($css_name,"\n.sprite-$nom_image {\n\twidth:".$w."px;\n\theight:".$h."px;\n\tbackground-position: -".$x."px 0px;\n}\n",FILE_APPEND); 
                $x += $w;
            }   
        }
    }
    
<?php

function html_gener($tab_images,$html_name='sprite.html')
{
    $num_img = count($tab_images);
    
    file_put_contents($html_name,"<link rel='stylesheet' href='style.css'>\n\n<div>\n");
    
    for ($i = 0 ; $i < $num_img ; $i++) 
    {
        $nom_image = basename($tab_images[$i],".png").'_img_'.$i;
        
        file_put_contents($html_name,
        "\t<div><i class='sprite sprite-".$nom_image."'></i></div>\n",FILE_APPEND);   
    }
    file_put_contents($html_name,"</div>",FILE_APPEND);
}
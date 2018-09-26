#!/usr/bin/env php
<?php

$red="\033[1;31m";
$gre="\033[1;32m";
$yel="\033[1;33m";
$blu="\033[1;34m";
$whi="\033[0;37m";

require 'listage.php';

require 'sprite.php';

require 'css_gener.php';

require 'html_gener.php';

$sprite_name="sprite.png";

$marge = 10;

$new_w = NULL;

$new_h = NULL;

$css_name = 'style.css';

$html_name = 'sprite.html';


$shortopts  = "";
$shortopts .= "r";
$shortopts .= "i::";
$shortopts .= "s::";
$shortopts .= "h::";
$shortopts .= "p:";
$shortopts .= "o:";
$shortopts .= "c:";


$longopts  = array(
    "recursive",     
    "output-image::",   
    "output-style::",
    "output-html::",  
    "padding:",  
    "override-size:",  
    "columns_number:",
    "help",             
);
$options = getopt($shortopts, $longopts);

// var_dump($options);

if (array_key_exists('help',$options))
{
    $help = file_get_contents('./help');
    echo $help;
}

elseif( isset($argv[1]) &&  is_dir(end($argv)))
{ 
    if (array_key_exists('r',$options))
    {   
        $tab_images = recursive(end($argv));   
    }
    
    elseif (array_key_exists('recursive',$options))
    {   
        $tab_images = recursive(end($argv));
    }
    
    else
    {
        $tab_images = listage(end($argv));   
    } 
    
    if ((key_exists('p',$options)))
    {   
        if( !is_numeric($options['p']))
        {
            $line = "";
            
            while (!is_numeric( $line) )
            {
                echo 'Veillez enter une valeur numerique'.PHP_EOL;
                
                $line = trim(fgets(STDIN));
            }
            
            $marge = abs($line);
        }
        
        else
        {
            $marge = abs($options['p']);
        }
    }
    
    elseif ((key_exists('padding',$options)))
    {   
        if( !is_numeric($options['padding']))
        {
            $line = "";
            
            while (!is_numeric( $line) )
            {
                echo "Veillez enter une valeur numerique".PHP_EOL;
                
                $line = trim(fgets(STDIN)); 
            }
            
            $marge = abs($line);
        }
        
        else
        {
            $marge = abs($options['padding']);
        }
    }
    
    
    if (key_exists('o',$options))
    {   
        if(!preg_match('/^[0-9]+x[0-9]+$/',$options['o']))
        {
            $line = "";
            
            while (!preg_match('/^[0-9]+x[0-9]+$/', $line) )
            {
                echo 'Veillez enter les valeur sous ce format exemple : 150x120 '.PHP_EOL;
                
                $line = trim(fgets(STDIN));
            }
            
            $new_size = explode('x',$line);
            $new_w = abs($new_size[0]);
            $new_h = abs($new_size[1]);
        }
        
        else
        {
            $new_size = explode('x',$options['o']);
            $new_w = abs($new_size[0]);
            $new_h = abs($new_size[1]);
        }
    }
    
    elseif (key_exists('override-size',$options))
    {   
        if(!preg_match('/^[0-9]+x[0-9]+$/',$options['override-size']))
        {
            $line = "";
            
            while (!preg_match('/^[0-9]+x[0-9]+$/', $line))
            {
                echo "Veillez enter des valeur numerique sous ce format exemple : 150*120".PHP_EOL;
                
                $line = trim(fgets(STDIN)); 
            }
            
            $new_size = explode('x',$line);
            $new_w = abs($new_size[0]);
            $new_h = abs($new_size[1]);
        }
        
        else
        {
            $new_size = explode('x',$options['override-size']);
            $new_w = abs($new_size[0]);
            $new_h = abs($new_size[1]);
        }
    }
    
    if( array_key_exists('i',$options) && $options['i'] !== false)
    {
        if(!preg_match("/.+(.png?)/", $options['i']))
        {
            
            $sprite_name=$options['i'].'.png';
            sprite($tab_images, $sprite_name, $marge, $new_w, $new_h);
        }
        
        else
        {
            $sprite_name=$options['i'];
            sprite($tab_images, $sprite_name, $marge, $new_w, $new_h);
            
        }
    }
    
    elseif( array_key_exists('output-image',$options) && $options['output-image'] !== false)
    {
        if(!preg_match("/.+(.png?)/", $options['output-image']))
        {
            $sprite_name=$options['output-image'].'png';
            sprite($tab_images, $sprite_name, $marge, $new_w, $new_h);
        }
        
        else
        {
            $sprite_name=$options['output-image'];
            sprite($tab_images, $sprite_name, $marge, $new_w, $new_h);
        }
    }
    
    else
    {
        sprite($tab_images,$sprite_name, $marge, $new_w, $new_h);
    }
    
    
    if ((array_key_exists('s',$options)) && $options['s'] !== false )
    {   
        if(!preg_match("/.+(.css?)/", $options['s']))
        {
            $css_name=$options['s'].'.css';
            css_gener($tab_images, $css_name, $sprite_name, $marge, $new_w, $new_h );
        }
        
        else
        {
            $css_name=$options['s'];
            css_gener($tab_images, $css_name, $sprite_name, $marge, $new_w, $new_h );
        }
        
    }
    
    elseif ((key_exists('output-style',$options)) && $options['output-style'] !== false)
    {   
        if(!preg_match("/.+(.css?)/", $options['output-style']))
        {
            $css_name=$options['output-style'].'.css';
            css_gener($tab_images, $css_name,$sprite_name, $marge, $new_w, $new_h );
        }
        
        else
        {
            $css_name=$options['output-style'];
            css_gener($tab_images, $css_name,$sprite_name, $marge, $new_w, $new_h );
        }
    }
    
    else
    {
        css_gener($tab_images,  $css_name, $sprite_name, $marge, $new_w, $new_h );
    }
    
    
    if ((key_exists('h',$options)) && $options['h'] !== false)
    {   
        if(!preg_match("/.+(.html?)/", $options['h']))
        {
            $html_name=$options['h'].'.html';
            html_gener($tab_images, $html_name);
        }
        
        else
        {
            $html_name=$options['h'];
            html_gener($tab_images, $html_name);
        }
    }
    
    elseif ((key_exists('output-html',$options)) && $options['output-html'] !== false)
    {   
        if(!preg_match("/.+(.html?)/", $options['output-html']))
        {
            $html_name=$options['output-html'].'.html';
            html_gener($tab_images, $html_name);
        }
        
        else
        {
            $html_name=$options['output-html'];
            html_gener($tab_images, $html_name);
        }
    }
    
    else
    {
        html_gener($tab_images,  $html_name);
    }
}
else
{
    echo "$red\nVeillez enter un chemin de dossier valide ou utiliser la commande --help";
}

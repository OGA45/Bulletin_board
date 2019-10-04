<?php
    function template($html,$i,$name,$seed,$text,$time){
        $htmldata=file_get_contents($html);
        $replaced='/-no-/';
        $htmldata=preg_replace($replaced,$i,$htmldata);
        $replaced='/-name-/';
        $htmldata=preg_replace($replaced,$name,$htmldata);
        $replaced='/-id-/';
        $htmldata=preg_replace($replaced,$seed,$htmldata);
        $replaced='/-text-/';
        $htmldata=preg_replace($replaced,$text,$htmldata);
        $replaced='/-time-/';
        $htmldata=preg_replace($replaced,$time,$htmldata);
        $replaced ='/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
        $url ='<a href="$1">$1</a>';
        $htmldata=preg_replace($replaced,$url,$htmldata);
        return $htmldata;
    }
    function template1($html,$id,$tile,$desc){
        $htmldata=file_get_contents($html);
        $replaced='/-id-/';
        $htmldata=preg_replace($replaced,$id,$htmldata);
        $replaced='/-title-/';
        $htmldata=preg_replace($replaced,$tile,$htmldata);
        $replaced='/-title2-/';
        $htmldata=preg_replace($replaced,$tile,$htmldata);
        $replaced='/-desc-/';
        $htmldata=preg_replace($replaced,$desc,$htmldata);
        return $htmldata;
    }
?>
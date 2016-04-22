<?php
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
class XMLTool{
     function __construct(){} 
   
//POISTETAAN
function DeleteXml($id, $userid)
    {   try{
        if(file_exists("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml")){
            $dom=new DOMDocument();
            $dom->load("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml");  
            $root = $dom->documentElement;   
            $allnodes = $dom->getElementsByTagName('product');
            $i = 0;
            foreach ($allnodes as $node) 
            {   
                if($id == $node->getElementsByTagName('id')->item(0)->nodeValue)
                {   
                    $root->removeChild($root->getElementsByTagName('product')->item($i));
                    $dom->save("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml");
                    return true;
                }   
                $i++;
            }
        }
        else{
            return false;
        }
    }
    catch (Exception $e) {echo "virhe tapahtui : ".$e->getMessage();}    
    } 

function WriteXml($userid ,$id, $name, $price, $availability, $description){ 
    try{
      if(!file_exists("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml"))
        {
         //luodaan uusi xml filu jos ei vielä ole ja kirjoitetaan  
		$xml = new DomDocument();   
        $container = $xml->createElement("products");
        $container = $xml->appendChild($container);
        $xml->FormatOutput = true;
        echo $xml->saveXML();
        $xml->save("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml");
			
        }
        //tallennetaan uutta tietoa

        $dom=new DOMDocument();
        $dom->load("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml");
        $dom->formatOutput = true;
        $root = $dom->documentElement;
        $newresult = $root->appendChild($dom->createElement("product"));
        $id = $newresult->appendChild($dom->createElement("id" , $id));
        $name = $newresult->appendChild($dom->createElement("name" , $name));
        $price = $newresult->appendChild($dom->createElement("price" , $price));
        $availability = $newresult->appendChild($dom->createElement("availability" , $availability));
        $description = $newresult->appendChild($dom->createElement("description" , $description));


        $dom->save("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml");
    }
catch (Exception $e) {
        echo "virhe tapahtui : ".$e->getMessage();
}        
}
 
 
//Kirjoitetaan xml olevat tiedostot
function WriteIt($userid)
{   
  $allproducts = new ArrayObject(array(), ArrayObject::STD_PROP_LIST);
    try{
    if(file_exists("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml")){
        $dom=new DOMDocument();
       $dom->load("/home/H9577/public_html/WWW-palvelinohjelmointi/harjoitustyo/shopcartnotes/note".$userid.".xml");
       $dom->formatOutput = true;       
        $allnodes = $dom->getElementsByTagName('product');
        foreach ($allnodes as $node) 
        {  
         $id = $node->getElementsByTagName('id')->item(0)->nodeValue;
         $name = $node->getElementsByTagName('name')->item(0)->nodeValue;
         $price = $node->getElementsByTagName('price')->item(0)->nodeValue;
         $availability = $node->getElementsByTagName('availability')->item(0)->nodeValue;
         $description = $node->getElementsByTagName('description')->item(0)->nodeValue;
        $product = new Product($id,$name, $price, $availability ,  $description);
       $allproducts[] = $product;
        }   
        return $allproducts;
    }
else{
    $text = "et ole asettanut vielä tuotteita ostoskoriin";
}
}
catch (Exception $e) {
        echo "virhe tapahtui : ".$e->getMessage();
}
}
 

   }  
?>
<?php
print_r(error_get_last());


//$satir1 = array("Product ID", "Active (0/1)","Name *","Categories (x,y,z...)","Price tax included","Tax rules ID","Wholesale price","On sale (0/1)","Discount amount","Discount percent","Discount from (yyyy-mm-dd)","Discount to (yyyy-mm-dd)","Reference #","Supplier reference #","Supplier","Manufacturer","EAN13","UPC","Ecotax","Width","Height","Depth","Weight","Quantity","Minimal quantity","Low stock level","Visibility","Additional shipping cost","Unity","Unit price","Short description","Description","Tags (x,y,z...)","Meta title","Meta keywords","Meta description","URL rewritten","Text when in stock","Text when backorder allowed","Available for order (0 = No, 1 = Yes)","Product available date","Product creation date","Show price (0 = No, 1 = Yes)","Image URLs (x,y,z...)","Image alt texts (x,y,z...)","Delete existing images (0 = No, 1 = Yes)","Feature(Name:Value:Position)","Available online only (0 = No, 1 = Yes)","Condition","Customizable (0 = No, 1 = Yes)","Uploadable files (0 = No, 1 = Yes)","Text fields (0 = No, 1 = Yes)","Out of stock","ID / Name of shop","Advanced stock management","Depends On Stock","Warehouse");


function array_to_csv_function($array, $filename = "acellurunler.csv", $delimiter=";") {
    // Bir temp dosyası açmak yerine bellek alanı kullanıyoruz. 
    $f = fopen('php://memory', 'w');
    // Verilerimizin olduğu diziyi döngüye sokuyoruz
    foreach ($array as $line) {
    // Dizimizin içindeki her dizi, CSV dosyamızda bir satır olmaktadır.
    fputcsv($f, $line, $delimiter);
    }
    // Dosya başlangıc işaretini sıfırlıyor
    fseek($f, 0);
    // Tarayıcıya bir csv dosyası olduğunu belirtiyor
    header('Content-Type: application/csv');
    // Tarayıcıya görüntülenmek için olmadığını, kaydedilmek için olduğunu belirtiyor. 
    header('Content-Disposition: attachment; filename="'.$filename.'";');
    // Üretilen CSV tarayıcıya iletiliyor.
    fpassthru($f);
   }

    $titles = array("urunID", "urunRef", "durum","urunAdi","kategoriler","marka","paraBirimi","fiyat","kisaAciklama","uzunAciklama","etiket","metaTitle","metaDesc","metaKey","resim","resimAciklama");

    $root = simplexml_load_file("urunler.xml");
    $kategori = "Yedek Parça";
    foreach ($root->urun as $item){
        $urunID = $item->UrunId;
        $urunRef = $item->StokKodu;
        $durum = $item->Durumu;
        $urunAdi = $item->StokAdi;
        $marka = $item->MarkaAdi;
        $paraBirimi = $item->SatisFiyati1ParaBirimi;
        $fiyat = $item->SatisFiyati1;
        if ($paraBirimi=="TL"){
           $yenifiyat = ($fiyat / 6.63);
           $yeniparaBirimi == "EURO";
        } else {
           $yenifiyat = $fiyat;
           $yeniparaBirimi = $paraBirimi;
        }
        $kisaAciklama = $item->Aciklama;
        $uzunAciklama = $item->Detay;
        $etiket = $item->SearchKeywords;
        $metaTitle = $item->StokAdi;
        $metaDesc = $item->Aciklama;
        $metaKey = $item->SearchKeywords;
        $resim = $item->Resim;
        $resimAciklama = $item->StokAdi;
          
        $urunler = array($urunID, $urunRef, $durum, $urunAdi, $kategori, $marka, $yeniparaBirimi, $yenifiyat, $kisaAciklama, $uzunAciklama, $etiket, $metaTitle, $metaDesc, $metaKey, $resim, $resimAciklama);   
    }
    
    $icerik = array($titles, array_push($urunler));
    array_to_csv_function($icerik, "export.csv");
    // Diğer bir şekilde kullanımı
    //array_to_csv_function(array($basliklar, $satir1, $satir2), "export.csv");


/*
//Excel gibi görünme kodları
header("Content-Type: application/vnd.ms-excel");
header("Content-disposition: attachment; filename=excellist.xls");

echo 'urunID'."\t".'urunRef'."\t".'durum'."\t".'urunAdi'."\t".'kategoriler'."\t".'marka'."\t".'paraBirimi'."\t".'fiyat'."\t".'kisaAciklama'."\t".'uzunAciklama'."\t".'etiket'."\t".'metaTitle'."\t".'metaDesc'."\t".'metaKey'."\t".'resim'."\t".'resimAciklama'."\n";

$veriler = simplexml_load_file("urunler.xml");
$kategori = "Yedek Parça";

foreach($veriler as $veri){
    $urunID = $veri->UrunId;
    $urunRef = $veri->StokKodu;
    $durum = $veri->Durumu;
    $urunAdi = $veri->StokAdi;
    $marka = $veri->MarkaAdi;
    $paraBirimi = $veri->SatisFiyati1ParaBirimi;
    $fiyat = $veri->SatisFiyati1;
    if ($paraBirimi=="TL"){
    $yenifiyat = ($fiyat / 6.63);
    $yeniparaBirimi == "EURO";
    } else {
    $yenifiyat = $fiyat;
    $yeniparaBirimi = $paraBirimi;
    }
    $kisaAciklama = $veri->Aciklama;
    $uzunAciklama = $veri->Detay;
    $etiket = $veri->SearchKeywords;
    $metaTitle = $veri->StokAdi;
    $metaDesc = $veri->Aciklama;
    $metaKey = $veri->SearchKeywords;
    $resim = $veri->Resim;
    $resimAciklama = $veri->StokAdi;

    echo $urunID ."\t".  $urunRef ."\t". $durum ."\t". $urunAdi ."\t". $kategori ."\t". $marka ."\t". $yenifiyat ."\t". $yeniparaBirimi ."\t". $kisaAciklama ."\t". $uzunAciklama ."\t". $etiket ."\t". $metaTitle ."\t". $metaDesc ."\t". $metaKey ."\t". $resim ."\t". $resimAciklama ."\n";
}
*/

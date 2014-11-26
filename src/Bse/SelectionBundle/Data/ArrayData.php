<?php

namespace Bse\SelectionBundle\Data;

class ArrayData
{

    public function __construct()
    {

    }


     public static function getCandidaturesData($kernel, $filePath)
    {
    	$rootDir = $kernel->getRootDir();

    	$resultArray = array();
    	ini_set('auto_detect_line_endings',TRUE);

    	//$handle = fopen($rootDir. '/../src/Bse/SelectionBundle/Data/candidatures.csv','r');
    	$handle = fopen($filePath,'r');
    	$columns = array();
    	$firstRow = true;
  		while (($data = fgetcsv($handle, 4000, ";")) !== FALSE) {
  	        if($firstRow){
  	        	foreach($data as $columnValue){
  	        		$columns[] = $columnValue;
  	        	}
  	        	$firstRow = false;
  	        }else{
  		        $colIndex = 0;
  		        $candidature = array();
  		        foreach($data as $columnValue){
  		        	$candidature[$columns[$colIndex]] = $columnValue;
  		        	$colIndex++;
  		    	}
  		    	$resultArray[] = $candidature;
  		    }
  	    }
  	    fclose($handle);
  		return $resultArray;
    }

    public static function getFilieresData($container, $faculteCode = '')
    {
    	$data_1 =array(
			'Mathématiques et applications',
			'Ingénierie des matériaux : traitement, caractérisation et contrôle de qualité',
			'Chimie organique et Environnement',
			'Sciences des matériaux',
			'Management qualité, Hygiène, Sécurité et Environnement',
			'Systèmes de protection des métaux : conception et environnement',
			'Génie des matériaux et technolgies des céramiques et ciments',
			'Electronique embarquée et systèmes de télécommunication',
			'Energétique - Mécanique des fluides',
			'Sciences et techniques nucléaires',
			'Energies Renouvelables',
			'Physique de la matière condensée',
			'Hydroinformatique et Gestion des Hydrosystèmes',
			'Neurocognition humaine et santé de la population',
			'Biologie - Santé - Environnement',
			'Nutrition humaine, Sécurité alimentaire et Management de la qualité',
			'MASTER SPÉCIALISÉ MÉTIERS D’ENSEIGNEMENT ET DE FORMATION EN PHYSIQUE-CHIMIE',
			'MASTER SPÉCIALISÉ MÉTIERS D’ENSEIGNEMENT ET DE FORMATION EN MATHÉMATIQUES',
			'Informatique'
		);

		$data_2 = array(
			'مكونات الأدب العربي في  المغرب الحديث والمعاصر: التاريخ  والخطابية',
			'Langue française et diversité linguistique',
			'Dynamique et gestion de l\'environnement',
			'Gestion Territoriale des risques environnementaux',
			'شمال إفريقيا وجنوب الصحراء',
			'Changements Climatiques , Ressources en Eau et développement durable au Maroc',
			'اللسانيات العربية والإعداد اللغوي',
			'اللهجات العربية والأدب الشفهي بالمغرب',
			'الاختلاف في العلوم الشرعية',
			'التواصل وتحليل الخطاب',
			'سوسيولوجبا التنمية المحلية',
			//'Teaching English As A Foreign Language (TEFL)',
			'Master in Culture and linguistics',
			//'Géographie et Aménagement'
		);

		$data_3 = array(
			'Banque et Assurance',
			'Management Audit et Contrôle',
			'Logistique et Marketing : Logistique et Supply Chain',
			'Logistique et Marketing : Marketing et Distribution'
		);

		$data = array('FS'=>$data_1, 'FL' => $data_2, 'FD' => $data_3);

		if(empty($faculteCode))
			$faculteCode = $container->getParameter('faculte_code');
		return $data[$faculteCode];
    }

    public static function getEtablissementsData($kernel)
    {
    	$rootDir = $kernel->getRootDir();

    	$resultArray = array();
    	ini_set('auto_detect_line_endings',TRUE);

    	$handle = fopen($rootDir. '/../src/Bse/CandidatureBundle/Data/etablissements.csv','r');
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
	        $num = count($data);
	        $resultArray[$data[0]] = $data[1];
	    }
	    fclose($handle);
    	/*$data =array(
			'Maroc',
			'Autre',
		);*/
		return $resultArray;

    }

    public static function getIntitulesDiplomeData($kernel)
    {
    	$rootDir = $kernel->getRootDir();


    	ini_set('auto_detect_line_endings',TRUE);

    	$intitulesdiplomes_LF = array();
    	$handle = fopen($rootDir. '/../src/Bse/CandidatureBundle/Data/intitulesdiplomes_LF.csv','r');
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
	        $num = count($data);
	        $intitulesdiplomes_LF[$data[0]] = $data[1];
	    }
	    fclose($handle);

	    $intitulesdiplomes_LP = array();
    	$handle = fopen($rootDir. '/../src/Bse/CandidatureBundle/Data/intitulesdiplomes_LP.csv','r');
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
	        $num = count($data);
	        $intitulesdiplomes_LP[$data[0]] = $data[1];
	    }
	    fclose($handle);
		  return array('LF'=> $intitulesdiplomes_LF , 'LP' => $intitulesdiplomes_LP);
    }

    public static function getTypesDiplomeData()
    {
    	$data =array(
			'LF'=>'Licence Fondamentale',
			'LP'=>'Licence Professionnelle',
		);
		return $data;

    }

    public static function getSystemesData()
    {
    	$data =array(
			'LMD',
			'Ancien'
		);
		return $data;
    }

    public static function getMentionsData()
    {
    	$data =array(
			'Passable',
			'Assez bien',
			'Bien',
			'Très bien',
			'Excellent',
		);
		return $data;

    }

    public static function getPaysData($kernel)
    {
    	$rootDir = $kernel->getRootDir();

    	$resultArray = array();
    	ini_set('auto_detect_line_endings',TRUE);

    	$handle = fopen($rootDir. '/../src/Bse/CandidatureBundle/Data/pays.csv','r');
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
	        $num = count($data);
	        $resultArray[$data[0]] = $data[1];
	    }
	    fclose($handle);
    	/*$data =array(
			'Maroc',
			'Autre',
		);*/
		return $resultArray;
    }

    public static function getVillesData($kernel)
    {
    	$rootDir = $kernel->getRootDir();

    	$resultArray = array();
    	ini_set('auto_detect_line_endings',TRUE);

    	$handle = fopen($rootDir. '/../src/Bse/CandidatureBundle/Data/villes.csv','r');
		while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
	        $num = count($data);
	        $resultArray[$data[0]] = $data[1];
	    }
	    fclose($handle);
    	/*$data =array(
			'Maroc',
			'Autre',
		);*/
		return $resultArray;
    }

    public static function getFacultesData()
    {
    	$data =array(
			'FS'=>'Faculté des Sciences',
			'FL'=>'Faculté des Lettres et des Sciences Humaines',
			'FD'=>'Faculté de droit'
			// 'FE'=>'Faculté d\'economie',
		);
		return $data;
    }

    public static function getValueUsingKey($searchedKey, $array) {
    	foreach($array as $key=>$value){
    		if($searchedKey == $key)
    			return $value;
    	}
	   	return $searchedKey;
	}

}

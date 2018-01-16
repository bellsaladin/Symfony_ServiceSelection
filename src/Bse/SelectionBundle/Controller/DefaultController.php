<?php

namespace Bse\SelectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Bse\SelectionBundle\Form\SelectionType;
use Bse\SelectionBundle\Entity\Selection;
use Exporter\handler;

use Exporter\Source\ArraySourceIterator;
use Exporter\Source\SourceIteratorInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

use Bse\SelectionBundle\Data\ArrayData;

use Exporter\Writer\XlsWriter;
use Exporter\Writer\XmlWriter;
use Exporter\Writer\JsonWriter;
use Exporter\Writer\CsvWriter;



class DefaultController extends Controller
{
    public function indexAction()
    {
    	$entity = new Selection();
        $form   = $this->createCreateForm($entity);

        $request = $this->get('request');
        $cookieFichierCandidaturesExists = (isset($request->cookies->all()['fichierCandidatures']))?true:false;
        $cookieFaculte = (isset($request->cookies->all()['faculte']))?$request->cookies->all()['faculte']:'';

        return $this->render('BseSelectionBundle:Default:index.html.twig', array('entity' => $entity,
            'form'   => $form->createView(), 'cookieFichierCandidaturesExists' =>$cookieFichierCandidaturesExists,'cookieFaculte' => $cookieFaculte ));
    }

    public function executeAction(Request $request)
    {

    	$entity = new Selection();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        //$firstCandidature = $request->request->get('firstCandidature');

        $directory = dirname(__FILE__).'/../../../../web/bundles/bseselection/uploads';
        $filename = sprintf( 'export_%s_%s.csv', date('Y_m_d_H_i_s', strtotime('now')), rand() );

        $fichierCandidatures = null;

        $cookieFichierCandidaturesExists = (isset($request->cookies->all()['fichierCandidatures']))?true:false;
        if(!$request->files->get('fichierCandidatures') instanceof UploadedFile && !$cookieFichierCandidaturesExists){
            return new Response('Vous devez téléchargé le fichier de données.');
        }

        if($cookieFichierCandidaturesExists && !$request->files->get('fichierCandidatures') instanceof UploadedFile){
            $fichierCandidatures = $request->cookies->all()['fichierCandidatures'];
        }else{
            $fichierCandidatures = $request->files->get('fichierCandidatures')->move($directory, $filename);
        }

        $formData = $form->getData();

        $session  = $this->get("session");
        $session->set("selectionEntity",$entity);

        $arrayCandidatures = ArrayData::getCandidaturesData($this->get('kernel'), $fichierCandidatures);

        $rowIndex = 0;
        foreach($arrayCandidatures as $candidature){
            $score = $this->calculateScoreForCandidature($candidature,$entity);
            $candidature['score'] = $score;
            // update candidature
            $arrayCandidatures[$rowIndex] = $candidature;
            $rowIndex++;
        }

        $arrayCandidatures = $this->array_msort($arrayCandidatures, array('score'=>SORT_DESC));

        $htmlOutput = $this->renderView('BseSelectionBundle:Default:execute.html.twig', array('entity' => $entity,
            'form'   => $form->createView(), 'data' => $arrayCandidatures, 'cookieFichierCandidaturesExists' =>$cookieFichierCandidaturesExists));
        $response = new Response($htmlOutput);

        $response->headers->setCookie(new Cookie('fichierCandidatures', $fichierCandidatures));
        $response->headers->setCookie(new Cookie('faculte', $entity->getFaculte()));
        return $response;
    }

    public function exportAction()
    {
        $request = $this->get('request');
        $session  = $this->get("session");
        $entity = $session->get("selectionEntity");

        $fichierCandidatures = '';
        $cookieFichierCandidaturesExists = (isset($request->cookies->all()['fichierCandidatures']))?true:false;
        if($cookieFichierCandidaturesExists){
            $fichierCandidatures = $request->cookies->all()['fichierCandidatures'];
        }

        $arrayCandidatures = ArrayData::getCandidaturesData($this->get('kernel'),$fichierCandidatures);

        $rowIndex = 0;
        foreach($arrayCandidatures as $candidature){
            $score = $this->calculateScoreForCandidature($candidature,$entity);
            $candidature['score'] = $score;
            // update candidature
            $arrayCandidatures[$rowIndex] = $candidature;
            $rowIndex++;
        }

        $arrayCandidatures = $this->array_msort($arrayCandidatures, array('score'=>SORT_DESC));

        /* return $this->render('BseSelectionBundle:Default:execute.html.twig', array('entity' => $entity,
            'form'   => $form->createView(), 'data' => $arrayCandidatures )); */


        // export
        //$exportedArray = array(array('hello','dadadda','dadaad'));
        $arraySource = new ArraySourceIterator($arrayCandidatures);
        $filename = sprintf( 'export_%s.xls', date('Y_m_d_H_i_s', strtotime('now')) );
        return $this->getResponse('xls', $filename, $arraySource);
    }


    private function array_msort($array, $cols)
        {
            $colarr = array();
            foreach ($cols as $col => $order) {
                $colarr[$col] = array();
                foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
            }
            $eval = 'array_multisort(';
            foreach ($cols as $col => $order) {
                $eval .= '$colarr[\''.$col.'\'],'.$order.',';
            }
            $eval = substr($eval,0,-1).');';
            eval($eval);
            $ret = array();
            foreach ($colarr as $col => $arr) {
                foreach ($arr as $k => $v) {
                    $k = substr($k,1);
                    if (!isset($ret[$k])) $ret[$k] = $array[$k];
                    $ret[$k][$col] = $array[$k][$col];
                }
            }
            return $ret;

        }

    private function calculateScoreForCandidature($candidature, $selection){
        $score = 0;

        // calcul age -------------------
        $today = new \DateTime();
        $dateNaissance = new \DateTime($candidature['date_naissance']);

        $diff = $dateNaissance->diff($today);
        $ageCandidat = $diff->y;

        // calcul durée licence -------------------
        $anneeObtentionBac = $candidature['annee_obtention_bac'];
        $anneeObtentionLicence = $candidature['annee_obtention_licence'];
        $anneeInscription = $candidature['annee_inscription'];
        $dureeLicence = 0;
        if($anneeObtentionBac == $anneeInscription){
            $dureeLicence = $anneeObtentionLicence - $anneeObtentionBac;
        }
        elseif($anneeObtentionBac != $anneeInscription && $anneeObtentionLicence - $anneeInscription < 3){
            $dureeLicence = $anneeObtentionLicence - $anneeObtentionBac;
        }else{
            $dureeLicence = $anneeObtentionLicence - $anneeInscription;
        }

        // score age -------------------

        if($ageCandidat >= 18 && $ageCandidat <= 22){
            $score += $selection->getAgeFrom18To22();
        }
        if($ageCandidat >= 23 && $ageCandidat <= 25){
            $score += $selection->getAgeFrom23To25();
        }

        // score durée licence -------------------

        if($dureeLicence >= 3 && $dureeLicence <= 4) $score += $selection->getDureeLicenceFrom3To4();
        if($dureeLicence >= 5 && $dureeLicence <= 6) $score += $selection->getDureeLicenceFrom5To6();
        if($dureeLicence >= 7 && $dureeLicence <= 8) $score += $selection->getDureeLicenceFrom7To8();

         // score type diplome -------------------

        if($candidature['type_diplome'] == $selection->getTypeDiplomeLFouLP()){
            $score += $selection->getTypeDiplome();
        }

        // score type système -------------------

        if($candidature['systeme'] == $selection->getTypeSystemeLMDouAncien() ){
            $score += $selection->getTypeSysteme();
        }

        // score etablissement ibn tofail -------------------

        if($candidature['etablissement_origine'] == '19000007' ||
           $candidature['etablissement_origine'] == '11000005' ||
           $candidature['etablissement_origine'] == '2000004'  ||
           $candidature['etablissement_origine'] == '10000007' ||
           $candidature['etablissement_origine'] == '3000007'){
                $score += $selection->getEtablissement();
        }

        // score mentions -------------------

        if($candidature['mention'] == 'Assez bien'){
            $score += $selection->getMentionAssezBien();
        }

        if($candidature['mention'] == 'Bien'){
            $score += $selection->getMentionBien();
        }

        if($candidature['mention'] == 'Très bien'){
            $score += $selection->getMentionTresBien();
        }


        if($selection->getFaculte() == 'FD' && isset($candidature['note_m1'])){
            if($candidature['note_m1'] >= 5 && $candidature['note_m1'] < 10)
                $score += $selection->getNoteM1From5To10();
            if($candidature['note_m1'] >= 10 && $candidature['note_m1'] < 15)
                $score += $selection->getNoteM1From10To15();
            if($candidature['note_m1'] >= 15 && $candidature['note_m1'] <= 20)
                $score += $selection->getNoteM1From15To20();

            if($candidature['note_m2'] >= 5 && $candidature['note_m2'] < 10)
                $score += $selection->getNoteM2From5To10();
            if($candidature['note_m2'] >= 10 && $candidature['note_m2'] < 15)
                $score += $selection->getNoteM2From10To15();
            if($candidature['note_m2'] >= 15 && $candidature['note_m2'] <= 20)
                $score += $selection->getNoteM2From15To20();

            if($candidature['note_m3'] >= 5 && $candidature['note_m3'] < 10)
                $score += $selection->getNoteM3From5To10();
            if($candidature['note_m3'] >= 10 && $candidature['note_m3'] < 15)
                $score += $selection->getNoteM3From10To15();
            if($candidature['note_m3'] >= 15 && $candidature['note_m3'] <= 20)
                $score += $selection->getNoteM3From15To20();

            if($candidature['note_m4'] >= 5 && $candidature['note_m4'] < 10)
                $score += $selection->getNoteM4From5To10();
            if($candidature['note_m4'] >= 10 && $candidature['note_m4'] < 15)
                $score += $selection->getNoteM4From10To15();
            if($candidature['note_m4'] >= 15 && $candidature['note_m4'] <= 20)
                $score += $selection->getNoteM4From15To20();

            if($candidature['note_m5'] >= 5 && $candidature['note_m5'] < 10)
                $score += $selection->getNoteM5From5To10();
            if($candidature['note_m5'] >= 10 && $candidature['note_m5'] < 15)
                $score += $selection->getNoteM5From10To15();
            if($candidature['note_m5'] >= 15 && $candidature['note_m5'] <= 20)
                $score += $selection->getNoteM5From15To20();

            if($candidature['note_m6'] >= 5 && $candidature['note_m6'] < 10)
                $score += $selection->getNoteM6From5To10();
            if($candidature['note_m6'] >= 10 && $candidature['note_m6'] < 15)
                $score += $selection->getNoteM6From10To15();
            if($candidature['note_m6'] >= 15 && $candidature['note_m6'] <= 20)
                $score += $selection->getNoteM6From15To20();
        }

        return $score;
        //return 100;
    }


    public function exportCsvFilesAction(){
        $request = $this->get('request');
        $kernel = $this->get('kernel');
        $rootDir = $kernel->getRootDir();
        $faculteCode = $request->query->get('faculte');

        $fichierCandidatures = $rootDir. '/../src/Bse/SelectionBundle/Data/candidatures_'.$faculteCode.'.csv';

        $arrayCandidatures = ArrayData::getCandidaturesData($kernel,$fichierCandidatures);

        $filieresFaculte = ArrayData::getFilieresData($this->container,$faculteCode);
        $filiereIndex = 0;
        $matchingCandidaturesIndex = 0;
        foreach($filieresFaculte as $filiere){
            $arrayCandidaturesMatchingFiliere = array();  // recreate the array for each filiere

            foreach($arrayCandidatures as $candidature){
                $filieresChoisies = $candidature['filiere'];
                $filieresChoisies = explode('//',$candidature['filiere']);
                foreach($filieresChoisies as $filiereChoisie){
                    if($filiereChoisie == $filiere){
                        //$candidature['score'] = $filiereChoisie;
                        unset($candidature['filiere']);
                        //unset($candidature['email']);
                        $arrayCandidaturesMatchingFiliere[$matchingCandidaturesIndex] = $candidature;
                    }
                }
                $matchingCandidaturesIndex++;
            }
            $filiereLibelleWithoutSpecialCaracters = preg_replace('/[^\w\s]+/u','', $filiere);
            $filiereLibelleWithoutSpecialCaracters = strtolower($filiereLibelleWithoutSpecialCaracters);
            $filiereLibelleWithoutSpecialCaracters = ucwords($filiereLibelleWithoutSpecialCaracters);
            $filiereLibelleWithoutSpecialCaracters = preg_replace('/\s+/', '', $filiereLibelleWithoutSpecialCaracters);
            $exportFile = sprintf( 'Candidatures_%s.csv', $filiereLibelleWithoutSpecialCaracters);
            $filiereData = array('libelle' => $filiere, 'candidaturesArray' => $arrayCandidaturesMatchingFiliere, 'exportFile' => $exportFile);
            $filieresFaculte[$filiereIndex] = $filiereData;
            $filiereIndex++;
        }

        $numFiliereToExport = $request->query->get('num');
        if(isset($numFiliereToExport) ){
            $filename = $filieresFaculte[$numFiliereToExport]['exportFile'];
            $arraySource = new ArraySourceIterator($filieresFaculte[$numFiliereToExport]['candidaturesArray']);
            return $this->getResponse('csv', $filename, $arraySource);
        }
        return $this->render('BseSelectionBundle:Default:exportCsvFiles.html.twig', array('data' => $filieresFaculte, 'faculteCode' => $faculteCode));


        // export
        //$exportedArray = array(array('hello','dadadda','dadaad'));
        $arraySource = new ArraySourceIterator($arrayCandidatures);
        $filename = sprintf( 'export_%s.xls', date('Y_m_d_H_i_s', strtotime('now')) );
        return $this->getResponse('csv', $filename, $arraySource);
    }


    /**
     * Creates a form to create a Selection entity.
     *
     * @param Selection $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Selection $entity)
    {
        $form = $this->createForm(new SelectionType(), $entity, array(
            'action' => $this->generateUrl('bse_selection_execute'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function getResponse($format, $filename, SourceIteratorInterface $source)
    {
        switch ($format) {
            case 'xls':
                $writer      = new XlsWriter('php://output');
                $contentType = 'application/vnd.ms-excel';
                break;
            case 'xml':
                $writer      = new XmlWriter('php://output');
                $contentType = 'text/xml';
                break;
            case 'json':
                $writer      = new JsonWriter('php://output');
                $contentType = 'application/json';
                break;
            case 'csv':
                $writer      = new CsvWriter('php://output', ';', '"', "", true, true);
                $contentType = 'text/csv';
                break;
            default:
                throw new \RuntimeException('Invalid format');
        }

        $callback = function() use ($source, $writer) {
            $handler = \Exporter\Handler::create($source, $writer);
            $handler->export();
        };

        return new StreamedResponse($callback, 200, array(
            'Content-Type'        => $contentType,
            'Content-Disposition' => sprintf('attachment; filename=%s', $filename)
        ));
    }
}

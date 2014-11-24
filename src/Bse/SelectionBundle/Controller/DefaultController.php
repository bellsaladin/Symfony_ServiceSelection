<?php

namespace Bse\SelectionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session;

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

        return $this->render('BseSelectionBundle:Default:index.html.twig', array('entity' => $entity,
            'form'   => $form->createView() ));
    }

    public function executeAction(Request $request)
    {
    	$entity = new Selection();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        //$firstCandidature = $request->request->get('firstCandidature');

        $formData = $form->getData();

        $session  = $this->get("session");
        $session->set("selectionEntity",$entity);

       
        $ageFrom18To22 = $form->get('ageFrom18To22')->getData();

        $arrayCandidatures = ArrayData::getCandidaturesData($this->get('kernel'));

        $rowIndex = 0;
        foreach($arrayCandidatures as $candidature){
            $score = $this->calculateScoreForCandidature($candidature,$entity);
            $candidature['score'] = $score;
            // update candidature
            $arrayCandidatures[$rowIndex] = $candidature; 
            $rowIndex++;
        }

        $arrayCandidatures = $this->array_msort($arrayCandidatures, array('score'=>SORT_DESC));

        return $this->render('BseSelectionBundle:Default:execute.html.twig', array('entity' => $entity,
            'form'   => $form->createView(), 'data' => $arrayCandidatures )); 


        // export
        //$exportedArray = array(array('hello','dadadda','dadaad'));
        $arraySource = new ArraySourceIterator($arrayCandidatures);
        $filename = sprintf( 'export_%s.xls', date('Y_m_d_H_i_s', strtotime('now')) );
        return $this->getResponse('xls', $filename, $arraySource);
    }

    public function exportAction()
    {
        $session  = $this->get("session");        
        $entity = $session->get("selectionEntity");

        $arrayCandidatures = ArrayData::getCandidaturesData($this->get('kernel'));

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
        $dateNaissance = new \DateTime('2008-03-13');

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

        if($candidature['type_diplome'] == 'LF'){
            $score += $selection->getTypeDiplome();            
        }

        // score type système -------------------

        if($candidature['systeme'] == 'LMD'){
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

        return $score;
        //return 100;
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
                $writer      = new CsvWriter('php://output', ',', '"', "", true, true);
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

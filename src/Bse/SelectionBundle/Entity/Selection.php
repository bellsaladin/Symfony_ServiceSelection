<?php

namespace Bse\SelectionBundle\Entity;

class Selection
{

    private $faculte;

    private $filiere;

    private $age_from_18_to_22;

    private $age_from_23_to_25;

    private $duree_licence_from_3_to_4;

    private $duree_licence_from_5_to_6;

    private $duree_licence_from_7_to_8;

    private $etablissement;

    private $type_diplome_lf_ou_lp;

    private $type_diplome;

    private $type_systeme_lmd_ou_ancien;    

    private $type_systeme;

    private $mention_assezbien;

    private $mention_bien;

    private $mention_tresbien;

    private $noteM1;

    private $noteM2;

    private $noteM3;

    private $noteM4;

    private $noteM5;

    private $noteM6;

    private $noteM1From5To10;  private $noteM1From10To15;  private $noteM1From15To20;

    private $noteM2From5To10;  private $noteM2From10To15;  private $noteM2From15To20;

    private $noteM3From5To10;  private $noteM3From10To15;  private $noteM3From15To20;

    private $noteM4From5To10;  private $noteM4From10To15;  private $noteM4From15To20;

    private $noteM5From5To10;  private $noteM5From10To15;  private $noteM5From15To20;

    private $noteM6From5To10;  private $noteM6From10To15;  private $noteM6From15To20;


    public function getFaculte(){
        return $this->faculte;
    }

    public function setFaculte($faculte){
        $this->faculte = $faculte;
        return $this;
    }

    public function getFiliere(){
        return $this->filiere;
    }

    public function setFiliere($filiere){
        $this->filiere = $filiere;
        return $this;
    }

    public function getAgeFrom18to22(){
        return $this->age_from_18_to_22;
    }

    public function setAgeFrom18to22($ageFrom18to22){
        $this->age_from_18_to_22 = $ageFrom18to22;
        return $this;
    }

    public function getAgeFrom23to25(){
        return $this->age_from_23_to_25;
    }

    public function setAgeFrom23to25($ageFrom23to25){
        $this->age_from_23_to_25 = $ageFrom23to25;
        return $this;
    }

    public function getDureeLicenceFrom3to4(){
        return $this->duree_licence_from_3_to_4;
    }

    public function setDureeLicenceFrom3to4($value){
        $this->duree_licence_from_3_to_4 = $value;
        return $this;
    }

    public function getDureeLicenceFrom5to6(){
        return $this->duree_licence_from_5_to_6;
    }

    public function setDureeLicenceFrom5to6($value){
        $this->duree_licence_from_5_to_6 = $value;
        return $this;
    }

    public function getDureeLicenceFrom7to8(){
        return $this->duree_licence_from_7_to_8;
    }

    public function setDureeLicenceFrom7to8($value){
        $this->duree_licence_from_7_to_8 = $value;
        return $this;
    }

    public function getTypeDiplome(){
        return $this->type_diplome;
    }

    public function setTypeDiplome($typeDiplome){
        $this->type_diplome = $typeDiplome;
        return $this;
    }

    public function getTypeDiplomeLFouLP(){
        return $this->type_diplome_lf_ou_lp;
    }

    public function setTypeDiplomeLFouLp($value){
        $this->type_diplome_lf_ou_lp= $value;
        return $this;
    }

    public function getTypeSysteme(){
        return $this->type_systeme;
    }

    public function setTypeSysteme($typeSysteme){
        $this->type_systeme = $typeSysteme;
        return $this;
    }

    public function getTypeSystemeLMDouAncien(){
        return $this->type_systeme_lmd_ou_ancien;
    }

    public function setTypeSystemeLMDouAncien($value){
        $this->type_systeme_lmd_ou_ancien = $value;
        return $this;
    }

    public function getEtablissement(){
        return $this->etablissement;
    }

    public function setEtablissement($etablissement){
        $this->etablissement = $etablissement;
        return $this;
    }

    public function getMentionAssezBien(){
        return $this->mention_assezbien;
    }

    public function setMentionAssezBien($value){
        $this->mention_assezbien = $value;
        return $this;
    }

    public function getMentionBien(){
        return $this->mention_bien;
    }

    public function setMentionBien($value){
        $this->mention_bien = $value;
        return $this;
    }

    public function getMentionTresBien(){
        return $this->mention_tresbien;
    }

    public function setMentionTresBien($value){
        $this->mention_tresbien = $value;
        return $this;
    }

   
    public function getnoteM1From5To10(){
        return $this->noteM1From5To10;
    }

    public function setNoteM1From5To10($value){
        $this->noteM1From5To10 = $value;
        return $this;
    }

    public function getnoteM1From10To15(){
        return $this->noteM1From10To15;
    }

    public function setNoteM1From10To15($value){
        $this->noteM1From10To15 = $value;
        return $this;
    }

    public function getnoteM1From15To20(){
        return $this->noteM1From15To20;
    }

    public function setNoteM1From15To20($value){
        $this->noteM1From15To20 = $value;
        return $this;
    }



    public function getnoteM2From5To10(){
        return $this->noteM2From5To10;
    }

    public function setNoteM2From5To10($value){
        $this->noteM2From5To10 = $value;
        return $this;
    }

    public function getnoteM2From10To15(){
        return $this->noteM2From10To15;
    }

    public function setNoteM2From10To15($value){
        $this->noteM2From10To15 = $value;
        return $this;
    }

    public function getnoteM2From15To20(){
        return $this->noteM2From15To20;
    }

    public function setNoteM2From15To20($value){
        $this->noteM2From15To20 = $value;
        return $this;
    }


    
    public function getnoteM3From5To10(){
        return $this->noteM3From5To10;
    }

    public function setNoteM3From5To10($value){
        $this->noteM3From5To10 = $value;
        return $this;
    }

    public function getnoteM3From10To15(){
        return $this->noteM3From10To15;
    }

    public function setNoteM3From10To15($value){
        $this->noteM3From10To15 = $value;
        return $this;
    }

    public function getnoteM3From15To20(){
        return $this->noteM3From15To20;
    }

    public function setNoteM3From15To20($value){
        $this->noteM3From15To20 = $value;
        return $this;
    }



    public function getnoteM4From5To10(){
        return $this->noteM4From5To10;
    }

    public function setNoteM4From5To10($value){
        $this->noteM4From5To10 = $value;
        return $this;
    }

    public function getnoteM4From10To15(){
        return $this->noteM4From10To15;
    }

    public function setNoteM4From10To15($value){
        $this->noteM4From10To15 = $value;
        return $this;
    }

    public function getnoteM4From15To20(){
        return $this->noteM4From15To20;
    }

    public function setNoteM4From15To20($value){
        $this->noteM4From15To20 = $value;
        return $this;
    }



    public function getnoteM5From5To10(){
        return $this->noteM5From5To10;
    }

    public function setNoteM5From5To10($value){
        $this->noteM5From5To10 = $value;
        return $this;
    }

    public function getnoteM5From10To15(){
        return $this->noteM5From10To15;
    }

    public function setNoteM5From10To15($value){
        $this->noteM5From10To15 = $value;
        return $this;
    }

    public function getnoteM5From15To20(){
        return $this->noteM5From15To20;
    }

    public function setNoteM5From15To20($value){
        $this->noteM5From15To20 = $value;
        return $this;
    }



    public function getnoteM6From5To10(){
        return $this->noteM6From5To10;
    }

    public function setNoteM6From5To10($value){
        $this->noteM6From5To10 = $value;
        return $this;
    }

    public function getnoteM6From10To15(){
        return $this->noteM6From10To15;
    }

    public function setNoteM6From10To15($value){
        $this->noteM6From10To15 = $value;
        return $this;
    }

    public function getnoteM6From15To20(){
        return $this->noteM6From15To20;
    }

    public function setNoteM6From15To20($value){
        $this->noteM6From15To20 = $value;
        return $this;
    }



}

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

    public function getNoteM1(){
        return $this->noteM1;
    }

    public function setNoteM1($noteM1){
        $this->noteM1 = $noteM1;
        return $this;
    }

    public function getNoteM2(){
        return $this->noteM2;
    }

    public function setNoteM2($noteM2){
        $this->noteM2 = $noteM2;
        return $this;
    }

    public function getNoteM3(){
        return $this->noteM3;
    }

    public function setNoteM3($noteM3){
        $this->noteM3 = $noteM3;
        return $this;
    }

    public function getNoteM4(){
        return $this->noteM4;
    }

    public function setNoteM4($noteM4){
        $this->noteM4 = $noteM4;
        return $this;
    }

    public function getNoteM5(){
        return $this->noteM5;
    }

    public function setNoteM5($noteM5){
        $this->noteM5 = $noteM5;
        return $this;
    }

    public function getNoteM6(){
        return $this->noteM6;
    }

    public function setNoteM6($noteM6){
        $this->noteM6 = $noteM6;
        return $this;
    }

}

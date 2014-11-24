<?php

namespace Bse\SelectionBundle\Entity;

class Selection
{

    private $age_from_18_to_22;

    private $age_from_23_to_25;

    private $duree_licence_from_3_to_4;

    private $duree_licence_from_5_to_6;

    private $duree_licence_from_7_to_8;

    private $type_diplome;

    private $etablissement;

    private $type_systeme;

    private $mention_assezbien;

    private $mention_bien;

    private $mention_tresbien;




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

    public function getTypeSysteme(){
        return $this->type_systeme;
    }

    public function setTypeSysteme($typeSysteme){
        $this->type_systeme = $typeSysteme;
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

}

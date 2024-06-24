<?php

namespace Domain\Orders\Actions\Cart\Item;

class GetCartItemFullname
{
    /*
     *
            function getFullnamePlainText(){
                $item_name = "";
                if($this->get('label') != "") $item_name .= $this->get('label').": ";
                $item_name .= $this->get('title');
                if(count($this->get('options')) > 0 || $this->custom_fields){
                    $item_name .= " - ";
                    if(count($this->get('options')) > 0){
                        foreach($this->get('options') as $o){
                            $item_name .= $o['display'].": ";
                            for($z=0; $z < count($o['value_id']); $z++){
                                if($z > 0) $item_name .= " / ";
                                $item_name .=  $o['value_display'][$z];
                                if($o['value_custom_type'][$z] >= 0 && $o['value_custom_type'][$z] != ""){
                                    $item_name .= "-".$o['value_custom_value'][$z];
                                }
                            }
                        }
                    }
                    if($this->custom_fields){
                        $item_name .= ' - ';
                        foreach($this->custom_fields as $form_id=>$section){
                            foreach($section as $section_id=>$fields){
                                foreach($fields as $field_id=>$field){
                                    $item_name .= $field['display'].': '.$field['value'].'; ';
                                }
                            }
                        }
                    }
                }
                return $item_name;
            }
     */
}

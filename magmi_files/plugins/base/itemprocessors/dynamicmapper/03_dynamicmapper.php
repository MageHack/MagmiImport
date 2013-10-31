<?php
/**
 * Class DynamicMapperProcessor
 * @author Szabolcs Ban
 *
 * This plugin provides value mapping for csv values before they are handled by magmi
 * dynamically by querying Magento database
 * (eav_attribute_option, eav_attribute and eav_attribute_option_value tables)
 *
 */
class DynamicMapperProcessor extends Magmi_ItemProcessor
{
    protected $_mapping;

    public function getPluginInfo()
    {
        return array(
            "name" => "Dynamic mapper",
            "author" => "Szabolcs Ban",
            "version" => "0.0.1",
            "url" => $this->pluginDocUrl("Dynamic_mapper")
        );
    }

    /**
     * you can add/remove columns for the item passed since it is passed by reference
     * @param Magmi_Engine $mmi : reference to magmi engine instance (convenient to perform database operations)
     * @param unknown_type $item : modifiable reference to item before import
     * the $item is a key/value array with column names as keys and values as read from csv file.
     * @return bool :
     * 		true if you want the item to be imported after your custom processing
     * 		false if you want to skip item import after your processing
     */
    public function processItemBeforeId(&$item,$params=null)
    {
        foreach(array_keys($item) as $k)
        {
            if(isset($this->_mapping[$k]))
            {
                if (!isset($this->_mapping[$k][$item[$k]])) {
                    continue;
                }
//                print "{$item[$k]} = {$this->_mapping[$k][$item[$k]]}<br/>";
                $item[$k]=$this->_mapping[$k][$item[$k]];
            }
        }
        return true;
    }

    /**
     * Initialize the mapping
     * @param $params
     */
    public function initialize($params)
    {
        $this->_mapping=array(
                            'status'=>array(
                                'Yes'=>1,
                                'No'=>0
                            ),
                            'visibility'=>array(
                                  "Not Visible Individually" => 1,
                                  "Catalog"=>2,
                                  "Search"=>3,
                                  "Catalog, Search"=>4
                                )
                            );

        // Escaping maybe ?
        $tprefix = $this->_magmiconfig->get("DATABASE","table_prefix");

        $res = $this->selectAll("SELECT a.attribute_code, o.option_id, v.value label FROM {$tprefix}eav_attribute_option o LEFT JOIN {$tprefix}eav_attribute a ON a.attribute_id = o.attribute_id LEFT JOIN {$tprefix}eav_attribute_option_value v ON o.option_id = v.option_id");

        foreach($res as $item)
        {
            $idx=$item['attribute_code'];
            if(!isset($this->_mapping[$idx]))
            {
                $this->_mapping[$idx]=array();
            }
            $this->_mapping[$idx][$item['label']]=$item['option_id'];
        }
    }

    static public function getCategory()
    {
        return "Input Data Preprocessing";
    }
}


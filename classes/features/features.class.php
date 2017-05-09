<?php
class OS_Features extends OS_Common
{


  /**
   *=============================================================
   * get_adress_details
   *=============================================================
   * @throws Exception
   * @return $data (array)
   */
  public function get_feature_position()
  {
    try {
      $res = $this->select("features", array("position"), "ORDER BY position DESC LIMIT 1");
      if( $res[0]['position'] ){
        $position = intval($res[0]['position'])+1;
      }else{
        $position = 1;
      }
      return $position;
    } catch (Exception $e) {
      $this->get_exception_error($e);
    }
  }


  /**
   *=============================================================
   * get_features
   *=============================================================
   * @throws Exception
   * @return $features (array)
   */
  public function get_features($id_lang)
  {
    try {
      $features = $this->select(
        "features f", 
        array("f.id", "t.name", "f.position"), 
        "LEFT JOIN `"._DB_PREFIX_."feature_trans` t ON (t.`id_feature` = f.`id` AND t.`id_lang` = $id_lang) WHERE 1 ORDER BY f.`position` ASC"
      );
      return $features;
    } catch (Exception $e) {
      $this->get_exception_error($e);
    }
  }

  /**
   *=============================================================
   * get_feature_values
   *=============================================================
   * @throws Exception
   * @return $values (array)
   */
  public function get_feature_values($id_feature, $id_lang)
  {
    try {
      $values = $this->select(
        "feature_value v", 
        array("vt.id", "vt.value", "vt.id_value" , "v.id_feature"), 
        "LEFT JOIN `"._DB_PREFIX_."feature_value_trans` vt ON (vt.`id_value` = v.`id` AND vt.`id_lang` = $id_lang) WHERE v.`id_feature`=$id_feature ORDER BY vt.`id` ASC"
      );
      return $values;
    } catch (Exception $e) {
      $this->get_exception_error($e);
    }
  }

  /**
   *=============================================================
   * get_feature_product
   *=============================================================
   * @throws Exception
   * @return $id_product (int)
   */
  public function get_feature_product($id_feature, $id_product)
  {
    try {
      $f_product = $this->select("feature_product", array("*"), "WHERE id_product=$id_product AND id_feature=$id_feature");
      return $f_product;
    } catch (Exception $e) {
      $this->get_exception_error($e);
    }
  }



/*============================================================*/
} //END PRODUCT CLASS
/*============================================================*/
?>
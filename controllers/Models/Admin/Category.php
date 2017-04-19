<?php
/**
 * 2016 OkadShop
 * Open source ecommerce software
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade OkadShop to newer
 * versions in the future. If you wish to customize OkadShop for your
 * needs please refer to http://www.okadshop.com for more information.
 *
 * @author    OKADshop <contact@okadshop.com>
 * @copyright 2016 OKADshop
 */
namespace Core\Models\Admin;

use Core\Image;
use Core\Media;
use Core\Session;
use Core\i18n\Language;
use Core\Models\Model;

class Category extends Model
{

	public $args = [
        'multilangues' => [
            [
                'table' => [
                    'c' => 'categories'
                ],
                'table_trans' => [
                    'ct' => 'category_trans'
                ],
                'foreign_key' => 'id_category'
            ]
        ],
        'columns' => [
            '*' => ['c', 'ct'],
            't2' => [
                'name' => 'parent_name'
            ]
        ],
        'joins' => [
            [
                'type' => 'LEFT JOIN',
                'table' => [
                    't2' => 'category_trans'
                ],
                'relation' => '(t2.id_category = c.id_parent AND ct.id_lang=t2.id_lang)'
            ]
        ]
    ];


	public function getCategoryTrans($args)
    {
        return $this->getByID($args['id_category'], $args['id_lang']);
    }


    public function getCategories($id_lang=null)
    {
        if( !is_null($id_lang) ) {
            $this->args['id_lang'] = $id_lang;
        }
        return getDB()->trans($this->args);
    }

    public function getByID($id_category, $id_lang=null)
    {
        $this->args['conditions'][] = [
            'key' => 'c.id',
            'value' => $id_category,
            'operator' => '=',
            'relation' => 'AND'
        ];
        $this->args['limit'] = 1;
        if( !is_null($id_lang) ) {
            $this->args['id_lang'] = $id_lang;
        }
        return getDB()->trans($this->args);
    }
    

    public function create($data)
    {
        // Get Database instance
        $db = getDB();

        // Category columns
        $cat_columns = $data['category'];
        $cat_columns['id_lang'] = $data['id_lang'];
        $cat_columns['position'] = $db->getMax('categories', 'position') + 1;
        if( !isset($data['category']['active']) ) $cat_columns['active'] = 0;

        // Create new category
        $id_category = $db->create('categories', $cat_columns);
        if( $id_category ) {
            $trans_columns = $data['trans'];
            $trans_columns['id_lang'] = $data['id_lang'];
            $trans_columns['id_category'] = $id_category;
            $this->createTrans($trans_columns);
            return $id_category;
        }
        return false;
    }

    public function update($data)
    {
        if( !isset($data['id_lang']) )
            return false;

        // Get Database instance
        $db = getDB();
        $cat_columns = $trans_columns = array();
        $id_lang = $data['id_lang'];
        $id_category = $data['id_category'];

        // update category infos
        if( isset($data['category']) ) {
            $cat_columns = $data['category'];
            if( !isset($data['category']['active']) ) $cat_columns['active'] = 0;
            $db->update('categories', $id_category, $cat_columns);
            set_flash_message('success', trans('Category was updated.', 'cats'));
        }

        // Upload image
        if( isset($_FILES['cover']) && $_FILES['cover']['size'][0] > 0 ){
            $uploadDir = 'uploads/category/'. $id_category .'/';
            $upload = upload_medias($_FILES['cover'], array(
                'title' => $id_category ,
                'extensions' => array('jpg', 'jpeg', 'png'),
                'uploadDir' => $uploadDir
            ));
            if( isset($upload['files'][0]) ){
                $imagePath = $uploadDir . $upload['files'][0];
                $db->update('categories', $id_category, [
                    'cover' => $imagePath
                ]);

                \Core\Image::resizeImage(site_base($imagePath), ['140x35', '237x65']);

                set_flash_message('success', trans('Cover was updated.', 'cats'));
            }
        }

        // Update category trans
        if( isset($data['trans']) ) {
            $trans_columns = $data['trans'];

            if( $id_trans = $this->transExists($id_category, $id_lang) ) {
                $trans_columns['udate'] = date("Y-m-d H:i:s");
                $db->update('category_trans', $id_trans, $trans_columns);
                set_flash_message('success', trans('Category was updated.', 'cats'));
            } else {
                $trans_columns['id_lang'] = $id_lang;
                $trans_columns['id_category'] = $id_category;
                $this->createTrans($trans_columns);
                set_flash_message('success', trans('Category was created.', 'cats'));
            }
        }
    }


    public function createTrans($columns)
    {
        $date = date("Y-m-d H:i:s");
        $columns['meta_title'] = $columns['name']; 
        $columns['meta_description'] = $columns['description']; 
        $columns['meta_keywords'] = str_replace(' ', ', ', $columns['description']); 
        $columns['link_rewrite'] = slugify($columns['name']); 
        $columns['cdate'] = $date; 
        $columns['udate'] = $date;
        return getDB()->create('category_trans', $columns);
    }


    public function transExists($id_category, $id_lang)
    {
        $trans = getDB()->findByColumns('category_trans', [
            [
                'key' => 'id_category',
                'value' => $id_category,
                'condition' => 'AND'
            ],
            [
                'key' => 'id_lang',
                'value' => $id_lang,
                'condition' => 'AND'
            ]
        ], ['id'], true);
        return (isset($trans->id)) ? $trans->id : 0;
    }




// END Class
}
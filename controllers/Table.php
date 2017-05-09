<?php
namespace Core;

use Core\Controllers\Controller;
use Core\Security;

class Table extends Controller
{
    public $select;
    public $from;
    public $order;
    public $limit;
    public $where;
    public $ID;
    public $operations;
    public $IMGFolder;
    public $table;
    public $Module;
    public $DataHeader;
    public $DHFE;
    public $DHOUT;
    public $DH;
    public $UPLOADER;
    public $Seeker;
    public $SeekerKeys;
    public $DIR;
    public $PICFIELD;
    public $PICEXT;
    public $PICICON;
    public $PICLBL;
    public $DB;
    public $join;
    public $SQL_select;


    public function GET($Args)
    {

        if(isset($Args['Butons'][0][0]) && isset($Args['Butons'][0][1]))
        {
            $button_add_title = $Args['Butons'][0][0];
            $button_add_link = $Args['Butons'][0][1];
        }

        $Title = $Args['Module'][1];

        $HEADERTABLE = $Args['THead'];
        $MODULE = $Args['Module'][0];

        $TBLHeader = '';
        foreach($HEADERTABLE as $DATATABLE_EL)
        {
            $TBLHeader .= '{"title":"'.$DATATABLE_EL.'"},';   
        }

        $HEADERTABLE = substr($TBLHeader,0,strlen($TBLHeader)-1);
        $MODULE = $MODULE[0];

    ?>
    <script>
    $(document).ready(function(){
        var asInitVals = new Array();
        //plugin pur charger le tableau
        var UploadOperation = new Array();
        var DeleteOperation = new Array();
        var EditOperation = new Array();
        var Table = $(".datatables").dataTable({
            "iDisplayLength": 15,
            "bSort" : true,
            "order": [],
            "aLengthMenu": [[15, 50, 100, 200, 300, -1], [15, 50, 100, 200, 300, "All"]],
            "sPaginationType": "full_numbers",
            "columns" : [<?php echo $HEADERTABLE; ?>],
            "data" : [<?php self::GET_DATA($Args); ?>],
            "language": {
              "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/<?=(!empty($_SESSION['dt_lang']) ? $_SESSION['dt_lang'] : 'French');?>.json"
            }
        });//fin plugin datatable
        Table.fnSort( [ [0,'desc'] ] );
    });//fin instance jquery
    </script>


    
    <div class="top-menu padding0">

        <div class="top-menu-title">
            <h3><i class="fa fa-tags"></i> <?php if(isset($Title)){echo $Title;}?></h3>
        </div>
        <?php
        if(isset($button_add_link)){
        ?>
        <div class="top-menu-button">
            <button type="button" class="btn btn-primary add-product" onclick="window.location = '<?php if(isset($button_add_link)){echo $button_add_link;}?>';"><?php if(isset($button_add_title)){echo $button_add_title;}?></button>
        </div>
        <?php
        }
        ?>

    </div>
    <div class="table-responsive">
    <table cellpadding="0" cellspacing="0" border="0" id="" class="datatables table table-bordered" id="datatable"></table>
    </div>

    <?php
    }

    public function GET_DATA($Args)
    {
            $Security = new Security();

            //$DB = new Database();
            //extract select
            $this->select = $Args['Select'];
            //extract from
            $this->from = $Args['From'][0];
            $WHERE = isset($Args['Where']) ? $Args['Where'] : '';
            $ORDER = isset($Args['Order']) ? $Args['Order'] : '';
            //extract where
            if(!empty($WHERE))
            {
                $this->where = 'where';
               foreach($WHERE as $where_e => $where_k)
               {

                    $this->where .= ' '.$where_k[0].$where_k[1].$where_k[2];
               }
            }else{
                    $this->where='';
            }
            //join
            $Join = isset($Args['Join']) ? $Args['Join'] : '';

            for($i=0;$i<=count($Join);$i++)
            {
                //echo $Join[$i];
            }
            if(!empty($Join))
            {
                $this->join = '';
               foreach($Join as $Join_e => $Join_k)
               {
                
                    //echo 'hello '.count($Join_k);

                    if(!empty($Join_k[3]))
                    {
                        if(in_array($Join_k[3], array('left','right','inner','full')))
                        {
                            $join_type = $Join_k[3];    
                        }else{
                            $join_type = 'inner';
                        }
                    }else{
                        $join_type = 'inner';
                    }
                    if(count($Join_k) == 4)
                    {
                        $this->join .= $join_type.' join '.$Join_k[0].' on ('.$Join_k[1].' = '.$Join_k[2].') ';   //as '.$Join_k[2].'  
                    }else{
                        $this->join .= $join_type.' join '.$Join_k[0].' on ('.$Join_k[1].' = '.$Join_k[2].') ';
                    }
               }
            }else{
                    $this->join = '';
            }

            //echo $this->join;
            //echo $this->join;
            //die();
    ///upload des images
            $this->UPLOADER = $Args['UPLOADFIELDS'];
    ///extract IMGFolder
            //$this->IMGFolder = $IMGFolder;
    ///extract operations
            $this->operations = $Args['Operations'];
    ///extract table
            $this->table = $Args['From'][0];
    ///extract module name
            $this->Module = $Args['Module'][0];

            /*
            $SQL = "select access_list.access_name from access,module_list,access_list where id_grusers = $USER or id_grusers in (select id_group from users_groups where users_groups.id_user = $USER ) and access.id_accesslist = access_list.id_alist and access.id_module = module_list.id_mlist and module_list.name = '$MODULE' group by access_name";
            $this->RES  = $DB->pdo->Query($SQL);
            $Rights = array();
            while($this->ROW = $DB->pdo->FArray($this->RES))
            {
                array_push($Rights, $this->ROW[0]);
            }
            */
            /* Paging */
            $sLimit = "";
            if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
            {
                    $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );
            }

            /* Ordering */
            $sOrder = "";
            
            if ( !empty($ORDER) )
            {
                    $sOrder = "";
                    /**/
                    $sOrder .= "ORDER BY  ".$ORDER;
                    /*
                    for ( $i=0 ; $i<mysql_real_escape_string( $_GET['iSortingCols'] ) ; $i++ )
                    {
                            $sOrder .= fnColumnToField(mysql_real_escape_string( $_GET['iSortCol_'.$i] ))."
                                    ".mysql_real_escape_string( $_GET['iSortDir_'.$i] ) .", ";
                    }
                    */
                    //$sOrder = substr_replace( $sOrder, "", -2 );
                    
            }

        
            if(isset($this->select))
            {
                foreach($this->select as $Select_e=>$Select_k)
                {

                    $this->SQL_select .= ','.$Select_k.' as '.$Select_e;
                }

                $this->SQL_select = substr($this->SQL_select, 1);
                //die($this->SQL_select);
                $sQuery = "SELECT $this->SQL_select FROM $this->from $this->join $this->where $sOrder $sLimit";
            }else{
                $sQuery = "$this->SQL_select FROM $this->from $this->join $this->where $sOrder $sLimit";
            }
            if(isset($_GET['die']))
            {
                die($sQuery);    
            }
            //$DB = Database::getInstance();
            if(!($rResult = $this->db->pdo->query($sQuery)))
            {
                    
                    die('Request Error');
            }
            //echo $sQuery;

            $sQuery = "SELECT FOUND_ROWS() as count";
            $rResultFilterTotal = $this->db->pdo->query( $sQuery);
            $aResultFilterTotal = (array)$rResultFilterTotal->fetch();
            // $iFilteredTotal = $aResultFilterTotal[0];
            $iFilteredTotal = $aResultFilterTotal['count'];

            $sQuery = "SELECT COUNT(*) as count FROM $this->table";
            $rResultTotal = $this->db->pdo->query( $sQuery);
            $aResultTotal = (array)$rResultTotal->fetch();
            // var_dump($aResultTotal);
            // $iTotal = $aResultTotal[0];
            $iTotal = $aResultTotal['count'];


            if(empty($_GET['sEcho']))
            {
                    $sEcho=1;
            }else{
                    $sEcho=$_GET['sEcho'];
            }
            $sOutput = '';
        $count =0;
        $aRows = $rResult->fetchAll();//to convert object to array
        $i = 0;

        foreach($aRows as $aRow)
        {      
            $aRow = (array)$aRow;   
            $count++;
            $sOutput .= "[";
            foreach($this->select as $Select_e=>$Select_k)
            {

                if($i == 0)
                {
                    $this->ID = stripslashes($Select_e);
                    $this->IDV= stripslashes($aRow[$Select_e]);
                    $this->FID = stripslashes($Select_e);
                }
                $i++;

                    
                $f = $Select_e;
                //check this please         
                if($f == 'content' || $f == 'short_text' /*|| strstr($f,'description')*/)
                {//

                }

                elseif(strstr($f,'active')){
                    $this->FIELD = $f;                                                                                          
                    if(preg_match('/\./',$f))
                    {
                        $f= split('[\.]',$f);
                        $f = $f[1];
                        $f = trim(stripslashes($aRow["$f"]));
                    }else{
                        $f = trim(stripslashes($aRow["$f"]));
                    }   
                    if($f ==1){
                        $sOutput .= '"<i class=\"fa fa-check\" aria-hidden=\"true\" title=\"'. l("activé", "core") .'\"></i>",';
                        //$sOutput .= '"<img src=\"images/hp.png\" name=\"'.$this->FIELD.'_'.$this->FID.'\" class=\"'.$this->table.'\" title=\"'.str_replace('(select ','',$this->ID).'\" value=\"1\" >",';   
                    }else{
                        //$sOutput .= '"<img src=\"images/no_hp.png\" name=\"'.$this->FIELD.'_'.$this->FID.'\" class=\"'.$this->table.'\" title=\"'.str_replace('(select ','',$this->ID).'\" value=\"0\" >",';
                        $sOutput .= '"<i class=\"fa fa-close\" aria-hidden=\"true\" title=\"'. l("desactivé", "core") .'\"></i>",';
                    }

                }elseif($f == 'img_src' ){
                      $url = $aRow["$f"];              
                      //$handle = @fopen($url,'r');            
                      //if($handle !== false){             
                        $sOutput .= '"<img src=\"'.$aRow["$f"].'\" style=\"width:25px;height:25px\" class=\"link\">",';                               
                }elseif($f == 'hexa' ){  
                    $sOutput .= '"<font style=\"color:#'.$aRow["$f"].'\">'.$aRow["$f"].'</font>",';                               
                }elseif(strstr($f ,'picture') || strstr($f ,'file')){
                    if(file_exists($aRow[$f]))
                    {
                        switch (substr($aRow[$f],-4))
                        {
                            case '.pdf' : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"'. l("Télécharger le fichier", "core") .'\"><img class=\"link\" src=\"'.$aRow[$f].'\" width=\"60px\"></a>",';
                                break;
                            case '.jpg' : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"'. l("Télécharger le fichier", "core") .'\"><img class=\"link\" src=\"'.$aRow[$f].'\" width=\"60px\"></a>",';
                                break;
                            case 'jpeg' : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"'. l("Télécharger le fichier", "core") .'\"><img class=\"link\" src=\"'.$aRow[$f].'\" width=\"60px\"></a>",';
                                break;
                            case '.png' : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"'. l("Télécharger le fichier", "core") .'\"><img class=\"link\" src=\"'.$aRow[$f].'\" width=\"60px\"></a>",';
                                break;
                            default : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"'. l("Télécharger le fichier", "core") .'\">'. l("Télécharger", "core") .'</a>",';
                        }
                    }else{
                        $sOutput .= '"'.$aRow[$f].'",';
                        //$sOutput .= '"<img class=\"link\" src=\"images/fileerror.png\" title=\"'. l("Fichier introuvable", "core") .'\">",';
                    }
                                    
                }elseif($f == 'order'){
                    if($count == 1){
                        $sOutput .='"<img name=\"'.$aRow["order"].'\" id=\"'.$this->FID.'\" src=\"images/order_bottom.png\" title=\"'. l("Deplacer en bas", "core") .'\" class=\"Displace '.$this->table.'\">",';                                  
                    }else if($count == $iTotal){
                        $sOutput .= '"<img name=\"'.$aRow["order"].'\" id=\"'.$this->FID.'\" src=\"images/order_top.png\" title=\"'. l("Deplacer en haut", "core") .'\" class=\"Displace '.$this->table.'\">",';                           
                    }else{
                        $sOutput .= '"<img name=\"'.$aRow["order"].'\" id=\"'.$this->FID.'\" src=\"images/order_bottom.png\" title=\"'. l("Deplacer en bas", "core") .'\" class=\"Displace '.$this->table.'\">&nbsp&nbsp'.
                                    '<img name=\"'.$aRow["order"].'\" id=\"'.$this->FID.'\" src=\"images/order_top.png\" title=\"'. l("Deplacer en haut", "core") .'\" class=\"Displace '.$this->table.'\">",';                            
                    }                 

                }else{
                    $sOutput .= '"'.addslashes($aRow[$f]).'",';
                } 
            }

            if(count($this->operations) != 0)
            {
                $sOutput .= '"';
                if(in_array('edit',$this->operations))
                {
                    $sOutput .= '<a rel=\"facebox\" href=\"?module='.$this->Module.'&action=edit&id='.$aRow[$this->FID].'\" class=\"btn btn-default btn-xs\" title=\"'. l("Editer", "core") .'\">'. l("Edit", "core") .'</a>';
                }

                if(in_array('view',$this->operations))
                {
                    $sOutput .= '<a href=\"?module='.$this->Module.'&action=view&id='.$aRow[$this->FID].'\" class=\"btn btn-default btn-xs \"  title=\"'. l("View", "core") .'\">'. l("View", "core") .'</a>';
                }
                if(in_array('download',$this->operations))
                {
                    $sOutput .= '<a href=\"?module='.$this->Module.'&action=invoice&id='.$aRow[$this->FID].'\" class=\"btn btn-default btn-xs\" title=\"'. l("Invoice", "core") .'\">'. l("Invoice", "core") .'</a>';
                }
                if(in_array('invoice',$this->operations))
                {
                    $sOutput .= '<a href=\"?module='.$this->Module.'&action=invoice&id='.$aRow[$this->FID].'\" class=\"btn btn-default btn-xs\" title=\"'. l("Download", "core") .'\">'. l("Download", "core") .'</a>';
                }
                if(in_array('delete',$this->operations) || in_array('DELETE',$this->operations))
                {
                    $sOutput .= '<a href=\"?module='.$this->Module.'&action=delete&id='.$aRow[$this->FID].'\" class=\"btn btn-default btn-xs DELETE\" onclick=\"DeleteElement(\''.site_url().$this->Module.'\','.$aRow[$this->FID].')\" title=\"'. l("Delete", "core") .'\">'. l("Delete", "core") .'</a>';
                }

                $sOutput .= '"],';
            }else{
                $sOutput = substr_replace( $sOutput, "", -1 );
                $sOutput .= '],';
            }   
        }
        $sOutput = substr_replace( $sOutput, "", -1 );

        echo $sOutput;
    }
   
}
?>
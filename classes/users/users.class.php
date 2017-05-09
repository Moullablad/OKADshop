<?php
class OS_User
{
	private $m_id;
	private $m_firstname;
	private $m_lastname;
	private $m_mail;
	private $m_pwd;
	private $sexe;
    private $day;
    private $month;
    private $year;
    private $birthday;
	
	private $logged_in = false;
								
	public function __construct()
	{
		//echo 11;
            //$DB = Database::getInstance();
	}
	
	public function __set($c,$v)
	{
		if($c == "m_mail" AND !user::userExist("user_mail = '".$v."'"))
			$this->{$c} = $v;
		else if($c == "m_pwd")
			$this->{$c} = md5($v);
		else if($c != "m_mail" and $c != "m_pwd")
			$this->{$c} = $v;
	}
        
	public static function delete(&$objet)
	{
		if($GLOBALS['DB']->exec("DELETE FROM "._DB_PREFIX_."user WHERE user_id = '".$objet->m_id ."' ;"))
		{
			$objet = null;
			return true;
		}
		else
			return false;
	}

	public static function getByID($user)
	{
            $DB = Database::getInstance();
            $query = "SELECT * FROM "._DB_PREFIX_."users WHERE id = $user";
            
            if($res = $DB->pdo->query($query))
            {
                if($res->rowCount() == 1)
                {
                    $row = $res->fetch();
                    //var_dump($row);
                    return array('Username'=>$row['username']);
                }
            }
	}
    public static function getEmailByID($user)
    {
            $DB = Database::getInstance();
            $query = "SELECT email FROM "._DB_PREFIX_."users WHERE id = $user";
            if($res = $DB->pdo->query($query))
            {
                if($res->rowCount() == 1)
                {
                    $row = $res->fetch();
                    return $row['email'];
                }
            }
    }    
	public static function getByEmail($email)
	{
            $DB = Database::getInstance();
            $query = "SELECT * FROM "._DB_PREFIX_."users WHERE email = '$email'";
            if($res = $DB->pdo->query($query))
            {
                if($res->rowCount() == 1)
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                    return false;
            }
	}
	public static function UList()
    {
       $DB = Database::getInstance();
        $query = "SELECT * FROM "._DB_PREFIX_."users";
        if($res = $DB->pdo->query($query))
        {
            $res->fetchAll();
            return;
        }
    }
	public static function login($email,$password)
	{

            $DB = Database::getInstance();
            $password = md5($password);
            try
            {
                $query = "SELECT id FROM "._DB_PREFIX_."users WHERE email = '$email' AND password = '$password' AND user_type = 'admin' ";
                if($res = $DB->pdo->query($query))
                {
                    if($res->rowCount() > 0)
                    {
                        $row = $res->fetch();
                        $_SESSION['admin'] = $row['id'];
                    }
                    access_dashboard();
                }else {
                    echo "DB error";
                }
            }
            catch(PDOException $e)
            {
                return $e->getMessage();
            }
	}
	
	public static function userExist($condition)
	{
		try
		{
			if($res = $GLOBALS['DB']->query("SELECT * FROM "._DB_PREFIX_."user WHERE ".$condition." ;"))
			{
				if($res->rowCount() >= 1)
				{
					$row = $res->fetchAll();
					return user::getByID($row[0]['id']);
				}
				else
					return false;
			}
			else
				return false;
		}
		catch(PDOException $e)
		{
			$e->getMessage();
			return false;
		}
	}

    public static function getCurrentUserName()
    {
        $CUser = self::getByID($_SESSION['admin']);
        echo 'Hello '.$CUser['Username'];
    }
	
	public static function controlConnection($user,$ip_client)
	{
		if($user = user::userExist("user_mail = '".$user->m_mail ."' AND user_pwd = '".$user->m_pwd ."' AND user_ip = '".$ip_client."' AND type_user_id <> '0' "))
			return $user;
		else
			return false;
	}
	
	// My Custom method
    public function create($UType,$Username,$Email,$PWD) 
    {
            $DB = Database::getInstance();
            $Security = new Security();
//            die($_POST['email']);
                $this->UType = $UType;//$_POST['prenom'];
                $this->Username = $Username;//$_POST['nom'];
 
                $this->Email = $Email;//$_POST['email'];
                $this->PWD = md5($PWD/*$_POST['password']*/);

                
                $this->sexe = 0;//$_POST['sexe'];

                /*
                $this->day = $_POST['day'];
                $this->month = $_POST['month'];
                $this->year = $_POST['year'];
                if($Security->check_numbers($this->day) && $Security->check_numbers($this->month) && $Security->check_numbers($this->year))
                {
                    $this->birthday = $this->year.'-'.$this->month.'-'.$this->day;
                }else{
                    die('birthday error');
                }
                */
                /*
		if($this->sexe == 'Homme')
        {
            $this->sexe = 1;
        }elseif($this->sexe == 'Femme')
        {
            $this->sexe = 1;
        }else{
            die('sexe error');
        }
        */
        if($this->getByEmail($this->m_mail))
        {
            die('une compte existe li&eacute;  avec cet email existe d&eacute;j&agrave;');
        }

            
            $sql = "INSERT INTO "._DB_PREFIX_."users (username,type,email,password,cdate) VALUES(:type,:username,:email,:password,now())";
            //echo $sql;
            $sth = $DB->pdo->prepare($sql);
            
            $sth->bindParam(':type', $this->UType);
            $sth->bindParam(':username', $this->Username);
            $sth->bindParam(':email', $this->Email);
            $sth->bindParam(':password', $this->PWD);
            
            //note we can't add a user several times so we need to add try catch and see what the return because if user is duplicated its not inserting.
            if(!empty($this->Email))
            {
				try {
                    $sth->execute();
					if($DB->pdo->lastInsertId("id") > 0)
					{
                        $_SESSION['admin'] = $DB->pdo->lastInsertId("id");
                        //if(true) you need to create session and just reload page to show information of user subscribed


                        /*
                        $headers  = "Reply-To: contact <contact@gridinc.fr>\r\n"; 
                        $headers .= "Return-Path: contact@gridinc.fr <contact@gridinc.fr>\r\n"; 
                        $headers .= "From: Grid <contact@".$_SERVER['HTTP_HOST'].">\r\n"; 


                        $headers .= "Content-type: text/html\r\n";
                        $headers .= "Organization: grid.cool\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        $headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
                        $headers .= "X-Priority: 3\r\n";
                        $headers .= "X-Mailer: PHP". phpversion() ."\r\n";

                        $subject = "Bienvenu ".$this->m_firstname;
                        
                        $Message = "<center>".$this->m_firstname.",<br><br>";

                        $Message .= 'Nous avons le plaisir de vous accueillir sur grid.<br>';
                        $Message .= 'Vous pouvez désormais vous connecter sur <a href="http://grid.cool" target="_blank">grid.cool</a>.<br>';
                        $Message .= 'Bienvenu dans le monde des personnes actives !<br>';
                        $Message .= '<br><br><br></center>';
                        $Message .= '<p style="text-align:left">email: '.$this->m_mail.'<br>mot de passe: '.$this->m_pwd.'</p><br>';
                        $Message .= 'Voici un petit récapitulatif pour mieux vous éclairer à propos de notre projet:<br><br>';
                        $Message .= 'Grid connecte les personnes à travers des échanges utiles à la réflexion et au développement de son activité.<br><br>';
                        $Message .= 'Comment ça marche ?<br><br>';

                        $Message .= 'Vous choisissez votre activité et le lieu où vous l’exercez.<br>';
                        $Message .= 'Vous pouvez ensuite commencer à écrire des articles très complets (un titre, un à propos, 10 images, 10 paragraphes) et composer l’ordre d’apparition de ces médias avec une dragtool.<br>';
                        $Message .= 'Une fois publié, l’article atterri dans un flux d’actualité où sont regroupés tous les articles des utilisateurs. Ce flux d’actualité va pouvoir ensuite se diviser en dizaines de milliers de flux plus ou moins précis grâce à un outil de filtre.<br>';
                        $Message .= 'L’utilisateur choisit de visiter le flux d\'articles qu’il souhaite.<br><br>';

                        $Message .= '<i>exemples:</i><br><br>';

                        $Message .= 'Professionnel -> Ingénieur -> Paris -> France<br>';
                        $Message .= 'S’afficheront les articles des ingénieurs de paris.<br>';
                        $Message .= 'Professionnel -> Ingénieur -> Tous -> Tous<br>';
                        $Message .= 'S’afficheront les articles des ingénieurs du monde entier.<br>';
                        $Message .= 'Ceci pour toutes les activités existantes et tous les lieux du globe.<br><br>';
                        $Message .= 'Amusez-vous bien et n’hésitez pas à nous contacter à propos de n’importe quel sujet !<br><br>';
                        $Message .= 'L’équipe<br><br>';
                        $Message .= '<hr><br>';
                        $Message .= '<a href="http://grid.cool" target="_blank">grid.cool</a> - be part of the active*<br><br>';


                        if(mail($this->Email, $subject, $Message, $headers))
                        {
                            return 'sent';
                        }else{
                            return 'not sent';
                        }
                        */




                        return true;	
					}else{
						return false;
					}

				} catch (Exception $e) {
		                    echo $e->getMessage();
		                    echo $e->getLine();
		                    return false;
				}

            }else{
                    //show this message (Erreur : nous pouvons pas cr&eacute;er votre compte! veuillez verifier les champs obligatoires)
                    return false;
            }
	}
	
	public static function contact($mail) {
		
		$to = $mail['to'];
		$subject = $mail['subject'];
		$message = $mail['message'];
		$headers = $mail['headers'];
		
		if ( mail($to, $subject, $message, $headers) ) {
			return true;
		} else {
			return 0;
		}
	}
	/*
	public static function connected() {
		
		if ( isset($_SESSION['admin']) ) {
			return $_SESSION['admin'];
		} else {
			return false;
		}
	}
    */
	
	public function full_name() {
		return strtoupper($this->m_firstname).' '.strtoupper($this->m_lastname);
	}
	
	public static function logout()
    {
        session_destroy();
        echo '<script>window.location.href = "?module=Login";</script>';
        return true;
            
	}
        /*****************************/
        
        public static function getUserJob($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT jobs.name as name FROM "._DB_PREFIX_."users_jobs join "._DB_PREFIX_."jobs on ("._DB_PREFIX_."jobs.id = "._DB_PREFIX_."users_jobs.id_job) WHERE "._DB_PREFIX_."users_jobs.id_user=$user and "._DB_PREFIX_."users_jobs.deleted = 0;";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }
        public static function getUserJobId($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT "._DB_PREFIX_."jobs.id FROM "._DB_PREFIX_."users_jobs join "._DB_PREFIX_."jobs on ("._DB_PREFIX_."jobs.id = "._DB_PREFIX_."users_jobs.id_job) WHERE "._DB_PREFIX_."users_jobs.id_user=$user and "._DB_PREFIX_."users_jobs.deleted = 0;";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['id'] != null)
                {
                    return $result['id'];
                }else{
                    return '';
                }
            }
        }


        public static function getUserEducation($user)
        {
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "select id,name from "._DB_PREFIX_."educations where id =(SELECT id_education from users_educations where id_user=$user order by id desc limit 1)";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }

        public static function getUserEducationId($user)
        {
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "select id from educations where id =(SELECT id_education from users_educations where id_user=$user order by id desc limit 1)";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['id'] != null)
                {
                    return $result['id'];
                }else{
                    return '';
                }
            }
        }

        public static function getUserCity($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT cities.name as name FROM cities join users_cities on (cities.id = users_cities.id_city) WHERE users_cities.id_user=$user and users_cities.deleted=0 order by users_cities.id desc ";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }
        public static function getUserCityId($user){
            /*
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT cities.id FROM cities join users_cities on (cities.id = users_cities.id_city) WHERE users_cities.id_user=$user and users_cities.deleted=0 order by users_cities.id desc";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['id'] != null)
                {
                    return $result['id'];
                }else{
                    return '';
                }
            }
            */
        }


        public static function getUserCountry($user)
        {
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT countries.name as name,countries.id as id FROM "._DB_PREFIX_."countries join "._DB_PREFIX_."users_countries on (countries.id = users_countries.id_country) WHERE users_countries.id_user=$user  order by users_countries.id desc";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }
        public static function getUserCountryId($user)
        {
            /*
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT countries.id FROM countries join users_countries on (countries.id = users_countries.id_country) WHERE users_countries.id_user=$user  order by users_countries.id desc";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['id'] != null)
                {
                    return $result['id'];
                }else{
                    return '';
                }
            }
            */
        }

        public static function getUserSubscription($user){
            return '2013-20-21';
        }
        public static function getDefaultPicture($user){
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $DB = Database::getInstance();
                $sql = "select link from profile_pictures where id_user =$user and `default` = 1";
//                echo $sql;
                $query3=$DB->pdo->query($sql);
                $ImageRES=$query3->fetch(PDO::FETCH_ASSOC);
                if(file_exists($ImageRES['link']))
                {
                    return $ImageRES['link'];
                }else{
                    return 'images/avatar/default.png';
                }
            }
        }
        public static function getUserCityCountry($user){
            if(self::getUserCountry($user) != '')
            {
                return self::getUserCity($user).', '.self::getUserCountry($user);       
            }else{
                return self::getUserCity($user);  
            }
        }
        public static function getUserFirstLastName($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT first_name as fname,last_name as lname FROM "._DB_PREFIX_."users where id = $user";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['fname'] != null)
                {
                    return ucfirst($result['fname']).' '.ucfirst($result['lname']);
                }else{
                    return '';
                }
            }
        }
        public static function getUserFirstName($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT first_name as name FROM "._DB_PREFIX_."users where id = $user";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }
        public static function getUserLastName($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT username as name FROM "._DB_PREFIX_."users where id = $user";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['name'] != null)
                {
                    return $result['name'];
                }else{
                    return '';
                }
            }
        }


        public static function getUserType($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT type FROM "._DB_PREFIX_."users where id = $user";
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['type'] != null)
                {
                    return $result['type'];
                }else{
                    return '';
                }
            }
        }

        public static function dateOfSubscription($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT cdate as date FROM "._DB_PREFIX_."users where id = $user";
                //echo $sql;
                $query = $DB->pdo->query($sql);
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if($result['date'] != null)
                {
                    return $result['date'];
                }else{
                    return '';
                }
            }
        }
        // verify if the user is new
        public static function newUser($user){
            $DB = Database::getInstance();
            $Security = new Security();
            if($Security->check_numbers($user))
            {
                $sql = "SELECT id FROM "._DB_PREFIX_."users where DATE(cdate) = DATE(NOW()) and id = $user";
                //echo $sql;
                if($res = $DB->pdo->query($sql))
                {
                    if($res->rowCount() == 1)
                    {
                        return true;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
            }
        }


        /**
         * get countries list
         *
         */
        public function get_countries_list(){
            try {
                global $DB;
                $query = "SELECT `id`, `name` FROM `"._DB_PREFIX_."countries`";
                if($rows = $DB->pdo->query($query)){
                  $data = $rows->fetchAll(PDO::FETCH_ASSOC);
                  if(!empty($data)) return $data;
                }
            } catch (Exception $e) {
              echo "<b>ERROR AT LINE [". $e->getLine() ."] </b><br>". $e->getMessage();
            }
        }


        /**
         * get genders list
         *
         */
        public function get_genders_list(){
            try {
                global $DB;
                $query = "SELECT `id`, `name` FROM `"._DB_PREFIX_."gender`";
                if($rows = $DB->pdo->query($query)){
                  $data = $rows->fetchAll(PDO::FETCH_ASSOC);
                  if(!empty($data)) return $data;
                }
            } catch (Exception $e) {
              exit;
            }
        }



        /**
         * get groupes list
         *
         */
        public function get_users_groups_list(){
            try {
                global $DB;
                $query = "SELECT `id`, `name` FROM `"._DB_PREFIX_."users_groups`";
                if($rows = $DB->pdo->query($query)){
                  $data = $rows->fetchAll(PDO::FETCH_ASSOC);
                  if(!empty($data)) return $data;
                }
            } catch (Exception $e) {
              exit;
            }
        }

        /**
         * get groupes list
         *
         */
        public function get_addresses_list($id_user){
            try {
                global $DB;
                $query = "SELECT `id`, `name` FROM `"._DB_PREFIX_."addresses` WHERE `id_user`=$id_user";
                if($rows = $DB->pdo->query($query)){
                  $data = $rows->fetchAll(PDO::FETCH_ASSOC);
                  if(!empty($data)) return $data;
                }
            } catch (Exception $e) {
              exit;
            }
        }


        /**
         * get groupes list
         *
         */
        public function get_customer_infos($id){
            try {
                global $DB;
                $query = "SELECT * FROM `"._DB_PREFIX_."users` WHERE id=$id";
                if($rows = $DB->pdo->query($query)){
                  $data = $rows->fetch(PDO::FETCH_ASSOC);
                  if(!empty($data)) return $data;
                }
            } catch (Exception $e) {
              exit;
            }
        }


        /**
         * get groupes list
         *
         */
        public function get_company_infos($id_user){
            try {
                global $DB;
                $query = "SELECT * FROM `"._DB_PREFIX_."user_company` WHERE id_user=$id_user";
                if($rows = $DB->pdo->query($query)){
                  $data = $rows->fetch(PDO::FETCH_ASSOC);
                  if(!empty($data)) return $data;
                }
            } catch (Exception $e) {
              exit;
            }
        }


        /**
         * get groupes list
         *
         */
        public function get_addess_infos($id_addess, $id_customer){
            try {
                global $DB;
                $query = "SELECT * FROM `"._DB_PREFIX_."addresses` WHERE `id`=$id_addess AND `id_user`=$id_customer";
                if($rows = $DB->pdo->query($query)){
                  $data = $rows->fetch(PDO::FETCH_ASSOC);
                  if(!empty($data)) return $data;
                }
            } catch (Exception $e) {
              exit;
            }
        }


      /**
       *=============================================================
       * get customer number
       *=============================================================
       * @throws Exception
       */
      function get_customer_number(){
        $common  = new OS_Common();
        $last_id = $common->select("users", array('id'), "ORDER BY id DESC LIMIT 1" );
        $user_id = intval($last_id[0]['id']) + 1;
        $number  = 'CL'.sprintf("%06d", $user_id);
        return $number;
      }



      function check_required_fields($fields){
        $req_fields = array();
        foreach ($fields as $key => $field) {
          if( $field == "" ){
            array_push($req_fields, $key);
          }
        }
        if( ! empty($req_fields) ) return $req_fields;
        return false;
      }


//END CLASS
}
?>
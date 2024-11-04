<?php
namespace App\system;
use Illuminate\Support\Facades\DB;
use App;

  class membership 
{
      var     $membership_no;
      var     $password;
      var     $confirm;
      var     $id_card;
      var     $birthday;
      var     $name;
      var     $sername;
      var     $dbms  , $surname ,$shareMonthly;
      var     $email;

      //search register membership_no
      function find_register()
      {
        $sql = DB::table('sc_confirm_register')->where('membership_no',$this->membership_no)->first();
        if(count($sql) >= 1){return true;}else{return false;}
      }
      //search re_register membership_no
        function find_re_register()
      {
        // $sql = "SELECT * FROM sc_confirm_register WHERE membership_no = '$this->membership_no' and mem_id = '$this->id_card'" ;
        //  $sql=    "SELECT * FROM sc_confirm_register WHERE membership_no = '$this->membership_no' " ;
          $sql = DB::table('sc_confirm_register')->where('membership_no',$this->membership_no)->first();
          
          if(count($sql) == 0){
            return true;
          }else{
            return false;
          }
      }
        //search member
      function find_member()
      {
          $sql = DB::table('sm_mem_m_membership_registered')->where('membership_no',$this->membership_no)->first();

          if(count($sql) == 1){
            // die("T");
            return true;
          }else{
            // die("F");
            return false;
          }
      }

      // share amount
      function findShareMonthly()
      {
        $this->query_string = "SELECT IFNULL(SHARE_AMOUNT,0) AS SHARE_AMOUNT FROM sm_mem_m_share_mem WHERE membership_no = '".$this->membership_no."' LIMIT 0,1";
        if($this->query()){
          $SHARE_AMOUNT = $this->result(0,"SHARE_AMOUNT");
          if($this->num_rows() == 1){
            if((float)$this->shareMonthly == (float)$SHARE_AMOUNT)
              return true;
          }
          return false;
        }
        return false;
      }

      // member login
      function login()
      {
            $sql =  "SELECT * FROM sc_confirm_register  WHERE membership_no = '$this->membership_no'  AND mem_password = '$this->password'" ;
            $this->query_string = $sql;
            $this->query();
          if($meminfo = $this->fetch_array()){return $meminfo ;}else{return false;}
      }
      // Check  member Confirm Status
      function check_confirm()
      {
          $sql  =    "SELECT mem_confirm FROM sc_confirm_register WHERE membership_no    = '$this->membership_no' " ;
          $this->query_string = $sql;
          $this->query();
          if($this->result(0,"mem_confirm") == 1){
            return true;
          }else{
            return false;
          }
      }

      function chk_member_status()
      {
          /*$sql = "SELECT membership_no FROM sm_mem_m_membership_registered WHERE membership_no = '$this->membership_no' and member_status_code = '0'" ;
          noomsk edit 27/02/2019 สร้อยบอกว่า ลค. อยากให้เข้าได้
          */
          // $sql = "SELECT membership_no FROM sm_mem_m_membership_registered WHERE membership_no = '$this->membership_no' " ;

          $sql = DB::table('sm_mem_m_membership_registered')->where('membership_no',$this->membership_no)->first();
          if(count($sql) == 1){
            return true;
          }else{
            return false;
          }
      }

  // member Change Password
      function change_pass()
      {
          $sql = "UPDATE sm_mem_m_membership_registered SET password_o = '$this->password'   WHERE membership_no = '$this->membership_no' ";
          $sql2 = "UPDATE sc_confirm_register SET mem_password    =    '$this->password'  WHERE membership_no = '$this->membership_no' ";
          $this->query_string = $sql;
          if($this->query()){$update = true;}else{$update = false;}
          $this->query_string = $sql2 ;
          if($this->query()){$update2 =  true;}else{$update2 = false;}
          if($update && $update2){return true;}else{return false;}
      }
        // Get member detail  fill into Array()
      function get_info()
      {
          $sql        =        "SELECT * FROM sm_mem_m_membership_registered WHERE membership_no    =    '$this->membership_no' " ;
        $this->query_string = $sql ;
          if($info = $this->fetch_array()){return $info ;}else{ return false;}

      }
        // Compare Human ID Card
      function check_id_card()
      {
          $sql = DB::table('sm_mem_m_membership_registered')->where('membership_no',$this->membership_no)->first();
          if(trim($sql->ID_CARD) ==  trim($this->id_card))
          {
            return true;
          }else{
            return false;
          }

      }
        // Check member Birthday
      function check_birth_day()
      {
          
          $sql = DB::table('sm_mem_m_membership_registered')->where('membership_no',$this->membership_no)->first();
          if($sql->DATE_OF_BIRTH == $this->birthday)
          {
            return true;
          }else{
            return false;
          }
      }
      // Check member Birthday re_register
      function    check_birth_day_re_register()
      {
          // $sql        =    "SELECT date_of_birth FROM sm_mem_m_membership_registered   WHERE membership_no    = '$this->membership_no' " ;
          // $this->query_string = $sql ;
          // $this->query();
          // if($this->result(0,'date_of_birth') == $this->birthday){return true;}else{return false;}
          $sql = DB::table('sm_mem_m_membership_registered')->select('date_of_birth')->where('membership_no',$this->membership_no)->first();
          if($sql->date_of_birth == $this->birthday){
            return true;
          }else{
            return false;
          }
          
      }
      // Check Member Name
      function check_name()
      {
          //$sql = "SELECT  member_name , member_surname FROM sm_mem_m_membership_registered WHERE membership_no = '$this->membership_no' " ;
          $sql = DB::table('sm_mem_m_membership_registered')->where('membership_no',$this->membership_no)->first();
          if(trim($this->name) == trim($sql->MEMBER_NAME) && trim($this->surname) == trim($sql->MEMBER_SURNAME))
          {
            return true ;
          }else{
            return false;
          }
          
      }
        // Register Member
      function register()
      {
          // $sql    = "INSERT INTO sc_confirm_register(membership_no,mem_id,member_name,member_surname," ;
          // $sql    .= "mem_password,mem_confirm,operate_date) VALUES('$this->membership_no','$this->id_card','$this->name','$this->surname','$this->password',1,'$today')" ;
          $envsecret = config('auth.SECRET_AUTH');
          // dd($envsecret);
          $today  = date("Y-n-j H:i:s") ;
          $sql = DB::table('sc_confirm_register')
                    ->insert(
                      ['membership_no' => $this->membership_no,
                      'mem_id' => $this->id_card,
                      'member_name' => $this->name,
                      'member_surname' => $this->surname,
                        'email' => $this->email,
                        'mem_password' => hash_hmac('sha256',$this->password,$envsecret),
                      'mem_confirm' => 1,
                      'operate_date' => $today,
                      'date_of_birth' => $this->birthday
                      ]
                    );

          if(!empty($sql))
          {
            return true;
          }else{
            return false;
          }
      }
      // re_Register Member
      function re_register()
      {
          /*$today    =      date("Y-n-j H:i:s") ;
          $IP = f_get_ip();
          $sql_2        =     "INSERT INTO www_chk_reset_pwd(membership_no,member_name,member_surname,date_edit,ip_address)";
          $sql_2        .=    "VALUES('$this->membership_no','$this->name','$this->surname','$today','$IP')" ;
          $this->query_string = $sql_2;
          $this->query();*/

          // $sql = "UPDATE sc_confirm_register SET membership_no = '$this->membership_no',mem_id = '$this->id_card',member_name = '$this->name',member_surname = '$this->surname',mem_password = '$this->password' where membership_no = '$this->membership_no'" ;
          $envsecret = config('auth.SECRET_AUTH');
          $sql = DB::table('sc_confirm_register')
                      ->where('membership_no','=',$this->membership_no)
                      ->update([
                        'membership_no' => $this->membership_no,
                        'mem_id' => $this->id_card,
                        'member_name' => $this->name,
                        'member_surname' => $this->surname,
                        // 'mem_email' => $this->email,
                        'mem_password' => hash_hmac('sha256',$this->password,$envsecret)
                      ]);
          if(!empty($sql)){
            return true;
          }else{
            return false;
          }

      }
      // Check Member No.
      function chk_member_no()
      {
          $sql        =     "SELECT membership_no FROM sm_mem_m_membership_registered WHERE id_card = '$this->id_card' and date_of_birth = '$this->birthday' and member_status_code = '0'" ;
          $this->query_string = $sql;
      if($this->query()){
          $result = $this->fetch_array();
          f_message("หมายเลขสมาชิกของท่านคือ $result[membership_no]") ;
          f_goto("../../");
          return true;}else{return false;}
      }
        // Set Member Confirm Status
      function confirm()
      {
              $sql    =    "UPDATE sc_confirm_register SET mem_confirm = '$this->confirm' WHERE membership_no        =    '$this->membership_no' " ;
              $this->query_string = $sql ;
              if($this->query()){return true;}else{return false;}
      }
        //Delete Member From sc_confirm_REGISTER
          function delete()
      {
              $sql    =    "DELETE FROM sc_confirm_register WHERE membership_no = '$this->membership_no' " ;
              $this->query_string = $sql;
              if($this->query()){return true;}else{return false;}
      }

      function chk_user_group(){
          $sql = "SELECT * FROM sm_username_member_group WHERE u_mem_group = '$this->membership_no' AND p_mem_group ='$this->grouppass'";
          $this->query_string = $sql;
          $this->query();
          if($usergroupinfo = $this->fetch_array()){return $usergroupinfo;}else{return false;}
      }

      // GET MEMEBER FULL NAME
      function f_get_full_name($ag_membership_no)
      {

          //***** ใช้ SC_MEM ในการ test (แต่ตัวจริงต้องใช้ SM_MEM)*********/
          $result = DB::table('sm_mem_m_membership_registered')
                          ->join('sm_mem_m_ucf_prename','sm_mem_m_membership_registered.prename_code','=','sm_mem_m_ucf_prename.prename_code')
                          ->select('sm_mem_m_ucf_prename.prename','sm_mem_m_membership_registered.MEMBER_NAME' ,'sm_mem_m_membership_registered.MEMBER_SURNAME')
                          ->where('sm_mem_m_membership_registered.MEMBERSHIP_NO','=',$ag_membership_no)
                          ->first();

          $full_name = $result->prename.$result->MEMBER_NAME. " " .$result->MEMBER_SURNAME;         
          return $full_name;                  
      }


}

?>

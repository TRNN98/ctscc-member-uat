<?php
   class LOGON_DETAIL 
   // extends DBMS
   {
      var $identify , $seq , $ip_address  ;

      function get_last_logon()
      {

         $num_seq = DB::table('www_logon_detail')
         ->where('identify', '=', $this->identify)
         ->count();
               
         if($num_seq > 0)
         {
             $max_seq = DB::table('www_logon_detail')
             ->where('identify', '=', $this->identify)
             ->max('seq');

             if($num_seq > 6)
              {
               $seq2del = ($max_seq - 7);
               DB::delete('DELETE FROM www_logon_detail WHERE identify = ? AND seq < ? ', [$this->identify , $seq2del]);
              }
               $last_seq = ($max_seq - 1);

               $last_logon = DB::select('SELECT * FROM www_logon_detail WHERE identify = :identify AND seq = :seq ', ['identify' => $this->identify , 'seq' => $last_seq]);
       
              if ($last_logon)
              {
                return $last_logon;
              }
          }
      }
         function add_logon_detail()
         {
            
            $sql  =  "SELECT * FROM www_logon_detail WHERE identify='$this->identify' ";
            $this->query_string = $sql ;
            $this->query();
            $num_seq = $this->num_rows();
                    
         if($num_seq > 0)
         {
           $sql  =  "SELECT max(seq)  FROM www_logon_detail WHERE identify='$this->identify' " ;
           $this->query_string = $sql ;
           $this->query();
           $max_seq = $this->result(0,0) ;
           $max_seq = $max_seq+1;
           
           $today  = date("Y-m-d H:i:s");
           $sql = "INSERT INTO www_logon_detail(seq,identify,access_date,ip_address) VALUES('$max_seq','$this->identify','$today','$this->ip_address')" ;
           $this->query_string = $sql ;
           $this->query();
         }
         elseif($num_seq == 0)
         {
           $today  = date("Y-m-d H:i:s");
           $sql = "INSERT INTO www_logon_detail(seq,identify,access_date,ip_address) VALUES('1','$this->identify','$today','$this->ip_address')" ;
           $this->query_string = $sql ;
           $this->query();
         }
       }                                                                        
      
   }
   
   class Counter  
   // extends DBMS
   {
       var $ip_address , $visit_date ,$visit_time , $session_id;
       
       function add_visitor()
       {
         $this->query_string = sprintf("INSERT INTO www_counter(ip_address,visit_date,visit_time,session_id) VALUES('%s','%s','%s','%s')",$this->ip_address,$this->visit_date,$this->visit_time,$this->session_id);
         if($this->query()){return true;}else{return false;}
       }
	   
	   function add_visitor_member()
       {
         $this->query_string = sprintf("INSERT INTO www_counter_member(ip_address,visit_date,visit_time,session_id) VALUES('%s','%s','%s','%s')",$this->ip_address,$this->visit_date,$this->visit_time,$this->session_id);
         if($this->query()){return true;}else{return false;}
       }
       
       function is_duplicate()
       {  
         $this->query_string = sprintf("SELECT * FROM www_counter WHERE session_id = '%s' AND visit_date = '%s' AND  ip_address = '%s' ",$this->session_id,$this->visit_date,$this->ip_address) ;  
         $this->query();
         if($this->num_rows() > 0 ){return true ;}else{return false;}
         
       }
   
   }
?>

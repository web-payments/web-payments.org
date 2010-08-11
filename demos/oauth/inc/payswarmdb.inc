<?php
abstract class db
{
   protected static $dbh = false;

   function connect()
   {
      self::$dbh = new PDO('sqlite:/var/tmp/payswarm-oauth-demo.sq3');
      self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      $dbh->exec(
         'CREATE TABLE IF NOT EXISTS payswarm 
            (id STRING, state integer, token STRING, 
               secret STRING, amount STRING, 
               mtime TIMESTAMP default CURRENT_TIMESTAMP 
                  ON UPDATE CURRENT_TIMESTAMP,
               PRIMARY KEY (id))');
   }

   protected function fatal_error($msg)
   {
      echo "<pre>Error!: $msg\n";
      $bt = debug_backtrace();
      foreach($bt as $line)
      {
         $args = var_export($line['args'], true);
         echo "{$line['function']}($args) at {$line['file']}:{$line['line']}\n";
      }
      echo "</pre>";
      die();
   }
}

class payswarm extends db
{
   function save($record)
   {
      $rval = false;
      
      if(!self::$dbh)
      {
         $this->connect();
      }
      
      if($record['id'] != 0)
      {
         try
         {
            $stmt = self::$dbh->prepare(
               'REPLACE INTO payswarm (id,state,token,secret,amount)
                  VALUES (:id,:state,:token,:secret,:amount)');
            $params = array(
               ':id'=>$record['id'],
               ':state'=>$record['state'],
               ':token'=>$record['token'],
               ':secret'=>$record['secret'],
               ':amount'=>$record['amount']);
            $stmt->execute($params);
         }
         catch (PDOException $e)
         {
            $this->fatal_error($e->getMessage());
         }
      }
      return $rval;
   }

   function update($record)
   {
      $rval = false;
      
      if(!self::$dbh)
      {
         $this->connect();
      }
      
      if($record['id'] != 0)
      {
         try
         {
            $q = "UPDATE payswarm SET ";
            foreach($record as $k=>$v)
            {
               if($k=='id') continue;
               $q .= "$k=?,";
            }
            $q = trim($q,",");
            $stmt = self::$dbh->prepare("$q where id={$record['id']}");
            $i=1;
            foreach($record as $k=>$v)
            {
               if($k=='id') continue;
               $stmt->bindParam($i, $record[$k]);
               $i++;
            }
            $stmt->execute();
         } 
         catch (PDOException $e)
         {
            $this->fatal_error($e->getMessage());
         }
      }
   }
   
   function load($id)
   {
      $rval = false;
      
      if(!self::$dbh)
      {
         $this->connect();
      }
      
      if($record['id'] != 0)
      {
         try
         {
            $id = self::$dbh->quote($id);
            $result = self::$dbh->query("SELECT * from payswarm where id = $id");
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $rval = $row;
         } 
         catch (PDOException $e)
         {
            $this->fatal_error($e->getMessage());
         }
      }
      return $rval;
   }

   function touch($id)
   {
      if(!self::$dbh)
      {
         $this->connect();
      }
      
      if($record['id'] != 0)
      {
         try
         {
            $id = self::$dbh->quote($id);
            $result = self::$dbh->query(
               "UPDATE payswarm SET mtime=CURRENT_TIMESTAMP WHERE id = $id");
         }
         catch (PDOException $e)
         {
            $this->fatal_error($e->getMessage());
         }
      }
   }

   function remove($id)
   {
      $rval = false;
      
      if(!self::$dbh)
      {
         $this->connect();
      }
      
      if($record['id'] != 0)
      {
         try
         {
            $id = mysql_real_escape_string($id);
            $result = self::$dbh->query(
               "DELETE from payswarm where id = '$id'");
         }
         catch (PDOException $e)
         {
            $this->fatal_error($e->getMessage());
            $rval = false;
         }
      }
      return $rval;
   }
}
?>

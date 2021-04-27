<?php namespace App\Libraries;

class BaseSys
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();

        // Init Table in DB
        $sql = "CREATE TABLE IF NOT EXISTS `db_update` (
                    `id`            INT(11)     NOT NULL    AUTO_INCREMENT,
                    `update_date`   DATETIME    NOT NULL,
                    PRIMARY KEY (`id`)
                )
                ENGINE = InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1";
		$this->db->query($sql);
        
            
    }

    public function get_db(){
        return $this->db;
    }

    public function load_sql($file = '',$datetime = ''){

        if($this->is_executed($datetime)){
            return;
        }

        // Set line to collect lines that wrap
        $templine = '';

        // Read in entire file
        $lines = file($file);

        // Loop through each line
        foreach ($lines as $line)
        {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            // Add this line to the current templine we are creating
            $templine .= $line;

            // If it has a semicolon at the end, it's the end of the query so can process this templine
            if (substr(trim($line), -1, 1) == ';')
            {
                // Perform the query
                $this->db->query($templine);

                // Reset temp variable to empty
                $templine = '';
             }
        }

        $this->update_datetime($datetime);
    }

    public function sql($sql_list = array(), $datetime = ''){

        if($this->is_executed($datetime)){
            return;
        }

        foreach($sql_list as $sql){
            $this->db->query($sql);
        }

        $this->update_datetime($datetime);

    }

    private function is_executed($datetime = ''){

        $sql = "SELECT * FROM db_update WHERE update_date =". $this->db->escape($datetime);

        $query = $this->db->query($sql);

        if(count($query->getResult()) > 0){
            return true;
        }else{
            
            return false;
        }
    }

    private function update_datetime($datetime = ''){

        $sql = "INSERT INTO db_update(`update_date`) VALUES(". $this->db->escape($datetime).")";

        $query = $this->db->query($sql);

    }

}

?>
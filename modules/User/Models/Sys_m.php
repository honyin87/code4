<?php 

namespace Modules\User\Models;

use CodeIgniter\Model;


class Sys_m extends Model
{
    protected $db;
    protected $base;

    public function __construct()
    {
        $this->base = new \App\Libraries\BaseSys();
        $this->db = $this->base->get_db();
        
    }


    public function sys_update(){

        //Tables Creation
        $this->create_tables();

        //Patches
        $this->patch();


    }

    public function create_tables(){

        $sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."users` (
                    `id`            INT(11)         NOT NULL    AUTO_INCREMENT,
                    `email`         VARCHAR(255)    NOT NULL,
                    `username`      VARCHAR(255)    ,
                    `firstname`     VARCHAR(255)    NOT NULL,
                    `lastname`      VARCHAR(255)    NOT NULL,
                    `password`      VARCHAR(255)    NOT NULL,
                    `contact_no`    VARCHAR(255)    NOT NULL,
                    `verified`      INT(2)          NOT NULL,
                    `status`        INT(2)          NOT NULL,
                    `create_by`     INT(11)         NOT NULL,
                    `create_date`   DATETIME        NOT NULL,
                    `update_by`     INT(11)         NOT NULL,
                    `update_date`   DATETIME        NOT NULL,
                    PRIMARY KEY (`id`)
                )
                ENGINE = InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1";

        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."roles` (
                    `id`            INT(11)         NOT NULL    AUTO_INCREMENT,
                    `role_name`     VARCHAR(255)    NOT NULL,
                    `description`   TEXT            ,
                    `auth_lvl`      INT(2)          NOT NULL,
                    `status`        INT(2)          NOT NULL,
                    `create_by`     INT(11)         NOT NULL,
                    `create_date`   DATETIME        NOT NULL,
                    `update_by`     INT(11)         NOT NULL,
                    `update_date`   DATETIME        NOT NULL,
                    PRIMARY KEY (`id`)
                )
                ENGINE = InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1";

        $this->db->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."user_role` (
            `id`            INT(11)         NOT NULL    AUTO_INCREMENT,
            `user_id`       INT(11)         NOT NULL,
            `role_id`       INT(11)         NOT NULL,
            `status`        INT(2)          NOT NULL,
            `create_by`     INT(11)         NOT NULL,
            `create_date`   DATETIME        NOT NULL,
            `update_by`     INT(11)         NOT NULL,
            `update_date`   DATETIME        NOT NULL,
            PRIMARY KEY (`id`)
        )
        ENGINE = InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1";

        $this->db->query($sql);

    }

    function patch(){

        
        $sql[] = "INSERT INTO `".DB_PREFIX."users` (`id`, `email`, `username`, `firstname`, `lastname`, `password`, `contact_no`, `verified`, `status`, `create_by`, `create_date`, `update_by`, `update_date`) 
                VALUES (NULL, '', 'admin', 'Default', 'Administrator', '20beaf3b3ce9ae10dc8c880a877723dc', '', '1', '1', '1', '2020-04-30 00:00:00', '1', '2020-04-30 00:00:00')";

        $sql[] = "INSERT INTO `tbl_roles` (`id`, `role_name`, `description`, `auth_lvl`, `status` , `create_by`, `create_date`, `update_by`, `update_date`) 
                VALUES (NULL, 'Super Admininistrator', 'has root access to this system', '1', '1', '1', '2020-04-30 00:00:00', '1', '2020-04-30 00:00:00')";

        $sql[] = "INSERT INTO `tbl_user_role` (`id`, `user_id`, `role_id`, `status` , `create_by`, `create_date`, `update_by`, `update_date`) 
                VALUES (NULL, '1', '1', '1', '1', '2020-04-30 00:00:00', '1', '2020-04-30 00:00:00')";


        $this->base->sql($sql,"2020-04-30 10:00:00");

        $sql = array();

        $sql[] = "INSERT INTO `tbl_roles` (`id`, `role_name`, `description`, `auth_lvl`, `status` , `create_by`, `create_date`, `update_by`, `update_date`) 
                VALUES (NULL, 'Admininistrator', 'has administrator access to this system', '1', '1', '1', '2020-04-30 00:00:00', '1', '2020-04-30 00:00:00')";
        $sql[] = "INSERT INTO `tbl_roles` (`id`, `role_name`, `description`, `auth_lvl`, `status` , `create_by`, `create_date`, `update_by`, `update_date`) 
                VALUES (NULL, 'Cashier', 'has access to cashier portal', '2', '1', '1', '2020-04-30 00:00:00', '1', '2020-04-30 00:00:00')";
        $sql[] = "INSERT INTO `tbl_roles` (`id`, `role_name`, `description`, `auth_lvl`, `status` , `create_by`, `create_date`, `update_by`, `update_date`) 
                VALUES (NULL, 'Waiter', 'has access to cashier portal', '3', '1', '1', '2020-04-30 00:00:00', '1', '2020-04-30 00:00:00')";

        $this->base->sql($sql,"2021-04-06 10:00:00");

    }

    

    
}

?>
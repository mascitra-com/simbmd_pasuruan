<?php
class Migration_user extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT','constraint' => 11,'auto_increment' => TRUE),
            'nama' => array('type' => 'VARCHAR','constraint' => 255),
            'nip' => array('type' => 'VARCHAR','constraint' => 255),
            'jabatan' => array('type' => 'VARCHAR','constraint' => 255,'default'=>null),
            'id_organisasi' => array('type' => 'INT','constraint' => 11),
            'username' => array('type' => 'VARCHAR','constraint'=>255),
            'password' => array('type' => 'VARCHAR','constraint'=>255),
            'is_superadmin' => array('type' => 'TINYINT','constraint'=>1,'default'=>0),
            'is_admin' => array('type' => 'TINYINT','constraint'=>1,'default'=>0),
            'last_login' => array('type' => 'DATETIME'),
            'log_action' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_user' => array('type' => 'VARCHAR','constraint'=>255,'default'=>null),
            'log_time' => array('type' => 'DATETIME','default'=>null),
            'is_deleted' => array('type' => 'TINYINT','constraint'=>1,'default'=>0)
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('user');
    }

    public function down() {
        $this->dbforge->drop_table('user');
    }
}
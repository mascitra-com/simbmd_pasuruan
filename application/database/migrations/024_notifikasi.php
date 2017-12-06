<?php
class Migration_notifikasi extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
            'title' => array('type' => 'VARCHAR', 'constraint' => 60, 'default'=>null),
            'description' => array('type' => 'TEXT', 'default'=>null),
            'link' => array('type' => 'TEXT', 'default'=>null),
            'from' => array('type' => 'INT', 'constraint' => 11, 'default'=>0),
            'to' => array('type' => 'INT', 'constraint' => 11, 'default'=>0),
            'is_read' => array('type' => 'TINYINT', 'constraint' => 1, 'default'=>0),
            'read_time' => array('type' => 'DATETIME', 'default'=>null),
            'create_time' => array('type' => 'DATETIME', 'default'=>null),
            ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('notifikasi');
    }

    public function down() {
        $this->dbforge->drop_table('notifikasi');
    }
}
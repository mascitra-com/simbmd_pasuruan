<?php
class Tools extends CI_Controller {

     public function __construct() {
        parent::__construct();

        # can only be called from the command line
        if (!$this->input->is_cli_request()) {
            exit('Direct access is not allowed. This is a command line tool, use the terminal');
        }
    }

    public function Model($name) {
        $path = APPPATH . "models/{$name}_model.php";
        $my_model = fopen($path, "w") or die("Unable to create model file!");
        $model_template = "<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class {$name}_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
}";

        fwrite($my_model, $model_template);
        fclose($my_model);

        echo "$path model berhasil dibuat." . PHP_EOL;
    }

    public function migration($name = null, $number = null) {
        if ($name === null || $number === null) {
            exit('Isi nama');
        }
        
        # prepare data
        // $timestamp  = date('YmdHis');
        $table_name = strtolower($name);
        $path       = APPPATH . "database/migrations/{$number}" . "_" . "{$name}.php";

        # begin write
        $my_migration = fopen($path, "w") or die("Unable to create migration file!");
        $migration_template = "<?php
class Migration_$name extends CI_Migration {

    public function up() {
        \$this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
                )
            ));
        \$this->dbforge->add_key('id', TRUE);
        \$this->dbforge->create_table('$table_name');
    }

    public function down() {
        \$this->dbforge->drop_table('$table_name');
    }
}";

        fwrite($my_migration, $migration_template);
        fclose($my_migration);

        echo "$path migration has successfully been created." . PHP_EOL;
    }

    public function migrate($version = null)
     {
        $this->load->library('migration');
        $sukses = FALSE;

        if ($version !== null) {
            $sukses = $this->migration->version($version);
        } else {
            $sukses = $this->migration->latest();
        }

        if ($sukses) {
            echo "Migrasi sukses";
        } else {
            show_error($this->migration->error_string());
        }
    }
}
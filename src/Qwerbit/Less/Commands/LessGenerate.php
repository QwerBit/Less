<?php
namespace Qwerbit\Less\Commands;

use Config,lessc;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class LessGenerate extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'less:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire() {
        $publicPath = public_path().DIRECTORY_SEPARATOR;
		//'less::group.'		
		$group = Config::get($this->option('config'));


        if (is_array($group))
        {
            $this->info('name config: '.$this->option('config'));
            foreach ($group as $_less=>$_css)
            {
                $pathLess = str_replace('/', DIRECTORY_SEPARATOR, $publicPath.$_less);
                $pathCss = str_replace('/', DIRECTORY_SEPARATOR, $publicPath.$_css);
                
                $lessContent = file_get_contents($pathLess);
                $less = new lessc;
                $cssContent = $less->compile($lessContent);
                file_put_contents($pathCss, $cssContent);
                
                $this->info('---------------------------------------------------');
                $this->info('Less generate: '.$_less);
                $this->info('           to: '.$_css);
            }
        }   
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments() {
	    return array();		
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions() {
        return array(
            array('config', null, InputOption::VALUE_OPTIONAL, 'packages:config.var', null),
        );
    }

}

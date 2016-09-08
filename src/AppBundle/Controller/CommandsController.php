<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Command\CacheClearCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Process\Process;

class CommandsController extends Controller
{
    /**
     * @Route("/post-receive-git")
     */
    public function postReceiveGitAction()
    {

	    try{

	    	$process = new Process('git reset --hard HEAD && git pull && php app/console cac:cle --env=prod');

		    //$process = new Process('ls -l');

		    $rootDir = $this->getParameter('kernel.root_dir').'/../';

		    $process->setWorkingDirectory($rootDir);

//		    $salida = shell_exec( 'cd /home/golfocom/www/demo/  && git reset --hard HEAD && git pull && php app/console cac:cle --env=prod' );

		    $process->run();

		    if ($process->isSuccessful()) {

		    	$cacheClearCmd = $this->get('app.cache.clear');

			    $input = new ArgvInput(array('--env=' . $this->container->getParameter('kernel.environment')));

			    $output = new BufferedOutput();

			    $cacheClearCmd->run($input,$output);

			    //$msg = 'Comando ejecutado satisfactoriamente';
			    $msg = $output;


		    }else{

			    throw new ProcessFailedException($process);

		    }



	    }
	    catch (\Exception $exception){
	    	$msg = $exception->getMessage();
	    }



	    return $this->render('AppBundle:Commands:post_receive_git.html.twig', array(
            'msg' => $msg
        ));
    }

}

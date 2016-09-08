<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Process\Process;

class CommandsController extends Controller
{
    /**
     * @Route("/post-receive-git")
     */
    public function postReceiveGitAction(Request $request)
    {

//	    if($this->getParameter('produccion') && $request->request->get('payload')) {
	    if($this->getParameter('produccion')) {


		    try {

			    $process = new Process('git reset --hard HEAD && git pull');

			    $rootDir = $this->getParameter( 'kernel.root_dir' ) . '/../';

			    $process->setWorkingDirectory( $rootDir );

			    $process->setTimeout( 60 );

			    $process->run();

			    if ( $process->isSuccessful() ) {

				    $cacheClearCmd = $this->get( 'app.cache.clear' );

				    $input = new ArgvInput( array( '--env=' . $this->container->getParameter( 'kernel.environment' ) ) );

				    $output = new BufferedOutput();

				    $cacheClearCmd->run( $input, $output );

				    $msg = 'Comando ejecutado satisfactoriamente';
				    //$msg = $output;


			    } else {

				    throw new ProcessFailedException( $process );

			    }


		    } catch ( \Exception $exception ) {
			    $msg = $exception->getMessage();
		    }

	    }else{
	    	$msg = 'No está permitido realizar esta accion en un servidor distinto a producción.';
	    }

	    return $this->render('AppBundle:Commands:post_receive_git.html.twig', array(
            'msg' => $msg
        ));
    }

}

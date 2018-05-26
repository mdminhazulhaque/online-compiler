<?php

namespace MdMinhazulHaque;

require_once 'Process.php';

class Compiler
{
    private $error = null;
    private $output = null;
    private $retcode = null;
    
    public function __construct($compiler, $content, $inputdata = "")
    {
        $source_filename = uniqid();
        file_put_contents($source_filename, $content);
        
        $process = new Process($compiler, $source_filename);
        
        $process->setInput($inputdata);
        $this->output = $process->getOutput();
        $this->error = $process->getError();
        $this->retcode = $process->close();
        
        unlink($source_filename);
    }
    
    public function getOutput()
    {
        return $this->output;
    }
    
    public function getError()
    {
        return $this->error;
    }
    
    public function getExitCode()
    {
        return $this->retcode;
    }
}

?>

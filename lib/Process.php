<?php

namespace MdMinhazulHaque;

class Process
{
    private $process = null;
    private $pipes = null;
    
    private $stdin;
    private $stdout;
    private $stderr;
    
    private $descriptorspec = array(
        0 => array("pipe", "r"),
        1 => array("pipe", "w"),
        2 => array("pipe", "w")
        );
    
    public function __construct($command, $arguments = "")
    {
        if($arguments != "") {
            $command .= ' ' . escapeshellarg($arguments);
        }
        
        $this->process = proc_open(
            $command,
            $this->descriptorspec,
            $this->pipes
            );
        
        if(!is_resource($this->process))
        {
            throw new RuntimeException('Unable to create a process object');
        }
        
        $this->stdin = $this->pipes[0];
        $this->stdout = $this->pipes[1];
        $this->stderr = $this->pipes[2];
    }
    
    public function setInput($content)
    {
        fwrite($this->stdin, $content);
        fclose($this->stdin);
    }
    
    public function getOutput()
    {
        if(false === $ret = stream_get_contents($this->stdout, -1, 0))
        {
            return '';
        }
        
        fclose($this->stdout);
        
        return $ret;
    }
    
    public function getError()
    {
        if(false === $ret = stream_get_contents($this->stderr, -1, 0))
        {
            return '';
        }
        
        return $ret;
    }
    
    public function __destruct()
    {
        $this->close();
    }
    
    public function close()
    {
        if(is_resource($this->process))
        {
            fclose($this->stderr);
            return proc_close($this->process);
        }
    }
}

?>

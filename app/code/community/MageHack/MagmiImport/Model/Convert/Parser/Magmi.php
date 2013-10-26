<?php
/**
 * Magmi Import
 */
class MageHack_MagmiImport_Model_Convert_Parser_Magmi extends Mage_Dataflow_Model_Convert_Parser_Csv
{

    public function parse()
    {
        $params=array(
            'ts' => time(),
            'run' => 'import',
            'logfile' => 'progress.txt',
            'profile' => 'default',
            'mode' => 'create',
            'engine' => 'magmi_productimportengine:Magmi_ProductImportEngine',
            'CSV:filename' => Mage::getBaseDir('var').DS.'import'.DS.$this->getVar('filename'),
            'files' => Mage::getBaseDir('var').DS.'import'.DS.$this->getVar('filename')
        );

        require_once(Mage::getBaseDir().DS.'magmi'.DS.'inc'.DS.'magmi_defs.php');
        require_once(Mage::getBaseDir().DS.'magmi'.DS.'inc'.DS.'magmi_statemanager.php');

        try
        {
            require_once(Mage::getBaseDir().DS.'magmi'.DS.'engines'.DS.'Magmi_ProductImportEngine.php');
        }
        catch(Exception $e)
        {
            // die("ERROR");
            print "NO ENGINE";
            throw new Mage_Exception("Cannot load the desired Magmi engine");
        }

        if(Magmi_StateManager::getState()!=="running")
        {
            Magmi_StateManager::setState("idle");

            $pf=Magmi_StateManager::getProgressFile(true);
            if(file_exists($pf)) {
                @unlink($pf);
            }
            set_time_limit(0);

            $mmi_imp = new Magmi_ProductImportEngine();
            $logfile=isset($params["logfile"])?$params["logfile"]:null;
            if(isset($logfile) && $logfile!="") {
                $fileName=Magmi_StateManager::getStateDir().DS.$logfile;
                if(file_exists($fileName))
                {
                    @unlink($fileName);
                }
                $mmi_imp->setLogger(new FileLogger($fileName));
            }
            else {
                $mmi_imp->setLogger(new EchoLogger());

            }
            $mmi_imp->run($params);

        }
        else {
            return "Still running ";
        }
    }

}
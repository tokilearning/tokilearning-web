<?php
/**
 * CCodeFile class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CCodeFile represents a code file being generated.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CCodeFile.php 2020 2010-04-06 04:48:53Z qiang.xue $
 * @package system.gii
 * @since 1.1.2
 */
class CCodeFile extends CComponent
{
	const OP_NEW='new';
	const OP_OVERWRITE='overwrite';
	const OP_SKIP='skip';

	/**
	 * @var string the file path that the new code should be saved to.
	 */
	public $path;
	/**
	 * @var mixed the newly generated code. If this is null, it means {@link path}
	 * should be treated as a directory.
	 */
	public $content;
	/**
	 * @var string the operation to be performed
	 */
	public $operation;
	/**
	 * @var string the error occurred when saving the code into a file
	 */
	public $error;

	/**
	 * Constructor.
	 * @param string the file path that the new code should be saved to.
	 * @param string the newly generated code
	 */
	public function __construct($path,$content)
	{
		$this->path=strtr($path,array('/'=>DIRECTORY_SEPARATOR,'\\'=>DIRECTORY_SEPARATOR));
		$this->content=$content;
		if(is_file($path))
			$this->operation=file_get_contents($path)===$content ? self::OP_SKIP : self::OP_OVERWRITE;
		else if($content===null)  // is dir
			$this->operation=is_dir($path) ? self::OP_SKIP : self::OP_NEW;
		else
			$this->operation=self::OP_NEW;
	}

	/**
	 * Saves the code into the file {@link path}.
	 */
	public function save()
	{
		$module=Yii::app()->controller->module;
		if($this->content===null)  // a directory
		{
			if(!is_dir($this->path) && !@mkdir($this->path,$module->newDirMode,true))
			{
				$this->error="Unable to create the directory '{$this->path}'.";
				return false;
			}
			else
				return true;
		}

		if($this->operation===self::OP_NEW)
		{
			$dir=dirname($this->path);
			if(!is_dir($dir) && !@mkdir($dir,$module->newDirMode,true))
			{
				$this->error="Unable to create the directory '$dir'.";
				return false;
			}
		}
		if(@file_put_contents($this->path,$this->content)===false)
		{
			$this->error="Unable to write the file '{$this->path}'.";
			return false;
		}
		else
			@chmod($this->path,$module->newFileMode);
		return true;
	}

	/**
	 * @return string the code file path relative to the application base path.
	 */
	public function getRelativePath()
	{
		if(strpos($this->path,Yii::app()->basePath)===0)
			return substr($this->path,strlen(Yii::app()->basePath)+1);
		else
			return $this->path;
	}

	/**
	 * @return string the code file extension (e.g. php, txt)
	 */
	public function getType()
	{
		if(($pos=strrpos($this->path,'.'))!==false)
			return substr($this->path,$pos+1);
		else
			return 'unknown';
	}
}
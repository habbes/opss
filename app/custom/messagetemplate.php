<?php

/**
 * class that handles the simple templates used for emails and messages
 * this class reads the templates and replaces placeholders with values
 * the placeholders are define with the syntax: {{name}}
 * where name is the name of the placeholder and the entier declaration
 * (including the brackets) will be replaced with values set in an instance
 * of this class
 * @author Habbes
 *
 */
class MessageTemplate
{
	protected $template;
	protected $vars;
	protected $defaultVal;
	protected $output;
	
	public function __construct($template = "")
	{
		$this->template = $template;
		$this->vars = array();
		$this->defaultVal = "";
	}
	
	/**
	 * sets the value for the given variable placeholder
	 * @param string $name
	 * @param string $value
	 */
	public function setVar($var, $value)
	{
		$this->vars[$var] = $value;
	}
	
	/**
	 * alias for the setVar method
	 * @param string $name
	 * @param string $value
	 */
	public function __set($name, $value)
	{
		$this->setVar($name, $value);
	}
	
	/**
	 * set each of the var in the given array to the specified value
	 * @param array $vars
	 */
	public function setVars($vars)
	{
		foreach($vars as $name => $value){
			$this->setVar($name, $value);
		}
	}
	
	/**
	 * gets the value set fo the given placeholder variable or the
	 * default val if no value has been set
	 * @param string $name
	 * @return string
	 */
	public function getVar($name)
	{
		return array_key_exists($name, $this->vars)?
			$this->vars[$name] : $this->defaultVal;
	}
	
	/**
	 * the value to use for vars in the template which have not been given a value
	 * @param string $val
	 */
	public function setDefaultVal($val)
	{
		$this->defaultVal = $val;
	}
	
	/**
	 * sets the template text to be used
	 * placeholders in the template text are given as {{name}} where
	 * name is the placeholder variable which will be replaced with a value
	 * set using setVar
	 * @param string $template
	 */
	public function setTemplate($template)
	{
		$this->template = $template;
	}
	
	/**
	 * sets the path to the template text to be used
	 * placeholders in the template text are given as {{name}} where
	 * name is the placeholder variable which will be replaced with a value
	 * set using setVar
	 * @param string $path
	 */
	public function setTemplatePath($path)
	{
		$this->setTemplate(file_get_contents($path));
	}
	
	/**
	 * callback used to replace a placeholder in the template
	 * with its specified value
	 * @param array $matches matches from the regex that finds placeholders
	 * matches[1] is the name of the placeholder
	 */
	protected function varReplaceCallback($matches)
	{
		return htmlspecialchars($this->getVar($matches[1]));
	}
	
	/**
	 * reads the template and replaces placeholders with their values
	 * and saves the resultant string in the output property
	 */
	protected function parse()
	{
		$out = preg_replace_callback('/{{([\w-]+)}}/',
			[$this, "varReplaceCallback"], $this->template);
		$this->output = $out;
	}
	
	/**
	 * gets the output of the template after replacing the placeholders
	 * with their specified values
	 * @return string
	 */
	public function getOutput()
	{
		if(!$this->output)
			$this->parse();
		return $this->output;
	}
}
<?php

/**
 * Clément Habinshuti
 * AERC MIS Project
 * Started: 26.02.2014
 * HtmlBuilder class to allow to build html output progressively
 */


/**
 * interface for a html element
 * used by HtmlBuilder
 */
interface iElement {

    public function getId();
    public function getLevel();
    public function getChildren();
    public function getParent();
    public function getTagCode();
    public function build();
    
}


/**
 * this interface indicates an iElement adds a line break after its end tag
 */
interface iElementBreaksLine {

}


/**
 * class to build a html text element/node
 */
class RawTextElement implements iElement {
    protected $id;
    protected $level;
    protected $parent;
    
    protected $text;
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getLevel(){
        return $this->level;
    }
    
    public function getParent(){
        return $this->parent;
    }
    
    public function setParent($parent){
        $this->parent = $parent;
    }
    
    public function getChildren(){
        return [];
    }
    
    public function getTagCode(){
        return "rt=" . $this->text;
    }
    
    public function getText(){
        return $this->text;
    }
    
    public function setText($text){
        $this->text = $text;
    }
    
    public function appendText($text){
        $this->text .= $text;
    }
    
    /**
     * @return string html output
     */
    public function build(){
        
        return $this->text;
    }
    
    public function __construct($text = "", $id = 0, $level = 0, $parent = null){
        $this->id = $id;
        $this->level = $level;
        $this->text = $text;
        $this->parent = $parent;
    }
}



/**
 * class to build a text node where the text is sanitized/escaped
 */
class TextElement extends RawTextElement {
    public function getTagCode(){
        return "t=" . $this->text;
    }
    
    public function build(){
        return htmlspecialchars(parent::build());
    }
}


/**
 * generic class to build html elements that use tags
 */
class TagElement implements iElement {
    protected $id;
    protected $level;
    protected $parent;
    protected $children;
    
    protected $tag;
    protected $attributes;
    
    public function getId(){
        return $this->id;
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getLevel(){
        return $this->level;
    }
    
    public function getTag(){
        return $this->tag;
    }
    
    public function setTag($tag){
        $this->tag = $tag;
    }
    
    public function getParent(){
        return $this->parent;
    }
    
    public function setParent($parent){
        $this->parent = $parent;
    }
    
    public function getChildren(){
        return $this->children;
    }
    
    public function getTagCode(){
        return "<" . $this->tag . ">";
    }
    
    public function getAttr($name){
        return $this->attributes[$name];
    }
    
    public function setAttr($name, $value){
        $this->attributes[$name] = $value;
    }
    
    public function setAttrs($pairs){
        foreach($pairs as $name => $value){
            $this->attributes[$name] = $value;
        }
    }
    
    public function appendAttr($name, $value){
        $this->attributes[$name] .= $value;
    }
    
    public function __construct($tag, $attrs=null, $id = 0, $level = 0, $parent = null){
        $this->id = $id;
        $this->level = $level;
        $this->tag = $tag;
        $this->attributes = Array();        
        if($attrs){
            $this->setAttrs($attrs);
        }
        $this->parent = $parent;
        $this->children = Array();
    }
    
    /**
     * append a child element to the current element
     * @param mixed $element either the iElement or the tag code or an array of pairs of element and its attributes
     * @param array $attrs map of attributes names and their values
     * @return iElement the appended element
     */
    public function append($element, $attrs=null){
        if(gettype($element) == "array"){
            $elements = $element; //rename just to avoid confusions
            foreach($elements as $params){
                $el = $params[0];
                $attrs = null;
                if(count($params) > 1)
                    $attrs = $params[1];
                $this->append($el, $attrs);
            }
            
            return null;
        }
        if(gettype($element) == "string")
            $element = ElementBuilder::create($element, $attrs);
    
        $this->children[] = $element;
        
        $element->setParent($this);
        
        return $element;
    }
    
    public function build(){
        $tag = $this->tag;
        $out = "<$tag";
        
        if(count($this->attributes) > 0)
            $out .= " ";
        
        foreach($this->attributes as $name=>$value){
            $out .= $name . '=' . "\"$value\" ";
        }
        
        $out .= ">";
        
        foreach($this->children as $el){
            $out .= $el->build();
        }
        
        $out .= "</$tag>";
        
        return $out;
    }
}



/**
 * tag elements which leave break the line after their close tags, like <title/>
 */
class LineElement extends TagElement implements iElementBreaksLine{
    
    public function getTagCode(){
        return "<" . $this->tag . " >";
    }

    public function build(){
        return parent::build() . "\n";
    }
}


/**
 * class to build html block elements like divs
 */
class BlockElement extends TagElement implements iElementBreaksLine{
    protected $indentLevel = 1;
    
    protected function indent(){
        $str = "";
        for($i = 0; $i < $this->indentLevel; $i++){
            $str .= "    ";
        }
        if($this->indentLevel == 1);
        return $str;
    }
    
    public function build(){
        $parentIndent = "";
        if(is_a($this->getParent(), "BlockElement"))
            $parentIndent = $this->getParent()->indent();
        $tag = $this->tag;
        $out = "\n$parentIndent<$tag";
        
        if(count($this->attributes) > 0)
            $out .= " ";
        
        foreach($this->attributes as $name=>$value){
            $out .= $name . '=' . "\"$value\" ";
        }
        
        $out .= ">\n";
        
        foreach($this->children as $index => $el){
            if(is_a($el, "BlockElement")){
                $el->indentLevel = $this->indentLevel + 1;
            }
            if(is_a($el, "BlockElement") || $index == 0 || is_a($this->children[$index - 1], "iElementBreaksLine"))
                $out .= $this->indent();
            $out .= $el->build();
        }
        
        $out .= "\n$parentIndent</$tag>\n";
        
        return $out;
    }
}

/**
 * class to build a html element
 * that has no content nor closing tag
 */
class EmptyElement extends TagElement {
    
    protected static $terminator = "/>\n";
    
    public function getChildren(){
        return [];
    }
    
    public function getTagCode(){
        return "<" . $this->tag . "/>";
    }
    
    public function build(){
         $tag = $this->tag;
        $out = "<$tag";
        
        if(count($this->attributes) > 0)
            $out .= " ";
        
        foreach($this->attributes as $name=>$value){
            $out .= $name . '=' . "\"$value\" ";
        }
        
        $out .= static::$terminator;
        
        return $out;
    }
}


//elements in head like meta or link
class HeadElement extends EmptyElement implements iElementBreaksLine{
    protected static $terminator = " >\n";
}


/**
 * create the appropriate iElement type based on
 * a string input
 */
class ElementBuilder {
    
    /**
     * determine the type and tag name/text of the given input
     * html element
     */
    static protected function parseInput($input){
        //the syntax is
        //<tag> for block tags
        //<tag/> for empty tags
        //t:text for text nodes
        $type="";
        $tag="";
        
        //test content tag
        if(preg_match("/^<[a-zA-Z0-9]+>$/", $input)){
            $type = "tag";            
            $tag = substr($input, 1, strlen($input) - 2);
            
        }
        //test for line element tag
        else if(preg_match("/^<[a-zA-Z0-9]+\s>$/", $input)){
            $type = "lineTag";
            $tag = substr($input, 1, strlen($input) - 3);
        }
        //test block content tag
        else if(preg_match("/^<[a-zA-Z0-9]+> $/", $input)){
            $type = "blockTag";
            $tag = substr($input, 1, strlen($input) - 3);
        }
        //test empty tag
        else if(preg_match("/^<[a-zA-Z0-9]+\/>$/", $input)){
            $type = "emptyTag";            
            $tag = substr($input, 1, strlen($input) - 3);
        }
        //head element
        else if(preg_match("/^<[a-zA-Z0-9]+$/", $input)){
            $type = "headEl";
            $tag = substr($input, 1);
        }
        //test raw text
        else if(preg_match("/^rt=/", $input)){
            $type = "rawText";
            $tag = substr($input, 3);
        }
        //test text
        else if(preg_match("/^t=/", $input)){
            $type = "text";
            $tag = substr($input, 2);
        }
        else {
            $type = "text";
            $tag = $input;
        }
        
        return ["type" => $type, "tag" => $tag];
    }
    
    /**
     * create an the appropriate iElement type based
     * on the given $tagcode. The following are valid:
     * <tag>  -> content tag
     * <tag> (followed by single whitespace) -> block tag
     * <tag/> -> empty tag
     * <tag -> head element tag
     * t=text goes here -> text node
     * rt=raw text goes here -> unescaped text (such as js code)
     * @param string $tagcode
     * @param array $attrs the attributes to use in the tag, array of attr=>value pairs
     * @return iElement
     */
    public static function create($tagcode, $attrs = null){
        $info = self::parseInput($tagcode);
        switch($info['type']){
            case "tag":
                return new TagElement($info['tag'], $attrs);
            
            case "lineTag":
                return new LineElement($info['tag'], $attrs);
            
            case "emptyTag":
                return new EmptyElement($info['tag'], $attrs);
                
            case "blockTag":
                return new BlockElement($info['tag'], $attrs);
                
            case "rawText":
                return new RawTextElement($info['tag']);
                
            case "text":
                return new TextElement($info['tag']);
            
            case "headEl":
                return new HeadElement($info['tag'], $attrs);
                
            default:
                return new TextElement($info['tag']);
        }
    }
}


/**
 * class to progressively build html markup
 */
class HtmlBuilder extends BlockElement {

    protected $elements;
    protected $levels;
    protected $children;
    protected $current;
    protected $parent = null;
    protected $indentLevel = 0;
    protected $id = 0;
    protected $level = 0;
    
    protected $curLevel = 0;
    protected $curId = 0;
    
    public function getChildren(){
        return $this->children;
    }
    
    public function setParent($el){
        $this->parent = $el;
    }
    
    public function resetParent(){
        $this->parent = null;
    }
    
    public function getParent(){
        if($this->parent)
            return $this->parent;
        return $this;
    }
    
    public function getTagCode(){
        return "builder";
    }
    
    public function __construct($element = null){
        $this->elements = Array();
        $this->levels = Array();
        $this->children = Array();
        $this->current = $this;
        $this->curId = 0;
        
        $this->addElement($this);
        
        if($element){
            if(gettype($element) == "string")
                $element = ElementBuilder::create($element);
            $this->appendTop($element);
        }
    }
    
    /**
     * @param iElement $element
     */
    protected function addElement($element){
        $this->elements[$element->getId()] = $element;
    }
    
    /**
     *@param iElement $element
     */
    protected function addToLevel($element){
        if(!array_key_exists($element->getLevel(), $this->levels))
        {
            $this->levels[$element->getLevel()] = Array();
        }
        array_push($this->levels[$element->getLevel()], $element);
    }
    
    /**
     * set the element in current, either by the element itself or its id
     * @param mixed $element the iElement or its id
     */
    public function setCurrent($element){
        if($element instanceof iElement){
            $id = $element->getId();
        } else {
            $id = $element;
        }
        
        $this->current = $this->elements[$id];
        
    }
    
    /**
     * get the current/pivot/reference element of the html builder
     * @return iElement
     */
    public function getCurrent(){
        return $this->current;
    }
    
    /**
     * set the current to the parent of the current element
     * $param int $levels how many levels to go up
     * @return iElement the new current
     */
    public function up($levels = 1){
        if($levels < 1) $levels = 0;
        $i = 0;
        while($this->current != $this && $i < $levels){
            $el = $this->current->getParent();
            $this->setCurrent($el);
            $i++;
        }
        
        return $el;
    }
    
    /**
     * append the specified element at the top level of this builder
     * @param mixed $el the iElement to append or its tag code
     * @param array $attrs the html attributes of the tag, array of attr->value pairs
     * @param boolean $current whether to update the current to the appended element
     * @return iElement the appended element
     */
    public function appendTop($el, $attrs=null, $current = true){
        if(gettype($el) == "string")
            $el = ElementBuilder::create($el, $attrs);
    
        $this->curLevel = 1;
        $this->curId += 1;
        $el->setId($this->curId);
        $this->addElement($el);
        $this->children[] = $el;
        $el->setParent($this);       
        
        if($current)
            $this->current = $el;
        
        return $el;
    }
    
    /**
     * insert the specified in the current element
     * @param mixed $el the iElement to insert or its tag code
     * @param array $attrs the html attributes of the tag, array of attr->value pairs
     * @param boolean $current whether to update the current to the inserted element
     * @return iElement the inserted element
     */
    public function insert($el, $attrs=null, $current = true){
        
        if(gettype($el) == "string")
            $el = ElementBuilder::create($el, $attrs);
        
        $this->curId += 1;
        $this->curLevel += 1;
        $el->setId($this->curId);
        $this->addElement($el);
        $this->current->append($el);
        
        if($current)
            $this->current = $el;
            
        return $el;
        
    }
    
    /**
     * append the element at the same level as the current elements
     * @param mixed $el the iElement to append or its tag code
     * @param array $attrs the html attributes of the tag, array of attr->value pairs
     * @param boolean $current whether to update the current to the appended element
     * @return iElement the inserted element
     */
    public function append($el, $attrs=null, $current = true){
        if(gettype($el) == "string")
            $el = ElementBuilder::create($el, $attrs);
    
        $this->curId += 1;
        $el->setId($this->curId);
        $this->addElement($el);
        if($this->current == $this || $this->current->getParent() == $this)
            $this->appendTop($el);
        else
            $this->current->getParent()->append($el);
        
        
        if($current){
            $this->current = $el;
        }
        
        return $el;
    }
    
    /**
     * create the html output of the builder
     * @return string
     */
    public function build(){
        /*$parentIndent = "";*/
        if(is_a($this->getParent(), "BlockElement")){
            //$parentIndent = $this->getParent()->indent();
            $this->indentLevel = $this->getParent()->indentLevel;
        }
        //$out = "$parentIndent";
        $out = "";
        foreach($this->children as $el){
            if(is_a($el, "BlockElement")){
                $el->indentLevel = $this->indentLevel + 1;
            }
            $out .= $el->build();
        }
        
        return $out;
        
    }
    
    public function debugPrint(){
        foreach($this->elements as $id => $el){
            
            echo $id . " => " . htmlspecialchars($el->getTagCode()) . "<br>";
        }
    }

}


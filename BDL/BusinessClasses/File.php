<?php
class file
{
    private $m_id,$m_path,$m_displayName,$m_type;
    
    function __construct($id,$path,$displayName,$type)
    {
        $this->m_id=$id;
        $this->m_path=$path;
        $this->m_displayName=$displayName;
        $this->m_type=$type;
        
        
    }
    function getId()
    {
        return $this->m_id;
    }
    function getPath()
    {
          return $this->m_path;
    }
    function getDisplayName()
    {
          return $this->m_displayName;
    }
    function getType()
    {
          return $this->m_type;
    }
    
    
    
}


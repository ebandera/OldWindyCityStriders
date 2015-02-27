<?php
class contentItem
{
    private $m_id,$m_pageId,$m_heading,$m_caption,$m_sortOrder,$m_expirationDate,$m_width,$m_height;
    
    function __construct($id,$pageId,$heading,$caption,$sortOrder,$expirationDate,$width,$height)
    {
        $this->m_id=$id;
        $this->m_pageId=$pageId;
        $this->m_heading=$heading;
        $this->m_caption=$caption;
        $this->m_sortOrder=$sortOrder;
        $this->m_expirationDate=$expirationDate;
        $this->m_width=$width;
        $this->m_height=$height;
        
        
    }
    function getId()
    {
       return $this->m_id; 
    }
    function getPageId()
    {
         return $this->m_pageId; 
    }
    function getHeading()
    {
         return $this->m_heading; 
        
    }
    function getCaption()
    {
         return $this->m_caption; 
    }
    function getSortOrder()
    {
         return $this->m_sortOrder; 
    }
    function getExpirationDate()
    {
         return $this->m_expirationDate; 
    }
    function getWidth()
    {
        return $this->m_width;
    }
    function getHeight()
    {
        return $this->m_height;
    }
    
    
    
}


<?php

namespace Entity;



/**
 * Chapter
 * 
 * @Entity
 * @Table(name="t_chapitre")
 * @HasLifecycleCallbacks
 */
class Chapter
{
    /**
     * @Id
     * @Column(type="integer",name="chap_id")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @Column(type="integer", name="chap_number", unique=true)
     */
    protected $number;
    
    /**
     *@Column(name="date_ajout", type="date") 
     */
    protected $date;
    
    /**
     * @Column(name="date_update", type="date", nullable=true)
     */
    protected $update;
    
    /**
     *@Column(type="string", name="chap_title")
     */
    protected $title;
    
    /**
     *@Column(type="string", name="chap_content", type="string")
     */
    protected $content;
    
    /**
     * @column (type="boolean", name="published")
     */
    protected $published = false;
    
    /**
     * @column (type="boolean", name="delete_chap")
     */
    protected $delete = false;
    
    /**
     * @OneToOne (targetEntity="Image", cascade={"persist"})
     * @JoinColumn(name="image_id", referencedColumnName="id")
     */
    protected $image;
    

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = $number;
        return $this;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }
    
    public function getContent(){
        return $this->content;
    }
    
   public function setContent ($content) {
       $this->content = $content;
       return $content;
   }
   
   public function getDate() {
       return $this->date;
   }
   
   public function setDate($date) {
       $this->date = $date;
       return $this;
   }
   
   public function getUpdate() {
       return $this->update;
   }
   
   public function setUpdate($update){
       $this->update = $update;
       return $this;
   }
   
   /**
    * 
    * @PreUpdate
    */
   public function updateDate(){
       $this->setUpdate(new \DateTime());
   }
   
   public function  getPublished() {
       return $this->published;
   }
   
   public function setPublished($published) {
       $this->published = $published;
       return $this;
   }
   
   public function getDelete(){
       return $this->delete;
   }
   
   public function setDelete($delete){
       $this->delete = $delete;
       return $this;
   }
   
   public function getImage(){
       return $this->image;
   }
   
   public function setImage (Image $image= null){
       $this->image = $image;
       return $this;
   }
}  
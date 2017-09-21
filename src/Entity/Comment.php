<?php


namespace Entity;

/**
 * Comment
 * 
 * @Entity
 * @Table(name="t_comment")
 */
class Comment
{
    /**
     * @Id
     * @Column(type="integer",name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *@Column(name="pseudo", type="string") 
     */
    protected $pseudo;
    
    /**
     *@Column(type="string", name="commentaires")
     */
    protected $comment;
    
    /**
     * 
     *@Column(type="date", name="date_commentaire")
     */
    protected $date;
    
    /**
     * 
     * @Column (type="boolean", name="signale")
     */
    protected $signale = false ;
    
    /**
     * @Column (type="boolean", name="delete_commentaires")
     */
    protected $delete = false;
    
    /**
     * 
     * @ManyToOne(targetEntity="Chapter")
     * @JoinColumn(name="chap_id", referencedColumnName="chap_id")
     */
    protected $chapter;
    
   


   public function __construct() {
        $this->date = new \DateTime;
    } 

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getPseudo() {
        return $this->pseudo;
    }

    public function setPseudo($pseudo) {
        $this->pseudo = $pseudo;
        return $this;
    }
    
    public function getComment() {
        return $this->comment;
    }
    
    public function setComment($comment) {
        $this->comment = $comment;
        return $this;
    }
    
    public function getDate () {
        return $this->date;
    }
    
    public function setDate ($date) {
        $this->date = $date;
        return $this;
    }
    
    public function getSignale () {
        return $this->signale;
    }
    
    public function setSignale ($signale) {
        $this->signale = $signale;
        return $this;
    }
   
    public function getDelete(){
        return $this->delete;
    }
    
    public function setDelete($delete){
        $this->delete = $delete;
        return $this;
    }
    
    public function getChapter () {
        return $this->chapter;
    }
    
    public function setChapter (Chapter $chapter) {
        $this->chapter = $chapter;
        return $this;
    }
}  
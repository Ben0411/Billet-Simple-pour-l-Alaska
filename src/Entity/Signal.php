<?php


namespace Entity;


/**
 * Signal
 * 
 * @Entity
 * @Table(name="t_signal")
 */
class Signal
{
    /**
     * @Id
     * @Column(type="integer",name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     *@Column(name="message", type="string") 
     */
    protected $message;
    
    
    /**
     * 
     *@Column(type="date", name="signal_date")
     */
    protected $date;
    
    /**
     * 
     * @ManyToOne(targetEntity="Comment")
     * @JoinColumn(name="comment_id", referencedColumnName="id")
     */
    private $comment;
    
   
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
    
     public function getMessage () {
        return $this->message;
    }
    
    public function setMessage ($message) {
        $this->message = $message;
        return $this;
    }

    public function getDate () {
        return $this->date;
    }
    
    public function setDate ($date) {
        $this->date = $date;
        return $this;
    }

   
    public function getComment () {
        return $this->comment;
    }
    
    public function setComment (Comment $comment) {
        $this->comment = $comment;
        return $this;
    }
    
   
}  